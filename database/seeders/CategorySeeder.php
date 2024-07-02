<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Apartment'],
            ['name' => 'Own Compound'],
            ['name' => 'Gated Community Spaces'],
            ['name' => 'Townhouses'],
            ['name' => 'Commercial Properties'],
            ['name' => 'Short-Term Rentals'],
            ['name' => 'Luxury Villas'],
            ['name' => 'Property Management Services'],
        ]);
    }
}
