# TODO: Perbaikan Bimbingan Mahasiswa

## Masalah
Mahasiswa yang telah masuk ke daftar mahasiswa dosen pembimbing (melalui `supervisor_id`) tidak dapat melakukan bimbingan karena `assigned_supervisor_id` di KP tidak di-set dengan benar.

## Analisis
1. Mahasiswa di-assign ke supervisor melalui `User::supervisor_id`
2. Supervisor dapat approve KP mahasiswa yang assigned kepadanya
3. Tapi `assigned_supervisor_id` di `KpApplication` tidak di-set otomatis saat approve
4. Mentoring memerlukan `assigned_supervisor_id` yang tidak null

## Solusi
Ketika supervisor approve KP, pastikan `assigned_supervisor_id` di-set berdasarkan `supervisor_id` mahasiswa.

## Langkah Perbaikan
- [ ] Update `Supervisor/VerificationController::approve()` untuk set `assigned_supervisor_id` jika belum ada
- [ ] Test perbaikan dengan membuat KP baru dan approve oleh supervisor
