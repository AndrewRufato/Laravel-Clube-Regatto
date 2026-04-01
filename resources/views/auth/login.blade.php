@extends('layouts.app')

@section('content')
<div class="page-shell page-shell--paper">
  <div class="page-center page-center--wide">
    <section class="auth-box auth-box--xl">
      <div class="auth-icon">
      <img src="{{ asset('images/icon-login.png') }}" alt="Logo Regatto">
      </div>

       <form method="POST" action="{{ route('auth.login.post') }}">
      @csrf

        <input class="panel-input auth-input" type="text" name="usuario" placeholder="EMAIL" required>
        <input class="panel-input auth-input" type="password" name="senha" placeholder="SENHA" required>

        <a href="{{ route('password.request') }}" class="link-btn-secondary">ESQUECI MINHA SENHA</a>

        <button class="btn-panel btn-panel--red auth-btn" type="submit">ENTRAR</button>
       </form>
        @if (session('success'))
         <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        @endif
    </section>
  </div>
</div>
@endsection