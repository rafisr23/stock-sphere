<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionOfRepair extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function details()
    {
        return $this->hasMany(DetailsOfRepairSubmission::class, 'submission_of_repair_id');
    }

    // public function getTechnicians()
    // {
    //     return $this->details->map(function ($detail) {
    //         return $detail->technician;
    //     });
    // }

    public function getItems()
    {
        return $this->details->map(function ($detail) {
            return $detail->itemUnit->items;
        });
    }

    public function getItemsUnits()
    {
        return $this->details->map(function ($detail) {
            return $detail->itemUnit;
        });
    }
}