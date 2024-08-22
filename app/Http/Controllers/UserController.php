<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Lista todos os usuários
    public function index(Request $request)
    {
        // Pesquisar por usuário ou email
        $userSearch = $request->input('pesquisar');
        $users = User::where('name', 'like', '%' . $userSearch . '%')
            ->orWhere('email', 'like', '%' . $userSearch . '%')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();


//        // Listar todos os usuários por página em ordem decrescente
//        $users = User::orderByDesc('created_at')->paginate(9);

            // Carrega a view
            return view('users.index', ['menu' => 'users', 'users' => $users, 'pesquisar' => $userSearch]);

    }

    // Visualizar o usuário
    public function show(User $user)
    {
        // Carregar a view
        return view('users.show', ['menu' => 'users', 'user' => $user]);
    }

    // Carrega o formulário cadastrar no usuário
    public function create()
    {
        // Recuperar todos os papéis
        $roles = Role::pluck('name')->all();

        // Carrega a view
        return view('users.create', ['menu' => 'users', 'roles' => $roles]);
    }

    // Cadastra no banco de dados o novo usuario
    public function store(UserRequest $request)
    {
        // Validar o formulário
        $request->validated();

        //Marca o início da transação
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => Str::lower($request->email),
                'password' => $request->password,
            ]);

            // Cadastrar papael para o usuário
            $user->assignRole($request->roles);

            // Salvar olog
            Log::info('Usuário cadastrdo', ['id' => $user->id, $user->name, $user->email, 'action_user_id' => Auth::id()]);

            // Operação concluída com êxito
            DB::commit();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Usuário não cadastrado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não concluída
            DB::rollBack();

            //Redireciona o usuário, enviar a mensagem de erro
            return redirect()->back()->withInput()->with('error', 'Usuário não cadastrado');
        }
    }

    // Carregar o formulário para editar o usuário
    public function edit(User $user)
    {
        // Recuperar os papéis do banco de dados
        $roles = Role::pluck('name')->all();

        // Recuperar o papel já atribuído ao usuário
        $userRoles = $user->roles->pluck('name')->first();

        // Carregar a view
        return view('users.edit', ['menu' => 'users', 'user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    // Atualizar o usuário no banco de dados
    public function update(UserRequest $request, User $user)
    {
        // Validar o formulário
        $request->validated();

        // Marcar o início da transação
        DB::beginTransaction();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Editar o papel do usuário
            $user->syncRoles($request->roles);

            // Salvar o log
            Log::info('Usuário editado', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Operação concuída
            DB::commit();

            // Redireciona o usuário, envia a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário editado com sucesso!');
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Usuário não editado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não concluída
            DB::rollBack();

            //Redireciona o usuário, envia mensagem de erro
            return redirect()->back()->withInput()->with('error', 'Usuário não cadastrado');
        }
    }

    // Excluir o usuário do banco de dados
    public function destroy(User $user)
    {
        try {
            // Excluir o registro do banco de dados
            $user->delete();

            // Remove todos os papéis atribuídos ao usuário
            $user->syncRoles([]);

            // Salvar log
            Log::info('Usuário excluído', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Redireciona o usuário, envia mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso!');
        } catch (\Exception $ex) {
            // Salvar log
            Log::error('Usuário não excluído', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Redireciona o usuário, envia mensagem de sucesso
            return redirect()->route('user.index')->with('error', 'Usuário não excluído. Existe curso(s) atribuido ao aluno');
        }
    }

    // Carregar o formulário editar a senha
    public function editPassword(User $user)
    {
        // Carregar a view
        return view('users.editPassword', ['menu' => 'users', 'user' => $user]);
    }

    // Editar no banco de dados a senha do usuário
    public function updatePassword(Request $request, User $user)
    {
        // Validar o formulário
        $request->validate([
            'password' => 'required|min:6|confirmed' // confirmed: para confirmar a senha com um campo
        ], [
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha de ter no mínimo :min caracteres',
            'password.confirmed' => 'O campo Confirmar nova senha não coincide'
            // outro campo deve ter o name: password_confirmation na view
        ]);

        // Marca o ponto inicial da transação
        DB::beginTransaction();

        try {
            // Editar a senha no banco de dados
            $user->update([
                'password' => $request->password
            ]);

            // Salvar o log
            Log::info('Senha editada', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Operação concluída
            DB::commit();

            // Redireciona o usuário, envia a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Senha do usuário editada com sucesso!');
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Senha não editada', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não concluída
            DB::rollBack();

            // Redireciona o usuário, envia mensagem de erro
            return redirect()->back()->withInput()->with('error', 'Senha do usuário não editada');
        }
    }
}

