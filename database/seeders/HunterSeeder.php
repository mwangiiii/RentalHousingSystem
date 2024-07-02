<?php

namespace Database\Seeders;

use App\Models\Hunter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HunterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 5 hunters
        Hunter::factory()->count(5)->create();
    }
}
