<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireResponse extends Model
{
    protected $fillable = [
        'questionnaire_template_id',
        'user_id',
        'kp_application_id',
        'responses',
        'submitted_at',
    ];

    protected $casts = [
        'responses' => 'array',
        'submitted_at' => 'datetime',
    ];

    // Relasi
    public function template(): BelongsTo
    {
        return $this->belongsTo(QuestionnaireTemplate::class, 'questionnaire_template_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kpApplication(): BelongsTo
    {
        return $this->belongsTo(KpApplication::class);
    }

    // Scope untuk user tertentu
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope untuk template tertentu
    public function scopeForTemplate($query, $templateId)
    {
        return $query->where('questionnaire_template_id', $templateId);
    }

    // Scope untuk KP application tertentu
    public function scopeForKpApplication($query, $kpApplicationId)
    {
        return $query->where('kp_application_id', $kpApplicationId);
    }
}
