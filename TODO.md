# TODO: Ubah Unggah KRS dan Proposal menjadi Link Drive

## Tugas Utama
- Ubah halaman /companies/{company}/apply untuk mahasiswa: ganti unggah file KRS dan proposal menjadi kolom link drive
- Sesuaikan tampilan pada dosen pembimbing (supervisor verifications)

## Langkah-langkah
1. **Update Migration**: Tambahkan kolom untuk link drive KRS dan proposal
2. **Update Model**: Tambahkan kolom baru ke fillable di KpApplication
3. **Update Controller**: Ubah storeApply untuk menyimpan link drive alih-alih file
4. **Update View Mahasiswa**: Ubah apply.blade.php untuk input link drive
5. **Update View Supervisor**: Ubah verifications/show.blade.php untuk menampilkan link drive
6. **Test**: Pastikan perubahan berfungsi dengan baik

## Status
- [x] Migration untuk kolom link drive
- [x] Update model KpApplication
- [x] Update KpApplicationController storeApply
- [x] Update resources/views/student/kp/apply.blade.php
- [x] Update resources/views/supervisor/verifications/show.blade.php
- [x] Test perubahan (Server running on http://127.0.0.1:8000)
