<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items_units extends Model
{
    use HasFactory;

    protected $table = 'items_units';
    protected $fillable = ['item_id', 'unit_id, serial_number', 'software_version', 'installation_date', 'contract', 'end_of_service', 'srs_status', 'last_checked_date'];
}
