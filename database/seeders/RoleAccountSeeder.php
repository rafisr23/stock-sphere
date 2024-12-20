<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

        Role::create([
            'name' => 'room',
            'guard_name' => 'web',
            'description' => 'Room role is for the admin of each room in the company',
        ]);

        $permission = Permission::create(['name' => 'assign technician']);

        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@simpellada.com',
            'username' => 'superadmin',
            'password' => bcrypt('superadmin'),
        ])->assignRole('superadmin');

        $unit = User::create([
            'name' => 'Unit',
            'email' => 'unit@simpellada.com',
            'username' => 'unit',
            'password' => bcrypt('unit'),
        ])->assignRole('unit');

        $technician = User::create([
            'name' => 'Technician',
            'email' => 'technician@simpellada.com',
            'username' => 'technician',
            'password' => bcrypt('technician'),
        ])->assignRole('technician');

        $technician2 = User::create([
            'name' => 'Technician 2',
            'email' => 'technician2@simpellada.com',
            'username' => 'technician2',
            'password' => bcrypt('technician2'),
        ])->assignRole('technician');

        $icu = User::create([
            'name' => 'ICU',
            'email' => 'icu@simpellada.com',
            'username' => 'icu',
            'password' => bcrypt('icu'),
        ])->assignRole('room');

        $radiology = User::create([
            'name' => 'Radiology',
            'email' => 'radiology@simpellada.com',
            'username' => 'radiology',
            'password' => bcrypt('radiology'),
        ])->assignRole('room');

        $laboratory = User::create([
            'name' => 'Laboratory',
            'email' => 'laboratory@simpellada.com',
            'username' => 'laboratory',
            'password' => bcrypt('laboratory'),
        ])->assignRole('room');

        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => 'User Room' . $i,
                'email' => 'user_room' . $i . '@simpellada.com',
                'username' => 'user_room' . $i,
                'password' => bcrypt('password'),
            ])->assignRole('room');
        }

        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => 'User Tech' . $i,
                'email' => 'user_tech' . $i . '@simpellada.com',
                'username' => 'user_tech' . $i,
                'password' => bcrypt('password'),
            ])->assignRole('technician');
        }

        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => 'User Unit' . $i,
                'email' => 'user_unit' . $i . '@simpellada.com',
                'username' => 'user_unit' . $i,
                'password' => bcrypt('password'),
            ])->assignRole('unit');
        }

        $techLeader = User::create([
            'name' => 'Technician Leader',
            'email' => 'techlead@simpellada.com',
            'username' => 'techlead',
            'password' => bcrypt('techlead'),
        ])->assignRole('technician')->givePermissionTo($permission);

        $rajal = User::create([
            'name' => 'Rajal',
            'email' => 'rajal@simpellada.com',
            'username' => 'rajal',
            'password' => bcrypt('rajal'),
        ])->assignRole('room');

        $ibs = User::create([
            'name' => 'IBS',
            'email' => 'ibs@simpellada.com',
            'username' => 'ibs',
            'password' => bcrypt('ibs'),
        ])->assignRole('room');

        $vk = User::create([
            'name' => 'VK',
            'email' => 'vk@simpellada.com',
            'username' => 'vk',
            'password' => bcrypt('vk'),
        ])->assignRole('room');
    }
}