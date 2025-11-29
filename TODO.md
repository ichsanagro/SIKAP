# TODO List for Link Validation Update

## Task: Modify link input validation in companies/../apply to show "Link tidak valid" for invalid links like https://drive.com/

### Steps:
1. ✅ Update KpApplicationController.php to add custom validation for drive links
   - ✅ Add regex validation to ensure links are valid Google Drive URLs (not just base domain)
   - ✅ Customize error messages to "Link tidak valid"
   - ✅ Apply to both storeApply and storeApplyOther methods

2. ✅ Update JavaScript validation in apply.blade.php for better UX
   - ✅ Add client-side check to prevent submission of invalid links
   - ✅ Show "Link tidak valid" message immediately

3. ✅ Test the changes
   - ✅ Server starts without syntax errors
   - ✅ Validation logic implemented correctly
   - ✅ Error messages set to "Link tidak valid"
