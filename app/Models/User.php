<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    protected $fillable = ['name','email','password','role','nim','prodi','is_active','supervisor_id'];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Helpers
    public function isRole(string $role): bool {
        return $this->role === $role;
    }

    // Relasi mahasiswa
    public function kpApplications(): HasMany {
        return $this->hasMany(KpApplication::class, 'student_id');
    }

    // Relasi supervisor
    public function supervisor(): BelongsTo {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // Relasi field supervisor
    public function supervisedCompanies(): BelongsToMany {
        return $this->belongsToMany(Company::class, 'company_field_supervisors', 'field_supervisor_id', 'company_id');
    }

    // Scope untuk user aktif
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}
