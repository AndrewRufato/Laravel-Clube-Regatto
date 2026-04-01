<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MovimentacaoPonto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembroAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('nome')) {
            $query->where('name', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('rrt')) {
            $query->where('rrt', 'like', '%' . $request->rrt . '%');
        }

        if ($request->filled('telefone')) {
            $query->where('telefone', 'like', '%' . $request->telefone . '%');
        }

        if ($request->filled('cpf_cnpj')) {
            $query->where('cpf_cnpj', 'like', '%' . $request->cpf_cnpj . '%');
        }

        if ($request->filled('profissao')) {
            $query->where('profissao', 'like', '%' . $request->profissao . '%');
        }

        if ($request->filled('aprovado')) {
            $query->where('aprovado', $request->aprovado);
        }

        $membros = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('club.membros-admin', compact('membros'));
    }

    public function movimentar(Request $request, User $user)
    {
        $request->validate([
            'valor'         => ['required', 'numeric', 'gt:0'],
            'tipo_mov'      => ['required', 'in:ADD,SUB'],
            'projeto'       => ['required', 'string', 'max:50'],
            'data_compra'   => ['required', 'date_format:d/m/Y'],
            'nome_cliente'  => ['required', 'string', 'max:150'],
        ], [
            'valor.required' => 'Informe o valor da movimentação.',
            'valor.numeric' => 'O valor precisa ser numérico.',
            'valor.gt' => 'O valor deve ser maior que zero.',

            'tipo_mov.required' => 'Informe o tipo de movimentação.',
            'tipo_mov.in' => 'Tipo de movimentação inválido.',

            'projeto.required' => 'Informe o projeto.',
            'projeto.max' => 'O projeto deve ter no máximo 50 caracteres.',

            'data_compra.required' => 'Informe a data da compra.',
            'data_compra.date_format' => 'A data da compra deve estar no formato dd/mm/aaaa.',

            'nome_cliente.required' => 'Informe o nome do cliente.',
            'nome_cliente.max' => 'O nome do cliente deve ter no máximo 150 caracteres.',
        ]);

        DB::beginTransaction();

        try {
            $admin = Auth::user();

            $valor = (float) $request->valor;
            $pontosAntes = (float) $user->pontos;
            $pontosDepois = $pontosAntes;

            if ($request->tipo_mov === 'ADD') {
                $pontosDepois = $pontosAntes + $valor;
            }

            if ($request->tipo_mov === 'SUB') {
                $pontosDepois = $pontosAntes - $valor;

                if ($pontosDepois < 0) {
                    return back()
                        ->withInput()
                        ->with('error', 'Não é possível subtrair um valor maior que a pontuação atual.');
                }
            }

            $dataCompra = Carbon::createFromFormat('d/m/Y', $request->data_compra)->format('Y-m-d');

            $user->update([
                'pontos' => $pontosDepois,
            ]);

            MovimentacaoPonto::create([
                'fk_user_admin'  => $admin->id,
                'fk_user_club'   => $user->id,
                'pontos_pre_mov' => $pontosAntes,
                'pontos_pos_mov' => $pontosDepois,
                'pontos_mov'     => $valor,
                'tipo_mov'       => $request->tipo_mov,
                'projeto'        => trim($request->projeto),
                'data_compra'    => $dataCompra,
                'nome_cliente'   => trim($request->nome_cliente),
            ]);

            DB::commit();

            return back()->with('success', 'Pontuação atualizada com sucesso.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Erro ao movimentar pontos: ' . $e->getMessage());
        }
    }
}