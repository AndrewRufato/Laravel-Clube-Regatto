<header class="bg-geral">
    <div class="container">
        <div class="row align-items-center header-row header-logins">

            <div class="col-12 col-md-3 text-center text-md-start">
                <a href="{{ route('home') }}">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Logo Regatto" 
                        class="logo-header"
                    >
                </a>
            </div>

            <div class="col-12 col-md-9 header-right">
                <nav class="menu-clube-nav">
                    @auth
                        @if (auth()->user()->role === 'admin') 
                            <a href="{{ route('membros.admin') }}">Membros do Clube</a>
                            <a href="{{ route('premios.index') }}">Prêmios do Clube</a>
                            <a href="{{ route('clube.pontos') }}">Pontos e Prêmios</a>
                            <a href="{{ route('cadastros.solicitacoes.index') }}">Solicitações de Cadastro</a>
                        @endif 
                    @endauth
                </nav>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 btn-sair">Sair</button>
                </form>
            </div>

        </div>
    </div>
</header>