<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'Admin',
        ]);

        Role::create([
            'role_name' => 'Landlord',
        ]);

        Role::create([
            'role_name' => 'Property Manager',
        ]);

        Role::create([
            'role_name' => 'Tenant',
        ]);

        Role::create([
            'role_name' => 'Accountant',
        ]);

        Role::create([
            'role_name' => 'Maintenance Worker',
        ]);
    }
}
