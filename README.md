# khgt
Kalender Hijriyah Global Tunggal (manual)

Alur Algoritma

1. Inisialisasi:
- Muat file tahun.php yang berisi data patokan konversi tahun Hijriyah.
- Tentukan tahun Hijriyah yang dipilih pengguna melalui form.
2. Proses:
- Untuk setiap bulan dalam tahun Hijriyah yang dipilih:
- Tampilkan nama bulan dan tahun.
- Hitung tanggal Masehi berdasarkan tanggal Hijriyah.
- Tampilkan kalender bulan dengan informasi tanggal Hijriyah, Masehi, pasaran Jawa, dan tooltip untuk hari-hari penting.
- Simpan offset pasaran Jawa untuk bulan berikutnya.
3. Tampilkan kalender untuk setiap bulan dalam tahun Hijriyah yang dipilih.
4. Sediakan fitur pencetakan kalender bulan dalam format PDF.
5. Tampilkan catatan dan link terkait.

File Eksternal

1. tahun.php: Berisi data patokan konversi tahun Hijriyah.
2. PrayTimes.js: Library untuk menghitung waktu shalat.
3. tanggal.js: Library untuk mengolah tanggal.
4. khgtstyle.css: File CSS untuk styling kalender.
5. html2pdf.js: Library untuk mengubah HTML menjadi PDF.
6. shoutbox.php: File yang berisi kode shoutbox.
7. backup-index.php: File yang berisi kode backup index.

Fungsi Utama

1. convertHijriyahToMasehi(): Mengubah tanggal Hijriyah menjadi Masehi.
2. getPasaranJawa(): Menghitung pasaran Jawa berdasarkan tanggal.
3. convertToArabicNumbers(): Mengubah angka menjadi angka Arab.
4. getTooltip(): Mengembalikan tooltip untuk hari-hari penting.
5. displayMonth(): Menampilkan kalender bulan.
