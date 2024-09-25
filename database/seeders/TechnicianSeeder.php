<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('technicians')->insert([
            'name' => 'John Doe',
            'phone' => '1234567890',
            'street' => '123 Main St',
            'city' => 'Anytown',
            'postal_code' => '12345',
            'status' => 'Active',
        ]);
            

    }
}
