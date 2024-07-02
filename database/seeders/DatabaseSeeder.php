<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
=======
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\House;
>>>>>>> master

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesSeeder::class);

<<<<<<< HEAD
        $adminRole = Role::where('role_name', 'Admin')->first();
        $propertyManagerRole = Role::where('role_name', 'Property Manager')->first();
        $landlordRole = Role::where('role_name', 'Landlord')->first();
        $maintenanceWorkerRole = Role::where('role_name', 'Maintenance Worker')->first();
        $accountantRole = Role::where('role_name', 'Accountant')->first();
        $tenantRole = Role::where('role_name', 'Tenant')->first();
=======
        $adminRole = Role::where('name', 'Admin')->first();
        $propertyManagerRole = Role::where('name', 'Property Manager')->first();
        $landlordRole = Role::where('name', 'Landlord')->first();
        $maintenanceWorkerRole = Role::where('name', 'Maintenance Worker')->first();
        $accountantRole = Role::where('name', 'Accountant')->first();
        $tenantRole = Role::where('name', 'Tenant')->first();
>>>>>>> master

        // Admin Data Seeded
        User::factory()->create([
            'name' => 'Elvis Makara',
            'email' => 'makarawahome@gmail.com',
<<<<<<< HEAD
            'role_id' => $adminRole->id,
=======
            'roles_id' => $adminRole->id,
>>>>>>> master
            'phone_number' => '+254 701727560',
            'id_number' => '41824185',
            'password' => Hash::make('123456789')
        ]);

<<<<<<< HEAD
        // Property Manager Seeded
        User::factory()->create([
            'email' => 'propertymanager@example.com',
            'role_id' => $propertyManagerRole->id,
=======
        User::factory()->create([
            'name' => 'Dennis Wanjiku',
            'email' => 'dennis.wanjiku@strathmore.edu',
            'roles_id' => $adminRole->id,
            'phone_number' => '+254743614394',
            'id_number' => '41191771',
            'password' => Hash::make('123456789')
        ]);

        // Property Manager Seeded
        User::factory()->create([
            'email' => 'propertymanager@example.com',
            'roles_id' => $propertyManagerRole->id,
>>>>>>> master
            'password' => Hash::make('password')
        ]);

        // Landlord Data Seeded
        User::factory()->create([
            'email' => 'landlord@example.com',
<<<<<<< HEAD
            'role_id' => $landlordRole->id,
=======
            'roles_id' => $landlordRole->id,
>>>>>>> master
            'password' => Hash::make('password')
        ]);

        // Maintenance Worker Seeded
        User::factory()->create([
            'email' => 'maintenance@example.com',
<<<<<<< HEAD
            'role_id' => $maintenanceWorkerRole->id,
=======
            'roles_id' => $maintenanceWorkerRole->id,
>>>>>>> master
            'password' => Hash::make('password')
        ]);

        // Accountant Data Seeded
        User::factory()->create([
            'email' => 'accountant@example.com',
<<<<<<< HEAD
            'role_id' => $accountantRole->id,
=======
            'roles_id' => $accountantRole->id,
>>>>>>> master
            'password' => Hash::make('password')
        ]);

        // Tenant Data Seeded (unverified)
<<<<<<< HEAD
        User::factory()->count(20)->create([
            'role_id' => $tenantRole->id,
=======
        User::factory()->count(5)->create([
            'roles_id' => $tenantRole->id,
>>>>>>> master
            'email_verified_at' => null, // For unverified users
        ]);

        // Tenant Data Seeded
<<<<<<< HEAD
        User::factory()->count(20)->create([
            'role_id' => $tenantRole->id,
        ]);
    }
}
=======
        User::factory()->count(2)->create([
            'roles_id' => $tenantRole->id,
        ]);

        $this->call(CategorySeeder::class);
        $this->call(HouseWithImageSeeder::class);
        
    }
}
>>>>>>> master
