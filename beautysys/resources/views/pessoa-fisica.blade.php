@extends('template')

@section('title', 'Pessoa Física')

@section('body-class')

@section('nav-buttons')
<ul class="nav d-flex flex-wrap justify-content-start">
    <li class="nav-item">
        <a href="" class="btn btn-custom ms-4" data-bs-toggle="modal" data-bs-target="#signinModal">Entrar</a>
    </li>

    <li class="nav-item">
        <button href="" type="button" id="btnAbrirCadastro" class="btn btn-custom2 ms-4" data-bs-toggle="modal" data-bs-target="#signupModal">Criar conta</button>
    </li>
</ul>
@endsection

@section('content')

<section class="d-flex" style="margin-top: 15rem; margin-bottom: 10rem;">
    <div class="container text-center">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h1 class="display-4">Agende seus Serviços de Beleza com Facilidade</h1>
        <p class="lead">Encontre os melhores salões e agende em poucos cliques.</p>
        <a href="" class="btn btn-custom btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#signinModal">Agendar Agora</a>
        <a href="{{ route('listaEstabLogin') }}" class="btn btn-custom2 btn-lg mt-4">Ver Salões</a>
    </div>
</section>

<div class="b-example-divider"></div>

<section id="vantagens" class="py-5" style="background: #eb7af0;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 vantagens">
                <h3><i class="fas fa-calendar-check"></i> Agendamento Simples</h3>
                <p>Agende seus serviços de beleza de forma rápida e prática.</p>
            </div>
            <div class="col-md-4 vantagens">
                <h3><i class="fas fa-cut"></i> Variedade de Salões</h3>
                <p>Escolha entre diversos salões parceiros e encontre o que melhor atende suas necessidades.</p>
            </div>
            <div class="col-md-4 vantagens">
                <h3><i class="fas fa-star"></i> Avaliações e Comentários</h3>
                <p>Veja as opiniões de outros clientes para tomar a decisão certa.</p>
            </div>
        </div>
        <div class="row mt-4 text-center">
            <div class="col-md-12 vantagens">
                <h3><i class="fas fa-cart-plus"></i> Ofertas e Promoções</h3>
                <p>Aproveite descontos exclusivos em salões selecionados.</p>
            </div>
        </div>
    </div>
</section>

<div class="b-example-divider"></div>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>ENTRE EM CONTATO</h3>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Seu email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensagem</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Sua mensagem"></textarea>
                    </div>
                    <button type="submit" class="btn btn-custom">Enviar</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3 style="color: #73005B">INFORMAÇÕES</h3>
                <p>Email: contato@beautysys.com</p>
                <p>Telefone: (11) 1234-5678</p>
                <p>Redes Sociais:</p>
                <ul class="list-unstyled">
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Cadastro de Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('cadastrarCliente') }}" method="POST">
                    @csrf
                    <!-- Nome Completo -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('nome') is-invalid @enderror" id="floatingName" name="nome" placeholder="Nome Completo" value="{{ old('nome') }}" required>
                        <label for="floatingName">Nome Completo</label>
                        @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control rounded-3 @error('data_nascimento') is-invalid @enderror" id="floatingDate" name="data_nascimento" placeholder="Data de Nascimento" value="{{ old('data_nascimento') }}" required>
                        <label for="floatingDate">Data de Nascimento</label>
                        @error('data_nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- CPF -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('cpf') is-invalid @enderror" id="floatingCpf" name="cpf" placeholder="CPF" value="{{ old('cpf') }}" required>
                        <label for="floatingCpf">CPF</label>
                        @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('telefone') is-invalid @enderror" id="floatingTelefone" name="telefone" placeholder="(XX) XXXXX-XXXX" value="{{ old('telefone') }}" required>
                        <label for="floatingTelefone">Telefone</label>
                        @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" id="floatingInput" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                        <label for="floatingInput">Email</label>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Senha -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('senha') is-invalid @enderror" id="floatingPassword" name="senha" placeholder="Senha" value="{{ old('senha') }}" required>
                        <label for="floatingPassword">Senha</label>
                        @error('senha')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botão de Cadastro -->
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Log In Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('loginCliente') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailLogin') is-invalid @enderror" id="floatingInputLogin" name="emailLogin" placeholder="name@example.com" value="{{ old('emailLogin') }}" required>
                        <label for="floatingInputLogin">Email address</label>
                        @error('emailLogin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('senhaLogin') is-invalid @enderror" id="floatingPasswordLogin" name="senhaLogin" placeholder="Password" value="{{ old('senhaLogin') }}" required>
                        <label for="floatingPasswordLogin">Senha</label>
                        @error('senhaLogin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mb-3">
                        <a class="" data-bs-toggle="modal" data-bs-target="#signupModal" style="cursor: pointer;">Não tenho conta</a>
                    </div>
                    <div class="text-center mb-3">
                        <a class="" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" style="cursor: pointer;">Esqueci a senha</a>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPAsswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Reset de senha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('esqueceuSenhaCliente') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailResetSenha') is-invalid @enderror" id="floatingForgotPassword" name="emailResetSenha" placeholder="name@example.com" value="{{ old('emailResetSenha') }}" required>
                        <label for="floatingForgotPassword">Email address</label>
                        @error('emailResetSenha')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/imask"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mostrar modal de cadastro se houver erros de cadastro
        @if ($errors->has('nome') || $errors->has('data_nascimento') || $errors->has('cpf') || $errors->has('telefone') || $errors->has('email') || $errors->has('senha'))
            var signupModal = new bootstrap.Modal(document.getElementById('signupModal'));
            signupModal.show();
        @endif

        // Mostrar modal de login se houver erros de login
        @if ($errors->has('emailLogin') || $errors->has('senhaLogin'))
            var signinModal = new bootstrap.Modal(document.getElementById('signinModal'));
            signinModal.show();
        @endif
    });

    document.addEventListener('DOMContentLoaded', function () {
        const flatpickrInstance = flatpickr("#floatingDate", {
            dateFormat: "Y-m-d", // Formato para o valor real
            altInput: true,      // Campo visual amigável
            altFormat: "d/m/Y",  // Formato para exibição amigável
            maxDate: "today",    // Limite máximo de data
            locale: "pt",        // Idioma para o calendário
            allowInput: true,    // Permite entrada manual
        });

        if (flatpickrInstance.altInput) { // Verifica se o altInput foi criado
            IMask(flatpickrInstance.altInput, {
                mask: "00/00/0000"
            });
        }
    });


    IMask(
        document.getElementById('floatingTelefone'),
        {
            mask: [
                {
                    mask: '(00) 0000-0000',
                },
                {
                    mask: '(00) 00000-0000',
                }
            ],
        }
    );

    IMask(
        document.getElementById('floatingCpf'),
        {
            mask: '000.000.000-00',
        },
    );
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@endsection
