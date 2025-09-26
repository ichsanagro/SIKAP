<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = ['name','address','contact_person','contact_phone','batch','quota'];

    public function kpApplications(): HasMany {
        return $this->hasMany(KpApplication::class);
    }
}
