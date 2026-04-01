<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CadastroSolicitacaoController extends Controller
{
    public function index()
    {
        $cadastrosPendentes = User::where('aprovado', 'N')
            ->orderBy('id', 'desc')
            ->get();

        return view('club.solicitacoes-cadastro', compact('cadastrosPendentes'));
    }

    public function aprovar($id)
    {
        $cadastro = User::findOrFail($id);

        $cadastro->update([
            'aprovado' => 'S',
        ]);

        try {
            Mail::raw(
                "Parabéns {$cadastro->name}, seu cadastro foi aprovado no nosso clube de benefícios!",
                function ($message) use ($cadastro) {
                    $message->to($cadastro->email)
                            ->subject('Cadastro aprovado no clube de benefícios');
                }
            );
        } catch (\Exception $e) {
            return redirect()
                ->route('cadastros.solicitacoes.index')
                ->with('error', 'Cadastro aprovado, mas houve erro ao enviar o e-mail.');
        }

        return redirect()
            ->route('cadastros.solicitacoes.index')
            ->with('success', 'Cadastro aprovado com sucesso e e-mail enviado.');
    }

    public function aprovarAdmin($id)
    {
        $cadastro = User::findOrFail($id);

        $cadastro->update([
            'aprovado' => 'S',
            'role' => 'admin',
        ]);

        try {
            Mail::raw(
                "Parabéns {$cadastro->name}, seu cadastro foi aprovado no nosso clube de benefícios!",
                function ($message) use ($cadastro) {
                    $message->to($cadastro->email)
                            ->subject('Cadastro aprovado no clube de benefícios');
                }
            );
        } catch (\Exception $e) {
            return redirect()
                ->route('cadastros.solicitacoes.index')
                ->with('error', 'Cadastro aprovado como administrador, mas houve erro ao enviar o e-mail.');
        }

        return redirect()
            ->route('cadastros.solicitacoes.index')
            ->with('success', 'Cadastro aprovado como administrador e e-mail enviado.');
    }

    public function recusar($id)
    {
        $cadastro = User::findOrFail($id);

        try {
            Mail::raw(
                "Desculpe, mas seu cadastro em nosso clube de benefícios foi recusado por motivos internos. Suas informações de cadastro serão excluídas.",
                function ($message) use ($cadastro) {
                    $message->to($cadastro->email)
                            ->subject('Cadastro recusado no clube de benefícios');
                }
            );
        } catch (\Exception $e) {
            return redirect()
                ->route('cadastros.solicitacoes.index')
                ->with('error', 'Houve erro ao enviar o e-mail de recusa. O cadastro não foi removido.');
        }

        $cadastro->delete();

        return redirect()
            ->route('cadastros.solicitacoes.index')
            ->with('success', 'Cadastro recusado, removido e e-mail enviado.');
    }
}