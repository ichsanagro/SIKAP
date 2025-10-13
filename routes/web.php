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
| - Verifications: pakai parameter {application} agar match ke:
|   function approve(Request $r, KpApplication $application)
|--------------------------------------------------------------------------
*/
Route::prefix('admin-prodi')
    ->middleware(['auth', 'role:ADMIN_PRODI,SUPERADMIN'])
    ->name('admin-prodi.')
    ->group(function () {

        // Companies CRUD
        Route::resource('companies', AdminCompanyController::class);

        // Verifications (index, show, approve, reject)
        Route::get('verifications', [VerificationController::class, 'index'])
            ->name('verifications.index');

        Route::get('verifications/{application}', [VerificationController::class, 'show'])
            ->name('verifications.show');

        Route::post('verifications/{application}/approve', [VerificationController::class, 'approve'])
            ->name('verifications.approve');

        Route::post('verifications/{application}/reject', [VerificationController::class, 'reject'])
            ->name('verifications.reject');

        // Assignments
        Route::get('assignments', [AssignmentController::class, 'index'])
            ->name('assignments');

        Route::post('assignments/{kp}/supervisor', [AssignmentController::class, 'assignSupervisor'])
            ->name('assign.supervisor');

        Route::post('assignments/{kp}/field', [AssignmentController::class, 'assignFieldSupervisor'])
            ->name('assign.field');
    });

/*
|--------------------------------------------------------------------------
| Dosen Supervisor
|--------------------------------------------------------------------------
*/
Route::prefix('supervisor')
    ->middleware(['auth', 'role:DOSEN_SUPERVISOR,SUPERADMIN'])
    ->group(function () {
        Route::get('mentoring', [MentoringLogController::class, 'reviewList'])->name('supervisor.mentoring.index');
        Route::post('mentoring/{log}/approve', [MentoringLogController::class, 'approve'])->name('supervisor.mentoring.approve');
        Route::post('mentoring/{log}/revise', [MentoringLogController::class, 'revise'])->name('supervisor.mentoring.revise');
    });

/*
|--------------------------------------------------------------------------
| Pengawas Lapangan
|--------------------------------------------------------------------------
*/
Route::prefix('lapangan')
    ->middleware(['auth', 'role:PENGAWAS_LAPANGAN,SUPERADMIN'])
    ->group(function () {
        Route::get('activities', [ActivityLogController::class, 'reviewList'])->name('field.activities.index');
        Route::post('activities/{log}/approve', [ActivityLogController::class, 'approve'])->name('field.activities.approve');
        Route::post('activities/{log}/revise', [ActivityLogController::class, 'revise'])->name('field.activities.revise');
    });
