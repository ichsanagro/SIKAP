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

    public function seminarApplications(): HasMany {
        return $this->hasMany(SeminarApplication::class, 'student_id');
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

    // Auto-update assigned_supervisor_id di KP applications ketika supervisor_id diubah
    protected static function booted() {
        static::updated(function ($user) {
            // Jika user adalah MAHASISWA dan supervisor_id diubah
            if ($user->role === 'MAHASISWA' && $user->wasChanged('supervisor_id')) {
                // Update assigned_supervisor_id untuk KP yang eligible mentoring
                $user->kpApplications()
                    ->whereIn('status', ['ASSIGNED_SUPERVISOR', 'APPROVED', 'COMPLETED'])
                    ->update(['assigned_supervisor_id' => $user->supervisor_id]);
            }
        });
    }
}
