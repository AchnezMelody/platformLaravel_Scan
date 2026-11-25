import time
from pathlib import Path
import threading

import cv2
import requests
from ultralytics import YOLO
from flask import Flask, Response
from flask_cors import CORS

# ==========================================
# KONFIGURASI
# ==========================================
BASE = "http://127.0.0.1:8000"
JEDA_KIRIM = 3     # detik minimal antar pengiriman
CEK_STATUS = 1     # detik

# Load model YOLO
model = YOLO(str(Path(__file__).parent / "yolov8n.pt"))
camera = cv2.VideoCapture(1)   # ganti 0 kalau kamera tidak terbuka
if not camera.isOpened():
    raise SystemExit("Kamera tidak bisa dibuka (coba index 0)")

# ==========================================
# SETUP FLASK UNTUK STREAMING KE WEB LARAVEL
# ==========================================
app = Flask(__name__)
CORS(app)
output_frame = None

def generate_frames():
    global output_frame
    while True:
        if output_frame is None:
            time.sleep(0.1)
            continue
        # Encode frame ke JPEG
        (flag, encodedImage) = cv2.imencode(".jpg", output_frame)
        if not flag:
            continue
        yield(b'--frame\r\n' b'Content-Type: image/jpeg\r\n\r\n' + bytearray(encodedImage) + b'\r\n')

@app.route("/video_feed")
def video_feed():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

# ==========================================
# FUNGSI ASLI KAMU
# ==========================================
def cek_status():
    try:
        r = requests.get(f"{BASE}/status", timeout=2)
        r.raise_for_status()
        return r.json()["status"]
    except Exception as e:
        print("Gagal cek status:", e)
        return "berhenti"

def kirim(jenis):
    try:
        r = requests.post(f"{BASE}/tambah", json={"jenis": jenis}, timeout=2)
        r.raise_for_status()
        print("Terkirim ke Laravel:", r.json())
    except Exception as e:
        print("Gagal kirim:", e)

def ukuran(luas):
    if luas > 300:
        return "besar"
    elif luas > 150:
        return "sedang"
    return "kecil"

# ==========================================
# LOOP UTAMA (DETEKSI & KIRIM GAMBAR)
# ==========================================
def loop_kamera():
    global output_frame
    
    status = "berhenti"
    terakhir_cek = 0
    terakhir_kirim = 0
    ada_sebelumnya = False
    
    # ✅ VARIABEL UNTUK OPTIMASI YOLO
    waktu_deteksi_terakhir = 0
    frame_tampil_terakhir = None

    while True:
        ok, frame = camera.read()
        if not ok:
            break

        if time.time() - terakhir_cek > CEK_STATUS:
            status = cek_status()
            terakhir_cek = time.time()

        if status == "jalan":
            try:
                # ✅ OPTIMASI 1: Hanya jalankan YOLO setiap 0.3 detik (sekitar 3 FPS)
                # Ini mengurangi beban CPU secara drastis
                if time.time() - waktu_deteksi_terakhir > 0.3:
                    hasil = model(frame, conf=0.5, classes=[39], verbose=False)[0]
                    frame_tampil_terakhir = hasil.plot() # Simpan hasil gambar ber-kotak
                    waktu_deteksi_terakhir = time.time()

                    ada_sekarang = len(hasil.boxes) > 0
                    if ada_sekarang and not ada_sebelumnya and time.time() - terakhir_kirim > JEDA_KIRIM:
                        x1, y1, x2, y2 = hasil.boxes.xyxy[0].tolist()
                        luas = (x2 - x1) * (y2 - y1)
                        jenis = ukuran(luas)
                        print(f"Botol: {jenis} (luas {luas:.0f})")
                        kirim(jenis)
                        terakhir_kirim = time.time()
                    ada_sebelumnya = ada_sekarang
                
                # Tampilkan gambar terakhir yang sudah ada kotak YOLO-nya
                tampil = frame_tampil_terakhir if frame_tampil_terakhir is not None else frame
            except Exception as e:
                print("Gagal:", e)
                tampil = frame
        else:
            ada_sebelumnya = False
            frame_tampil_terakhir = None # Reset gambar saat berhenti
            tampil = frame

        # ✅ OPTIMASI 2: Perkecil resolusi sebelum dikirim ke web (Lebar 640px)
        # Ini membuat pengiriman gambar di web jauh lebih ringan dan tidak ngelag
        tampil_kecil = cv2.resize(tampil, (640, 480))

        # Simpan frame yang sudah dikecilkan ke variabel global
        output_frame = tampil_kecil.copy()

        # Tampilkan jendela kamera seperti aslinya
        cv2.imshow("YOLO Detection", tampil)
        
        # Tekan 'k' untuk keluar
        if cv2.waitKey(1) & 0xFF == ord("k"):
            break

    camera.release()
    cv2.destroyAllWindows()

# ==========================================
# JALANKAN PROGRAM
# ==========================================
if __name__ == "__main__":
    # 1. Jalankan kamera di background
    t = threading.Thread(target=loop_kamera, daemon=True)
    t.start()

    # 2. Jalankan server streaming Flask
    print("==================================================")
    print("Server Stream berjalan di: http://127.0.0.1:5000/video_feed")
    print("Silakan buka web Laravel di: http://127.0.0.1:8000/mesin")
    print("Tekan 'k' di jendela kamera atau CTRL+C di terminal untuk keluar.")
    print("==================================================")
    
    # host 0.0.0.0 agar bisa diakses, port 5000
    app.run(host="0.0.0.0", port=5000, debug=False, threaded=True)