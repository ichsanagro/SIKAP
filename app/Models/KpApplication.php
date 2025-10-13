<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KpApplication extends Model
{
    protected $fillable = [
        // kolom existing
        'student_id',
        'title',
        'placement_option',
        'company_id',
        'custom_company_name',
        'custom_company_address',
        'start_date',
        'status',
        'assigned_supervisor_id',
        'field_supervisor_id',
        'notes',
        'krs_path',

        // kolom verifikasi admin_prodi
        'verification_status',
        'verification_notes',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'verified_at' => 'datetime',
    ];

    // ====== RELATIONS ======
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_supervisor_id');
    }

    public function fieldSupervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'field_supervisor_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function mentoringLogs(): HasMany
    {
        return $this->hasMany(MentoringLog::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }

    // ====== HELPERS ======
    public function statusBadgeClass(): string
    {
        return match ($this->verification_status) {
            'APPROVED' => 'bg-green-100 text-green-700',
            'REJECTED' => 'bg-red-100 text-red-700',
            default    => 'bg-yellow-100 text-yellow-700', // PENDING / null
        };
    }
}
