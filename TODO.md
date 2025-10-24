# TODO: Add Field Supervisors Page for Admin Prodi

## Pending Tasks
- [x] Add fieldSupervisors(), createFieldSupervisor(), storeFieldSupervisor(), editFieldSupervisor(), updateFieldSupervisor(), destroyFieldSupervisor(), toggleFieldSupervisorActive() methods to AdminProdiController.php
- [x] Create resources/views/admin_prodi/field_supervisors/index.blade.php (table with ID, Name, Email, Institution, Status, Actions)
- [x] Create resources/views/admin_prodi/field_supervisors/create.blade.php
- [x] Create resources/views/admin_prodi/field_supervisors/edit.blade.php
- [x] Add field-supervisors routes in web.php (index, create, store, edit, update, destroy, toggle-active)
- [x] Add field supervisors link in ADMIN_PRODI menu in sidebar.blade.php
- [x] Add field supervisors link in "Data & Statistik" section and add field_supervisors count to stats in admin_prodi/index.blade.php

## Followup steps
- [ ] Test accessing the field supervisors page
- [ ] Verify company relationships display correctly
- [ ] Ensure actions work (edit, toggle, delete)
