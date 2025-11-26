# Sistem Informasi Kepegawaian – Laravel

Aplikasi ini merupakan **Sistem Informasi Kepegawaian** berbasis web yang dibangun menggunakan **Laravel** sebagai bagian dari tugas akhir / skripsi.  
Fitur utama meliputi:

- Manajemen data pegawai  
- Pengajuan dan persetujuan cuti  
- Pencatatan kehadiran pegawai  
- Laporan pegawai, cuti, dan kehadiran (export PDF)  
- Role-based access control (Admin & Pegawai)

---

## 🧰 Teknologi yang Digunakan

- **Framework** : Laravel  
- **Frontend**  : Blade + Tailwind CSS (Laravel Breeze)  
- **Database**  : MySQL  
- **Auth**      : Laravel Breeze (dimodifikasi menjadi login NIP)  
- **PDF**       : barryvdh/laravel-dompdf  

---

## 🧑‍💻 Fitur Utama

### 1. Autentikasi & Role

- Login menggunakan **NIP** & password  
- Role:
  - **Admin** : mengelola data pegawai, cuti, kehadiran, dan laporan  
  - **Pegawai** : mengajukan cuti, melihat riwayat cuti & kehadiran, melihat profil  
- Middleware **role-based access control**  
- Dashboard terpisah untuk Admin & Pegawai  

### 2. Manajemen Data Pegawai

- CRUD data pegawai (oleh admin)
- Relasi otomatis dengan tabel `users`
- Auto-generate akun login pegawai saat data pegawai dibuat
- Sinkronisasi nama & NIP antara `pegawai` dan `users`
- Input jabatan & departemen menggunakan dropdown
- Halaman detail pegawai yang menampilkan:
  - Data kepegawaian
  - Informasi kontak
  - Informasi akun login
- Fitur **Reset Password** oleh admin untuk setiap pegawai

### 3. Modul Cuti

- Pegawai mengajukan cuti melalui form pengajuan  
- Admin dapat melihat seluruh pengajuan cuti  
- Admin memutuskan pengajuan (disetujui / ditolak) menggunakan satu dropdown  
- Keputusan cuti **final** (tidak dapat diedit ulang)  
- Riwayat cuti dapat dilihat oleh pegawai dan admin  

### 4. Modul Kehadiran

- Admin mencatat kehadiran pegawai per tanggal
- Status kehadiran: **hadir, izin, sakit, alpha**
- Rekap kehadiran per tanggal
- Data kehadiran muncul di dashboard dan laporan

### 5. Laporan & Export PDF

- **Laporan Pegawai**
  - Filter berdasarkan status kepegawaian, jabatan, dan departemen
  - Tabel laporan + **Export PDF**

- **Laporan Cuti**
  - Filter berdasarkan periode tanggal, status pengajuan, jenis cuti, dan departemen
  - Tabel laporan + **Export PDF**

- **Laporan Kehadiran**
  - Filter berdasarkan bulan, tahun, dan departemen
  - Rekap hadir/izin/sakit/alpha
  - Tabel laporan + **Export PDF**

### 6. Dashboard Admin

Dashboard admin menampilkan ringkasan:

- Total pegawai, pegawai aktif, kontrak, dan nonaktif  
- Ringkasan cuti (pending, disetujui, ditolak, dan jumlah cuti bulan ini)  
- Ringkasan kehadiran hari ini (hadir, izin, sakit, alpha)  
- Pegawai per departemen (Top 5)  
- Quick link ke:
  - Laporan Pegawai  
  - Laporan Cuti  
  - Laporan Kehadiran  

---

## 🚀 Instalasi & Setup

> Pastikan sudah menginstall PHP, Composer, Node.js, dan MySQL.

1. **Clone Repository**

```bash
git clone <url-repo-github-anda>.git
cd pegawai
