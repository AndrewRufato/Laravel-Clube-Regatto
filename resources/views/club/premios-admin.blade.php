@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">PRÊMIOS</h1>
            <p class="text-muted mb-0">Pesquise, edite e remova prêmios</p>
        </div>

        <a href="{{ route('premios.create') }}" class="btn btn-danger">
            Cadastrar novo prêmio
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ocorreram erros de validação:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('premios.index') }}">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">ID</label>
                        <input
                            type="text"
                            name="id"
                            class="form-control"
                            value="{{ request('id') }}"
                            placeholder="ID"
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nome</label>
                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            value="{{ request('nome') }}"
                            placeholder="Nome"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Pontos</label>
                        <input
                            type="text"
                            name="pontos_resgate"
                            class="form-control"
                            value="{{ request('pontos_resgate') }}"
                            placeholder="Pontos para resgate"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Ativo</label>
                        <select name="ativo" class="form-select">
                            <option value="">Todos</option>
                            <option value="S" {{ request('ativo') === 'S' ? 'selected' : '' }}>Ativo</option>
                            <option value="N" {{ request('ativo') === 'N' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <input
                            type="text"
                            name="descricao"
                            class="form-control"
                            value="{{ request('descricao') }}"
                            placeholder="Descrição"
                        >
                    </div>

                    <div class="col-12 d-flex gap-2 justify-content-end">
                        <a href="{{ route('premios.index') }}" class="btn btn-outline-secondary">
                            Limpar
                        </a>
                        <button type="submit" class="btn btn-dark">
                            Pesquisar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h3 class="h4 fw-bold mb-3">RESULTADOS</h3>

    @if($premios->count() > 0)
        <div class="accordion" id="accordionPremios">
            @foreach($premios as $premio)
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header" id="heading{{ $premio->id }}">
                        <button
                            class="accordion-button collapsed fw-bold"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $premio->id }}"
                            aria-expanded="false"
                            aria-controls="collapse{{ $premio->id }}"
                        >
                            <div class="d-flex w-100 align-items-center">
                                <div style="width: 60%;">
                                    #{{ $premio->id }} - {{ $premio->nome }}
                                </div>

                                <div style="width: 20%;">
                                    <span class="badge {{ $premio->ativo === 'S' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $premio->ativo === 'S' ? 'ATIVO' : 'INATIVO' }}
                                    </span>
                                </div>
                            </div>
                        </button>
                    </h2>

                    <div
                        id="collapse{{ $premio->id }}"
                        class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $premio->id }}"
                        data-bs-parent="#accordionPremios"
                    >
                        <div class="accordion-body">
                            <form
                                action="{{ route('premios.update', $premio->id) }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nome</label>
                                        <input
                                            type="text"
                                            name="nome"
                                            class="form-control"
                                            value="{{ old('nome.' . $premio->id, $premio->nome) }}"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Pontos para resgate</label>
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            name="pontos_resgate"
                                            class="form-control"
                                            value="{{ old('pontos_resgate.' . $premio->id, $premio->pontos_resgate) }}"
                                            required
                                        >
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Descrição</label>
                                        <textarea
                                            name="descricao"
                                            rows="4"
                                            class="form-control"
                                        >{{ old('descricao.' . $premio->id, $premio->descricao) }}</textarea>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select name="ativo" class="form-select" required>
                                            <option value="S" {{ $premio->ativo === 'S' ? 'selected' : '' }}>Ativo</option>
                                            <option value="N" {{ $premio->ativo === 'N' ? 'selected' : '' }}>Inativo</option>
                                        </select>
                                    </div>

                                    <div class="col-md-8">
                                        <label class="form-label">Imagem</label>
                                        <input
                                            type="file"
                                            name="imagem"
                                            class="form-control"
                                            accept=".jpg,.jpeg,.png,.webp"
                                        >
                                    </div>

                                    @if($premio->imagem)
                                        <div class="col-12">
                                            <div class="mb-2">Imagem atual:</div>
                                            <img
                                                src="{{ asset('storage/' . $premio->imagem) }}"
                                                alt="Imagem do prêmio"
                                                style="max-width: 220px; border-radius: 8px;"
                                            >
                                        </div>
                                    @endif

                                    <div class="col-12 d-flex gap-2 mt-3">
                                        <button type="submit" class="btn btn-success">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <form
                                action="{{ route('premios.destroy', $premio->id) }}"
                                method="POST"
                                class="mt-3"
                                onsubmit="return confirm('Tem certeza que deseja remover este prêmio?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    Remover
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $premios->links() }}
        </div>
    @else
        <div class="alert alert-warning">
            Nenhum prêmio encontrado.
        </div>
    @endif
</div>
@endsection