@extends('layouts.user')

@section('content')
<div class="page-shell page-shell--paper">
  <div class="page-center">
    <header class="page-header">
      <h1 class="page-title">MEMBROS</h1>
      <p class="page-subtitle">Pesquise por um membro do clube</p>
    </header>

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

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <section class="panel-card panel-card--wide">
      <form method="GET" action="{{ route('membros.admin') }}" class="form-grid">
        <input
          class="panel-input"
          type="text"
          name="nome"
          placeholder="NOME"
          value="{{ request('nome') }}"
        >

        <input
          class="panel-input"
          type="text"
          name="email"
          placeholder="EMAIL"
          value="{{ request('email') }}"
        >

        <input
          class="panel-input"
          type="text"
          name="rrt"
          placeholder="REGISTRO DE RESPONSABILIDADE (RRT)"
          value="{{ request('rrt') }}"
        >

        <input
          class="panel-input"
          type="text"
          name="telefone"
          placeholder="TELEFONE"
          value="{{ request('telefone') }}"
        >

        <input
          class="panel-input"
          type="text"
          name="cpf_cnpj"
          placeholder="CPF/CNPJ"
          value="{{ request('cpf_cnpj') }}"
        >

        <input
          class="panel-input"
          type="text"
          name="profissao"
          placeholder="PROFISSÃO"
          value="{{ request('profissao') }}"
        >

        <select class="panel-input" name="aprovado">
          <option value="">APROVADO (TODOS)</option>
          <option value="S" {{ request('aprovado') === 'S' ? 'selected' : '' }}>SIM</option>
          <option value="N" {{ request('aprovado') === 'N' ? 'selected' : '' }}>NÃO</option>
        </select>

        <div class="form-grid__actions">
          <button class="btn-panel btn-panel--dark" type="submit">PESQUISAR</button>
        </div>
      </form>
    </section>

    <h3 class="panel-section-title">RESULTADOS</h3>

    <div class="accordion" id="accordionMembros">
      @forelse($membros as $membro)
        <div class="accordion-item mb-3">
          <h2 class="accordion-header" id="heading-{{ $membro->id }}">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapse-{{ $membro->id }}"
              aria-expanded="false"
              aria-controls="collapse-{{ $membro->id }}"
            >
              <div class="accordion-member-meta">
                <span class="member-name"><strong>{{ $membro->name }}</strong></span>
                <span class="member-email">{{ $membro->email }}</span>
                <span class="member-phone">{{ $membro->telefone ?? '-' }}</span>
              </div>
            </button>
          </h2>

          <div
            id="collapse-{{ $membro->id }}"
            class="accordion-collapse collapse"
            aria-labelledby="heading-{{ $membro->id }}"
            data-bs-parent="#accordionMembros"
          >
            <div class="accordion-body">
              <div class="mb-3">
                <strong>CPF/CNPJ:</strong> {{ $membro->cpf_cnpj ?? '-' }}
              </div>

              <div class="mb-3">
                <strong>Profissão:</strong> {{ $membro->profissao ?? '-' }}
              </div>

              <div class="mb-3">
                <strong>RRT:</strong> {{ $membro->rrt ?? '-' }}
              </div>

              <div class="mb-3">
                <strong>Aprovado:</strong>
                {{ $membro->aprovado === 'S' ? 'Sim' : 'Não' }}
              </div>

              <form method="POST" action="{{ route('membros.movimentar', $membro->id) }}" class="js-form-movimentacao">
                @csrf

                <div class="row g-2">
                  <div class="col-12 col-md-4">
                    <label class="form-label fw-bold">PROJETO</label>
                    <input
                      class="form-control"
                      type="text"
                      name="projeto"
                      maxlength="50"
                      placeholder="Informe o projeto"
                      value="{{ old('projeto') }}"
                      required
                    >
                  </div>

                  <div class="col-12 col-md-4">
                    <label class="form-label fw-bold">DATA DA COMPRA</label>
                    <input
                      class="form-control js-data-compra"
                      type="text"
                      name="data_compra"
                      placeholder="dd/mm/aaaa"
                      value="{{ old('data_compra') }}"
                      maxlength="10"
                      inputmode="numeric"
                      autocomplete="off"
                      required
                    >
                    <div class="invalid-feedback">
                      Informe uma data válida no formato dd/mm/aaaa.
                    </div>
                  </div>

                  <div class="col-12 col-md-4">
                    <label class="form-label fw-bold">NOME DO CLIENTE</label>
                    <input
                      class="form-control"
                      type="text"
                      name="nome_cliente"
                      maxlength="150"
                      placeholder="Informe o nome do cliente"
                      value="{{ old('nome_cliente') }}"
                      required
                    >
                  </div>
                </div>

                <div class="d-flex align-items-center flex-wrap gap-2 mb-3 mt-4">
                  <div style="color: #d62828; font-weight: 700;">
                    PONTOS ATUAIS:
                  </div>

                  <div style="font-weight: 700;">
                    {{ number_format((float) $membro->pontos, 2, ',', '.') }}
                  </div>

                  <input
                    class="form-control"
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="valor"
                    placeholder="0,00"
                    style="max-width: 140px;"
                    value="{{ old('valor') }}"
                    required
                  >

                  <button
                    type="submit"
                    name="tipo_mov"
                    value="ADD"
                    class="btn btn-success btn-sm"
                  >
                    +
                  </button>

                  <button
                    type="submit"
                    name="tipo_mov"
                    value="SUB"
                    class="btn btn-danger btn-sm"
                  >
                    -
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="alert alert-info">
          Nenhum membro encontrado com os filtros informados.
        </div>
      @endforelse
    </div>

    <div class="mt-4">
      {{ $membros->links() }}
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function aplicarMascaraData(valor) {
        valor = valor.replace(/\D/g, '').slice(0, 8);

        if (valor.length > 4) {
            return valor.replace(/(\d{2})(\d{2})(\d{1,4})/, '$1/$2/$3');
        }

        if (valor.length > 2) {
            return valor.replace(/(\d{2})(\d{1,2})/, '$1/$2');
        }

        return valor;
    }

    function dataValida(data) {
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(data)) {
            return false;
        }

        const partes = data.split('/');
        const dia = parseInt(partes[0], 10);
        const mes = parseInt(partes[1], 10);
        const ano = parseInt(partes[2], 10);

        if (mes < 1 || mes > 12) {
            return false;
        }

        if (dia < 1) {
            return false;
        }

        const dataObj = new Date(ano, mes - 1, dia);

        return (
            dataObj.getFullYear() === ano &&
            dataObj.getMonth() === mes - 1 &&
            dataObj.getDate() === dia
        );
    }

    document.querySelectorAll('.js-data-compra').forEach(function (input) {
        input.addEventListener('input', function (e) {
            e.target.value = aplicarMascaraData(e.target.value);

            if (e.target.value.length < 10) {
                e.target.classList.remove('is-invalid');
            }
        });

        input.addEventListener('blur', function (e) {
            const valor = e.target.value.trim();

            if (valor === '') {
                e.target.classList.remove('is-invalid');
                return;
            }

            if (!dataValida(valor)) {
                e.target.classList.add('is-invalid');
            } else {
                e.target.classList.remove('is-invalid');
            }
        });
    });

    document.querySelectorAll('.js-form-movimentacao').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const inputData = form.querySelector('.js-data-compra');

            if (!inputData) {
                return;
            }

            const valor = inputData.value.trim();

            if (!dataValida(valor)) {
                e.preventDefault();
                inputData.classList.add('is-invalid');
                inputData.focus();
            }
        });
    });
});
</script>
@endsection