<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['title' => 'Listar cursos', 'name' => 'index-course'],
            ['title' => 'Visualizar curso', 'name' => 'show-course'],
            ['title' => 'Cadastar curso', 'name' => 'create-course'],
            ['title' => 'Editar curso', 'name' => 'edit-course'],
            ['title' => 'Apagar curso', 'name' => 'destroy-course'],

            ['title' => 'Listar módulos', 'name' => 'index-module'],
            ['title' => 'Visualizar módulo', 'name' => 'show-module'],
            ['title' => 'Cadastrar módulo', 'name' => 'create-module'],
            ['title' => 'Editar módulo', 'name' => 'edit-module'],
            ['title' => 'Apagar módulo', 'name' => 'destroy-module'],

            ['title' => 'Listar aulas', 'name' => 'index-classe'],
            ['title' => 'Visualizar aula', 'name' => 'show-classe'],
            ['title' => 'Cadastrar aula', 'name' => 'create-classe'],
            ['title' => 'Editar aula', 'name' => 'edit-classe'],
            ['title' => 'Apagar aula', 'name' => 'destroy-classe'],
            ['title' => 'Assitir a aula', 'name' => 'view-classe'],
            ['title' => 'Baixar pdf da aula', 'name' => 'file-classe'],

            ['title' => 'Listar dashboards', 'name' => 'dashboard'],

            ['title' => 'Listar professores', 'name' => 'index-teacher'],
            ['title' => 'Visualizar professor', 'name' => 'show-teacher'],
            ['title' => 'Cadastrar professor', 'name' => 'create-teacher'],
            ['title' => 'Editar professor', 'name' => 'edit-teacher'],
            ['title' => 'Apagar professor', 'name' => 'destroy-teacher'],

            ['title' => 'Listar alunos', 'name' => 'index-student'],
            ['title' => 'Visualizar alunos', 'name' => 'show-student'],
            ['title' => 'Cadastrar aluno', 'name' => 'create-student'],
            ['title' => 'Editar aluno', 'name' => 'edit-student'],
            ['title' => 'Apagar aluno', 'name' => 'destroy-student'],

            ['title' => 'Listar usuários', 'name' => 'index-user'],
            ['title' => 'Visualizar usuário', 'name' => 'show-user'],
            ['title' => 'Cadastrar usuário', 'name' => 'create-user'],
            ['title' => 'Editar usuário', 'name' => 'edit-user'],
            ['title' => 'Apagar usuário', 'name' => 'destroy-user'],
            ['title' => 'Editar senha do usuário', 'name' => 'edit-user-password'],

            ['title' => 'Listar papéis', 'name' => 'index-role'],
            ['title' => 'Visualizar papel', 'name' => 'show-role'],
            ['title' => 'Cadastrar papel', 'name' => 'create-role'],
            ['title' => 'Editar papel', 'name' => 'edit-role'],
            ['title' => 'Apagar papel', 'name' => 'destroy-role'],

            ['title' => 'Listar permissões do papel', 'name' => 'index-role-permission'],
            ['title' => 'Editar permissões do papel', 'name' => 'update-role-permission'],


        ];

        foreach ($permissions as $permission) {
            $existingPermission = Permission::where('name', $permission['name'])->first();

            if (!$existingPermission) {
                Permission::create([
                    'title' => $permission['title'],
                    'name' => $permission['name'],
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}
