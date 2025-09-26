<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = ['name','email','password','role','nim','prodi'];

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
}
