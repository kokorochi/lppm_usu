<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposeOutputType extends Model
{
    protected $fillable = [
        'item',
        'propose_id',
        'output_type_id'
    ];
    public $timestamps = false;
    protected $touches = ['propose'];

    public function propose()
    {
        return $this->belongsTo(Propose::class);
    }

    public function outputType()
    {
        return $this->belongsTo(Output_type::class);
    }
}
