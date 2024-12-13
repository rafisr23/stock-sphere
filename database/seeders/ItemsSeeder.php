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
            'item_description' => 'Alat syngo.via View&GO',
            'downtime' => '365',
            'modality' => 'Syngo',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 2,
            'item_name' => 'SOMATOM go.Top',
            'item_description' => 'Alat SOMATOM go.Top',
            'downtime' => '365',
            'modality' => 'Computed Tomography',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 3,
            'item_name' => 'MAGNETOM Sempra (CN)',
            'item_description' => 'Alat MAGNETOM Sempra (CN)',
            'downtime' => '365',
            'modality' => 'Magenetic Resonance',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 4,
            'item_name' => 'AED/Defibrillator',
            'item_description' => 'Alat AED/Defibrillator',
            'merk' => 'Mindray',
            'distributor' => 'PT. Cyber Medical Indonesia',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 5,
            'item_name' => 'Anesthesi Unit',
            'item_description' => 'Alat Anesthesi Unit',
            'merk' => 'Mindray',
            'distributor' => 'PT. Cyber Medical Indonesia',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 6,
            'item_name' => 'Anesthesi Unit',
            'item_description' => 'Alat Anesthesi Unit',
            'merk' => 'GE Healthcare',
            'distributor' => 'PT. Surgika Alkesindo',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 7,
            'item_name' => 'Auto Lensmeter',
            'item_description' => 'Alat Auto Lensmeter',
            'merk' => 'Nidek',
            'distributor' => 'PT. Pusaka Mulya Medika',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 8,
            'item_name' => 'Auto Ref/Keratometer',
            'item_description' => 'Alat Auto Ref/Keratometer',
            'merk' => 'Nidek',
            'distributor' => 'PT. Pusaka Mulya Medika',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 9,
            'item_name' => 'Autoclave',
            'item_description' => 'Alat Autoclave',
            'merk' => 'GEA',
            'distributor' => 'PT. PT. Inti Hasil Medicatama',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 10,
            'item_name' => 'Biosafety Cabinet',
            'item_description' => 'Alat Biosafety Cabinet',
            'merk' => 'MYC07',
            'distributor' => 'PT. Ganesha Mycolab Indonesia',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 11,
            'item_name' => 'Blood Bank',
            'item_description' => 'Alat Blood Bank',
            'merk' => 'Beku Box',
            'distributor' => 'PT. Hospi Niaga',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 12,
            'item_name' => 'Blood Tube Roller Mixer',
            'item_description' => 'Alat Blood Tube Roller Mixer',
            'merk' => 'One Med',
            'distributor' => 'PT. Intisumber Hasil Sempurna Global',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 13,
            'item_name' => 'Carescape Central Station',
            'item_description' => 'Alat Carescape Central Station',
            'merk' => 'GE',
            'distributor' => 'PT. IDS Medical Systems Indonesia',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 14,
            'item_name' => 'Cariotocograph (CTG)',
            'item_description' => 'Alat Cariotocograph (CTG)',
            'merk' => 'Bistos',
            'distributor' => '',
            'norec' => Str::orderedUuid(),
        ]);
        DB::table('items')->insert([
            'id' => 15,
            'item_name' => 'Centrifuge',
            'item_description' => 'Alat Centrifuge',
            'merk' => 'EBGA',
            'distributor' => 'PT. Prima Alkesindo Nusantara',
            'norec' => Str::orderedUuid(),
        ]);
    }
}