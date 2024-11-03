<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items_units extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function items()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function rooms()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function detailsOfRepairSubmission()
    {
        return $this->hasMany(DetailsOfRepairSubmission::class, 'item_unit_id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenances::class, 'item_room_id');
    }
}
