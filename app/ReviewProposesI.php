<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewProposesI extends Model
{
    public $timestamps = false;
    protected $table = 'review_proposes_i';
    protected $fillable = [
        'review_propose_id',
        'item',
        'aspect',
        'quality',
        'score',
        'comment'
    ];

    public function reviewPropose()
    {
        return $this->belongsTo(ReviewPropose::class);
    }
}
