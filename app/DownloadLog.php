<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    protected $fillable = [
        'propose_id',
        'download_type',
        'file_name_ori',
        'file_name',
        'created_by'
    ];

    public function propose()
    {
        return $this->belongsTo(Propose::class);
    }
}
