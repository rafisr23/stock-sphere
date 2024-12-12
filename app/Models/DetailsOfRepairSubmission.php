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
        return $this->belongsTo(Items_units::class, 'item_unit_id');
    }

    public function getItem()
    {
        return $this->itemUnit->items;
    }

    public function sparepartsOfRepair()
    {
        return $this->hasMany(SparepartsOfRepair::class);
    }
    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }

    public function evidenceTechnician()
    {
        return $this->hasMany(EvidenceTechnicianRepairments::class, 'details_of_repair_submission_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->norec = \Str::orderedUuid();
        });
    }
}
