<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        // Carregar a view
        return view('login.forgotPassword');
    }

    public function submitForgotPassword(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'É necessário um e-mail válido',
        ]);

        // Verificar se existe o email no banco de dados
        $user = User::where('email', $request->email)->first();

        if (!$user){
            // Salvar o log
            Log::info('Tentativo inválida ao recuperar senha email não cadastrado', ['email' => $request->email] );
            // Redirecionar o usuário, enviar a mensagem
            return redirect()->back()->withInput()->with('error', 'E-mail não encontrado');
        }

        try {
            // Salvar o token recuperar senha e enviar e-mail
             $status = Password::sendResetLink(
                $request->only('email')
            );

            // Salvar o log
            Log::info('Recuperar senha', ['status' => $status, 'email' => $request->email]);

            // Redirecionar e enviar mensagem
            return redirect()->route('login.index')->with('success', 'Email enviado, siga as instruções para recuperar a senha!');

        }catch (\Exception $ex){
            // Salvar o log
            Log::warning('Erro ao recuperar senha', ['error' => $ex->getMessage(), 'email' => $request->email]);

            // Redirecionar e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'Tente mais tarde');
        }
    }

    public function showResetPassword(Request $request)
    {
        // Carregar a view
        return view('login.resetPassword', ['token' => $request->token]);
    }

    public function submitResetPassword(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'O campo e-mail é obrigatorio',
            'email.email' => 'É necessário um e-mail válido',
            'password.min' => 'Senha com no mínimo :min caracteres',
            'password.confirmed' => 'As senhas estão diferentes',
            'email.exists' => 'E-mail não cadastrado no sistema!'
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    // forçar, pois, password é uma propriedade protegida
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);

                    $user->save();
                }
            );


            // Salvar o log
            Log::info('Senha atualizada', ['resposta' => $status, 'email' => $request->email]);

            // Redirecionar o usuáiro e enviar mensagem
            return $status === Password::PASSWORD_RESET ? redirect()->route('login.index')->with('success', 'Senha atualizada com sucesso') :
                redirect()->route('login.index')->with('error', __($status));

        }catch (\Exception $ex){
            // Salvar o log
            Log::info('Erro ao atualizar senha', ['error' =>$ex->getMessage(), 'email' => $request->email]);

            // Redirecionar o usuário e enviar mensagem
            return redirect()->back()->withInput()->with('error', 'Tente mais tarde');
        }

    }
}
