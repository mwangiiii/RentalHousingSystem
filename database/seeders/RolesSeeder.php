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
        $roles = [
            ['role_name' => 'Admin'],
            ['role_name' => 'Landlord'],
            ['role_name' => 'Property Manager'],
            ['role_name' => 'Tenant'],
            ['role_name' => 'Accountant'],
            ['role_name' => 'Maintenance Worker'],
            ['role_name' => 'Lister'],
            ['role_name' => 'House hunter']
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['role_name' => $role['role_name']]);
        }
      
    }

    
}
