<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewPropose extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['propose_id', 'nidn', 'suggestion', 'conclusion_id'];

    public function reviewProposesI()
    {
        return $this->hasMany(ReviewProposesI::class);
    }

    public function conclusion()
    {
        return $this->belongsTo(Conclusion::class);
    }

    public function propose()
    {
        return $this->belongsTo(Propose::class);
    }
}
