@extends('layouts.user')

@section('content')
<div class="page-shell page-shell--paper">
  <div class="page-center page-center--narrow">

    @if(session('success'))
      <div class="alert alert-success mb-3">
        {{ session('success') }}
      </div>
    @endif

    <section class="points-hero">
      <h2 class="points-hero__title">RESGATE REALIZADO COM SUCESSO</h2>

      <div style="margin-top: 20px; font-size: 18px; color: #222;">
        <p><strong>Usuário:</strong> {{ $resgate->user->name }}</p>
        <p><strong>Prêmio solicitado:</strong> {{ $resgate->premio->nome }}</p>
        <p><strong>Pontos gastos:</strong> {{ number_format($resgate->pontos_gasto, 0, ',', '.') }}</p>
        <p><strong>Saldo antes do resgate:</strong> {{ number_format($resgate->saldo_user_antes_do_resgate, 0, ',', '.') }}</p>
        <p><strong>Saldo após o resgate:</strong> {{ number_format($resgate->saldo_user_pos_resgate, 0, ',', '.') }}</p>
        <p><strong>Data do resgate:</strong> {{ $resgate->created_at->format('d/m/Y H:i:s') }}</p>
      </div>

      <div style="margin-top: 25px;">
        <a href="{{ route('clube.pontos') }}" class="btn-panel btn-panel--red">
          VOLTAR PARA PRÊMIOS
        </a>
      </div>
    </section>

  </div>
</div>
@endsection