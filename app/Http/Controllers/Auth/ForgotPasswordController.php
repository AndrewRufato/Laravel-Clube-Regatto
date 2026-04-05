<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function send(Request $request)
    {
        Log::info('🔵 Iniciou envio de reset de senha');

        // Validação
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = $request->email;

        // 🔍 Verifica se o usuário existe no banco
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::warning('❌ Usuário NÃO encontrado', [
                'email' => $email
            ]);
        } else {
            Log::info('✅ Usuário encontrado', [
                'id' => $user->id,
                'email' => $user->email
            ]);
        }

        try {
            // 🚀 Dispara envio do email de reset
            $status = Password::sendResetLink([
                'email' => $email
            ]);

            Log::info('📨 Status do envio', [
                'status' => $status
            ]);

            // ✅ Sucesso
            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('status', 'Email de redefinição enviado com sucesso!');
            }

            // ⚠️ Falha controlada
            return back()->withErrors([
                'email' => 'Erro ao enviar email: ' . __($status),
            ]);

        } catch (\Throwable $e) {
            // 💥 Erro real (SMTP, conexão, etc)
            Log::error('🔥 Erro real no envio de email', [
                'message' => $e->getMessage()
            ]);

            return back()->withErrors([
                'email' => 'Erro técnico ao enviar email. Tente novamente mais tarde.',
            ]);
        }
    }
}