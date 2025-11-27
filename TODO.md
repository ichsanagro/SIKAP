# TODO: Remove Kuota Menu and Pages for PENGAWAS_LAPANGAN Role

## Steps to Complete
- [x] Edit resources/views/layouts/sidebar.blade.php to remove Kuota links for PENGAWAS_LAPANGAN
- [x] Edit resources/views/field_supervisor/dashboard.blade.php to remove quota management link
- [x] Delete resources/views/field_supervisor/company_quotas/ directory and all files inside
- [x] Edit routes/web.php to remove company-quotas routes
- [x] Delete app/Http/Controllers/FieldSupervisor/CompanyQuotaController.php
- [x] Delete app/Models/CompanyQuota.php
- [x] Run php artisan route:clear and view:clear to clear caches
- [x] Test the changes by logging in as PENGAWAS_LAPANGAN user
