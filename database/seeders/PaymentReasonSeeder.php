<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentReason;

class PaymentReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            ['name' => 'Rent'],
            ['name' => 'Utilities'],
            ['name' => 'Maintenance Fee'],
            // Add more reasons as needed
        ];

        foreach ($reasons as $reason) {
            PaymentReason::create($reason);
        }
    }
}
