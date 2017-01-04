<?php

namespace App\ModelSDM;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $connection = 'simsdm';
    protected $table = 'faculty';
}
