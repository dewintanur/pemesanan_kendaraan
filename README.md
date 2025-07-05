# Aplikasi Pemesanan Kendaraan Perusahaan Tambang

Aplikasi ini digunakan untuk mengelola pemesanan kendaraan milik dan sewaan perusahaan tambang, termasuk proses persetujuan berjenjang, pencatatan riwayat kendaraan, jadwal servis, dan pelaporan.

---

## Akun Login

| Role           | Email                   | Password     |
|----------------|--------------------------|--------------|
| Admin          | admin@example.com        | admin123     |
| Approver Level 1 | approver1@example.com   | approver123  |
| Approver Level 2 | approver2@example.com   | approver123  |

---


| Komponen      | Versi                   |
|---------------|--------------------------|
| **PHP**       | 8.2                      |
| **Laravel**   | 11.x                     |
| **MySQL/MariaDB** | 10.4.32 (MariaDB)     |
| **Laravel Excel** | `maatwebsite/excel`  |
| **Chart.js**  | 4.x (melalui CDN)        |
| **Frontend**  | Blade + TailwindCSS/Bootstrap 5 |

---

##  Instalasi

1. **Clone project**
   git clone https://github.com/namamu/pemesanan-kendaraan.git
   cd pemesanan-kendaraan

2. **Install dependency**
    composer install
    npm install && npm run dev

3. **Copy .env dan generate key**
    cp .env.example .env
    php artisan key:generate

4. **Setup database**
    DB_DATABASE=pemesanan_kendaraan
    DB_USERNAME=root
    DB_PASSWORD=

5. **Migrasi & Seeder**
    php artisan migrate:fresh --seed

6. **Jalankan Aplikasi**
    php artisan serve

 
 <!-- PANDUAN PENGGUNAAN -->

 1. **Panduan Penggunaan**
>>>>> Sebagai Admin:
        Login dengan akun admin
        Tambah pemesanan kendaraan
        Pilih driver & atur approver level 1 dan level 2
        Lihat status pemesanan dari menu dashboard
        Lihat grafik penggunaan kendaraan & export laporan

>>>>> Sebagai Approver:
        Login sesuai level
        Lihat daftar pemesanan yang menunggu persetujuan
        Klik "Setujui" atau "Tolak"
        Status pemesanan akan otomatis berubah sesuai aksi

>>>>>> Pengembalian Kendaraan:
        Setelah kendaraan digunakan, admin klik "Kembalikan"
        Isi form riwayat (KM akhir, BBM, dll)
        Kendaraan ditandai telah kembali dan riwayat tersimpan

>>>>>> Fitur Lain:
        Dashboard grafik pemakaian
        Riwayat servis kendaraan
        Log aktivitas user
        Export laporan ke Excel (per tanggal)


LINK GAMBAR ERD DAN ACTIVITY DIAGRAM
https://drive.google.com/drive/folders/1kwmrsXPGUi9ombtGasJy4zHFGuMgs8Iw?usp=sharing