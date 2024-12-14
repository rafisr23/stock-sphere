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
            'calibration_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
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
            'calibration_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
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
            'calibration_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items_units')->insert([
            'item_id' => '4',
            'room_id' => '4',
            'serial_number' => 'FQ-23062649',
            'software_version' => '-',
            'installation_date' => '2005-05-20 23:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2005-05-20 23:00:00',
            'srs_status' => 'No SRS Connection',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0201',
            'maintenance_date' => '2006-05-20',
            'calibration_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '5',
            'room_id' => '5',
            'serial_number' => 'DW-32014897',
            'software_version' => '-',
            'installation_date' => '2005-05-20 23:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2005-05-20 23:00:00',
            'srs_status' => 'Connected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0302',
            'maintenance_date' => '2006-05-20',
            'calibration_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '6',
            'room_id' => '5',
            'serial_number' => 'APKA00945',
            'software_version' => '-',
            'installation_date' => '2005-05-20 23:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2005-05-20 23:00:00',
            'srs_status' => 'Disconnected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0303',
            'maintenance_date' => '2006-05-20',
            'calibration_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items_units')->insert([
            'item_id' => '7',
            'room_id' => '4',
            'serial_number' => '505540',
            'software_version' => '-',
            'installation_date' => '2005-05-20 23:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2005-05-20 23:00:00',
            'srs_status' => 'No SRS Connection',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0201',
            'maintenance_date' => '2006-05-20',
            'calibration_date' => '2006-05-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '8',
            'room_id' => '4',
            'serial_number' => '230709',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'Connected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0302',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '9',
            'room_id' => '3',
            'serial_number' => '-',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'Disconnected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0303',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items_units')->insert([
            'item_id' => '10',
            'room_id' => '3',
            'serial_number' => '-',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'No SRS Connection',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0201',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '11',
            'room_id' => '3',
            'serial_number' => 'XC268L-000014',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'Connected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0302',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '12',
            'room_id' => '3',
            'serial_number' => 'VF225AK000095',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'Disconnected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0303',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items_units')->insert([
            'item_id' => '13',
            'room_id' => '1',
            'serial_number' => 'SNF21280018SA',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'No SRS Connection',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0201',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '14',
            'room_id' => '6',
            'serial_number' => 'AFNA0070',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'Connected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0302',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('items_units')->insert([
            'item_id' => '15',
            'room_id' => '3',
            'serial_number' => '0037130-06',
            'software_version' => '-',
            'installation_date' => '2024-10-20 16:00:00',
            'contract' => 'EXTENDED WARRANTY',
            'end_of_service' => '2025-10-20 16:00:00',
            'srs_status' => 'Disconnected',
            'last_checked_date' => '2005-05-20 23:00:00',
            'status' => 'Running',
            'functional_location_no' => '700-40305299-0303',
            'maintenance_date' => '2025-01-20',
            'calibration_date' => '2025-10-20',
            'norec' => Str::orderedUuid(),
        ]);

    }
}