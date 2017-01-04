<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auth_Object_Ref extends Model
{
    protected $table = 'auth_object_ref';
    protected $fillable = ['object_desc'];
}
