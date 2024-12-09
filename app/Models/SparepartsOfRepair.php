<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparepartsOfRepair extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sparepart()
    {
        return $this->belongsTo(Spareparts::class);
    }

    public function detailsOfRepairSubmission()
    {
        return $this->belongsTo(DetailsOfRepairSubmission::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->norec = \Str::orderedUuid();
        });
    }
}