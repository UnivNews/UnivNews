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
        \Illuminate\Support\Facades\DB::table('boost_prices')->insert([
            ['duration_type' => '3_days',  'duration_days' => 3,  'price' => 50000,  'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['duration_type' => '1_week',  'duration_days' => 7,  'price' => 100000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['duration_type' => '1_month', 'duration_days' => 30, 'price' => 350000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
