<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Teacher::where('first_name', 'Marciel')->first()){
            Teacher::create([
                'first_name' => 'Marciel',
                'last_name' => 'Alessandro Varini'
            ]);
        }

        if (!Teacher::where('first_name', 'Luana')->first()){
            Teacher::create([
                'first_name' => 'Luana',
                'last_name' => 'Maisa dos Santos'
            ]);
        }

        if (!Teacher::where('first_name', 'Erlon')->first()){
            Teacher::create([
                'first_name' => 'Erlon',
                'last_name' => 'Martins Tostes'
            ]);
        }
    }
}
