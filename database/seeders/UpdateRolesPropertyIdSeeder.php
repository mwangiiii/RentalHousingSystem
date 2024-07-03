<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateRolesPropertyIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultPropertyId = Property::first()->id;

        Role::whereNull('property_id')->update(['property_id' => $defaultPropertyId]);
    }
}
