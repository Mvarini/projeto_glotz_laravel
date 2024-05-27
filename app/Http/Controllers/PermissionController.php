<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        // Recuperar os dados do banco de dados
        $permissions = Permission::orderBy('created_at')->paginate(20);

        // Carregar a view
        return view('permissions.index', ['menu' => 'permissions', 'permissions' => $permissions]);
    }

    public function show(Permission $permission)
    {
        // Carregar a view
        return view('permissions.show', ['menu' => 'permissions', 'permission' => $permission]);
    }

    public function create()
    {
        return view('permissions.create', ['menu' => 'permissions']);
    }

    public function store(PermissionRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Iniciar a transação
        DB::beginTransaction();

        try {

            $permission = Permission::create([
                'title' => $request->title,
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            // Processo concluído
            DB::commit();

            // Salvar o log
            Log::info('Permissão cadastrada', ['id' => $permission->id, 'auth_user_action' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('permission.index')->with('success', 'Permissão cadastrada com sucesso');

        }catch (\Exception $ex){
            // Processo não concluído
            DB::rollBack();

            // Salvar o log
            Log::error('Permissão não cadastrada', ['error' => $ex->getMessage(), 'auth_user_action' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'Permissão não cadastrada');
        }
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', ['menu' => 'permissions', 'permission' => $permission]);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        // Validar o formuláiro
        $request->validated();

        // Iniciar a transação
        DB::beginTransaction();

        try {
            // Atualizar os dados no banco de dados
            $permission->update([
                'title' => $request->title,
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            // Processo concluído
            DB::commit();

            // Salvar o log
            Log::info('Permissão atualizada', ['id' => $permission->id, 'auth_user_action' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->route('permission.index')->with('success', 'Permissão atualizada com sucesso');

        }catch (\Exception $ex){
            // Processo não concluído
            DB::rollBack();

            // Salvar o log
            Log::error('Permissão não atualizada', ['error' => $ex->getMessage(), 'auth_user_action' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->with('error', 'Permissão não atualizada');
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            // Apagar do banco de dados
            $permission->delete();

            // Salvar o log
            Log::info('Permissão deletada', ['id' => $permission->id, 'auth_user_action' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->route('permission.index')->with('success', 'Permissão excluída com sucesso');

        }catch (\Exception $ex){
            // Salvar o log
            Log::error('Permissão não deletada', ['error' => $ex->getMessage(), 'auth_user_action' => Auth::id()]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'Permissão não deletada');
        }
    }
}
