@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
    <div class="bg-1">
        <section class="regatto-hero-content">
            <div class="container py-5">
                <div class="row align-items-center g-4">

                    {{-- COLUNA ESQUERDA --}}
                    <div class="col-12 col-lg-6">
                        <div class="hero-left">
                            <img
                                src="{{ asset('images/logo.png') }}"
                                alt="Grupo Regatto"
                                class="hero-logo mb-4"
                            >

                            <h1 class="hero-title mb-2">
                                Clube de benefícios <span class="hero-title-strong">Regatto</span>
                            </h1>

                            <p class="hero-subtitle mb-4">
                                O <strong>Clube Regatto</strong> é um programa criado para valorizar, reconhecer e premiar profissionais parceiros que indicam clientes para a Regatto Ambientes Planejados, fortalecendo parcerias e incentivando relacionamentos duradouros.
                            </p>

                            <div class="d-flex flex-wrap gap-3">
                                <a href="#como-afiliar" class="btn regatto-btn regatto-btn--red px-4 link-btn-primary">
                                    AFILIE-SE
                                </a>

                                <a href="{{ route('clube.pontos') }}" class="btn regatto-btn regatto-btn--red px-4 link-btn-primary btn-associado">
                                    ÁREA DO ASSOCIADO
                                </a>
                            </div>

                            <div>
                                
                            </div>
                        </div>
                    </div>

                    {{-- COLUNA DIREITA (FORM) --}}
                    <div class="col-12 col-lg-6">
                        <div class="d-flex justify-content-lg-end">
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <div id="saiba-mais-top" class="bg-geral bg-corpo-body"></div>

    <div id="saiba-mais" class="bg-2 py-5 px-3">
        <div class="container text-center master">

            <div class="row justify-content-center">
                <div class="col-12 col-md-6 mb-4">
                    <h3 class="tl-h3">SAIBA COMO FUNCIONA</h3>
                </div>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-12 col-md-4">
                    <img src="{{ asset('images/cadastre.png') }}" alt="Passo 1" class="mb-3 mt-5 img-icon">
                    <h4 class="tl-h4">CADASTRE-SE GRATUITAMENTE</h4>
                </div>
                <div class="col-12 col-md-4">
                    <img src="{{ asset('images/pontue.png') }}" alt="Passo 2" class="mb-3 mt-5 img-icon  ">
                    <h4 class="tl-h4">ACUMULE PONTOS COM OS PROJETOS NA REGATTO</h4>
                </div>
                <div class="col-12 col-md-4">
                    <img src="{{ asset('images/troque.png') }}" alt="Passo 3" class="mb-3 mt-5 img-icon">
                    <h4 class="tl-h4">TROQUE SEUS PONTOS POR BRINDES INCRÍVEIS</h4>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-geral bg-corpo-body"></div>

    <div id="como-afiliar" class="bg-3">
        <section class="regatto-hero-content regatto-hero-join">
            <div class="container py-5">
                <div class="row">
                    <div class="col-12">
                        <h2 class="join-top-title text-center mb-4">
                            AFILIE-SE REALIZANDO O CADASTRO E COMECE A PONTUAR
                        </h2>
                    </div>
                </div>

                <div id="form-afiliacao" class="row align-items-center g-4 mt-2">
                    {{-- COLUNA ESQUERDA (FORM) --}}
                    <div class="col-12 col-lg-6">
                        <div class="d-flex justify-content-lg-start">
                            <div class="regatto-card regatto-card--join w-100 form-2">
                                <h3 class="regatto-card-title regatto-card-title--join text-center mb-4">
                                    Preencha para se Afiliar
                                </h3>

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Ocorreram erros ao realizar o cadastro:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('afiliacao.store') }}" class="regatto-form" novalidate>
                                    @csrf

                                    <div class="mb-3">
                                        <input
                                            type="text"
                                            name="nome"
                                            class="form-control regatto-input regatto-input--join @error('nome') is-invalid @enderror"
                                            placeholder="Nome completo"
                                            value="{{ old('nome') }}"
                                            required
                                        >
                                        @error('nome')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control regatto-input regatto-input--join @error('email') is-invalid @enderror"
                                            placeholder="E-mail"
                                            value="{{ old('email') }}"
                                            required
                                        >
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input
                                            type="password"
                                            name="senha"
                                            class="form-control regatto-input regatto-input--join @error('senha') is-invalid @enderror"
                                            placeholder="Senha"
                                            required
                                        >
                                        @error('senha')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input
                                            type="password"
                                            name="senhaconfirmacao"
                                            class="form-control regatto-input regatto-input--join @error('senhaconfirmacao') is-invalid @enderror"
                                            placeholder="Confirmar Senha"
                                            required
                                        >
                                        @error('senhaconfirmacao')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input
                                            type="text"
                                            name="telefone"
                                            id="telefone"
                                            class="form-control regatto-input regatto-input--join @error('telefone') is-invalid @enderror"
                                            placeholder="Telefone"
                                            value="{{ old('telefone') }}"
                                            inputmode="numeric"
                                            maxlength="15"
                                            required
                                        >
                                        @error('telefone')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input
                                            type="text"
                                            name="cpf_cnpj"
                                            id="cpf_cnpj"
                                            class="form-control regatto-input regatto-input--join @error('cpf_cnpj') is-invalid @enderror"
                                            placeholder="CPF ou CNPJ"
                                            value="{{ old('cpf_cnpj') }}"
                                            inputmode="numeric"
                                            maxlength="18"
                                            required
                                        >
                                        @error('cpf_cnpj')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <select
                                            name="profissao"
                                            class="form-select regatto-input regatto-input--join @error('profissao') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">Selecione sua profissão</option>
                                            <option value="Arquiteto" {{ old('profissao') === 'Arquiteto' ? 'selected' : '' }}>
                                                Arquiteto
                                            </option>
                                            <option value="Engenheiro" {{ old('profissao') === 'Engenheiro' ? 'selected' : '' }}>
                                                Engenheiro
                                            </option>
                                            <option value="Corretor de imóveis" {{ old('profissao') === 'Corretor de imóveis' ? 'selected' : '' }}>
                                                Corretor de imóveis
                                            </option>
                                        </select>
                                        @error('profissao')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <input
                                            type="text"
                                            name="rrt"
                                            class="form-control regatto-input regatto-input--join @error('rrt') is-invalid @enderror"
                                            placeholder="Registro de Responsabilidade (RRT)"
                                            value="{{ old('rrt') }}"
                                        >
                                        @error('rrt')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input @error('aceite_termos') is-invalid @enderror"
                                                type="checkbox"
                                                name="aceite_termos"
                                                id="aceite_termos"
                                                value="1"
                                                {{ old('aceite_termos') ? 'checked' : '' }}
                                                required
                                            >
                                            <label class="form-check-label text-dark" for="aceite_termos">
                                                Ao marcar você está de acordo com nossos
                                                <a href="{{ route('public.politica') }}" target="_blank">
                                                    Termos e Condições e Política de Privacidade
                                                </a>.
                                            </label>
                                        </div>

                                        @error('aceite_termos')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn regatto-btn regatto-btn--red w-100 regatto-btn--join">
                                        AFILIAR
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- COLUNA DIREITA (TEXTO/RECOMPENSAS) --}}
                    <div class="col-12 col-lg-6">
                        <div class="join-right">
                            <h3 class="join-right-title mb-2">
                                Uma viagem de cruzeiro para duas pessoas está te aguardando
                            </h3>

                            <div>
                                <a href="{{ route('clube.pontos') }}" class="btn regatto-btn regatto-btn--red px-4 link-btn-primary btn-associado mt-4">
                                    ÁREA DO ASSOCIADO
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const telefoneInput = document.getElementById('telefone');
            const cpfCnpjInput = document.getElementById('cpf_cnpj');

            function aplicarMascaraTelefone(valor) {
                valor = valor.replace(/\D/g, '').slice(0, 11);

                if (valor.length <= 10) {
                    valor = valor.replace(/^(\d{0,2})(\d{0,4})(\d{0,4})$/, function (_, p1, p2, p3) {
                        let resultado = '';

                        if (p1) resultado += '(' + p1;
                        if (p1 && p1.length === 2) resultado += ') ';
                        if (p2) resultado += p2;
                        if (p3) resultado += '-' + p3;

                        return resultado;
                    });
                } else {
                    valor = valor.replace(/^(\d{0,2})(\d{0,5})(\d{0,4})$/, function (_, p1, p2, p3) {
                        let resultado = '';

                        if (p1) resultado += '(' + p1;
                        if (p1 && p1.length === 2) resultado += ') ';
                        if (p2) resultado += p2;
                        if (p3) resultado += '-' + p3;

                        return resultado;
                    });
                }

                return valor;
            }

            function aplicarMascaraCpfCnpj(valor) {
                valor = valor.replace(/\D/g, '').slice(0, 14);

                if (valor.length <= 11) {
                    valor = valor.replace(/^(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2})$/, function (_, p1, p2, p3, p4) {
                        let resultado = '';
                        if (p1) resultado += p1;
                        if (p2) resultado += '.' + p2;
                        if (p3) resultado += '.' + p3;
                        if (p4) resultado += '-' + p4;
                        return resultado;
                    });
                } else {
                    valor = valor.replace(/^(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})$/, function (_, p1, p2, p3, p4, p5) {
                        let resultado = '';
                        if (p1) resultado += p1;
                        if (p2) resultado += '.' + p2;
                        if (p3) resultado += '.' + p3;
                        if (p4) resultado += '/' + p4;
                        if (p5) resultado += '-' + p5;
                        return resultado;
                    });
                }

                return valor;
            }

            if (telefoneInput) {
                telefoneInput.addEventListener('input', function () {
                    this.value = aplicarMascaraTelefone(this.value);
                });

                telefoneInput.addEventListener('paste', function () {
                    setTimeout(() => {
                        this.value = aplicarMascaraTelefone(this.value);
                    }, 0);
                });

                telefoneInput.value = aplicarMascaraTelefone(telefoneInput.value);
            }

            if (cpfCnpjInput) {
                cpfCnpjInput.addEventListener('input', function () {
                    this.value = aplicarMascaraCpfCnpj(this.value);
                });

                cpfCnpjInput.addEventListener('paste', function () {
                    setTimeout(() => {
                        this.value = aplicarMascaraCpfCnpj(this.value);
                    }, 0);
                });

                cpfCnpjInput.value = aplicarMascaraCpfCnpj(cpfCnpjInput.value);
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const hasErrors = {{ $errors->any() ? 'true' : 'false' }};

            if (hasErrors) {
                const form = document.getElementById('form-afiliacao');

                if (form) {
                    setTimeout(() => {
                        form.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }, 200);
                }
            }
        });
    </script>
@endsection