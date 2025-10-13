# TODO: Perbaiki Status Dosen Pembimbing di Halaman Mahasiswa

## Deskripsi Masalah
Ketika judul KP sudah di-approve oleh admin prodi, status diubah menjadi 'APPROVED' dan dosen pembimbing sudah ditetapkan. Status "APPROVED" sudah menunjukkan bahwa KP sedang berjalan dan mahasiswa dapat mulai bimbingan.

## Steps to Complete

- [x] Update `app/Http/Controllers/AdminProdi/VerificationController.php` untuk mengubah status menjadi 'APPROVED' saat approve
- [x] Update `resources/views/student/kp/index.blade.php` untuk menampilkan status dengan warna yang sesuai
- [x] Update `resources/views/student/kp/show.blade.php` untuk menampilkan status dengan warna yang sesuai dan tombol bimbingan
- [x] Update `app/Http/Controllers/SupervisorController.php` untuk menampilkan daftar mahasiswa bimbingan dengan benar
- [x] Update `resources/views/supervisor/students/index.blade.php` untuk menampilkan pesan yang sesuai ketika ada mahasiswa yang ditugaskan tetapi belum ada yang disetujui
- [x] Update `app/Http/Controllers/SuperAdmin/SuperAdminController.php` untuk sinkronisasi supervisor_id dengan assigned_supervisor_id di KP applications saat edit user
- [ ] Test perubahan untuk memastikan status tampil dengan benar
