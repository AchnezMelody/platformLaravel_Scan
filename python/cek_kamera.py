"""
Cek kamera yang tersedia di laptop.
Jalankan:  py cek_kamera.py

Setiap kamera yang ditemukan akan tampil di jendela selama beberapa detik,
supaya kamu bisa lihat index mana yang webcam laptop dan mana yang DroidCam/HP.
Tekan tombol apa saja di jendela preview untuk lanjut lebih cepat.

PENTING: tutup dulu deteksiBotol.py dan aplikasi lain yang memakai kamera.
"""
import cv2

MAKS_INDEX = 5          # cek index 0 sampai 4
LAMA_PREVIEW = 3000     # milidetik tiap preview

BACKEND = [
    (cv2.CAP_DSHOW, "DSHOW"),   # yang dipakai deteksiBotol.py
    (cv2.CAP_MSMF, "MSMF"),     # kadang dibutuhkan untuk kamera Microsoft Phone Link
]

ditemukan = []

for backend, nama_backend in BACKEND:
    print(f"\n=== Backend {nama_backend} ===")
    for i in range(MAKS_INDEX):
        cam = cv2.VideoCapture(i, backend)
        if not cam.isOpened():
            print(f"  Index {i}: -")
            cam.release()
            continue

        ok, frame = cam.read()
        if not ok or frame is None:
            print(f"  Index {i}: terbuka tapi tidak ada gambar")
            cam.release()
            continue

        h, w = frame.shape[:2]
        print(f"  Index {i}: ADA  ({w}x{h})")
        ditemukan.append((nama_backend, i, w, h))

        judul = f"{nama_backend} index {i} - tekan tombol untuk lanjut"
        cv2.putText(frame, f"{nama_backend} INDEX {i}", (20, 50),
                    cv2.FONT_HERSHEY_SIMPLEX, 1.5, (0, 255, 0), 3)
        cv2.imshow(judul, frame)
        cv2.waitKey(LAMA_PREVIEW)
        cv2.destroyWindow(judul)
        cam.release()

cv2.destroyAllWindows()

print("\n=== HASIL ===")
if not ditemukan:
    print("Tidak ada kamera yang terbaca.")
    print("Cek: DroidCam Client sudah Start, kabel/USB debugging OK, tidak ada aplikasi lain yang memakai kamera.")
else:
    for nama_backend, i, w, h in ditemukan:
        print(f"  {nama_backend}  index {i}  ({w}x{h})")
    print("\nPakai index kamera HP di deteksiBotol.py:  INDEX_KAMERA = <angka>")
    print("Kalau kamera HP hanya muncul di MSMF, ganti cv2.CAP_DSHOW jadi cv2.CAP_MSMF di deteksiBotol.py.")