<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }

    public function item_unit()
    {
        return $this->belongsTo(Items_units::class, 'item_unit_id');
    }
}