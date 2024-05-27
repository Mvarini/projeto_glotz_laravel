<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(Role $role)
    {
        if ($role->name == 'Super Admin') {
            // Salvar o log
            Log::info('Permissão do super admin não pode ser acessada', ['action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role.index')->with('error', 'Permissão do super admin não pode ser acessada');
        }

        // Recuperar as permissões do papel
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id')
            ->all();

        // Recuperar as permissões
        $permissions = Permission::get();

        // Salvar o log
        Log::info('Listar permissões do papel', ['action_user_id' => Auth::id()]);

        // Carregar a view
        return view(
            'rolePermissions.index',
            ['menu' => 'roles', 'role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions]
        );
    }

    public function update(Request $request, Role $role)
    {
        // Obter a permissão específica com base no ID fornecido em $request->permission
        $permission = Permission::find($request->permission);

        if (!$permission) {
            // Salvar o log
            Log::info(
                'Permissão não encontrada',
                ['role' => $role->id, 'permission' => $request->permission, 'action_user_id' => Auth::id()]
            );

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route(
                'role-permission.update',
                ['role' => $role->id, 'permission' => $request->permission]
            )->with('error', 'Permissão não encontrada');
        }

        // Verificar se a permissão já está associada ao papel
        if ($role->permissions->contains($permission)) {
            // Remover a permissão do papel (bloquear)
            $role->revokePermissionTo($permission);

            // Salvar o log
            Log::info(
                'Bloquear permissão para o papel',
                ['action_user_id' => Auth::id(), 'permissão' => $request->permission]
            );

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role-permission.index', ['role' => $role->id])->with(
                'error',
                'Permissão ' . $permission->title . ' bloqueada para o papel ' . $role->name
            );
        } else {
            // Adicionar a permissão para o papel (liberado)
            $role->givePermissionTo($permission);

            // Salvar o log
            Log::info(
                'Liberar permissão para o papel',
                ['action_user_id' => Auth::id(), 'permissão' => $request->permission]
            );

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role-permission.index', ['role' => $role->id])->with(
                'success',
                'Permissão '. $permission->title .' liberada para o papel '. $role->name
            );
        }
    }
}
