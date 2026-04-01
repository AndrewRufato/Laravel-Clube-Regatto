@extends('layouts.app')

@section('content')
<div class="page-shell page-shell--paper">
  <div class="page-center page-center--wide">
    <section class="auth-box auth-box--xl">

      @php
        $email = request('email');
      @endphp

      {{-- Se chegou aqui sem email, o link está incompleto --}}
      @if (!$email)
        <div class="auth-alert auth-alert--danger" role="alert" style="margin-bottom: 12px;">
          Link inválido ou incompleto. Solicite um novo link para redefinir a senha.
        </div>

        <a class="btn-panel btn-panel--red auth-btn" href="{{ route('password.update') }}">
          VOLTAR
        </a>
      @else

        @if (session('status'))
          <div class="auth-alert auth-alert--success" role="alert" style="margin-bottom: 12px;">
            {{ session('status') }}
          </div>
        @endif

        {{-- Erros gerais (por ex. token inválido) --}}
        @if ($errors->any())
          <div class="auth-alert auth-alert--danger" role="alert" style="margin-bottom: 12px;">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
          @csrf

          {{-- Necessários pro broker --}}
          <input type="hidden" name="token" value="{{ $token }}">
          <input type="hidden" name="email" value="{{ $email }}">

          {{-- (Opcional) mostrar o email sem permitir editar --}}
          <div style="margin-bottom: 10px; font-size: 14px; opacity: .85;">
            {{ $email }}
          </div>

          <input
            class="panel-input auth-input @error('password') is-invalid @enderror"
            type="password"
            name="password"
            placeholder="NOVA SENHA"
            required
            autocomplete="new-password"
          >

          <input
            class="panel-input auth-input"
            type="password"
            name="password_confirmation"
            placeholder="REPITA A SENHA"
            required
            autocomplete="new-password"
          >

          <button class="btn-panel btn-panel--red auth-btn" type="submit">
            ENVIAR
          </button>
        </form>

      @endif

    </section>
  </div>
</div>
@endsection