<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsOfRepairSubmission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function submission()
    {
        return $this->belongsTo(SubmissionOfRepair::class, 'submission_of_repair_id');
    }

    public function itemUnit()
    {
        return $this->belongsTo(ItemUnit::class);
    }

    // public function technician()
    // {
    //     return $this->belongsTo(User::class, 'technician_id');
    // }

    public function getItem()
    {
        return $this->itemUnit->items;
    }

    public function sparepartsOfRepair()
    {
        return $this->hasMany(SparepartsOfRepair::class);
    }
}