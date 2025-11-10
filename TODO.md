# TODO: Perubahan Input Seminar dari File Upload ke Link Drive

## ✅ Completed Tasks
- [x] Buat migrasi database untuk rename kolom `kegiatan_harian_path` dan `bimbingan_kp_path` menjadi `kegiatan_harian_drive_link` dan `bimbingan_kp_drive_link`
- [x] Update model `SeminarApplication` fillable fields
- [x] Update `SeminarApplicationController` validation dan store logic (dari file upload ke URL validation)
- [x] Update view mahasiswa `resources/views/student/seminar/index.blade.php` form input (dari file input ke URL input)
- [x] Update view supervisor `resources/views/supervisor/seminar/index.blade.php` link display
- [x] Update view supervisor `resources/views/supervisor/seminar/show.blade.php` link display
- [x] Update view admin prodi `resources/views/admin_prodi/seminar/index.blade.php` link display
- [x] Jalankan migrasi database

## 🔄 Next Steps
- [ ] Test perubahan pada semua role terkait (mahasiswa, admin prodi, dosen supervisor)
- [ ] Verifikasi bahwa link drive dapat diakses dengan benar
- [ ] Pastikan tidak ada error pada form submission dan display

## 📋 Testing Checklist
- [ ] Mahasiswa dapat menginput link drive kegiatan harian dan bimbingan KP
- [ ] Admin Prodi dapat melihat dan mengklik link drive pada halaman review
- [ ] Dosen Supervisor dapat melihat dan mengklik link drive pada halaman index dan show
- [ ] Link drive terbuka di tab baru dengan target="_blank"
- [ ] Validasi URL berfungsi dengan benar
- [ ] Tidak ada error pada database query setelah migrasi
