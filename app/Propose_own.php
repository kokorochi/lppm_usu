<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propose_own extends Model {
    protected $table = 'proposes_own';
    protected $fillable = [
        'id',
        'years',
        'dedication_type',
        'scheme',
        'sponsor',
        'member',
        'annotation'
    ];

    public $timestamps = false;
}
