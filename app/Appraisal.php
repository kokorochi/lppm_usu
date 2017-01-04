<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appraisal extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'created_by'];
    protected $dates = ['deleted_at'];  

    public function appraisal_i()
    {
        return $this->hasMany(Appraisal_i::class);
    }
}
