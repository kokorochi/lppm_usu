<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appraisal_i extends Model
{
    protected $table = 'appraisals_i';
    protected $fillable = ['id', 'item', 'aspect', 'quality'];
    public $timestamps = false;

    public function appraisal()
    {
        return $this->belongsTo(Appraisal::class, 'id', 'id');
    }
}
