<header class="bg-geral">
    <div class="container">
        <div class="row align-items-center header-row header-logins">

            <!-- Logo -->
            <div class="col-3 col-md-3">
                 <a href="{{ route('home') }}">
                <img 
                    src="{{ asset('images/logo.png') }}" 
                    alt="Logo Regatto" 
                    class="logo-header"
                ></a>
            </div>

            <!-- Título -->
             <div class="col-3 col-md-9 d-flex flex-row justify-content-around align-items-center">
                    <nav class="menu-clube-nav">
                        <a href="{{ route('membros.admin') }}">MEMBROS DO CLUBE</a>
                        
                        
                        
                        <a href="{{ route('premios.index') }}">PRÊMIOS DO CLUBE</a>
                        
                        <a href="{{ route('clube.pontos') }}">PONTOS E PRÊMIOS</a>
                        
                       <a href="{{ route('cadastros.solicitacoes.index') }}">SOLICITAÇÕES DE CADASTRO</a>
                        
                    </nav>
                    <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 btn-sair">Sair</button>
                    </form>
              </div>

            

            
        </div>
    </div>
</header>

<!-- NOVA SESSÃO DE NAVEGAÇÃO -->
