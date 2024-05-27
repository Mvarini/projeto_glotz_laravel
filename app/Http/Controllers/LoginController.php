<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

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
        return redirect()->route('course.index');
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
