<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DedicationOutputGuidebook extends Model
{
    protected $fillable = [
        'dedication_id',
        'title',
        'book_year',
        'publisher',
        'isbn',
        'file_cover_ori',
        'file_cover',
        'file_back_ori',
        'file_back',
        'file_table_of_contents_ori',
        'file_table_of_contents',
    ];

    protected $touches = ['dedication'];

    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }
}
