<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibrations extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function item_room()
    {
        return $this->belongsTo(Items_units::class, 'item_room_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->norec = \Str::orderedUuid();
        });
    }
}