<?php

namespace Database\Seeders;

use App\Models\VaccineCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VaccineCenter::insert([
            ['name' => 'Mirpur 1', 'daily_limit' => 50],
            ['name' => 'Mirpur 2', 'daily_limit' => 40],
            ['name' => 'Mirpur 10', 'daily_limit' => 30],
            ['name' => 'Kazipara', 'daily_limit' => 30],
            ['name' => 'jamuna Future Park', 'daily_limit' => 30],
        ]);

    }
}
