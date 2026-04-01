<?php

namespace App\Http\Controllers;

use App\Models\Premio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PremioAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Premio::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }

        if ($request->filled('pontos_resgate')) {
            $query->where('pontos_resgate', $request->pontos_resgate);
        }

        if ($request->filled('ativo')) {
            $ativo = strtoupper($request->ativo);
            if (in_array($ativo, ['S', 'N'])) {
                $query->where('ativo', $ativo);
            }
        }

        $premios = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('club.premios-admin', compact('premios'));
    }

    public function update(Request $request, Premio $premio)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'pontos_resgate' => ['required', 'numeric', 'min:0'],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'ativo' => ['required', 'in:S,N'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('imagem')) {
            if ($premio->imagem && Storage::disk('public')->exists($premio->imagem)) {
                Storage::disk('public')->delete($premio->imagem);
            }

            $premio->imagem = $request->file('imagem')->store('premios', 'public');
        }

        $premio->nome = $validated['nome'];
        $premio->pontos_resgate = $validated['pontos_resgate'];
        $premio->descricao = $validated['descricao'] ?? null;
        $premio->ativo = $validated['ativo'];
        $premio->save();

        return redirect()
            ->route('premios.index')
            ->with('success', 'Prêmio atualizado com sucesso!');
    }

    public function destroy(Premio $premio)
    {
        if ($premio->imagem && Storage::disk('public')->exists($premio->imagem)) {
            Storage::disk('public')->delete($premio->imagem);
        }

        $premio->delete();

        return redirect()
            ->route('premios.index')
            ->with('success', 'Prêmio removido com sucesso!');
    }
}