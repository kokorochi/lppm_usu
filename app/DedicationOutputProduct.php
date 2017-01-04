<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DedicationOutputProduct extends Model
{
    protected $fillable = [
        'dedication_id',
        'file_blueprint_ori',
        'file_blueprint',
        'file_finished_good_ori',
        'file_finished_good',
        'file_working_pic_ori',
        'file_working_pic',
    ];
    
    protected $touches = ['dedication'];

    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }
}
