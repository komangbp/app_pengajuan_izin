<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# 📌 Aplikasi Pengajuan Izin

## 📝 Deskripsi
Backend API + Dashboard sederhana untuk sistem pengajuan izin (cuti, sakit, dll) dengan 3 level pengguna:
- **Admin**: Mengelola user, menambah verifikator, melihat semua izin, reset password.
- **Verifikator**: Memverifikasi user, memproses izin (ACC/Tolak/Revisi).
- **User Biasa**: Mengajukan izin, melihat status, update atau batalkan izin.

Dibuat menggunakan **Laravel 10**, **Sanctum** untuk autentikasi API.

---

### Struktur Koleksi
- Auth
  - Register
  - Login
  - Logout
- User Biasa
  - Ajukan Izin
  - Lihat Semua Izin Sendiri
  - Lihat Detail Izin
  - Update Izin
  - Batalkan Izin
  - Hapus Izin
  - Update Password
- Admin
  - Lihat Semua User
  - Tambah Verifikator
  - Ubah User Jadi Verifikator
  - Reset Password User
  - Lihat Semua Izin
- Verifikator
  - Lihat User (Filter Verified)
  - Verifikasi User
  - Lihat Izin (Filter Status)
  - ACC Izin
  - Tolak Izin

---

## 🚀 Instalasi

1. Clone repository:
   ```bash
   git clone https://github.com/komangbp/app_pengajuan_izin.git
   cd app_pengajuan_izin

