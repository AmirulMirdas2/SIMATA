# SIMATA (Sistem Manajemen Tiket Terminal Aceh)

**Tugas Proyek Mata Kuliah Proyek Perangkat Lunak** > Disusun oleh: 
* Halim Elsa Putra (2308107010062)
* M. Milan Ramadhan (2308107010064)
* Amirul Mirdas (2308107010070)
* Mahardika Shiddiq Anshari (23081070100)

**SIMATA** adalah sistem informasi terintegrasi untuk melayani pemesanan dan pengelolaan operasional tiket bus antarkota di wilayah Aceh. Sistem ini mengusung konsep *paperless*, otomatisasi transaksi, dan pencegahan praktik calo melalui digitalisasi terminal berbasis *real-time*.

---

## Fitur Utama Sistem

Proyek ini dibagi ke dalam tiga modul utama yang saling terintegrasi:

### 1. Modul Penumpang (Client-Side / Mobile Web)
*Fokus: Kemudahan Akses & Transaksi Real-time (Mobile First).*

* **Pencarian & Filter Cerdas:** Pengguna dapat mencari jadwal bus berdasarkan Kota Asal, Kota Tujuan, dan Tanggal. Hasil menampilkan opsi armada, jam keberangkatan, harga, dan sisa kursi.
* **Visualisasi Denah Kursi (Interactive Seat Selection):** Pemilihan kursi langsung pada denah grafis bus dengan indikator warna: Hijau (Tersedia), Merah (Terisi), Kuning (Sedang Dipilih).
* **Manajemen Data Penumpang:** Mendukung *Auto-fill* data diri (Nama, NIK, No. HP) untuk mempercepat pemesanan berikutnya.
* **Pembayaran Digital (Payment Gateway):** Terintegrasi dengan metode pembayaran instan (QRIS, VA, E-Wallet). Status pembayaran terdeteksi otomatis tanpa perlu unggah bukti transfer.
* **E-Ticket & QR Code (Paperless):** Tiket digital dengan QR Code unik terbit secara instan sesaat setelah pembayaran sukses.
* **Riwayat Transaksi:** Pelacakan status tiket secara *real-time* (Pending Payment, Paid/Issued, Expired, Cancelled).

### 2. Modul Administrator (Admin Dashboard / Web)
*Fokus: Monitoring & Manajemen Data (Tanpa Validasi Manual).*

* **Dashboard Eksekutif (Real-time):** Menampilkan statistik visual total pendapatan harian/bulanan dan grafik tingkat keterisian kursi per armada.
* **Manajemen Master Data (CRUD):** Pengelolaan data PO Bus, Fasilitas, Layout Kursi, pengaturan tarif dasar, dan rute perjalanan.
* **Manajemen Jadwal & Kuota:** Pembuatan jadwal keberangkatan (*Assign Bus to Route*) dan fitur *Block Seat* untuk kebutuhan operasional khusus.
* **Laporan Manifest Digital:** Laporan daftar penumpang final yang otomatis terisi dan dapat diunduh/dicetak untuk keperluan sopir atau kondektur.
* **Monitoring Transaksi:** Pelacakan log transaksi masuk dari Payment Gateway secara transparan.

### 3. Fitur Backend & Sistem (API Service)
*Fokus: Keamanan Data & Integrasi Pihak Ketiga.*

* **Payment Gateway Webhook:** API *callback* untuk menerima sinyal dari Payment Gateway dan mengubah status tiket menjadi *Paid* secara otomatis.
* **Concurrency Control (Penguncian Kursi):** Sistem *temporary lock* untuk mencegah *double-booking* ketika ada dua pengguna yang memilih kursi sama di waktu bersamaan.
* **QR Code Generator:** Pembuatan gambar QR unik secara dinamis berbasis ID Transaksi saat tiket diterbitkan.
* **Auto-Cancel Scheduler:** Sistem *cron job* yang membatalkan pesanan otomatis jika pengguna tidak membayar dalam batas waktu (misal: 15 menit), dan mengembalikan kursi menjadi *Available*.

---

## Dokumentasi Perancangan Sistem

Untuk menjaga repositori tetap rapi, seluruh diagram arsitektur dan perancangan *database* disimpan secara terpisah. Silakan klik tautan di bawah ini untuk melihat detail masing-masing diagram:

* **[Data Flow Diagram (DFD Level 0) - Aliran Data Sistem](./docs/diagrams/dfd.png)**
* **[Entity-Relationship Diagram (ERD) - Struktur Database](./docs/diagrams/erd.png)**
* **[Logical Record Structure (LRS) - Relasi Tabel Fisik](./docs/diagrams/lrs.png)**

---

## Teknologi yang Digunakan (Tech Stack)

* **Front-end:**
* **Back-end:** 
* **Database:** 
* **Integrasi:**

---

## Tim Pengembang

Proyek ini dikembangkan secara kolaboratif oleh:
* **Front-end Developer:** Halim & Milan
* **Back-end Developer:** Amirul & Mahardika

---

### Langkah-langkah
1. **Clone repositori ini:**
   ```bash
   git clone [https://github.com/username/simata-repo.git](https://github.com/username/simata-repo.git)
   cd simata-repo
