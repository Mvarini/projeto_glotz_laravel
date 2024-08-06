<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function loginProcess(LoginRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Validar o email e senha com as informações do banco de dados
        $authLogin =  Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Verificar se o usuário foi autenticado
        if (!$authLogin) {
            return back()->withInput()->with('error', 'E-mail ou senha inválido!');
        }

        // Recuperar o id do usuário logado
        $user = Auth::user();
        $user = User::find($user->id);

        // Verifica se a permissão é Super admin, tem acesso a todas as páginas
        if ($user->hasRole('Super Admin')) {
            // O usuário tem todas as permissões
            $permissons = Permission::pluck('name')->toArray();
        }else{
            // Recuperar no banco de dados as permissões que o papel possui
            $permissons = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        }

        //Atribuir as permissões ao usuário
        $user->syncPermissions($permissons);

        // Redirecionar o usuário
        if($user->hasRole('Aluno')){
            return redirect()->route('course.index');
        }else{
            return redirect()->route('dashboard.index');
        }

    }

    public function create()
    {
        // Carregar a view
        return view('login.create');
    }

    public function store(Request $request)
    {
        // Validar os dados
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'O campo e-mail é obrigatorio',
            'email.email' => 'É necessário um e-mail válido',
            'email.unique' => 'O e-mail já está cadastrado',
            'password.min' => 'Senha com no mínimo :min caracteres',
            'password.confirmed' => 'As senhas estão diferentes',
        ]);

        // Ponto inicial da transação
        DB::beginTransaction();

        try {
            // Salvar no bando de dados
            $user = User::create([
                'name' => $request->name,
                'email' => Str::lower($request->email),
                'password' => $request->password,
            ]);

            // Cadastrar papael definido para novos usuários
            $user->assignRole('Aluno');

            // Salvar o log
            Log::info('Usuário cadastrado', ['id' => $user->id, $user->name, $user->email]);

            // Transação concluída
            DB::commit();

            // Redirecionar e enviar mensagem
            return redirect()->route('login.index')->with('success', 'Usuário cadastrado com sucesso');

        }catch (\Exception $ex){
            // Salvar o log
            Log::info('Usuário não cadastrado', ['error' => $ex->getMessage(), 'name' => $request->name, 'email' => $request->email]);

            // Operação não concluída
            DB::rollBack();

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->back()->withInput()->with('error', 'Usuário não cadastrado');
        }
    }

    // Deslogar o usuário
    public function destroy()
    {
        // Deslogar o usuário
        Auth::logout();

        // Redirecionar o usuário e mostrar mensagem
        return redirect()->route('login.index');
    }
}
