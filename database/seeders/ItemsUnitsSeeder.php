<?php

namespace Database\Seeders;

use DB;
use App\Models\User;
use App\Models\Items;
use App\Models\Items_units;
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
        $superadminAccount = User::where('username', 'superadmin')->first();
        
        $itemUnit1 = Items_units::create([
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
        $itemUnit1Log = [
            'norec' => $itemUnit1->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit1->items->item_name . ' to room: ' . $itemUnit1->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit1->id,
            'item_unit_status' => $itemUnit1->status,
        ];
        createLog($itemUnit1Log);

        $itemUnit2 = Items_units::create([
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
        $itemUnit2Log = [
            'norec' => $itemUnit2->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit2->items->item_name . ' to room: ' . $itemUnit2->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit2->id,
            'item_unit_status' => $itemUnit2->status,
        ];
        createLog($itemUnit2Log);

        $itemUnit3 = Items_units::create([
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
        $itemUnit3Log = [
            'norec' => $itemUnit3->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit3->items->item_name . ' to room: ' . $itemUnit3->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit3->id,
            'item_unit_status' => $itemUnit3->status,
        ];
        createLog($itemUnit3Log);
        
        $itemUnit4 = Items_units::create([
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
        $itemUnit4Log = [
            'norec' => $itemUnit4->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit4->items->item_name . ' to room: ' . $itemUnit4->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit4->id,
            'item_unit_status' => $itemUnit4->status,
        ];
        createLog($itemUnit4Log);

        $itemUnit5 = Items_units::create([
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
        $itemUnit5Log = [
            'norec' => $itemUnit5->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit5->items->item_name . ' to room: ' . $itemUnit5->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit5->id,
            'item_unit_status' => $itemUnit5->status,
        ];
        createLog($itemUnit5Log);

        $itemUnit6 = Items_units::create([
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
        $itemUnit6Log = [
            'norec' => $itemUnit6->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit6->items->item_name . ' to room: ' . $itemUnit6->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit6->id,
            'item_unit_status' => $itemUnit6->status,
        ];
        createLog($itemUnit6Log);

        $itemUnit7 = Items_units::create([
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
        $itemUnit7Log = [
            'norec' => $itemUnit7->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit7->items->item_name . ' to room: ' . $itemUnit7->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit7->id,
            'item_unit_status' => $itemUnit7->status,
        ];
        createLog($itemUnit7Log);

        $itemUnit8 = Items_units::create([
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
        $itemUnit8Log = [
            'norec' => $itemUnit8->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit8->items->item_name . ' to room: ' . $itemUnit8->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit8->id,
            'item_unit_status' => $itemUnit8->status,
        ];
        createLog($itemUnit8Log);

        $itemUnit9 = Items_units::create([
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
        $itemUnit9Log = [
            'norec' => $itemUnit9->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit9->items->item_name . ' to room: ' . $itemUnit9->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit9->id,
            'item_unit_status' => $itemUnit9->status,
        ];
        createLog($itemUnit9Log);

        $itemUnit10 = Items_units::create([
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
        $itemUnit10Log = [
            'norec' => $itemUnit10->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit10->items->item_name . ' to room: ' . $itemUnit10->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit10->id,
            'item_unit_status' => $itemUnit10->status,
        ];
        createLog($itemUnit10Log);

        $itemUnit11 = Items_units::create([
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
        $itemUnit11Log = [
            'norec' => $itemUnit11->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit11->items->item_name . ' to room: ' . $itemUnit11->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit11->id,
            'item_unit_status' => $itemUnit11->status,
        ];
        createLog($itemUnit11Log);

        $itemUnit12 = Items_units::create([
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
        $itemUnit12Log = [
            'norec' => $itemUnit12->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit12->items->item_name . ' to room: ' . $itemUnit12->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit12->id,
            'item_unit_status' => $itemUnit12->status,
        ];
        createLog($itemUnit12Log);

        $itemUnit13 = Items_units::create([
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
        $itemUnit13Log = [
            'norec' => $itemUnit13->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit13->items->item_name . ' to room: ' . $itemUnit13->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit13->id,
            'item_unit_status' => $itemUnit13->status,
        ];
        createLog($itemUnit13Log);

        $itemUnit14 = Items_units::create([
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
        $itemUnit14Log = [
            'norec' => $itemUnit14->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit14->items->item_name . ' to room: ' . $itemUnit14->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit14->id,
            'item_unit_status' => $itemUnit14->status,
        ];
        createLog($itemUnit14Log);

        $itemUnit15 = Items_units::create([
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
        $itemUnit15Log = [
            'norec' => $itemUnit15->norec,
            'norec_parent' => $superadminAccount->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Assign item: ' . $itemUnit15->items->item_name . ' to room: ' . $itemUnit15->rooms->name . ' by ' . $superadminAccount->name,
            'item_unit_id' => $itemUnit15->id,
            'item_unit_status' => $itemUnit15->status,
        ];
        createLog($itemUnit15Log);

    }
}