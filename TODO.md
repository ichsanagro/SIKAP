# TODO: Edit Mahasiswa Admin Prodi

## Tugas Utama
- [x] Membuat field NIM dan Program Studi di form edit mahasiswa menjadi readonly
- [x] Menghapus validasi required untuk nim dan prodi pada method updateStudent di controller
- [x] Memastikan nilai NIM dan Prodi tetap tersimpan tanpa perubahan

## Langkah-langkah
1. [x] Edit file `resources/views/admin_prodi/students/edit.blade.php`:
   - [x] Tambahkan atribut `readonly` pada input NIM
   - [x] Tambahkan atribut `readonly` pada input Program Studi
   - [x] Hapus atribut `required` dari kedua input tersebut

2. [x] Edit file `app/Http/Controllers/AdminProdi/AdminProdiController.php`:
   - [x] Pada method `updateStudent`, hapus validasi required untuk 'nim' dan 'prodi'
   - [x] Pastikan updateData tidak mengubah nim dan prodi (atau hapus dari updateData jika tidak diperlukan)

## Testing
- [ ] Test form edit mahasiswa untuk memastikan NIM dan Prodi readonly
- [ ] Test submit form untuk memastikan data lainnya bisa diubah
- [ ] Test bahwa NIM dan Prodi tidak berubah setelah edit
