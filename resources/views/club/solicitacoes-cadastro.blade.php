@extends('layouts.admin')

@section('content')
<div class="container py-4">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem;">SOLICITAÇÃO DE CADASTRO</h1>
        <p class="text-muted mb-0">Valide os cadastros para uso do clube</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($cadastrosPendentes->isEmpty())
        <div class="alert alert-info text-center">
            Não há solicitações de cadastro pendentes no momento.
        </div>
    @else
        <div class="accordion" id="accordionCadastros">
            @foreach($cadastrosPendentes as $cadastro)
                <div class="accordion-item mb-3 border rounded overflow-hidden">
                    <h2 class="accordion-header" id="heading-{{ $cadastro->id }}">
                        <button
                            class="accordion-button collapsed fw-semibold"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $cadastro->id }}"
                            aria-expanded="false"
                            aria-controls="collapse-{{ $cadastro->id }}"
                        >
                            {{ $cadastro->name }}
                        </button>
                    </h2>

                    <div
                        id="collapse-{{ $cadastro->id }}"
                        class="accordion-collapse collapse"
                        aria-labelledby="heading-{{ $cadastro->id }}"
                        data-bs-parent="#accordionCadastros"
                    >
                        <div class="accordion-body">
                            <div class="mb-2">
                                <strong>Nome:</strong>
                                <span>{{ $cadastro->name }}</span>
                            </div>

                            <div class="mb-2">
                                <strong>Email:</strong>
                                <span>{{ $cadastro->email ?? '-' }}</span>
                            </div>

                            <div class="mb-2">
                                <strong>Telefone:</strong>
                                <span>{{ $cadastro->telefone ?? '-' }}</span>
                            </div>

                            <div class="mb-2">
                                <strong>CPF/CNPJ:</strong>
                                <span>{{ $cadastro->cpf_cnpj ?? '-' }}</span>
                            </div>

                            <div class="mb-2">
                                <strong>Profissão:</strong>
                                <span>{{ $cadastro->profissao ?? '-' }}</span>
                            </div>

                            <div class="mb-4">
                                <strong>RRT:</strong>
                                <span>{{ $cadastro->rrt ?? '-' }}</span>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <form action="{{ route('cadastros.solicitacoes.aprovar', $cadastro->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success">
                                        ACEITAR
                                    </button>
                                </form>

                                <form action="{{ route('cadastros.solicitacoes.recusar', $cadastro->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">
                                        RECUSAR
                                    </button>
                                </form>

                                <form action="{{ route('cadastros.solicitacoes.aprovarAdmin', $cadastro->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-adm">
                                        ACEITAR COMO ADM
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection