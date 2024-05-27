<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // Detalhes do perfil
    public function show()
    {
        // Recuperar do banco de dados as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Carregar a view
        return view('profile.show', ['user' => $user]);
    }

    public function edit()
    {
        // Recuperar do banco de dados as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Carregar a view
        return view('profile.edit', ['user' => $user]);
    }

    public function update(ProfileRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Inicar a transação
        DB::beginTransaction();

        try {
            // Recuperar do banco de dados as informações do usuário logado
            $user = User::Where('id', Auth::id())->first();

            // Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            // Salvar o log
            Log::info('Perfil editado', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Processo concluído
            DB::commit();

            // redirecionar o usuário e enviar mensagem
            return redirect()->route('profile.show')->with('success', 'Perfil editado com sucesso');
        } catch (\Exception $ex) {
            // Salvar o log
            Log::error('Perfil não editado', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Processo não concluído
            DB::rollBack();

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'Perfil não editado');
        }
    }

    public function editPassword()
    {
        // Recuperar do banco de dados as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Carregar a view
        return view('profile.editPassword', ['user' => $user]);
    }

    public function updatePassword(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'password' => 'required|min:6|confirmed' // confirmed: para confirmar a senha com um campo do form
        ], [
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha de ter no mínimo :min caracteres',
            'password.confirmed' => 'O campo Confirmar nova senha não coincide'
            // outro campo deve ter o name: password_confirmation na view
        ]);

        // Inicar a transação
        DB::beginTransaction();

        try {
            // Recuperar os dados do usuário logado no banco de dados
            $user = User::where('id', Auth::id())->first();

            // Atualizar a senha do usuário logado
            $user->update([
                'password' => $request->password
            ]);

            // Salvar o log
            Log::info('Senha editada', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Processo concluído
            DB::commit();

            // Redirecionar o usuário e enviar a mensagem
            return redirect()->route('profile.show')->with('success', 'Senha editada com sucesso');
        } catch (\Exception $ex) {

            // Salvar o log
            Log::error('Senha não editada', ['error' => $ex->getMessage(), 'action_user_id' => Auth::id()]);

            // Processo não concluído
            DB::rollBack();

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'Senha não editada');
        }
    }
}
