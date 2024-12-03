<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SparepartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spareparts')->insert([
            // Syngo.via View&GO (Item_ID: 1)
            [
                'item_id' => 1,
                'name' => 'Power Supply Unit (PSU)',
                'serial_no' => 'PSU123',
                'description' => 'Power supply unit for server',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 1,
                'name' => 'Hard Disk/SSD',
                'serial_no' => 'HDD500',
                'description' => '500GB SSD for data storage',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 1,
                'name' => 'RAM 16GB',
                'serial_no' => 'RAM16',
                'description' => '16GB RAM for high-performance computing',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 1,
                'name' => 'Graphics Processing Unit (GPU)',
                'serial_no' => 'GPU1080',
                'description' => 'NVIDIA GTX 1080 GPU for image rendering',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 1,
                'name' => 'Cooling System',
                'serial_no' => 'COOLX1',
                'description' => 'Cooling system for server',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],

            // SOMATOM go.Top (Item_ID: 2)
            [
                'item_id' => 2,
                'name' => 'X-ray Tube',
                'serial_no' => 'XRAYT01',
                'description' => 'X-ray tube for CT scanner',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 2,
                'name' => 'High Voltage Generator',
                'serial_no' => 'HVG200',
                'description' => 'High voltage generator for X-ray tube',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 2,
                'name' => 'Cooling Oil',
                'serial_no' => 'COIL500',
                'description' => 'Cooling oil for X-ray tube',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 2,
                'name' => 'CT Scanner Detector',
                'serial_no' => 'CTDET100',
                'description' => 'CT scanner detector for image capture',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 2,
                'name' => 'Patient Table Motor',
                'serial_no' => 'TABLEM01',
                'description' => 'Motor for patient table movement',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],

            // MAGNETOM Sempra (CN) (Item_ID: 3)
            [
                'item_id' => 3,
                'name' => 'Magnet Cooling System',
                'serial_no' => 'MAGCOOL01',
                'description' => 'Cooling system for MRI magnet',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 3,
                'name' => 'Gradient Coil',
                'serial_no' => 'GRADCOIL01',
                'description' => 'Gradient coil for MRI scanner',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 3,
                'name' => 'RF Amplifier',
                'serial_no' => 'RFAMP500',
                'description' => 'Radiofrequency amplifier for MRI scanner',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 3,
                'name' => 'RF Coil',
                'serial_no' => 'RFCOIL100',
                'description' => 'Radiofrequency coil for signal reception',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => 3,
                'name' => 'Helium Compressor',
                'serial_no' => 'HECOMP200',
                'description' => 'Helium compressor for magnet cooling',
                'is_generic' => false,
                'norec' => Str::orderedUuid(),
            ],[
                'item_id' => null,
                'name' => 'Gloves',
                'serial_no' => 'GLV001',
                'description' => 'Disposable medical gloves',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => null,
                'name' => 'Flashlight',
                'serial_no' => 'FLASH001',
                'description' => 'LED flashlight for examination',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => null,
                'name' => 'Screwdriver Set',
                'serial_no' => 'TOOL001',
                'description' => 'Screwdriver set for equipment repair',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => null,
                'name' => 'Surgical Mask',
                'serial_no' => 'MASK001',
                'description' => 'Disposable surgical mask',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
            [
                'item_id' => null,
                'name' => 'Digital Thermometer',
                'serial_no' => 'THERMO001',
                'description' => 'Digital thermometer for temperature measurement',
                'is_generic' => true,
                'norec' => Str::orderedUuid(),
            ],
        ]);
    }
}