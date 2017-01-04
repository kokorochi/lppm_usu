<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'years',
        'category_type',
        'dedication_type',
        'appraisal_type',
        'scheme',
        'sponsor',
        'min_member',
        'max_member',
        'propose_begda',
        'propose_endda',
        'review_begda',
        'review_endda',
        'first_begda',
        'first_endda',
        'monev_begda',
        'monev_endda',
        'last_begda',
        'last_endda',
        'annotation',
    ];

    protected $dates = ['deleted_at'];

    public function categoryType()
    {
        return $this->belongsTo(Category_type::class);
    }

    public function dedicationType()
    {
        return $this->belongsTo(Dedication_type::class);
    }

    public function appraisal()
    {
        return $this->belongsTo(Appraisal::class);
    }

    public function propose()
    {
        return $this->hasMany(Propose::class);
    }
}
