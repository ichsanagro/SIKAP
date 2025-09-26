<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'kp_application_id',
        'student_id',
        'date',
        'description',
        'photo_path',
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
}
