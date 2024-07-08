<?php

namespace Database\Seeders;

// use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use App\Models\Role;
// use App\Models\House;
// use Database\Seeders\RolesSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $this->call(RolesSeeder::class);
        $this->call(CategorySeeder::class);

        // $adminRole = Role::where('role_name', 'Admin')->first();
        // $propertyManagerRole = Role::where('role_name', 'Property Manager')->first();
        // $landlordRole = Role::where('role_name', 'Landlord')->first();
        // $maintenanceWorkerRole = Role::where('role_name', 'Maintenance Worker')->first();
        // $accountantRole = Role::where('role_name', 'Accountant')->first();
        // $tenantRole = Role::where('role_name', 'Tenant')->first();

        // Admin Data Seeded
        // User::factory()->create([
        //     'name' => 'Elvis Makara',
        //     'email' => 'makarawahome@gmail.com',
        //     'role_id' => $adminRole->id,
        //     'phone_number' => '+254 701727560',
        //     'id_number' => '41824185',
        //     'password' => Hash::make('123456789')
        // ]);

        // // Property Manager Seeded
        // User::factory()->create([
        //     'email' => 'propertymanager@example.com',
        //     'role_id' => $propertyManagerRole->id,
        //     'password' => Hash::make('password')
        // ]);

        // // Landlord Data Seeded
        // User::factory()->create([
        //     'email' => 'landlord@example.com',
        //     'role_id' => $landlordRole->id,
        //     'password' => Hash::make('password')
        // ]);

        // // Maintenance Worker Seeded
        // User::factory()->create([
        //     'email' => 'maintenance@example.com',
        //     'role_id' => $maintenanceWorkerRole->id,
        //     'password' => Hash::make('password')
        // ]);

        // // Accountant Data Seeded
        // User::factory()->create([
        //     'email' => 'accountant@example.com',
        //     'role_id' => $accountantRole->id,
        //     'password' => Hash::make('password')
        // ]);

        // // Tenant Data Seeded (unverified)
        // User::factory()->count(20)->create([
        //     'role_id' => $tenantRole->id,
        //     'email_verified_at' => null, // For unverified users
        // ]);

        // // Tenant Data Seeded
        // User::factory()->count(20)->create([
        //     'role_id' => $tenantRole->id,
        // ]);
    }
}
