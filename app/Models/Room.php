<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function units()
    {
        return $this->belongsTo(Units::class);
    }

    public function items()
    {
        return $this->hasMany(Items::class);
    }
}
