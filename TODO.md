# Questionnaire Fix for DOSEN_SUPERVISOR

## Completed Tasks
- [x] Analyze the issue: questionnaire_template_id null for DOSEN_SUPERVISOR submissions
- [x] Identify root cause: route doesn't pass questionnaire parameter but controller expects it
- [x] Modify QuestionnaireResponseController::store() to handle questionnaire from hidden input for supervisors
- [x] Make questionnaire parameter optional and add logic to fetch from request for DOSEN_SUPERVISOR

## Followup Steps
- [ ] Test questionnaire submission for DOSEN_SUPERVISOR role
- [ ] Verify responses are saved correctly without errors
- [ ] Test that MAHASISWA submissions still work
- [ ] Check that validation and redirects work properly
