<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'superadmin', 
            'guard_name' => 'web',
            'description' => 'Super Admin role is for the highest level of the application access',
        ]);

        Role::create([
            'name' => 'unit', 
            'guard_name' => 'web',
            'description' => 'Unit role is for the admin of the company',
        ]);

        Role::create([
            'name' => 'technician', 
            'guard_name' => 'web',
            'description' => 'Technician role is for the technician of the company',
        ]);

        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@stocksphere.com',
            'username' => 'superadmin',
            'password' => bcrypt('superadmin'),
        ])->assignRole('superadmin');

        $unit = User::create([
            'name' => 'Unit',
            'email' => 'unit@stocksphere.com',
            'username' => 'unit',
            'password' => bcrypt('unit'),
        ])->assignRole('unit');

        $technician = User::create([
            'name' => 'Technician',
            'email' => 'technician@stocksphere.com',
            'username' => 'technician',
            'password' => bcrypt('technician'),
        ])->assignRole('technician');
    }
}