<?php

namespace App\ModelSDM;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $connection = 'simsdm';
    protected $table = 'lecturer';
}
