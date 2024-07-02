<?php

namespace Database\Seeders;

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
            ['name' => 'Admin'],
            ['name' => 'Landlord'],
            ['name' => 'Property Manager'],
            ['name' => 'Tenant'],
            ['name' => 'Accountant'],
            ['name' => 'Maintenance Worker'],
            ['name' => 'Lister'],
            ['name' => 'house hunter']
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']]);
        }
      
    }

    
}
