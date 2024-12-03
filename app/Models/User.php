<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function unit()
    {
        return $this->hasOne(Units::class);
    }

    public function technician()
    {
        return $this->hasOne(Technician::class);
    }

    public function logs()
    {
        return $this->hasMany(NewLog::class);
    }

    public function room()
    {
        return $this->hasOne(Rooms::class);
    }

    public static function boot()
{
    parent::boot();

    static::creating(function ($user) {
        // Cek apakah kolom norec ada di tabel
        if (Schema::hasColumn($user->getTable(), 'norec')) {
            $user->norec = (string) Str::orderedUuid();
        }
    });
}
}