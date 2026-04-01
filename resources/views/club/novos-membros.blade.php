@extends('layouts.admin')

@section('content')
<div class="page-shell page-shell--paper">
  <div class="page-center">
    <header class="page-header">
      <h1 class="page-title">SOLICITAÇÃO DE CADASTRO</h1>
      <p class="page-subtitle">Valide os cadastros do para uso do clube</p>
    </header>

    <section class="panel-stack">

      {{-- ITEM FECHADO --}}
      <details class="panel-dd">
        <summary class="panel-dd__head">
          <span class="panel-dd__title">Nome da pessoa 1 quer se afiliar para o clube</span>
          <span class="panel-dd__chev">V</span>
        </summary>
      </details>

      {{-- ITEM ABERTO --}}
      <details class="panel-dd" open>
        <summary class="panel-dd__head">
          <span class="panel-dd__title">Nome da pessoa 1 quer se afiliar para o clube</span>
          <span class="panel-dd__chev">V</span>
        </summary>

        <div class="panel-dd__body">
          <div class="panel-grid">
            <div class="panel-grid__row"><strong>Email:</strong> <span>email@exemplo.com.br</span></div>
            <div class="panel-grid__row"><strong>Telefone:</strong> <span>19999999999</span></div>
            <div class="panel-grid__row"><strong>RRT:</strong> <span>0000000000</span></div>
          </div>

          <div class="panel-actions">
            <form method="POST" action="#">
              @csrf
              <button type="submit" class="btn-panel btn-panel--ok">ACEITAR</button>
            </form>

            <form method="POST" action="#">
              @csrf
              <button type="submit" class="btn-panel btn-panel--danger">RECUSAR</button>
            </form>
          </div>
        </div>
      </details>

    </section>
  </div>
</div>
@endsection