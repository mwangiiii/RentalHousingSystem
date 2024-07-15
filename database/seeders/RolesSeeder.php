<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Admin'],
            ['role_name' => 'Property Manager'],
            ['role_name' => 'Landlord'],
            ['role_name' => 'Maintenance Worker'],
            ['role_name' => 'Accountant'],
            ['role_name' => 'Tenant'],
            ['role_name' => 'lister'],
            ['role_name' => 'hunter'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
