<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roleSearch = $request->input('pesquisar');
        $roles = Role::where('name', 'like', '%' . $roleSearch . '%')
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

//        // Recuperar os registros do banco de dados
//        $roles = Role::orderBy('name', 'asc')->paginate(10);

        // Carregar a view
        return view('roles.index', ['menu' => 'roles', 'roles' => $roles, 'pesquisar' => $roleSearch]);
    }

    public function show(Role $role)
    {
        // Carregar a view
        return view('roles.show', ['menu' => 'roles', 'role' => $role]);
    }

    public function create()
    {
        // Carregar a view
        return view('roles.create', ['menu' => 'roles']);
    }

    public function store(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'name' => 'required|unique:roles,name',
        ], [
            'name.required' => 'O campo papel é obrigatorio',
            'name.unique' => 'Já existe o papel com este nome',
        ]);

        // Inicar a transação
        DB::beginTransaction();

        try {
            // Cadastrar no banco de dados
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            // Salvar o Log
            Log::info('Papel cadastrado', ['id' => $role->id, 'action_user_id' => Auth::id()]);

            // Processo concluído
            DB::commit();

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role.index')->with('success', 'Papel cadastrado com sucesso');
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Papel não cadastrado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Processo não concluído
            DB::rollBack();

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role.index')->with('error', 'Erro ao cadastrar papel');
        }
    }

    public function edit(Role $role)
    {
        // Carregar a view
        return view('roles.edit', ['menu' => 'roles', 'role' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        // Validar o formulário
        $request->validate([
            'name' => 'required|unique:roles,name',
        ], [
            'name.required' => 'O campo papel é obrigatório',
            'name.unique' => 'Já existe o papel com este nome',
        ]);

        // Inicar a transação
        DB::beginTransaction();

        try {
            $role->update([
                'name' => $request->name,
            ]);

            // Salvar o Log
            Log::info('Papel atualizado', ['id' => $role->id, 'action_user_id' => Auth::id()]);

            // Processo concluído
            DB::commit();

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role.index')->with('success', 'Papel atualizado com sucesso');
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Papel não atualizado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Processo não concluído
            DB::rollBack();

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role.index')->with('error', 'Erro ao atualizar papel');
        }
    }

    public function destroy(Role $role)
    {
        try {
            // Deletar o papel do banco de dados
            $role->delete();

            // Salvar o log
            Log::info('Papel excluido', ['id' => $role->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role.index')->with('success', 'Papel excluído com sucesso');
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Papel não excluído', ['id' => $role->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('role.index')->with('error', 'Erro ao excluir papel');
        }
    }
}
