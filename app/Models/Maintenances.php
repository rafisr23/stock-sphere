<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenances extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenancesFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function item_room()
    {
        return $this->belongsTo(Items_units::class, 'item_room_id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }
}
