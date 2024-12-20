<?php

namespace Database\Seeders;

use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            'id' => 1,
            'user_id' => 3,
            'customer_name' => 'Oetomo Hospital',
            'street' => 'Jl. Raya Bojongsoang, Lengkong',
            'city' => 'KABUPATEN BANDUNG',
            'postal_code' => '40287',
            'province' => 'JAWA BARAT',
            'district' => 'BOJONGSOANG',
            'village' => 'LENGKONG',
            'serial_no' => '123456',
            'image' => 'unit-1.jpeg',
            'norec' => Str::orderedUuid(),
        ]);
    }
}
