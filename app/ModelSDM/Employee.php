<?php

namespace App\ModelSDM;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'simsdm';
    protected $table = 'employee';
}
