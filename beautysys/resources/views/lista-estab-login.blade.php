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
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingName" name="nome" placeholder="" required>
                            <label for="floatingName">Nome Completo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control rounded-3" id="floatingDate" name="data_nascimento" placeholder="" required>
                            <label for="floatingDate">Data de Nascimento</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingCpf" name="cpf" placeholder="" required>
                            <label for="floatingDate">CPF</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingTelefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required>
                            <label for="floatingDate">Telefone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="floatingInput" name="email" placeholder="name@example.com" required>
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword" name="senha" placeholder="Password" required>
                            <label for="floatingPassword">Senha</label>
                        </div>
                        <button href="" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Cadastrar</button>
                        <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
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
                            <input type="email" class="form-control rounded-3" id="floatingInput" name="email" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword" name="senha" placeholder="Password">
                            <label for="floatingPassword">Senha</label>
                        </div>
                        <div class="text-center mb-3">
                            <a class="" data-bs-toggle="modal" data-bs-target="#signupModal" style="cursor: pointer;">Não tenho conta</a> 
                        </div>
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

