<?php

namespace App\Http\Controllers;

use App\Models\Premio;
use App\Models\Resgate;
use App\Models\MovimentacaoPonto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PremioController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $premios = Premio::where('ativo', 'S')
            ->orderBy('id', 'desc')
            ->get();

        $historicoMovimentacoes = MovimentacaoPonto::where('fk_user_club', $user->id)
            ->whereYear('data_compra', Carbon::now()->year)
            ->orderBy('data_compra', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('club.pontos-premios', compact('user', 'premios', 'historicoMovimentacoes'));
    }

    public function resgatar(Premio $premio)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->with('error', 'Você precisa estar logado.');
        }

        if ($premio->ativo !== 'S') {
            return redirect()
                ->route('clube.pontos')
                ->with('error', 'Este prêmio não está disponível para resgate.');
        }

        if ((int) $user->pontos < (int) $premio->pontos_resgate) {
            return redirect()
                ->route('clube.pontos')
                ->with('error', 'Você não possui pontos suficientes para resgatar este prêmio.');
        }

        DB::beginTransaction();

        try {
            $saldoAntes = (int) $user->pontos;
            $pontosGasto = (int) $premio->pontos_resgate;
            $saldoDepois = $saldoAntes - $pontosGasto;

            $resgate = Resgate::create([
                'fk_user' => $user->id,
                'fk_premio' => $premio->id,
                'pontos_gasto' => $pontosGasto,
                'saldo_user_antes_do_resgate' => $saldoAntes,
                'saldo_user_pos_resgate' => $saldoDepois,
            ]);

            $user->pontos = $saldoDepois;
            $user->save();

            $emailsDestino = [
                'clube@moveisplanejadosregatto.com.br',
                'clube@moveisplanejadosregatto.com.br',
            ];

            Mail::send('emails.resgate-premio', [
                'user' => $user,
                'premio' => $premio,
                'resgate' => $resgate,
                'saldoAntes' => $saldoAntes,
                'saldoDepois' => $saldoDepois,
            ], function ($message) use ($emailsDestino, $user, $premio) {
                $message->to($emailsDestino)
                    ->subject('Novo resgate de prêmio - ' . $premio->nome . ' - ' . $user->name);
            });

            DB::commit();

            return redirect()
                ->route('premios.sucesso', $resgate->id)
                ->with('success', 'Prêmio resgatado com sucesso.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('clube.pontos')
                ->with('error', 'Erro ao resgatar prêmio: ' . $e->getMessage());
        }
    }

    public function sucesso(Resgate $resgate)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ((int) $resgate->fk_user !== (int) $user->id) {
            abort(403, 'Você não tem permissão para acessar este resgate.');
        }

        $resgate->load(['user', 'premio']);

        return view('club.premios-sucesso', compact('resgate'));
    }
}