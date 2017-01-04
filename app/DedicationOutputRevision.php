<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DedicationOutputRevision extends Model
{
    protected $fillable = [
        'dedication_id',
        'item',
        'revision_text',
        'created_by',
        'updated_by',
    ];

    protected $touches = ['dedication'];

    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }
}
