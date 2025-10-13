<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KpApplicationController;
use App\Http\Controllers\MentoringLogController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\AdminProdi\CompanyController as AdminCompanyController;
use App\Http\Controllers\AdminProdi\VerificationController;
use App\Http\Controllers\AdminProdi\AssignmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Field Supervisor (Pengawas Lapangan)
use App\Http\Controllers\FieldSupervisor\ScoreController as FieldScoreController;
use App\Http\Controllers\FieldSupervisor\StudentController as FieldStudentController;
use App\Http\Controllers\FieldSupervisor\EvaluationController as FieldEvaluationController;
use App\Http\Controllers\FieldSupervisor\CompanyQuotaController as FieldCompanyQuotaController;

/*
|--------------------------------------------------------------------------
| Public / Landing
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Auth (Breeze already registers /login, /register, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dashboard (after login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Logout (POST for CSRF protection)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Umum (authenticated): Download KRS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/kp-applications/{kp}/krs', [KpApplicationController::class, 'downloadKrs'])
        ->name('kp.krs.download');
});

/*
|--------------------------------------------------------------------------
| Mahasiswa
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:MAHASISWA'])->group(function () {
    Route::resource('kp-applications', KpApplicationController::class)
        ->parameters(['kp-applications' => 'kp_application'])
        ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

    Route::post('kp-applications/{kp}/submit', [KpApplicationController::class, 'submit'])
        ->name('kp.submit');

    Route::resource('mentoring-logs', MentoringLogController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('activity-logs', ActivityLogController::class)
        ->only(['index', 'create', 'store']);

    Route::get('reports/create/{kp}', [ReportController::class, 'create'])->name('reports.create');
    Route::post('reports/{kp}', [ReportController::class, 'store'])->name('reports.store');

    Route::get('questionnaire/{kp}', [QuestionnaireController::class, 'create'])->name('questionnaire.create');
    Route::post('questionnaire/{kp}', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
});

/*
|--------------------------------------------------------------------------
| Admin Prodi (+ Superadmin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin-prodi')
    ->middleware(['auth', 'role:ADMIN_PRODI,SUPERADMIN'])
    ->name('admin-prodi.')
    ->group(function () {

        Route::resource('companies', AdminCompanyController::class);

        Route::get('verifications', [VerificationController::class, 'index'])
            ->name('verifications.index');

        Route::get('verifications/{application}', [VerificationController::class, 'show'])
            ->name('verifications.show');

        Route::post('verifications/{application}/approve', [VerificationController::class, 'approve'])
            ->name('verifications.approve');

        Route::post('verifications/{application}/reject', [VerificationController::class, 'reject'])
            ->name('verifications.reject');

        Route::get('assignments', [AssignmentController::class, 'index'])
            ->name('assignments');

        Route::post('assignments/{kp}/supervisor', [AssignmentController::class, 'assignSupervisor'])
            ->name('assign.supervisor');

        Route::post('assignments/{kp}/field', [AssignmentController::class, 'assignFieldSupervisor'])
            ->name('assign.field');
    });

/*
|--------------------------------------------------------------------------
| Super Admin
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\SuperAdmin\SuperAdminController;

Route::prefix('super-admin')
    ->middleware(['auth', 'role:SUPERADMIN'])
    ->name('super-admin.')
    ->group(function () {

        Route::get('/', [SuperAdminController::class, 'dashboard'])->name('index');

        Route::resource('users', SuperAdminController::class)->except(['show']);
        Route::post('users/{user}/toggle-active', [SuperAdminController::class, 'toggleActive'])->name('users.toggle-active');
        Route::get('applications', [SuperAdminController::class, 'applications'])->name('applications.index');
        Route::get('companies', [SuperAdminController::class, 'companies'])->name('companies.index');
        Route::get('mentoring-logs', [SuperAdminController::class, 'mentoringLogs'])->name('mentoring-logs.index');
        Route::get('activity-logs', [SuperAdminController::class, 'activityLogs'])->name('activity-logs.index');
        Route::get('reports', [SuperAdminController::class, 'reports'])->name('reports.index');
        Route::get('scores', [SuperAdminController::class, 'scores'])->name('scores.index');
        Route::get('evaluations', [SuperAdminController::class, 'evaluations'])->name('evaluations.index');
        Route::get('quotas', [SuperAdminController::class, 'quotas'])->name('quotas.index');
    });

/*
|--------------------------------------------------------------------------
| Dosen Supervisor
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\SupervisorController;

Route::prefix('supervisor')
    ->middleware(['auth', 'role:DOSEN_SUPERVISOR,SUPERADMIN'])
    ->name('supervisor.')
    ->group(function () {
        // Dashboard
        Route::get('/', [SupervisorController::class, 'dashboard'])->name('dashboard');

        // Daftar mahasiswa bimbingan - hanya lihat
        Route::get('students', [SupervisorController::class, 'students'])->name('students.index');
        Route::get('students/{kpApplication}', [SupervisorController::class, 'showStudent'])->name('students.show');

        // Catatan bimbingan - lihat, tambah, hapus, ubah
        Route::get('mentoring', [SupervisorController::class, 'mentoringLogs'])->name('mentoring.index');
        Route::get('mentoring/{mentoringLog}', [SupervisorController::class, 'showMentoringLog'])->name('mentoring.show');
        Route::get('mentoring/create', [SupervisorController::class, 'createMentoringLog'])->name('mentoring.create');
        Route::post('mentoring', [SupervisorController::class, 'storeMentoringLog'])->name('mentoring.store');
        Route::get('mentoring/{mentoringLog}/edit', [SupervisorController::class, 'editMentoringLog'])->name('mentoring.edit');
        Route::put('mentoring/{mentoringLog}', [SupervisorController::class, 'updateMentoringLog'])->name('mentoring.update');
        Route::delete('mentoring/{mentoringLog}', [SupervisorController::class, 'destroyMentoringLog'])->name('mentoring.destroy');

        // Memberikan nilai mahasiswa - tambah, ubah
        Route::get('scores', [SupervisorController::class, 'scores'])->name('scores.index');
        Route::get('scores/create', [SupervisorController::class, 'createScore'])->name('scores.create');
        Route::post('scores', [SupervisorController::class, 'storeScore'])->name('scores.store');
        Route::get('scores/{kpScore}/edit', [SupervisorController::class, 'editScore'])->name('scores.edit');
        Route::put('scores/{kpScore}', [SupervisorController::class, 'updateScore'])->name('scores.update');

        // Melihat dokumen mahasiswa - lihat (dengan approve/reject)
        Route::get('documents', [SupervisorController::class, 'documents'])->name('documents.index');
        Route::get('documents/{kpApplication}', [SupervisorController::class, 'showDocument'])->name('documents.show');
        Route::post('documents/reports/{report}/approve', [SupervisorController::class, 'approveReport'])->name('documents.reports.approve');
        Route::post('documents/reports/{report}/reject', [SupervisorController::class, 'rejectReport'])->name('documents.reports.reject');
        Route::post('documents/questionnaires/{questionnaire}/approve', [SupervisorController::class, 'approveQuestionnaire'])->name('documents.questionnaires.approve');
        Route::post('documents/questionnaires/{questionnaire}/reject', [SupervisorController::class, 'rejectQuestionnaire'])->name('documents.questionnaires.reject');

        // Mengisi kuesioner terhadap instansi mitra
        Route::get('questionnaires', [SupervisorController::class, 'questionnaires'])->name('questionnaires.index');
        Route::get('questionnaires/{kpApplication}/create', [SupervisorController::class, 'createQuestionnaire'])->name('questionnaires.create');
        Route::post('questionnaires/{kpApplication}', [SupervisorController::class, 'storeQuestionnaire'])->name('questionnaires.store');
    });

/*
|--------------------------------------------------------------------------
| Pengawas Lapangan (Field Supervisor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:PENGAWAS_LAPANGAN,SUPERADMIN']) // <— PERBAIKAN DI SINI
    ->prefix('field-supervisor')
    ->name('field.')
    ->group(function () {

        // Alias untuk mencegah error "Route [field.activities.index] not defined"
        Route::get('activities', [FieldStudentController::class, 'index'])
            ->name('activities.index');

        // 1) Nilai KP (CRUD)
        Route::resource('scores', FieldScoreController::class)
            ->only(['index','show','create','store','edit','update','destroy']);

        // 2) Data mahasiswa KP (lihat & unassign -> hapus relasi supervisor)
        Route::get('students', [FieldStudentController::class,'index'])->name('students.index');
        Route::get('students/{application}', [FieldStudentController::class,'show'])->name('students.show');
        Route::delete('students/{application}', [FieldStudentController::class,'destroy'])->name('students.destroy');

        // 3) Evaluasi & feedback kuesioner (tambah & ubah)
        Route::resource('evaluations', FieldEvaluationController::class)
            ->only(['index','create','store','edit','update']);

        // 4) Kuota instansi per periode (tambah, ubah, hapus)
        Route::resource('company-quotas', FieldCompanyQuotaController::class)
            ->only(['index','create','store','edit','update','destroy'])
            ->names('company-quotas');
    });
