@extends('template')

@section('title', 'Parceiros')

@section('body-class')

@section('nav-buttons')
    
@endsection

@section('content')

<section id="home" class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
    <div class="container text-center">
        <h1 class="display-4">Beauty Sys</h1>
        <p class="lead">Aumente sua produtividade e a satisfação de seus clientes!</p>
        <a href="" class="btn btn-custom btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#signinModalProfissional">Sou um profissional</a>
        <a href="" class="btn btn-custom2 btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#signinModalProprietario">Proprietário</a>
    </div>
</section>

<div class="b-example-divider"></div>

<section id="vantagens" class="py-5" style="background: #eb7af0;">
    <div class="container">
        <div class="row text">
            <div class="col-md-6">
                <div class="row">
                <h2>CONHEÇA O BEAUTYSYS</h2>
                <p>O BeautySys é um sistema de gerenciamento para salões de beleza, desenvolvido para otimizar a administração de agendamentos.
                    Este sistema permitirá aos salões gerenciar eficientemente suas operações diárias, oferecendo aos clientes a capacidade de 
                    agendar serviços como cortes de cabelo, coloração, manicure, pedicure e outros tratamentos de beleza. 
                    Além disso, pensando na evolução natural do sistema, projetamos o Beauty Sys para incluir funcionalidades de venda de produtos de beleza.
                    Isso permitirá que os salões não apenas prestem serviços, mas também comercializem uma variedade de produtos, como xampus, condicionadores, 
                    cremes e acessórios. O objetivo é oferecer uma interface amigável que facilite e integre a experiência em salões de beleza e barbearias.</p>
                </div>
                <div class="row mb-5 mt-3">
                    <h3>Controle Total</h3>
                    <p>Com nossa plataforma, a gestão dos agendamentos e dos recursos financeiros ficam muito mais simples
                        e resgistrados de maneira segura, consistente e atualizada 100% do tempo.
                    </p>
                </div>
                <div class="row mb-5">
                    <h3>Facilidade de comunicação</h3>
                    <p>Detalhes e alterações no agendamento, além do contato com o cliente ficam muito mais facilitados, pois você 
                        faz tudo isso em só lugar. Isso te ajuda a reduzir o número de ausências, flexibilizar sua agenda e criar uma
                         relação muito mais próxima com a comunidade.
                    </p>
                </div>
                <div class="row mb-5">
                    <h3>Disponibilidade</h3>
                    <p>Seus clientes podem realizar agendamentos a qualquer dia e horário, de acordo com a grade horária do estabelecimento.
                        Isso permite que seus clientes possam realizar o agendamento durante o melhor horário para ele, além de você não 
                        precisar responder um e anotar cada agendamento manualmente.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <img class="img-fluid" src="{{ asset('images/beauty-salon.jpg') }}">
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

    <!-- Poup-up de cadastro pro proprietário-->
    <div class="modal fade" id="signupModalProprietario" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Cadastro de Estabelecimento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 pt-0">
                    <form action="{{ route('cadastrarEstabelecimento') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingRazaoSocial" name="razao_social" placeholder="Razão Social" required>
                            <label for="floatingRazaoSocial">Razão Social</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingNomeFantasia" name="nome_fantasia" placeholder="Nome Fantasia" required>
                            <label for="floatingNomeFantasia">Nome Fantasia</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingTelefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required>
                            <label for="floatingTelefone">Telefone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingCNPJ" name="cnpj" placeholder="XX.XXX.XXX/XXXX-XX" required>
                            <label for="floatingCNPJ">CNPJ</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingLogradouro" name="logradouro" placeholder="Logradouro" required>
                            <label for="floatingLogradouro">Logradouro</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control rounded-3" id="floatingNumero" name="numero" placeholder="Número" required>
                            <label for="floatingNumero">Número</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingBairro" name="bairro" placeholder="Bairro" required>
                            <label for="floatingBairro">Bairro</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingCidade" name="cidade" placeholder="Cidade" required>
                            <label for="floatingCidade">Cidade</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingEstado" name="estado" placeholder="UF" maxlength="2" required>
                            <label for="floatingEstado">Estado</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingCEP" name="cep" placeholder="XXXXX-XXX" required>
                            <label for="floatingCEP">CEP</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="time" class="form-control rounded-3" id="floatingInicioExpediente" name="inicio_expediente" placeholder="Início do Expediente" required step ="1">
                            <label for="floatingInicioExpediente">Início Expediente</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="time" class="form-control rounded-3" id="floatingTerminoExpediente" name="termino_expediente" placeholder="Término do Expediente" required step ="1">
                            <label for="floatingTerminoExpediente">Término Expediente</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="floatingEmail" name="email" placeholder="name@example.com" required>
                            <label for="floatingEmail">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword" name="senha" placeholder="Senha" required>
                            <label for="floatingPassword">Senha</label>
                        </div>
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Cadastrar</button>
                        <small class="text-body-secondary">Ao clicar em cadastrar, você concorda com os termos de uso.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Poup-up de login pro proprietário-->
    <div class="modal fade" id="signinModalProprietario" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Sign In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 pt-0">
                    <form class="">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="text-center mb-3">
                            <a class="" data-bs-toggle="modal" data-bs-target="#signupModalProprietario" style="cursor: pointer;">Não tenho conta</a> 
                        </div>
                        <a href="{{ route('PaginaInicialPj') }}" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Sign In</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Poup-up de cadastro pro profissional-->
    <div class="modal fade" id="signupModalProfissional" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Sign up for free</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 pt-0">
                    <form action="{{ route('cadastrarProfissional') }}" method="POST">
                    @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingName" name="nome" placeholder="" required>
                            <label for="floatingName">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control rounded-3" id="floatingDate" name="data_nascimento" placeholder="" required>
                            <label for="floatingDate">Date of birth</label>
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
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button href="" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Sign up</button>
                        <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Poup-up de login pro profissional-->
    <div class="modal fade" id="signinModalProfissional" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Sign In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 pt-0">
                    <form class="">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="text-center mb-3">
                            <a class="" data-bs-toggle="modal" data-bs-target="#signupModalProfissional" style="cursor: pointer;">Não tenho conta</a>
                        </div>
                        <a href="{{ route('PaginaInicialProfissional') }}" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Sign In</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- <script> script para teste de cadastro de estabelecimento
    document.addEventListener("DOMContentLoaded", function() {
    // Função para preencher automaticamente o formulário
    function autoFillForm() {
        document.getElementById('floatingRazaoSocial').value = "Exemplo Comércio Ltda";
        document.getElementById('floatingNomeFantasia').value = "Exemplo Barbershop";
        document.getElementById('floatingTelefone').value = "(11) 98765-4321";
        document.getElementById('floatingCNPJ').value = "12.345.678/0001-99";
        document.getElementById('floatingLogradouro').value = "Rua dos Exemplos";
        document.getElementById('floatingNumero').value = "123";
        document.getElementById('floatingBairro').value = "Centro";
        document.getElementById('floatingCidade').value = "São Paulo";
        document.getElementById('floatingEstado').value = "SP";
        document.getElementById('floatingCEP').value = "01000-000";
        document.getElementById('floatingInicioExpediente').value = "08:00";
        document.getElementById('floatingTerminoExpediente').value = "18:00";
        document.getElementById('floatingEmail').value = "exemplo@empresa.com";
        document.getElementById('floatingPassword').value = "senha123";
    }

    // Adicionar evento de clique em um botão para preencher o formulário automaticamente
    const autoFillButton = document.createElement("button");
    autoFillButton.textContent = "Preencher Formulário";
    autoFillButton.classList.add("btn", "btn-secondary", "mb-3");
    autoFillButton.addEventListener("click", autoFillForm);
    
    // Inserir o botão no modal, antes do formulário
    const modalBody = document.querySelector("#signupModalProprietario .modal-body");
    modalBody.insertBefore(autoFillButton, modalBody.firstChild);
});

    </script> -->