<?php

namespace App;

use App\ModelSDM\Lecturer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model {
    use SoftDeletes;
    public $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'item',
        'nidn',
        'status',
        'areas_of_expertise'
    ];

    public function propose()
    {
        return $this->belongsTo(Propose::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'nidn', 'employee_card_serial_number');
    }
}
