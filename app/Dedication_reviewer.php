<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dedication_reviewer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'propose_id',
        'item',
        'nidn',
        'created_by',
        'updated_by'
    ];

    public function propose()
    {
        return $this->belongsTo(Propose::class);
    }
}
