# TODO: Update kp-applications/create page for MAHASISWA role

## Tasks
- [x] Update resources/views/student/kp/create.blade.php: Add search bar at top, display company cards below with name, short address, "Info" button.
- [x] Create resources/views/student/kp/company_detail.blade.php: Show full company info (name, address, available quota), "Ajukan KP" button.
- [x] Create resources/views/student/kp/apply.blade.php: Form for applying to specific company (title, upload KRS, upload proposal, submit).
- [x] Create resources/views/student/kp/apply_other.blade.php: Form for applying to other company (title, upload approval document, upload KRS, submit).
- [x] Update app/Http/Controllers/KpApplicationController.php: Add methods companyDetail, applyForm, storeApply, applyOtherForm, storeApplyOther.
- [x] Update routes/web.php: Add routes for company detail, apply form, store apply, apply other form, store apply other.
- [x] Update app/Models/KpApplication.php: Add proposal_path and approval_path to fillable.
- [x] Create migration for proposal_path and approval_path.
- [x] Run migration.
- [ ] Test the flow: Search companies, view detail, apply, submit -> status SUBMITTED (pending for supervisor).
- [x] Add "Ajukan KP di Instansi Lain" button at bottom of create page.

## Notes
- Use Tailwind CSS for cards and layout.
- File uploads: KRS (PDF/JPG/PNG), proposal, approval document.
- Status after submit: 'SUBMITTED', waiting for dosen_supervisor approval.
- Ensure search functionality works (AJAX or simple form submit).
