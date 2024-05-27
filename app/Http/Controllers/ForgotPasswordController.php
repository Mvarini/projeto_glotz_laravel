<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return redirect()->back()->withInput()->with('error', 'Função indisponível no momento');
    }
}
