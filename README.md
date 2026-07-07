# ODOT ERP

ODOT ERP adalah aplikasi Enterprise Resource Planning (ERP) dan Point of Sale (POS) berbasis web yang dikembangkan menggunakan **Laravel 12**, **Tailwind CSS v4**, dan **Alpine.js**. Aplikasi ini dirancang untuk memudahkan pengelolaan kasir, inventaris, hingga pelaporan dengan antarmuka yang modern, cepat, dan responsif.

## 🚀 Fitur Utama

- **Autentikasi & RBAC (Role-Based Access Control)**
  Terdapat 3 peran (Role) utama dengan hak akses spesifik menggunakan Spatie Permission:
  - **Pemilik (Owner)**: Akses penuh ke seluruh sistem (Manajemen User, Laporan Lengkap).
  - **Admin**: Akses manajemen produk, kategori, dan pergerakan stok.
  - **Kasir**: Akses khusus untuk melakukan transaksi Point of Sale (POS).

- **Manajemen Inventaris (Inventory)**
  - Pengelolaan Kategori Produk.
  - Pengelolaan Produk (SKU, Harga, Stok).
  - Pencatatan Pergerakan Stok (Barang Masuk / Keluar).

- **Point of Sale (POS)**
  - Antarmuka kasir yang interaktif, cepat, dan mudah digunakan (dibangun dengan Alpine.js).
  - Sistem keranjang belanja langsung di halaman.
  - Cetak struk termal secara instan.

- **Dashboard & Pelaporan**
  - Ringkasan harian (Pendapatan, Total Transaksi, dll).
  - Grafik Penjualan interaktif menggunakan Chart.js.
  - Laporan penjualan dan pergerakan stok.

## 🛠 Teknologi yang Digunakan

- **Backend**: [Laravel 12](https://laravel.com/)
- **Frontend**: Blade Templates, [Tailwind CSS v4](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/)
- **Database**: MySQL (Kompatibel dengan PostgreSQL / Supabase)
- **Role Management**: [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- **Charts**: [Chart.js](https://www.chartjs.org/)

## 📦 Kebutuhan Sistem

- PHP 8.2 atau lebih baru
- Composer 2.x
- Node.js & NPM
- MySQL / PostgreSQL

## ⚙️ Cara Instalasi

1. **Clone Repositori**
   ```bash
   git clone https://github.com/thirza-rep/ODOT.git
   cd ODOT
   ```

2. **Install Dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database & Seeding**
   Jalankan migrasi beserta *seeder* untuk membuat peran, kategori, produk awal, dan pengguna default.
   ```bash
   php artisan migrate:fresh --seed
   ```
   > **Catatan**: *Seeder* akan otomatis membuat akun Admin (`admin@odot.test`) dan Pemilik (`pemilik@odot.test`) dengan kata sandi `password`.

5. **Jalankan Aplikasi**
   Buka 2 terminal terpisah, lalu jalankan perintah berikut:
   
   Terminal 1 (Menjalankan server Laravel):
   ```bash
   php artisan serve
   ```
   
   Terminal 2 (Menjalankan Vite untuk memproses CSS/JS):
   ```bash
   npm run dev
   ```

6. Buka aplikasi di browser pada alamat: `http://localhost:8000`

## 🎨 Desain & UI/UX
ODOT ERP menggunakan palet warna yang modern dan lembut:
- **Soft Blue** (`#4F7DF3`) sebagai warna utama.
- **Mint Green** (`#00C9A7`) sebagai warna aksen kesuksesan.
- Efek *Glassmorphism* dan animasi transisi ringan pada berbagai komponen (kartu, modal, notifikasi).

---
*Dibuat untuk mempermudah bisnis Anda.*
