import cv2
import requests
import time
import threading
from flask import Flask, Response
from flask_cors import CORS
from ultralytics import YOLO

app = Flask(__name__)
CORS(app)

# ================= KONFIGURASI =================
# INDEX_KAMERA: 0 untuk webcam laptop, 1 (atau 2) untuk DroidCam HP
INDEX_KAMERA = 1 
LARAVEL_URL = "http://127.0.0.1:8000/tambah"
COOLDOWN_DETEKSI = 2.0 

# Menggunakan model bawaan YOLO (yolov8n.pt)
MODEL_PATH = "yolov8n.pt" 

print("Memuat model YOLO...")
model = YOLO(MODEL_PATH)
print("Model berhasil dimuat!")

# Buka kamera (DroidCam / Webcam)
camera = cv2.VideoCapture(INDEX_KAMERA, cv2.CAP_DSHOW)

if not camera.isOpened():
    print(f"PERINGATAN: Kamera di index {INDEX_KAMERA} tidak bisa dibuka!")
    print("Coba ganti INDEX_KAMERA ke 0 atau 2.")

frame_terbaru = None
lock = threading.Lock()
terakhir_kirim = 0

def proses_kamera():
    global frame_terbaru, terakhir_kirim
    while True:
        ok, frame = camera.read()
        if not ok:
            print("Kamera terputus, mencoba lagi...")
            time.sleep(1)
            continue

        # Deteksi YOLO (Hanya kelas 39 = Botol)
        hasil = model(frame, conf=0.5, classes=[39], verbose=False)[0]

        # Jika ada botol terdeteksi
        if len(hasil.boxes) > 0:
            # 1. Cek ukuran botol (Besar/Sedang/Kecil)
            for box in hasil.boxes.xyxy:
                x1, y1, x2, y2 = box
                lebar = x2 - x1
                tinggi = y2 - y1
                luas = lebar * tinggi
                
                if luas > 300:
                    print("Botol : Besar")
                elif luas > 150:
                    print("Botol : Sedang")
                else:
                    print("Botol : Kecil")

            # 2. Kirim ke Laravel (dengan jeda cooldown)
            if time.time() - terakhir_kirim > COOLDOWN_DETEKSI:
                try:
                    r = requests.post(LARAVEL_URL, timeout=2)
                    print(f"[{time.strftime('%H:%M:%S')}] Terkirim ke Laravel: {r.status_code}")
                    terakhir_kirim = time.time()
                except Exception as e:
                    print("Gagal kirim ke Laravel:", e)

        # Simpan frame yang ada kotak deteksinya
        annotated = hasil.plot()
        with lock:
            frame_terbaru = annotated

def generate_video():
    global frame_terbaru
    while True:
        with lock:
            f = frame_terbaru
        
        if f is None:
            time.sleep(0.05)
            continue

        # Kecilkan resolusi & kompres agar ringan di web
        small = cv2.resize(f, (480, 360))
        _, buf = cv2.imencode('.jpg', small, [cv2.IMWRITE_JPEG_QUALITY, 55])
        
        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + buf.tobytes() + b'\r\n')

@app.route('/video_feed')
def video_feed():
    return Response(generate_video(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    t = threading.Thread(target=proses_kamera, daemon=True)
    t.start()
    
    print("\n=== SERVER FLASK BERJALAN ===")
    print("Buka http://127.0.0.1:5000/video_feed di browser laptop untuk tes")
    print("Tekan CTRL+C untuk berhenti.\n")
    
    app.run(host='0.0.0.0', port=5000, threaded=True)