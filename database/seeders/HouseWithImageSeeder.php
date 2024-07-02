<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\Image;
use App\Models\Lister;

class HouseWithImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed 3 listers first
        Lister::factory()->count(3)->create()->each(function ($lister) {
            // For each lister, create 1 associated house
            $house = House::factory()->create(['lister_id' => $lister->id]);

            // For each house, create 3 associated images
            Image::factory()->count(3)->create(['house_id' => $house->id]);
        });
    }
}
