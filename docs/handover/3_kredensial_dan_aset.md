# DAFTAR KREDENSIAL & INVENTARIS ASET (RAHASIA) - PARMAN FARM

> [!WARNING]
> Dokumen ini bersifat **SANGAT RAHASIA**. Jangan membagikan dokumen ini secara terbuka. Simpan di tempat yang aman (seperti Password Manager) setelah semua kolom diisi.

Dokumen ini berisi semua informasi akses masuk (credentials) dan kepemilikan aset digital untuk aplikasi **Parman Farm**.

---

## 1. Informasi Domain & DNS Management

- **Registrar Domain:** [Misal: Niagahoster / Domainesia / GoDaddy]
- **URL Login Registrar:** [Link Login]
- **Username / Email Login:** `...................................`
- **Password:** `...................................`
- **Nama Domain:** `parman-farm.com` (atau domain yang digunakan)
- **Status Langganan:** Aktif s.d [Tanggal Kedaluwarsa]

---

## 2. Server Hosting / VPS

- **Provider Hosting:** [Misal: DigitalOcean / AWS / IDCloudHost / cPanel]
- **URL Control Panel:** [Link Login Server]
- **Username Login Panel:** `...................................`
- **Password Login Panel:** `...................................`
- **IP Server (Public):** `...................................`
- **Akses SSH (Jika VPS):**
  - **Username:** `root` / `ubuntu`
  - **Port:** `22` (atau port kustom)
  - **Autentikasi:** Password / SSH Key (lampirkan file SSH Private Key secara terpisah)

---

## 3. Akses Basis Data (Database)

- **Database Host:** `127.0.0.1` (atau host database server hosting)
- **Database Port:** `3306`
- **Nama Database:** `parman-farm`
- **Database Username:** `root`
- **Database Password:** `...................................`
- **Link Akses phpMyAdmin / Adminer / Railway Dashboard (Jika ada):** `https://railway.app/`

---

## 4. Akun Administrator Sistem (Default Seed)

Akun default yang diinisialisasi oleh seeder database (`php artisan db:seed`):
- **URL Login Aplikasi:** `https://parman-farm-production.up.railway.app/login`
- **Akun Owner (Pemilik):**
  - **Email/Username:** `owner`
  - **Password:** `12345678`
- **Akun Karyawan (Operator):**
  - **Email/Username:** `karyawan`
  - **Password:** `12345678`

*(Catatan: Klien wajib segera mengubah password default ini setelah login pertama kali untuk keamanan)*

---

## 5. Layanan Pihak Ketiga (Third-Party Services)

### A. SMTP / Pengiriman Email (Untuk Reset Password / Notifikasi)
- **Provider:** [Misal: Brevo / Mailgun / SMTP Gmail]
- **SMTP Host:** `...................................`
- **SMTP Port:** `587` / `465`
- **SMTP Username:** `...................................`
- **SMTP Password:** `...................................`

### B. Penyimpanan Cloud (Jika ada, misal S3/Cloudinary)
- **Provider:** `...................................`
- **API Key / Secret:** `...................................`

### C. WhatsApp/SMS Gateway (Jika ada notifikasi otomatis)
- **Provider:** `...................................`
- **API Token/Key:** `...................................`
