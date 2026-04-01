@extends('layouts.user')

@section('content')
<div class="page-shell page-shell--paper">
  <div class="page-center page-center--narrow">

    @if(session('success'))
      <div class="alert alert-success mb-3">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger mb-3">
        {{ session('error') }}
      </div>
    @endif

    <section class="points-hero">
      <h2 class="points-hero__title">
        SEUS PONTOS
        <span style="display:block; font-size:14px; margin-top:8px; color:#d62828;">
          {{ $user->name }}
        </span>
      </h2>

      <div class="points-hero__value">
        {{ number_format($user->pontos, 0, ',', '.') }}
      </div>
    </section>

    <section class="mb-4">
      <div class="accordion history-accordion" id="accordionHistorico">
        <div class="accordion-item history-accordion__item">
          <h2 class="accordion-header" id="headingHistorico">
            <button
              class="accordion-button collapsed history-accordion__button"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseHistorico"
              aria-expanded="false"
              aria-controls="collapseHistorico"
            >
              Histórico
            </button>
          </h2>

          <div
            id="collapseHistorico"
            class="accordion-collapse collapse"
            aria-labelledby="headingHistorico"
            data-bs-parent="#accordionHistorico"
          >
            <div class="accordion-body history-accordion__body">
              @forelse($historicoMovimentacoes as $mov)
                <div class="history-card">
                  <div class="history-card__grid">
                    <div class="history-card__item">
                      <span class="history-card__label">Projeto</span>
                      <span class="history-card__value">{{ $mov->projeto ?? '-' }}</span>
                    </div>

                    <div class="history-card__item">
                      <span class="history-card__label">Nome do Cliente</span>
                      <span class="history-card__value">{{ $mov->nome_cliente ?? '-' }}</span>
                    </div>

                    <div class="history-card__item">
                      <span class="history-card__label">Data da Compra</span>
                      <span class="history-card__value">
                        {{ !empty($mov->data_compra) ? \Carbon\Carbon::parse($mov->data_compra)->format('d/m/Y') : '-' }}
                      </span>
                    </div>

                    <div class="history-card__item">
                      <span class="history-card__label">Saldo Acumulado</span>
                      <span class="history-card__value history-card__value--points">
                        {{ number_format((int) $mov->pontos_mov, 0, ',', '.') }}
                      </span>
                    </div>
                  </div>
                </div>
              @empty
                <div class="alert alert-warning mb-0">
                  Nenhum histórico de pontuação encontrado para o ano vigente.
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="reward-list">
      @forelse($premios as $premio)
        <article class="reward-card">
          <div class="reward-card__img">
            @if(!empty($premio->imagem))
              <img src="{{ asset('storage/' . $premio->imagem) }}" alt="{{ $premio->nome }}">
            @else
              <img src="{{ asset('images/premio-exemplo.jpg') }}" alt="{{ $premio->nome }}">
            @endif
          </div>

          <div class="reward-card__content">
            <h3 class="reward-card__title">
              {{ strtoupper($premio->nome) }}
              <span class="reward-card__points">
                {{ number_format($premio->pontos_resgate, 0, ',', '.') }} PONTOS
              </span>
            </h3>

            <p class="reward-card__desc">
              {{ $premio->descricao }}
            </p>

            <form id="form-resgate-{{ $premio->id }}" action="{{ route('premios.resgatar', $premio->id) }}" method="POST">
              @csrf

              <button
                class="btn-panel btn-panel--red reward-card__btn"
                type="button"
                onclick="verificarPontos({{ (int) $user->pontos }}, {{ (int) $premio->pontos_resgate }}, {{ $premio->id }})"
              >
                RESGATAR
              </button>
            </form>
          </div>
        </article>
      @empty
        <div class="alert alert-warning">
          Nenhum prêmio ativo encontrado no momento.
        </div>
      @endforelse
    </section>

  </div>
</div>

<script>
  function verificarPontos(pontosUsuario, pontosPremio, premioId) {
    if (pontosUsuario < pontosPremio) {
      alert('Pontos insuficientes para resgatar este prêmio.');
      return;
    }

    document.getElementById('form-resgate-' + premioId).submit();
  }
</script>

<style>
  .history-accordion__item {
    border: 1px solid #1f1f1f;
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
  }

  .history-accordion__button {
    font-weight: 700;
    color: #d62828;
    background: #fff;
    box-shadow: none !important;
  }

  .history-accordion__button:not(.collapsed) {
    color: #d62828;
    background: #fff5f5;
  }

  .history-accordion__body {
    background: #fafafa;
    padding: 16px;
  }

  .history-card {
    background: #fff;
    border: 1px solid #e7e7e7;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
  }

  .history-card:last-child {
    margin-bottom: 0;
  }

  .history-card__grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
  }

  .history-card__item {
    display: flex;
    flex-direction: column;
    min-width: 0;
  }

  .history-card__label {
    font-size: 12px;
    font-weight: 700;
    color: #d62828;
    text-transform: uppercase;
    margin-bottom: 4px;
  }

  .history-card__value {
    font-size: 15px;
    font-weight: 600;
    color: #222;
    word-break: break-word;
  }

  .history-card__value--points {
    color: #111;
    font-weight: 800;
  }

  @media (max-width: 991.98px) {
    .history-card__grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 575.98px) {
    .history-accordion__body {
      padding: 12px;
    }

    .history-card {
      padding: 12px;
    }

    .history-card__grid {
      grid-template-columns: 1fr;
      gap: 10px;
    }

    .history-card__label {
      font-size: 11px;
    }

    .history-card__value {
      font-size: 14px;
    }
  }
</style>
@endsection