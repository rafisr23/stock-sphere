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
    
}
