<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyQuota extends Model
{
    protected $fillable = ['company_id','period','quota'];

    public function company() { return $this->belongsTo(Company::class); }
}
