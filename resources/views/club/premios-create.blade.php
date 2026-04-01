 @extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Cadastrar novo prêmio</h1>
        <a href="{{ route('premios.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Corrija os campos abaixo:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('premios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            value="{{ old('nome') }}"
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
                            value="{{ old('pontos_resgate') }}"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea
                            name="descricao"
                            rows="4"
                            class="form-control"
                        >{{ old('descricao') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ativo</label>
                        <select name="ativo" class="form-select" required>
                            <option value="S" {{ old('ativo', 'S') === 'S' ? 'selected' : '' }}>Ativo</option>
                            <option value="N" {{ old('ativo') === 'N' ? 'selected' : '' }}>Inativo</option>
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
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Salvar prêmio
                    </button>

                   <a href="{{ route('premios.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection