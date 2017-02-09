<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dedication extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'propose_id',
        'file_progress_activity',
        'file_progress_activity_ori',
        'file_progress_budgets',
        'file_progress_budgets_ori',
        'file_final_activity',
        'file_final_activity_ori',
        'file_final_budgets',
        'file_final_budgets_ori',
        'created_by',
    ];
    protected $dates = ['deleted_at'];

    public function propose()
    {
        return $this->belongsTo(Propose::class);
    }

    public function dedicationOutputService()
    {
        return $this->hasMany(DedicationOutputService::class);
    }

    public function dedicationOutputMethod()
    {
        return $this->hasMany(DedicationOutputMethod::class);
    }

    public function dedicationOutputProduct()
    {
        return $this->hasMany(DedicationOutputProduct::class);
    }

    public function dedicationOutputPatent()
    {
        return $this->hasMany(DedicationOutputPatent::class);
    }

    public function dedicationOutputGuidebook()
    {
        return $this->hasMany(DedicationOutputGuidebook::class);
    }

    public function dedicationOutputRevision()
    {
        return $this->hasMany(DedicationOutputRevision::class);
    }

    public function dedicationOutputGeneral()
    {
        return $this->hasMany(DedicationOutputGeneral::class);
    }

    public function outputFlowStatus()
    {
        return $this->hasMany(OutputFlowStatus::class);
    }
}
