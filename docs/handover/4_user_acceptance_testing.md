# USER ACCEPTANCE TESTING (UAT) - PARMAN FARM
## Lembar Pengujian Aplikasi Oleh Klien

Dokumen ini digunakan untuk memvalidasi bahwa seluruh fitur yang dikembangkan dalam aplikasi **Parman Farm** telah berfungsi dengan baik dan sesuai dengan kesepakatan awal sebelum proyek secara resmi diserahterimakan.

---

- **Nama Penguji (Klien):** `...................................`
- **Tanggal Pengujian:** `...................................`
- **Versi Aplikasi:** `v1.0.0`
- **Status Akhir:** `[ ] Diterima Penuh / [ ] Diterima dengan Catatan / [ ] Ditolak`

---

## Tabel Pengujian Fitur

| ID Tes | Modul/Fitur | Langkah Pengujian | Hasil yang Diharapkan | Status (Lolos/Gagal) | Catatan Klien |
| :--- | :--- | :--- | :--- | :---: | :--- |
| **UAT-01** | Autentikasi | 1. Buka halaman `/login`<br>2. Masukkan email & password salah<br>3. Masukkan email & password benar | 1. Menampilkan pesan error validasi.<br>2. Berhasil masuk ke Dashboard sesuai Role. | `[  ]` | |
| **UAT-02** | Dashboard | 1. Periksa ringkasan statistik (jumlah sapi, produksi harian, status kesehatan). | Data statistik tampil secara dinamis sesuai isi database. | `[  ]` | |
| **UAT-03** | Manajemen Sapi | 1. Buka halaman Sapi.<br>2. Klik Tambah Sapi dan simpan data.<br>3. Ubah data sapi.<br>4. Hapus data sapi. | 1. Data sapi baru tersimpan & memiliki kode unik.<br>2. Perubahan data tersimpan.<br>3. Sapi terhapus dari daftar. | `[  ]` | |
| **UAT-04** | Catatan Kesehatan | 1. Tambah rekam medis untuk Sapi tertentu.<br>2. Set status ke "Perlu Pemantauan" atau "Perlu Tindakan". | 1. Rekam medis tersimpan.<br>2. Status kesehatan sapi di Dashboard dan tabel Sapi ikut berubah. | `[  ]` | |
| **UAT-05** | Catatan Produksi | 1. Input jumlah produksi susu (liter) per sapi.<br>2. Pilih sesi (Pagi/Sore) dan tanggal. | Jumlah susu masuk ke database dan memperbarui grafik dashboard. | `[  ]` | |
| **UAT-06** | Manajemen Mitra | 1. Tambah mitra baru (PT/Koperasi/Perorangan) beserta alamat dan kontak. | Data mitra tersimpan dan bisa dipilih pada menu Penjualan. | `[  ]` | |
| **UAT-07** | Pencatatan Penjualan| 1. Catat transaksi penjualan baru dengan memilih salah satu Mitra.<br>2. Isi jumlah susu/sapi terjual dan total pendapatan. | Transaksi tersimpan, status pembayaran (Selesai/Pending) sesuai opsi. | `[  ]` | |
| **UAT-08** | Laporan Keuangan | 1. Buka menu Laporan.<br>2. Filter berdasarkan rentang tanggal tertentu.<br>3. Klik Ekspor/Cetak. | Laporan menampilkan total akumulasi produksi & penjualan secara akurat sesuai rentang tanggal. | `[  ]` | |

---

## Tanda Tangan Persetujuan

Dengan menandatangani lembar UAT ini, Pihak Klien menyatakan bahwa fitur-fitur di atas telah diuji dan berfungsi sebagaimana mestinya.

\
\
**(----------------------------------------)** \
*Perwakilan Pihak Klien (Penguji)* \
Tanggal: 
