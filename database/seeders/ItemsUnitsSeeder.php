<?php

namespace Database\Seeders;

use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemsUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items_units')->insert([
            'item_id' => '1',
            'room_id' => '1',
            'serial_number' => '101076',
            'software_version' => 'VA46A',
            'installation_date' => '2005-05-20 23:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2005-05-20 23:00:00',
            'srs_status' => 'No SRS Connection',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0201',
            'maintenance_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ,
            'calibration_date' => '2006-05-20'
        ]);
        DB::table('items_units')->insert([
            'item_id' => '2',
            'room_id' => '1',
            'serial_number' => '181543',
            'software_version' => 'VA40A-SP03',
            'installation_date' => '2005-05-20 23:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2005-05-20 23:00:00',
            'srs_status' => 'Connected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0302',
            'maintenance_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ,
            'calibration_date' => '2006-05-20'
        ]);
        DB::table('items_units')->insert([
            'item_id' => '3',
            'room_id' => '1',
            'serial_number' => '179979',
            'software_version' => 'VA50M-SP01',
            'installation_date' => '2005-05-20 23:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2005-05-20 23:00:00',
            'srs_status' => 'Disconnected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0303',
            'maintenance_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ,
            'calibration_date' => '2006-05-20'
        ]);
    }
}