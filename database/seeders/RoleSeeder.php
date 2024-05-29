<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Role::where('name', 'Super Admin')->first()) {
            Role::create([
                'name' => 'Super Admin',
            ]);
        }

        if (! Role::where('name', 'Admin')->first()) {
            $admin = Role::create([
                'name' => 'Admin',
            ]);
        } else {
            $admin = Role::where('name', 'Admin')->first();
        }
        // Dar permissão para o papel
        $admin->givePermissionTo([
            'index-course',
            'show-course',
            'create-course',
            'edit-course',
            'destroy-course',

            'index-module',
            'show-module',
            'create-module',
            'edit-module',
            'destroy-module',

            'index-classe',
            'show-classe',
            'create-classe',
            'edit-classe',
            'destroy-classe',
            'view-classe',
            'file-classe',

            'dashboard',

            'index-teacher',
            'show-teacher',
            'create-teacher',
            'edit-teacher',
            'destroy-teacher',

            'index-student',
            'show-student',

            'index-user',
            'show-user',

            'index-role',
            'show-role',
            'index-role-permission',

        ]);

        if (! Role::where('name', 'Aluno')->first()) {
            $student = Role::create([
                'name' => 'Aluno',
            ]);

            // Dar permissão para o papel
            $student->givePermissionTo([
                'index-course',
            ]);
        } else {
            $student = Role::where('name', 'Aluno')->first();
        }

        $student->givePermissionTo([
            'index-module',
            'view-classe',
            'file-classe',
            'generate-pdf-user',
        ]);
    }
}
