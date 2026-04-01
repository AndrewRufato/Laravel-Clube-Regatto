<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Envia o link (token) para o e-mail, se existir usuário
        $status = Password::sendResetLink($request->only('email'));

        // Boa prática: mensagem genérica (não revelar se existe ou não)
         return back()->with('status', __($status));
    }
}