# Product Requirements Document: Sistem Bengkel Theo

## 1. Ringkasan Produk

Sistem Bengkel Theo adalah aplikasi web untuk membantu operasional bengkel motor dalam mengelola stok sparepart, transaksi penjualan sparepart, booking servis online, pembayaran servis, cetak nota, notifikasi user, dan dashboard laporan operasional.

Produk ini digunakan oleh dua jenis pengguna utama:

- Admin bengkel, untuk mengelola stok, transaksi, booking, pembayaran, nota, dan laporan.
- User pelanggan, untuk melihat stok sparepart dan membuat booking servis online.

## 2. Tujuan Produk

Tujuan utama sistem ini adalah membuat proses administrasi bengkel lebih cepat, rapi, dan mudah dipantau.

Tujuan bisnis:

- Mempermudah admin mencatat dan memantau penjualan sparepart.
- Mempermudah pelanggan melakukan booking servis online.
- Mengurangi pencatatan manual untuk stok, pembayaran, dan nota.
- Menyediakan dashboard untuk melihat performa bengkel.
- Membantu admin mengetahui stok hampir habis dan booking yang belum dibayar.

## 3. Latar Belakang Masalah

Operasional bengkel sering melibatkan banyak data yang berubah setiap hari, seperti stok sparepart, transaksi penjualan, booking pelanggan, pembayaran servis, dan laporan pendapatan. Jika data dicatat manual, admin lebih rentan mengalami kesalahan pencatatan, kehilangan data, atau kesulitan membuat laporan.

Sistem ini dibuat untuk menyatukan proses tersebut ke dalam satu aplikasi web sehingga admin dapat bekerja lebih efisien dan pelanggan dapat melakukan booking tanpa harus datang langsung ke bengkel.

## 4. Ruang Lingkup Produk

### Termasuk Dalam Sistem

- Login dan registrasi user.
- Role admin dan user.
- Dashboard admin.
- Manajemen stok sparepart.
- Penjualan sparepart dan cetak nota.
- Riwayat transaksi penjualan sparepart.
- Booking servis online oleh user.
- Data booking user untuk admin.
- Filter booking berdasarkan status bayar, tanggal booking, nama/plat motor, dan nomor antrian.
- Pembayaran booking servis.
- Cetak nota pembayaran booking.
- Notifikasi pembatalan booking kepada user.
- Grafik penjualan sparepart dan booking servis.
- Ringkasan sparepart paling laris, stok hampir habis, transaksi hari ini, pendapatan bulan ini, dan booking belum dibayar.

### Tidak Termasuk Untuk Versi Saat Ini

- Integrasi payment gateway.
- Integrasi WhatsApp otomatis.
- Multi cabang bengkel.
- Manajemen pegawai/mekanik.
- Laporan ekspor PDF atau Excel.
- Sistem akuntansi lengkap.
- Barcode scanner untuk sparepart.

## 5. Pengguna dan Hak Akses

### Admin

Admin adalah pemilik atau petugas bengkel yang mengelola operasional.

Admin dapat:

- Melihat dashboard.
- Mengelola data stok sparepart.
- Memproses pembelian sparepart.
- Mencetak nota sparepart.
- Melihat data booking user.
- Memfilter data booking.
- Memproses pembayaran booking.
- Mencetak nota servis.
- Membatalkan booking user.
- Melihat laporan dan grafik operasional.

### User

User adalah pelanggan bengkel.

User dapat:

- Registrasi dan login.
- Melihat stok sparepart.
- Membuat booking servis online.
- Memilih nomor antrian.
- Memilih paket servis.
- Menerima notifikasi jika booking dibatalkan admin.

## 6. Fitur Utama

### 6.1 Autentikasi dan Role

Deskripsi:
Sistem menyediakan login, registrasi, dan logout. Setelah login, user diarahkan sesuai role.

Kebutuhan:

- User baru dapat registrasi.
- User dapat login menggunakan email dan password.
- Admin masuk ke dashboard.
- User masuk ke halaman stok sparepart.
- Menu sidebar disesuaikan berdasarkan role.

Kriteria penerimaan:

- User dengan role admin hanya melihat menu admin.
- User biasa tidak dapat membuka halaman admin.
- Logout mengakhiri session pengguna.

### 6.2 Dashboard Admin

Deskripsi:
Dashboard menampilkan ringkasan performa bengkel dan data penting untuk pengambilan keputusan.

Data yang ditampilkan:

- Total penjualan sparepart.
- Total booking servis.
- Total pendapatan sparepart.
- Total transaksi hari ini.
- Total pendapatan bulan ini.
- Booking belum dibayar.
- Sparepart paling laris.
- Stok hampir habis.
- Grafik penjualan sparepart per bulan.
- Grafik servis per bulan.

Kriteria penerimaan:

- Grafik penjualan sparepart hanya bertambah ketika sparepart berhasil terjual.
- Pendapatan bulan ini dihitung dari transaksi sparepart pada bulan berjalan.
- Booking belum dibayar dihitung dari booking yang belum memiliki tanggal pembayaran.
- Stok hampir habis menampilkan sparepart dengan stok rendah.

### 6.3 Manajemen Stok Sparepart

Deskripsi:
Admin dapat menambahkan, mengubah, menghapus, dan melihat stok sparepart.

Data sparepart:

- Nama sparepart.
- Kode sparepart.
- Gambar sparepart.
- Harga.
- Stok.

Kebutuhan:

- Kode sparepart harus unik.
- Harga tidak boleh negatif.
- Stok tidak boleh negatif.
- Gambar bersifat opsional.

Kriteria penerimaan:

- Sparepart yang ditambahkan tampil di katalog admin dan user.
- Admin dapat mencari sparepart berdasarkan nama atau kode.
- User dapat melihat status stok tersedia atau habis.

### 6.4 Penjualan Sparepart

Deskripsi:
Admin dapat memproses pembelian sparepart dari halaman data sparepart.

Alur:

1. Admin memilih sparepart.
2. Admin menekan tombol beli dan print nota.
3. Sistem mengecek stok.
4. Jika stok tersedia, stok berkurang.
5. Sistem menyimpan riwayat transaksi.
6. Sistem menampilkan nota pembelian.

Kriteria penerimaan:

- Pembelian gagal jika stok habis.
- Stok berkurang setelah pembelian berhasil.
- Transaksi tersimpan di riwayat penjualan.
- Grafik penjualan sparepart bertambah setelah transaksi berhasil.
- Nota menampilkan nama produk, kode, harga, jumlah, total, tanggal, dan admin.

### 6.5 Booking Servis Online

Deskripsi:
User dapat membuat booking servis online dengan memilih nomor antrian dan mengisi data kendaraan.

Data booking:

- Nomor antrian.
- Nama.
- Alamat.
- No HP/WA.
- Tanggal booking.
- Plat motor.
- Jenis motor.
- Paket servis.
- Keluhan atau kerusakan motor.

Kebutuhan:

- Nomor antrian harus unik.
- Tanggal booking wajib diisi.
- User dapat memilih paket servis.
- Keluhan motor bersifat opsional.

Kriteria penerimaan:

- Nomor antrian yang sudah digunakan tidak dapat dipilih lagi.
- Booking berhasil tersimpan atas nama user yang login.
- Booking muncul di halaman admin.

### 6.6 Data Booking Admin dan Filter

Deskripsi:
Admin dapat melihat daftar booking user dan memfilter data agar lebih mudah dibaca.

Filter yang tersedia:

- Status bayar.
- Tanggal booking.
- Nama atau plat motor.
- Nomor antrian.

Kriteria penerimaan:

- Filter status bayar dapat menampilkan semua, sudah bayar, atau belum bayar.
- Filter tanggal booking menampilkan data sesuai tanggal yang dipilih.
- Pencarian nama atau plat motor menampilkan data yang sesuai.
- Filter tetap aktif saat pagination.
- Tombol reset menghapus semua filter.

### 6.7 Pembayaran Booking

Deskripsi:
Admin dapat memproses pembayaran booking servis.

Data pembayaran:

- Biaya servis.
- Biaya sparepart.
- Harga paket servis.
- Total bayar.
- Tanggal pembayaran.

Kriteria penerimaan:

- Total bayar dihitung dari harga paket servis, biaya servis, dan biaya sparepart.
- Setelah pembayaran berhasil, status booking berubah menjadi sudah bayar.
- Nota servis dapat dicetak setelah pembayaran.

### 6.8 Nota

Deskripsi:
Sistem menyediakan nota untuk transaksi sparepart dan pembayaran booking.

Kebutuhan:

- Nota dapat dicetak dari browser.
- Nota menampilkan nomor nota.
- Nota menampilkan informasi transaksi.
- Halaman print menyembunyikan sidebar dan topbar.

Kriteria penerimaan:

- Nota sparepart muncul setelah pembelian berhasil.
- Nota booking muncul setelah pembayaran berhasil.
- Layout nota tetap rapi saat dicetak.

### 6.9 Notifikasi User

Deskripsi:
User menerima notifikasi jika booking dibatalkan admin.

Kriteria penerimaan:

- Saat admin membatalkan booking, sistem membuat notifikasi untuk user terkait.
- User melihat modal notifikasi setelah login atau membuka halaman.
- User dapat menandai notifikasi sebagai sudah dibaca.

## 7. Kebutuhan Laporan

Nama laporan yang disarankan:

**Laporan Operasional Bengkel Theo**

Isi laporan:

- Ringkasan penjualan sparepart.
- Ringkasan booking servis.
- Pendapatan sparepart.
- Pendapatan bulan ini.
- Transaksi hari ini.
- Booking belum dibayar.
- Sparepart paling laris.
- Stok hampir habis.
- Grafik penjualan sparepart per bulan.
- Grafik servis per bulan.

Kebutuhan lanjutan:

- Ekspor PDF.
- Ekspor Excel.
- Filter laporan berdasarkan tanggal, bulan, atau tahun.
- Cetak laporan.

## 8. Kebutuhan Non-Fungsional

### Keamanan

- Halaman admin hanya dapat diakses oleh role admin.
- User tidak boleh mengakses data booking milik admin.
- Form wajib memakai validasi server-side.
- Aksi penting seperti hapus dan beli perlu konfirmasi.

### Kinerja

- Halaman daftar memakai pagination.
- Query dashboard harus tetap ringan meskipun data bertambah.
- Filter booking harus tetap menggunakan query database, bukan filter manual di browser.

### Kemudahan Penggunaan

- Sidebar harus jelas berdasarkan role.
- Tombol aksi utama harus mudah ditemukan.
- Status stok dan status bayar harus terlihat jelas.
- Form harus memiliki label yang mudah dipahami.

### Kompatibilitas

- Sistem berjalan di browser modern.
- Tampilan harus tetap dapat digunakan di desktop dan mobile.
- Nota harus dapat dicetak dari browser.

## 9. Struktur Data Utama

### User

- Nama.
- Email.
- Password.
- Role.

### Sparepart

- Nama sparepart.
- Kode sparepart.
- Gambar sparepart.
- Harga.
- Stok.

### Riwayat Penjualan Sparepart

- ID sparepart.
- Nama sparepart.
- Kode sparepart.
- Harga.
- Jumlah.
- Total.
- Tanggal transaksi.

### Booking

- User.
- Nomor antrian.
- Nama pelanggan.
- Alamat.
- No HP/WA.
- Tanggal booking.
- Plat motor.
- Jenis motor.
- Paket servis.
- Harga paket servis.
- Keluhan motor.
- Harga servis.
- Harga sparepart.
- Total bayar.
- Tanggal pembayaran.

### Notifikasi User

- User.
- Judul.
- Pesan.
- Tanggal dibaca.

## 10. Prioritas Pengembangan

### Prioritas Tinggi

- Stabilkan alur transaksi sparepart.
- Tambahkan halaman riwayat penjualan sparepart.
- Simpan nomor nota secara permanen di database.
- Perbaiki test bawaan agar sesuai perilaku aplikasi.
- Tambahkan ekspor laporan PDF atau Excel.

### Prioritas Sedang

- Tambahkan filter laporan.
- Tambahkan indikator stok menipis di halaman sparepart.
- Tambahkan pencarian dan filter pada stok sparepart.
- Rapikan penamaan menu menjadi Data Sparepart dan Transaksi Penjualan.

### Prioritas Rendah

- Integrasi WhatsApp untuk notifikasi booking.
- Barcode scanner sparepart.
- Multi cabang bengkel.
- Manajemen data mekanik.

## 11. Risiko dan Mitigasi

### Risiko: Data penjualan tidak akurat

Mitigasi:
Gunakan tabel riwayat transaksi khusus, bukan tabel stok produk, untuk laporan penjualan.

### Risiko: Stok menjadi negatif

Mitigasi:
Gunakan validasi stok dan transaksi database saat pembelian.

### Risiko: Booking menumpuk dan sulit dicari

Mitigasi:
Gunakan filter status bayar, tanggal booking, nama/plat motor, dan nomor antrian.

### Risiko: Nota berubah saat dicetak ulang

Mitigasi:
Simpan nomor nota permanen saat transaksi atau pembayaran dibuat.

## 12. Metrik Keberhasilan

- Admin dapat menemukan booking tertentu dalam waktu kurang dari 10 detik.
- Admin dapat mengetahui stok hampir habis dari dashboard.
- Admin dapat mencetak nota setelah transaksi tanpa pencatatan manual.
- Laporan dashboard sesuai dengan transaksi yang berhasil.
- User dapat membuat booking tanpa bantuan admin.

## 13. Kesimpulan

Sistem Bengkel Theo berfungsi sebagai alat bantu operasional bengkel yang mencakup stok sparepart, transaksi penjualan, booking servis, pembayaran, nota, notifikasi, dan laporan. Fokus pengembangan berikutnya sebaiknya diarahkan pada laporan yang lebih lengkap, riwayat transaksi, ekspor laporan, dan penyimpanan nomor nota permanen agar sistem semakin siap digunakan dalam operasional harian bengkel.
