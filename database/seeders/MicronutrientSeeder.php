<?php

namespace Database\Seeders;

use App\Models\Micronutrient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MicronutrientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Micronutrient::truncate();

        DB::table('micronutrients')->insert([
            ['name' => 'Water', 'unit' => '0'],
            ['name' => 'pH', 'unit' => '0'], 
            ['name' => 'Protein', 'unit' => '1'], 
            ['name' => 'Ketone', 'unit' => '2'], 
            ['name' => 'Sodium', 'unit' => '3'], 
            ['name' => 'Oxidative Stress', 'unit' => '0'], 
            ['name' => 'Vitamin C', 'unit' => '2'], 
            ['name' => 'Creatinine', 'unit' => '2'], 
            ['name' => 'Calcium', 'unit' => '2'], 
            ['name' => 'Magnesium', 'unit' => '4'], 
            ['name' => 'Glucose', 'unit' => '2'], 
            ['name' => 'Zinc', 'unit' => '4']
        ]);
    }
}
