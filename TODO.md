# TODO: Perbaiki Fitur Seminar Mahasiswa

## Tugas Utama
Perbaiki fitur seminar pada role mahasiswa. Jika mahasiswa belum melakukan 10 bimbingan pada halaman mentoring-logs maka akan muncul pesan peringatan jika mahasiswa menekan tombol "Ajukan Seminar" di halaman Seminar.

## Langkah-langkah Implementasi
- [x] Tambahkan validasi di SeminarApplicationController::store untuk memeriksa jumlah bimbingan yang disetujui (status APPROVED) minimal 10.
- [x] Jika belum mencapai 10, redirect kembali dengan pesan error.
- [x] Test fungsionalitas dengan mencoba submit seminar tanpa memenuhi syarat.

## File yang Diedit
- app/Http/Controllers/SeminarApplicationController.php

## Status
- [x] Analisis selesai
- [x] Implementasi validasi
- [x] Testing (syntax check passed)
