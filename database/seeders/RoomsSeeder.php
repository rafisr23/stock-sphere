<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            'user_id' => 6,
            'unit_id' => 1,
            'name' => 'ICU',
            'description' => 'Intensive Care Unit',
            'serial_no' => strval(random_int(1000, 9999)),
        ]);

        DB::table('rooms')->insert([
            'user_id' => 7,
            'unit_id' => 1,
            'name' => 'Radiology',
            'description' => 'Radiology Unit',
            'serial_no' => strval(random_int(1000, 9999)),
        ]);

        DB::table('rooms')->insert([
            'user_id' => 8,
            'unit_id' => 1,
            'name' => 'Laboratory',
            'description' => 'Laboratory Unit',
            'serial_no' => strval(random_int(1000, 9999)),
        ]);
    }
}
