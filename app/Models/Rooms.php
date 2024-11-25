<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function units()
    {
        return $this->belongsTo(Units::class, 'unit_id');
    }

    public function items_units()
    {
        return $this->hasMany(Items_units::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submission_of_repairs()
    {
        return $this->hasMany(SubmissionOfRepair::class, 'room_id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenances::class, 'room_id');
    }

    public function calibrations()
    {
        return $this->hasMany(Calibrations::class, 'room_id');
    }
}
