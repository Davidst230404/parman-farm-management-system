# RENCANA PEMELIHARAAN & SLA (MAINTENANCE PLAN) - PARMAN FARM
## Ketentuan Dukungan Pasca-Serah Terima Proyek

Dokumen ini menjelaskan rencana perawatan, dukungan teknis, garansi kerusakan (*bug*), serta kebijakan backup data untuk aplikasi **Parman Farm** setelah masa serah terima selesai dilakukan.

---

## 1. Masa Garansi & Perbaikan Bug (Bug Warranty)

- **Durasi Garansi:** `......` bulan (Rekomendasi: 1 - 3 Bulan) terhitung sejak tanggal penandatanganan **Berita Acara Serah Terima (BAST)**.
- **Cakupan Garansi:**
  - Perbaikan gratis atas kesalahan logika program (*bug*), kesalahan fungsionalitas sistem, atau kegagalan sistem yang disebabkan oleh kesalahan pengkodean awal oleh Developer.
  - Penyesuaian minor jika terdapat ketidaksesuaian tampilan pada peramban (*browser*) modern yang umum digunakan.
- **Hal yang TIDAK Dicakup Garansi:**
  - Penambahan fitur baru di luar kesepakatan awal (*change request*).
  - Kerusakan sistem yang diakibatkan oleh kelalaian Klien (seperti kesalahan modifikasi server, kehilangan kredensial, serangan siber pihak luar, atau infeksi malware pada server klien).
  - Gangguan konektivitas internet atau kegagalan infrastruktur hosting/domain pihak ketiga.

---

## 2. Kebijakan Backup Data (Data Backup Policy)

Untuk mencegah kehilangan data penting akibat kegagalan server, Klien disarankan menerapkan prosedur backup berikut:

### A. Backup Database Otomatis (Rekomendasi)
Pencatatan harian seperti data Sapi, Produksi Susu harian, dan Penjualan sangat krusial. Oleh karena itu:
- **Frekuensi Backup:** Setiap hari pukul 02:00 WIB (saat lalu lintas server sepi).
- **Format Output:** File `.sql` atau `.sql.gz`.
- **Lokasi Penyimpanan Backup:** Disimpan pada direktori lokal server yang aman dan secara berkala diunggah ke penyimpanan awan sekunder (Google Drive / AWS S3 / Dropbox).

### B. Cara Melakukan Backup Database secara Manual
Melalui server terminal atau phpMyAdmin:
```bash
mysqldump -u [db_username] -p [db_name] | gzip > backup_parman_farm_$(date +%F).sql.gz
```

### C. Prosedur Pemulihan Data (Database Recovery/Restore)
Jika database mengalami korupsi atau kehilangan data, ikuti langkah berikut:
1. Pastikan database kosong atau buat database baru.
2. Gunakan perintah berikut di terminal:
   ```bash
   gunzip < backup_parman_farm_yyyy-mm-dd.sql.gz | mysql -u [db_username] -p [db_name]
   ```

---

## 3. Dukungan Teknis & Hubungan Kerja (SLA / Service Level Agreement)

Setelah masa garansi berakhir, Klien dapat memilih untuk melanjutkan pemeliharaan secara bulanan (*Retainer Maintenance Agreement*) dengan ketentuan layanan pendukung sebagai berikut:

### A. Saluran Dukungan (Support Channels)
Pengajuan bantuan masalah dapat dikirimkan melalui:
- **Email:** `support@yourdomain.com`
- **WhatsApp Support:** `+628xxxxxxxxxx`

### B. Waktu Respons Berdasarkan Tingkat Keparahan (Severity Level)

| Tingkat Masalah | Deskripsi Masalah | Waktu Respon Maksimal | Waktu Target Solusi |
| :--- | :--- | :---: | :---: |
| **Kritis (Critical)** | Aplikasi mati total (*down*), database tidak bisa diakses, atau transaksi penjualan gagal diproses. | 1 Jam | 6 Jam |
| **Sedang (Medium)** | Beberapa fungsi tidak berjalan (misal: grafik di dashboard tidak muncul), namun aplikasi utama masih bisa diakses. | 4 Jam | 24 Jam |
| **Rendah (Low)** | Perubahan teks minor, kesalahan tata letak visual (*styling*), atau pertanyaan seputar penggunaan sistem. | 12 Jam | 48 Jam |

---

## 4. Pembaruan Rutin & Pemeliharaan Server

Untuk menjaga performa aplikasi tetap optimal, aktivitas pemeliharaan berkala berikut perlu dilakukan:
1. **Pembersihan Log:** Menghapus file log Laravel lama di folder `storage/logs/` secara rutin.
2. **Pembaruan Paket Keamanan:** Melakukan update versi PHP minor dan sistem operasi server secara berkala untuk menambal celah keamanan.
3. **Pemantauan Disk Space:** Memastikan sisa kapasitas penyimpanan server berada di atas 20%.
