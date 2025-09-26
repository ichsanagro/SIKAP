<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'kp_application_id',
        'student_id',
        'file_path',
        'submitted_at',
        'status',   // SUBMITTED | VERIFIED_PRODI | REVISION | APPROVED
        'grade',    // nullable, 0-100 (opsional)
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function kpApplication(): BelongsTo
    {
        return $this->belongsTo(KpApplication::class, 'kp_application_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
