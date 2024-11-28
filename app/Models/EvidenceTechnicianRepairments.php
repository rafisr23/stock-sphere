<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenceTechnicianRepairments extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detailsOfRepairSubmission()
    {
        return $this->belongsTo(DetailsOfRepairSubmission::class, 'details_of_repair_submission_id');
    }
}