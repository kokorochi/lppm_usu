<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DedicationOutputGeneral extends Model
{
    protected $fillable = ['dedication_id', 'item', 'file_name_ori', 'file_name', 'output_description'];

    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }
}
