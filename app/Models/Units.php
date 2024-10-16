<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function items_units()
    {
        return $this->hasMany(Items_units::class, 'unit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technicians()
    {
        return $this->hasMany(Technician::class, 'unit_id');
    }

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'unit_id');
    }
}