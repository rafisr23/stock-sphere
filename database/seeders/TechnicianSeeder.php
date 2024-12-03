<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('technicians')->insert([
            'name' => 'Asep Suandi',
            'phone' => '1234567890',
            'street' => '123 Main St',
            'city' => 'KOTA BANDUNG',
            'postal_code' => '12345',
            'status' => 'active',
            'province' => 'JAWA BARAT',
            'district' => 'COBLONG',
            'village' => 'DAGO',
            'user_id' => 4,
            'unit_id' => 1,
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('technicians')->insert([
            'name' => 'Budi Santoso',
            'phone' => '1234567890',
            'street' => '123 Main St',
            'city' => 'KOTA BANDUNG',
            'postal_code' => '12345',
            'status' => 'active',
            'province' => 'JAWA BARAT',
            'district' => 'COBLONG',
            'village' => 'DAGO',
            'user_id' => 5,
            'unit_id' => 1,
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('technicians')->insert([
            'name' => 'Cahya Putra',
            'phone' => '1234567890',
            'street' => '123 Main St',
            'city' => 'KOTA BANDUNG',
            'postal_code' => '12345',
            'status' => 'active',
            'province' => 'JAWA BARAT',
            'district' => 'COBLONG',
            'village' => 'DAGO',
            'user_id' => 6,
            'unit_id' => 1,
            'norec' => Str::orderedUuid(),
        ]);
        
        DB::table('technicians')->insert([
            'name' => 'Tech Lead',
            'phone' => '1234567890',
            'street' => '123 Main St',
            'city' => 'KOTA BANDUNG',
            'postal_code' => '12345',
            'status' => 'active',
            'province' => 'JAWA BARAT',
            'district' => 'COBLONG',
            'village' => 'DAGO',
            'user_id' => 39,
            'unit_id' => 1,
        ]);
            

    }
}