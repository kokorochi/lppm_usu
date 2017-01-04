<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DedicationOutputService extends Model
{
    protected $fillable = ['dedication_id', 'item', 'file_name_ori', 'file_name'];

    protected $touches = ['dedication'];
    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }
}
