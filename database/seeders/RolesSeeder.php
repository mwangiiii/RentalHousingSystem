<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
=======
>>>>>>> master
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
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
=======
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

    
>>>>>>> master
}
