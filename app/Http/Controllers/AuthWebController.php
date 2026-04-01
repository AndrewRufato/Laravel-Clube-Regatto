<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthWebController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'usuario' => ['required', 'email'],
            'senha'   => ['required', 'string'],
        ]);

        $email = mb_strtolower($data['usuario']);

        $user = User::where('email', $email)->first();

        if ($user && $user->aprovado !== 'S') {
            return back()
                ->withErrors(['usuario' => 'Aguarde seu cadastro ser aprovado.'])
                ->onlyInput('usuario');
        }

        if (Auth::attempt([
            'email' => $email,
            'password' => $data['senha'],
        ])) {
            $request->session()->regenerate();

            return redirect()->intended(route('clube.pontos'));
        }

        return back()
            ->withErrors(['usuario' => 'Usuário ou senha inválidos.'])
            ->onlyInput('usuario');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}