<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionOfRepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('submission_of_repairs')->insert([
            'unit_id' => 1,
            'room_id' => 1,
            'status' => 0,
            'description' => 'Description 1',
            'date_submitted' => now(),
            'date_worked_on' => null,
            'estimated_date_completed' => null,
            'date_completed' => null,
            'date_cancelled' => null,
        ]);
    }
}
