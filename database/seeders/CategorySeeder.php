<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        {
            Category::create([
                'name' => 'Apartment',
            ]);
    
            Category::create([
                'name' => 'Own Compound',
            ]);
    
            Category::create([
                'name' => 'Gated Community Spaces',
            ]);
    
            Category::create([
                'name' => 'Townhouses',
            ]);
    
            Category::create([
                'name' => 'Commercial Properties',
            ]);
    
            Category::create([
                'name' => 'Short-Term Rentals',
            ]);

            Category::create([
                'name' => 'Luxury Villas'
            ]);

            Category::create([
                'name' => 'Property Management Services'
            ]);
        }
    }
}
