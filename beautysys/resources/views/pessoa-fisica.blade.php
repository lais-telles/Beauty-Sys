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

<section class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
    <div class="container text-center">
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
