<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionnaireTemplate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'target_role',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi
    public function questions(): HasMany
    {
        return $this->hasMany(QuestionnaireQuestion::class)->orderBy('order');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(QuestionnaireResponse::class);
    }

    // Scope untuk role tertentu
    public function scopeForRole($query, $role)
    {
        return $query->where('target_role', $role)->where('is_active', true);
    }

    // Scope untuk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
