<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyFieldSupervisor extends Model
{
    protected $fillable = [
        'company_id',
        'field_supervisor_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function fieldSupervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'field_supervisor_id');
    }
}
