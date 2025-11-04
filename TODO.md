# TODO: Add Validation for Duplicate Mentoring Log Dates

## Steps to Complete:
1. [x] Modify the `store` method in `MentoringLogController.php` to add a check for existing mentoring logs on the same date for the student.
2. [x] Add the validation logic after the initial request validations.
3. [x] If a log exists on the same date, return back with the error message "Anda sudah melakukan bimbingan di hari itu." and preserve input.
4. Test the functionality to ensure the validation works correctly.
