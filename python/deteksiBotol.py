import cv2
import numpy as np
import requests
import time
import threading
from flask import Flask, Response
from flask_cors import CORS
from ultralytics import YOLO

app = Flask(__name__)
CORS(app)

# ================= KONFIGURASI =================
INDEX_KAMERA = 1                 # 0 = webcam laptop, 1 (atau 2) = DroidCam HP
LARAVEL_URL = "http://127.0.0.1:8000/tambah"
COOLDOWN_DETEKSI = 2.0
MODEL_PATH = "yolov8n.pt"

IMGSZ = 640                      # ukuran input YOLO. 640 = akurat. Kalau CPU lemah turunkan ke 480/416
CONF = 0.35                      # ambang keyakinan. Turunkan (0.25) kalau botol sulit terdeteksi
DEBUG_SEMUA_KELAS = False        # True = TES: deteksi semua objek (bukan hanya botol) untuk cek model hidup

LEBAR, TINGGI = 480, 360         # ukuran video yang dikirim ke web (tidak mempengaruhi akurasi YOLO)
JPEG_QUALITY = 60
MAKS_FPS_STREAM = 20             # batas FPS yang dikirim ke browser

# Ambang ukuran botol = persentase luas kotak terhadap luas frame. KALIBRASI dari hasil uji.
AMBANG_BESAR = 0.25
AMBANG_SEDANG = 0.10

# ================= MODEL =================
print("Memuat model YOLO...")
model = YOLO(MODEL_PATH)
model(np.zeros((480, 640, 3), dtype=np.uint8), imgsz=IMGSZ, verbose=False)  # warm-up
print("Model berhasil dimuat!")

# ================= KAMERA =================
camera = cv2.VideoCapture(INDEX_KAMERA, cv2.CAP_DSHOW)
camera.set(cv2.CAP_PROP_BUFFERSIZE, 1)

if not camera.isOpened():
    print(f"PERINGATAN: Kamera di index {INDEX_KAMERA} tidak bisa dibuka!")
    print("Coba ganti INDEX_KAMERA ke 0, 1 atau 2.")

# ================= STATE BERSAMA =================
lock_mentah = threading.Lock()
frame_mentah = None
id_mentah = 0

lock_box = threading.Lock()
box_terbaru = []                 # [(x1, y1, x2, y2, conf, nama)] dalam koordinat frame asli

kondisi = threading.Condition()
jpeg_terbaru = None
id_jpeg = 0

terakhir_kirim = 0


def ukuran_botol(luas_box, luas_frame):
    rasio = luas_box / luas_frame
    if rasio > AMBANG_BESAR:
        return "Besar"
    elif rasio > AMBANG_SEDANG:
        return "Sedang"
    return "Kecil"


def kirim_ke_laravel(ukuran):
    """Kirim ukuran botol (kecil/sedang/besar). Poinnya dihitung di Laravel."""
    try:
        r = requests.post(LARAVEL_URL, data={"ukuran": ukuran.lower()}, timeout=3)
        print(f"[{time.strftime('%H:%M:%S')}] Terkirim ke Laravel ({ukuran}): {r.status_code}")
    except Exception as e:
        print("Gagal kirim ke Laravel:", e)


def baca_kamera():
    """Thread 1: baca kamera, gambar kotak terakhir, encode JPEG untuk web.
    Tidak menunggu YOLO, jadi video selalu lancar."""
    global frame_mentah, id_mentah, jpeg_terbaru, id_jpeg
    while True:
        ok, frame = camera.read()
        if not ok:
            print("Kamera terputus, mencoba lagi...")
            time.sleep(1)
            continue

        with lock_mentah:
            frame_mentah = frame
            id_mentah += 1

        h, w = frame.shape[:2]
        tampil = cv2.resize(frame, (LEBAR, TINGGI))
        sx, sy = LEBAR / w, TINGGI / h

        with lock_box:
            daftar = list(box_terbaru)
        for x1, y1, x2, y2, conf, nama in daftar:
            p1 = (int(x1 * sx), int(y1 * sy))
            p2 = (int(x2 * sx), int(y2 * sy))
            cv2.rectangle(tampil, p1, p2, (0, 255, 0), 2)
            cv2.putText(tampil, f"{nama} {conf:.2f}", (p1[0], max(p1[1] - 6, 12)),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 2)

        ok2, buf = cv2.imencode('.jpg', tampil, [cv2.IMWRITE_JPEG_QUALITY, JPEG_QUALITY])
        if ok2:
            with kondisi:
                jpeg_terbaru = buf.tobytes()
                id_jpeg += 1
                kondisi.notify_all()


def proses_deteksi():
    """Thread 2: YOLO di frame asli, secepat yang CPU mampu."""
    global box_terbaru, terakhir_kirim
    id_terakhir = 0
    kelas = None if DEBUG_SEMUA_KELAS else [39]

    while True:
        with lock_mentah:
            if frame_mentah is None or id_mentah == id_terakhir:
                frame = None
            else:
                frame = frame_mentah
                id_terakhir = id_mentah

        if frame is None:
            time.sleep(0.01)
            continue

        hasil = model(frame, conf=CONF, classes=kelas, imgsz=IMGSZ, verbose=False)[0]

        daftar = []
        for (x1, y1, x2, y2), c, k in zip(hasil.boxes.xyxy.tolist(),
                                          hasil.boxes.conf.tolist(),
                                          hasil.boxes.cls.tolist()):
            daftar.append((x1, y1, x2, y2, c, model.names[int(k)]))

        with lock_box:
            box_terbaru = daftar

        if DEBUG_SEMUA_KELAS:
            if daftar:
                print("Terdeteksi:", [d[5] for d in daftar])
            continue

        if daftar and time.time() - terakhir_kirim > COOLDOWN_DETEKSI:
            terakhir_kirim = time.time()
            h, w = frame.shape[:2]
            # Satu pengiriman = satu botol: pakai kotak terbesar di frame
            x1, y1, x2, y2, _, _ = max(daftar, key=lambda d: (d[2] - d[0]) * (d[3] - d[1]))
            ukuran = ukuran_botol((x2 - x1) * (y2 - y1), w * h)
            print("Botol :", ukuran)
            threading.Thread(target=kirim_ke_laravel, args=(ukuran,), daemon=True).start()


def generate_video():
    id_dikirim = 0
    jeda = 1.0 / MAKS_FPS_STREAM
    while True:
        with kondisi:
            kondisi.wait_for(lambda: id_jpeg != id_dikirim, timeout=2)
            if id_jpeg == id_dikirim:
                continue
            data = jpeg_terbaru
            id_dikirim = id_jpeg

        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + data + b'\r\n')
        time.sleep(jeda)


@app.route('/video_feed')
def video_feed():
    return Response(generate_video(),
                    mimetype='multipart/x-mixed-replace; boundary=frame')


if __name__ == '__main__':
    threading.Thread(target=baca_kamera, daemon=True).start()
    threading.Thread(target=proses_deteksi, daemon=True).start()

    print("\n=== SERVER FLASK BERJALAN ===")
    print("Tes di browser: http://127.0.0.1:5000/video_feed")
    print("Tekan CTRL+C untuk berhenti.\n")

    app.run(host='0.0.0.0', port=5000, threaded=True)