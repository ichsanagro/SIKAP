<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Questionnaire extends Model
{
    protected $fillable = [
        'kp_application_id',
        'company_rating',
        'supervisor_rating',
        'facilities_rating',
        'overall_experience',
        'suggestions',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'company_rating' => 'integer',
        'supervisor_rating' => 'integer',
        'facilities_rating' => 'integer',
    ];

    // Relasi
    public function kpApplication(): BelongsTo
    {
        return $this->belongsTo(KpApplication::class);
    }
}
