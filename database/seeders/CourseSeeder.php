<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Course::where('name', 'NR 11')->first()){
            Course::create([
                'teacher_id' => 1,
                'name' => 'NR 11',
                'hour' => 6,
                'price' => 0.00
            ]);
        }

        if (!Course::where('name', 'NR 12')->first()){
            Course::create([
                'teacher_id' => 2,
                'name' => 'NR 12',
                'hour' => 4,
                'price' => 0.00
            ]);
        }

        if (!Course::where('name', 'NR 13')->first()){
            Course::create([
                'teacher_id' => 3,
                'name' => 'NR 13',
                'hour' => 10,
                'price' => 0.00
            ]);
        }
    }
}
