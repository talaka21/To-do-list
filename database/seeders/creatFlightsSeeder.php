<?php

namespace Database\Seeders;

use App\Models\flight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class creatFlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       flight::factory(25)->create();
    }
}
