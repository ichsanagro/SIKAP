# TODO: Ubah Lampiran Mentoring Logs ke Link Drive

## Tugas Utama
- Ubah kolom lampiran pada halaman create mentoring logs untuk mahasiswa dari upload file menjadi input link Google Drive saja.
- Sesuaikan halaman yang sama untuk dosen pembimbing.

## Langkah-langkah
- [x] Ubah view mahasiswa: resources/views/student/mentoring/create.blade.php - ganti input file dengan input text untuk link drive.
- [x] Ubah view dosen: resources/views/supervisor/mentoring/create.blade.php - sama.
- [x] Ubah controller mahasiswa: MentoringLogController::store - ubah validation 'attachment' => 'nullable|url', simpan $request->attachment langsung ke attachment_path.
- [x] Ubah controller dosen: SupervisorController::storeMentoringLog - sama.
- [x] Ubah view show mahasiswa: resources/views/student/mentoring/show.blade.php - deteksi link drive vs file lokal.
- [x] Ubah view show dosen: resources/views/supervisor/mentoring/show.blade.php - sama.
- [x] Ubah view edit dosen: resources/views/supervisor/mentoring/edit.blade.php - ubah input attachment ke URL.
- [x] Ubah controller update dosen: SupervisorController::updateMentoringLog - ubah validation dan penyimpanan.
- [ ] Test: Pastikan form submit berhasil dan link tersimpan.

## Status
- Implementasi selesai. Semua perubahan telah diterapkan pada view dan controller untuk create, show, dan edit.
