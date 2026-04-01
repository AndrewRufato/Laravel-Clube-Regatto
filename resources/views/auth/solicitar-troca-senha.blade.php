@extends('layouts.app')

@section('content')
<div class="page-shell page-shell--paper">
  <div class="page-center page-center--wide">
    <section class="auth-box auth-box--xl">

      {{-- Mensagem de status (sempre genérica) --}}
      @if (session('status'))
        <div class="auth-alert auth-alert--success" role="alert" style="margin-bottom: 12px;">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <input
          class="panel-input auth-input @error('email') is-invalid @enderror"
          type="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="E-MAIL DE CADASTRO"
          required
          autocomplete="email"
        >

        @error('email')
          <div class="auth-error" style="margin-top: 8px;">
            {{ $message }}
          </div>
        @enderror

        <button class="btn-panel btn-panel--red auth-btn" type="submit">
          ENVIAR
        </button>
      </form>

    </section>
  </div>
</div>
@endsection