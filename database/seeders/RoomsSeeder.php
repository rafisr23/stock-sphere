<?php

namespace Database\Seeders;

use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('rooms')->insert([
            'user_id' => 7,
            'unit_id' => 1,
            'name' => 'Radiology',
            'description' => 'Radiology Unit',
            'serial_no' => strval(random_int(1000, 9999)),
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('rooms')->insert([
            'user_id' => 8,
            'unit_id' => 1,
            'name' => 'Laboratory',
            'description' => 'Laboratory Unit',
            'serial_no' => strval(random_int(1000, 9999)),
            'norec' => Str::orderedUuid(),
        ]);
    }
}