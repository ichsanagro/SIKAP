<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeminarApplication extends Model
{
    protected $fillable = [
        'student_id',
        'kegiatan_harian_path',
        'bimbingan_kp_path',
        'status',
        'examiner_id',
        'admin_note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function examiner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }

    // Helpers
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'APPROVED' => 'bg-green-100 text-green-700',
            'REJECTED' => 'bg-red-100 text-red-700',
            default    => 'bg-yellow-100 text-yellow-700', // PENDING
        };
    }

    public function statusText(): string
    {
        return match ($this->status) {
            'APPROVED' => 'Disetujui',
            'REJECTED' => 'Ditolak',
            default    => 'Pending',
        };
    }
}
