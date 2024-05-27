<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Classe::where('name', 'Apresentação')->first()){
            Classe::create([
                'module_id' => 1,
                'name' => 'Apresentação',
                'video' => 'Teste 1',
                'order_classe' => 1,
                'pdf' => 'Teste 1'
            ]);
        }
    }
}
