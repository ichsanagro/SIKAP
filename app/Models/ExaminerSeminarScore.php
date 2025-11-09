<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExaminerSeminarScore extends Model
{
    protected $fillable = [
        'kp_application_id',
        'examiner_id',
        'laporan',
        'presentasi',
        'sikap',
        'catatan',
        'total_skor',
        'rata_rata',
        'nilai_huruf',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(KpApplication::class, 'kp_application_id');
    }

    public function examiner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }
}
