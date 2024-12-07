<?php

namespace Database\Seeders;

use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DetailsOfRepairSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('details_of_repair_submissions')->insert([
            'submission_of_repair_id' => 1,
            'item_unit_id' => 1,
            'technician_id' => 1,
            'quantity' => 1,
            'status' => 0,
            'description' => 'Description 1',
            'date_worked_on' => null,
            'date_completed' => null,
            'date_cancelled' => null,
            'created_at' => now(),
            'norec' => Str::orderedUuid(),
        ]);

        DB::table('details_of_repair_submissions')->insert([
            'submission_of_repair_id' => 1,
            'item_unit_id' => 2,
            'technician_id' => 1,
            'quantity' => 1,
            'status' => 0,
            'description' => 'Description 2',
            'date_worked_on' => null,
            'date_completed' => null,
            'date_cancelled' => null,
            'created_at' => now(),
            'norec' => Str::orderedUuid(),
        ]);

        // sisain 1 item
        // DB::table('details_of_repair_submissions')->insert([
        //     'submission_of_repair_id' => 1,
        //     'item_unit_id' => 3,
        //     'technician_id' => 1,
        //     'quantity' => 1,
        //     'status' => 0,
        //     'description' => 'Description 3',
        //     'date_worked_on' => null,
        //     'date_completed' => null,
        //     'date_cancelled' => null,
        //     'created_at' => now(),
        //     'norec' => Str::orderedUuid(),
        // ]);
    }
}