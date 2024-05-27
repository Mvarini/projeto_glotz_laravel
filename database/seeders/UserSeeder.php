<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Caso não exista, então adicione no banco
        if (!User::where('email', 'marciel@2tx.com.br')->first()){
            $superAdmin = User::create([
                'name' => 'Marciel',
                'email' => 'marciel@2tx.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir o papel ao usuário
            $superAdmin->assignRole('Super Admin');
        }

        // Caso não exista, então adicione no banco
        if (!User::where('email', 'luana@2tx.com.br')->first()){
            $admin = User::create([
                'name' => 'Luana',
                'email' => 'luana@2tx.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir o papel ao usuário
            $admin->assignRole('Admin');
        }

        // Caso não exista, então adicione no banco
        if (!User::where('email', 'jean@2tx.com.br')->first()){
            $teacher = User::create([
                'name' => 'Jean',
                'email' => 'jean@2tx.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir o papel ao usuário
            $teacher->assignRole('Aluno');
        }

        // Caso não exista, então adicione no banco
        if (!User::where('email', 'bruno@2tx.com.br')->first()){
            $student = User::create([
                'name' => 'Bruno',
                'email' => 'bruno@2tx.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir o papel ao usuário
            $student->assignRole('Aluno');
        }
    }
}
