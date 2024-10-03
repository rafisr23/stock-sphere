<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(Items::class);
    }

    public function technicians()
    {
        return $this->hasMany(Technician::class);
    }
}