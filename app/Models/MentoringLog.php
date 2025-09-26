<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentoringLog extends Model
{
    protected $fillable = [
        'kp_application_id',
        'student_id',
        'supervisor_id',
        'date',
        'topic',
        'notes',
        'attachment_path',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function kpApplication(): BelongsTo
    {
        return $this->belongsTo(KpApplication::class, 'kp_application_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
