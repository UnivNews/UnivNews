<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoostPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prices = [
            ['duration_type' => '3_days',  'duration_days' => 3,  'price' => 50000,  'is_active' => true],
            ['duration_type' => '1_week',  'duration_days' => 7,  'price' => 100000, 'is_active' => true],
            ['duration_type' => '1_month', 'duration_days' => 30, 'price' => 350000, 'is_active' => true],
        ];

        foreach ($prices as $price) {
            \Illuminate\Support\Facades\DB::table('boost_prices')->updateOrInsert(
                ['duration_type' => $price['duration_type']],
                array_merge($price, ['updated_at' => now(), 'created_at' => now()])
            );
        }
    }
}
