<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function items_units()
    {
        return $this->hasMany(Items_units::class, 'item_id');
    }

    public function sparepart()
    {
        return $this->belongsTo(Spareparts::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
