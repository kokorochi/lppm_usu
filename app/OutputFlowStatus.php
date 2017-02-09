<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutputFlowStatus extends Model
{
    protected $fillable = [
        'deedication_id',
        'item',
        'status_code',
        'created_by',
    ];

    public function statusCode()
    {
        return $this->hasOne(StatusCode::class, 'code', 'status_code');
    }
}
