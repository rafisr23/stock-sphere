<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unit()
    {
        return $this->belongsTo(Units::class, 'unit_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function repair()
    {
        return $this->hasMany(DetailsOfRepairSubmission::class, 'technician_id');
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenances::class, 'technician_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->norec = \Str::orderedUuid();
        });
    }

    public function logs()
    {
        return $this->hasMany(NewLog::class, 'technician_id');
    }
}