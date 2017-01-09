<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Propose extends Model {
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'period_id',
        'is_own',
        'faculty_code',
        'title',
        'total_amount',
        'final_amount',
        'file_partner_contract',
        'time_period',
        'bank_account_name',
        'bank_account_no',
        'file_propose',
        'file_propose_final',
        'is_approved'
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function proposesOwn()
    {
        return $this->hasOne(Propose_own::class);
    }

    public function member()
    {
        return $this->hasMany(Member::class);
    }

    public function dedicationPartner()
    {
        return $this->hasMany(Dedication_partner::class);
    }

    public function dedicationReviewer()
    {
        return $this->hasMany(Dedication_reviewer::class);
    }

    public function proposeOutputType()
    {
        return $this->hasMany(ProposeOutputType::class);
    }

    public function flowStatus()
    {
        return $this->hasMany(FlowStatus::class);
    }

    public function reviewPropose()
    {
        return $this->hasMany(ReviewPropose::class);
    }

    public function dedication()
    {
        return $this->hasOne(Dedication::class);
    }

    public function downloadLog()
    {
        return $this->hasMany(DownloadLog::class);
    }
}
