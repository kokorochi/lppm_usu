<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DedicationOutputMethod extends Model
{
    protected $fillable = [
        'dedication_id',
        'item',
        'file_name_ori',
        'file_name',
        'annotation',
    ];

    protected $touches = ['dedication'];

    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }
}
