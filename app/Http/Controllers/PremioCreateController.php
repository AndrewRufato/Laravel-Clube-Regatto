<?php

namespace App\Http\Controllers;

use App\Models\Premio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PremioCreateController extends Controller
{
    /**
     * Exibe a tela de criação de prêmio
     */
    public function create()
    {
        return view('club.premios-create');
    }

    /**
     * Salva o novo prêmio no banco
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'pontos_resgate' => ['required', 'numeric', 'min:1'],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'ativo' => ['required', 'in:S,N'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $caminhoImagem = null;

        if ($request->hasFile('imagem')) {

            $caminhoImagem = $request->file('imagem')->store(
                'premios',
                'public'
            );
        }

        Premio::create([
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'] ?? null,
            'pontos_resgate' => $validated['pontos_resgate'],
            'ativo' => $validated['ativo'],
            'imagem' => $caminhoImagem,
        ]);

        return redirect()
            ->route('premios.index')
            ->with('success', 'Prêmio criado com sucesso!');
    }
}