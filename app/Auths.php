<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auths extends Model
{
    use softDeletes;
    protected $table = 'auths';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'auth_object_ref_id', 'begin_date', 'end_date', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
