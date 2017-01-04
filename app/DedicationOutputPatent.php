<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DedicationOutputPatent extends Model
{
    protected $fillable = [
        'dedication_id',
        'patent_no',
        'patent_year',
        'patent_owner_name',
        'patent_type',
        'file_patent_ori',
        'file_patent',
    ];

    protected $touches = ['dedication'];

    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }
}
