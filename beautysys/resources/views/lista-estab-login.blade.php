@extends('template')

@section('title', 'Estabelecimentos disponíveis')

@section('body-class')

@section('nav-buttons')
    <li class="nav-item">
        <a href="" class="btn btn-custom ms-4" data-bs-toggle="modal" data-bs-target="#signinModal">Entrar</a>
    </li>

    <li class="nav-item">
        <button href="" type="button" id="btnAbrirCadastro" class="btn btn-custom2 ms-4" data-bs-toggle="modal" data-bs-target="#signupModal">Criar conta</button>
    </li>
@endsection

@section('content')
<section class="mx-5" style="margin-top: 13rem;">
    <h1 class="ms-5">Estabelecimentos Disponíveis</h1>

    @if(empty($estabelecimentos))
        <p>Nenhum estabelecimento disponível no momento.</p>
    @else
        <div class="row justify-content-between mx-5">
            @foreach($estabelecimentos as $e)
                <div class="col-md-4 mb-4"> 
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $e->nome_fantasia }}</h5>
                                <p class="card-text">
                                    Telefone: {{ $e->telefone }}<br>
                                    Email: {{ $e->email }}<br>
                                    Endereço: {{ $e->logradouro }}, {{ $e->numero }}, {{ $e->bairro }} - {{ $e->cidade }} - {{ $e->estado }}
                                </p>
                                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signinModal">Agendar</button>
                            </div>
                        </div>
                </div>
            @endforeach
        </div>
    @endif
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

