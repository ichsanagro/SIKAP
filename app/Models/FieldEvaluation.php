<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldEvaluation extends Model
{
    protected $fillable = ['kp_application_id','supervisor_id','rating','evaluation','feedback'];

    public function application() { return $this->belongsTo(KpApplication::class, 'kp_application_id'); }
    public function supervisor()  { return $this->belongsTo(User::class, 'supervisor_id'); }
}
