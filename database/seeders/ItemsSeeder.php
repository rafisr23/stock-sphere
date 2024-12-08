<?php

namespace Database\Seeders;

use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            'id' => 1,
            'item_name' => 'syngo.via View&GO',
            'item_description' => 'Description 1',
            'downtime' => '365',
            'modality' => 'Syngo',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 2,
            'item_name' => 'SOMATOM go.Top',
            'item_description' => 'Description 2',
            'downtime' => '365',
            'modality' => 'Computed Tomography',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 3,
            'item_name' => 'MAGNETOM Sempra (CN)',
            'item_description' => 'Description 3',
            'downtime' => '365',
            'modality' => 'Magenetic Resonance',
            'norec' => Str::orderedUuid(),
        ]);
    }
}