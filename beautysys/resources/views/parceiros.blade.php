@extends('template')

@section('title', 'Parceiros')

@section('body-class')

@section('nav-buttons')
    
@endsection

@section('content')

<section id="home" class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
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
        <h1 class="display-4">Beauty Sys</h1>
        <p class="lead">Aumente sua produtividade e a satisfação de seus clientes!</p>
        <a href="" class="btn btn-custom btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#signinModalProfissional">Sou um profissional</a>
        <a href="" class="btn btn-custom2 btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#signinModalProprietario">Tenho um estabelecimento</a>
    </div>
</section>

<div class="b-example-divider"></div>

<section id="vantagens" class="py-5" style="background: #eb7af0;">
    <div class="container">
        <div class="row text">
            <div class="col-md-6">
                <div class="row">
                <h2 class="fw-bold">CONHEÇA O BEAUTYSYS</h2>
                <p>O BeautySys é um sistema de gerenciamento para salões de beleza, desenvolvido para otimizar a administração de agendamentos.
                    <br>Este sistema permitirá aos salões gerenciar eficientemente suas operações diárias, oferecendo aos clientes a capacidade de 
                    agendar serviços como cortes de cabelo, coloração, manicure, pedicure e outros tratamentos de beleza. 
                    Além disso, pensando na evolução natural do sistema, projetamos o Beauty Sys para incluir funcionalidades de venda de produtos de beleza.
                    <br>Isso permitirá que os salões não apenas prestem serviços, mas também comercializem uma variedade de produtos, como xampus, condicionadores, 
                    cremes e acessórios. O objetivo é oferecer uma interface amigável que facilite e integre a experiência em salões de beleza e barbearias.</p>
                </div>
                <div class="row mb-3 mt-3 vantagens">
                    <h3>Controle Total</h3>
                    <p>Com nossa plataforma, a gestão dos agendamentos e dos recursos financeiros ficam muito mais simples
                        e resgistrados de maneira segura, consistente e atualizada 100% do tempo.
                    </p>
                </div>
                <div class="row mb-3 vantagens">
                    <h3>Facilidade de comunicação</h3>
                    <p>Detalhes e alterações no agendamento, além do contato com o cliente ficam muito mais facilitados, pois você 
                        faz tudo isso em só lugar. Isso te ajuda a reduzir o número de ausências, flexibilizar sua agenda e criar uma
                         relação muito mais próxima com a comunidade.
                    </p>
                </div>
                <div class="row mb-3 vantagens">
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
            <div class="col-md-6 mt-5">
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
<div class="modal fade" id="signupModalEstab" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control rounded-3 @error('razao_social') is-invalid @enderror" id="floatingRazaoSocial" name="razao_social" placeholder="Razão Social" value="{{ old('razao_social') }}" required>
                        <label for="floatingRazaoSocial">Razão Social</label>
                        @error('razao_social')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('nome_fantasia') is-invalid @enderror" id="floatingNomeFantasia" name="nome_fantasia" placeholder="Nome Fantasia" value="{{ old('nome_fantasia') }}" required>
                        <label for="floatingNomeFantasia">Nome Fantasia</label>
                        @error('nome_fantasia')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('telefone') is-invalid @enderror" id="floatingTelefoneEstab" name="telefoneEstab" placeholder="(XX) XXXXX-XXXX" value="{{ old('telefoneEstab') }}" required>
                        <label for="floatingTelefone">Telefone</label>
                        @error('telefoneEstab')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('cnpj') is-invalid @enderror" id="floatingCNPJ" name="cnpj" placeholder="XX.XXX.XXX/XXXX-XX" value="{{ old('cnpj') }}" required>
                        <label for="floatingCNPJ">CNPJ</label>
                        @error('cnpj')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('logradouro') is-invalid @enderror" id="floatingLogradouro" name="logradouro" placeholder="Logradouro" value="{{ old('logradouro') }}" required>
                        <label for="floatingLogradouro">Logradouro</label>
                        @error('logradouro')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('numero') is-invalid @enderror" id="floatingNumero" name="numero" placeholder="Número" value="{{ old('numero') }}" required>
                        <label for="floatingNumero">Número</label>
                        @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('bairro') is-invalid @enderror" id="floatingBairro" name="bairro" placeholder="Bairro" value="{{ old('bairro') }}" required>
                        <label for="floatingBairro">Bairro</label>
                        @error('bairro')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('cidade') is-invalid @enderror" id="floatingCidade" name="cidade" placeholder="Cidade" value="{{ old('cidade') }}" required>
                        <label for="floatingCidade">Cidade</label>
                        @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('estado') is-invalid @enderror" id="floatingEstado" name="estado" placeholder="UF" maxlength="2" value="{{ old('estado') }}" required>
                        <label for="floatingEstado">Estado</label>
                        @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('cep') is-invalid @enderror" id="floatingCEP" name="cep" placeholder="XXXXX-XXX" value="{{ old('cep') }}" required>
                        <label for="floatingCEP">CEP</label>
                        @error('cep')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Select inicio expediente -->
                    <div class="form-floating mb-3">
                        <select class="form-select rounded-3 @error('inicio_expediente') is-invalid @enderror" 
                                id="floatingInicioExpediente" 
                                name="inicio_expediente" 
                                required>
                            <option value="" disabled {{ old('inicio_expediente') ? '' : 'selected' }}>Selecione um horário</option>
                            @php
                                // Gera os horários de 08:00 a 18:00 com incrementos de 30 minutos
                                for ($h = 6; $h <= 23; $h++) {
                                    for ($m = 0; $m < 60; $m += 30) {
                                        // Adiciona os segundos '00' ao formato
                                        $time = sprintf('%02d:%02d:00', $h, $m);
                                        echo "<option value=\"$time\" " . (old('inicio_expediente') == $time ? 'selected' : '') . ">$time</option>";
                                    }
                                }
                            @endphp
                        </select>
                        <label for="floatingInicioExpediente">Início do Expediente</label>
                        @error('inicio_expediente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Select termino expediente -->
                    <div class="form-floating mb-3">
                        <select class="form-select rounded-3 @error('termino_expediente') is-invalid @enderror" 
                                id="floatingTerminoExpediente" 
                                name="termino_expediente" 
                                required>
                            <option value="" disabled {{ old('termino_expediente') ? '' : 'selected' }}>Selecione um horário</option>
                            @php
                                // Gera os horários de 08:00 a 18:00 com incrementos de 30 minutos
                                for ($h = 6; $h <= 23; $h++) {
                                    for ($m = 0; $m < 60; $m += 30) {
                                        // Adiciona os segundos '00' ao formato
                                        $time = sprintf('%02d:%02d:00', $h, $m);
                                        echo "<option value=\"$time\" " . (old('termino_expediente') == $time ? 'selected' : '') . ">$time</option>";
                                    }
                                }
                            @endphp
                        </select>
                        <label for="floatingTerminoExpediente">Término do Expediente</label>
                        @error('termino_expediente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailCadasProp') is-invalid @enderror" id="floatingEmailCadasProp" name="emailCadasProp" placeholder="name@example.com" value="{{ old('emailCadasProp') }}" required>
                        <label for="floatingEmailCadasProp">Email</label>
                        @error('emailCadasProp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('senhaCadasProp') is-invalid @enderror" id="floatingPasswordCadasProp" name="senhaCadasProp" placeholder="Senha" value="{{ old('senhaCadasProp') }}" required>
                        <label for="floatingPasswordCadasProp">Senha</label>
                        @error('senhaCadasProp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                <h1 class="fw-bold mb-0 fs-2">Log In Estabelecimento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('loginEstab') }}" method="POST">
                @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailLoginProp') is-invalid @enderror" id="floatingInput" name="emailLoginProp" placeholder="name@example.com" value="{{ old('emailLoginProp') }}" required>
                        <label for="floatingInput">Email address</label>
                        @error('emailLoginProp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('senhaLoginProp') is-invalid @enderror" id="floatingPassword" name="senhaLoginProp" placeholder="Password" value="{{ old('senhaLoginProp') }}" required>
                        <label for="floatingPassword">Senha</label>
                        @error('senhaLoginProp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mb-3">
                        <a class="" data-bs-toggle="modal" data-bs-target="#signupModalEstab" style="cursor: pointer;">Não tenho conta</a> 
                    </div>
                    <div class="text-center mb-3">
                        <a class="" data-bs-toggle="modal" data-bs-target="#forgotPasswordModalEstab" style="cursor: pointer;">Esqueci a senha</a>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Entrar</button>
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
                <h1 class="fw-bold mb-0 fs-2">Cadastro de Profissional</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('cadastrarProfissional') }}" method="POST">
                @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('nome') is-invalid @enderror" id="floatingName" name="nome" placeholder="Nome Completo" value="{{ old('nome') }}" required required>
                        <label for="floatingName">Nome Completo</label>
                        @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control rounded-3 @error('data_nascimento') is-invalid @enderror" id="floatingDate" name="data_nascimento" placeholder="Data de Nascimento" value="{{ old('data_nascimento') }}" required>
                        <label for="floatingDate">Data de Nascimento</label>
                        @error('data_nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('cpf') is-invalid @enderror" id="floatingCpf" name="cpf" placeholder="CPF" value="{{ old('cpf') }}" required>
                        <label for="floatingCpf">CPF</label>
                        @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 @error('telefone') is-invalid @enderror" id="floatingTelefoneProf" name="telefone" placeholder="(XX) XXXXX-XXXX" value="{{ old('telefone') }}" required>
                        <label for="floatingTelefone">Telefone</label>
                        @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailCadasProf') is-invalid @enderror" id="floatingInput" name="emailCadasProf" placeholder="name@example.com" value="{{ old('emailCadasProf') }}" required>
                        <label for="floatingInput">Email address</label>
                        @error('emailCadasProf')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('senhaCadasProf') is-invalid @enderror" id="floatingPassword" name="senhaCadasProf" placeholder="Password" value="{{ old('senhaCadasProf') }}" required>
                        <label for="floatingPassword">Senha</label>
                        @error('senhaCadasProf')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button href="" class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Cadastrar</button>
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
                <h1 class="fw-bold mb-0 fs-2">Log In Profissional</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('loginProfissional') }}" method="POST">
                @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailLoginProf') is-invalid @enderror" id="floatingInput" name="emailLoginProf" placeholder="name@example.com" value="{{ old('emailLoginProf') }}" required>
                        <label for="floatingInput">Email address</label>
                        @error('emailLoginProf')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('senhaLoginProf') is-invalid @enderror" id="floatingPassword" name="senhaLoginProf" placeholder="Password" value="{{ old('senhaLoginProf') }}" required>
                        <label for="floatingPassword">Senha</label>
                        @error('senhaLoginProf')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mb-3">
                        <a class="" data-bs-toggle="modal" data-bs-target="#signupModalProfissional" style="cursor: pointer;">Não tenho conta</a>
                    </div>
                    <div class="text-center mb-3">
                        <a class="" data-bs-toggle="modal" data-bs-target="#forgotPasswordModalProf" style="cursor: pointer;">Esqueci a senha</a>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPasswordModalEstab" tabindex="-1" aria-labelledby="forgotPAsswordModalLabelEstab" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Reset de senha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('esqueceuSenhaEstabelecimento') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailResetSenhaEstab') is-invalid @enderror" id="floatingForgotPasswordEstab" name="emailResetSenhaEstab" placeholder="name@example.com" value="{{ old('emailResetSenhaEstab') }}" required>
                        <label for="floatingForgotPasswordEstab">Email address</label>
                        @error('emailResetSenhaEstab')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPasswordModalProf" tabindex="-1" aria-labelledby="forgotPAsswordModalLabelProf" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Reset de senha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('esqueceuSenhaProfissional') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('emailResetSenha') is-invalid @enderror" id="floatingForgotPasswordProf" name="emailResetSenhaProf" placeholder="name@example.com" value="{{ old('emailResetSenhaProf') }}" required>
                        <label for="floatingForgotPasswordProf">Email address</label>
                        @error('emailResetSenhaProf')
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
        // Mostrar modal de cadastro do Estabelecimento se houver erros de cadastro
        @if ($errors->has('razao_social') || $errors->has('nome_fantasia') || $errors->has('telefone') || $errors->has('cnpj') 
        || $errors->has('logradouro') || $errors->has('numero') || $errors->has('bairro') || $errors->has('cidade') 
        || $errors->has('estado') || $errors->has('cep') || $errors->has('inicio_expediente') || $errors->has('termino_expediente')
        || $errors->has('emailCadasProp')|| $errors->has('senhaCadasProp'))
            var signupModal = new bootstrap.Modal(document.getElementById('signupModalProprietario'));
            signupModal.show();
        @endif

        // Mostrar modal de login do Estabelecimento se houver erros de login
        @if ($errors->has('emailLoginProp') || $errors->has('senhaLoginProp'))
            var signinModal = new bootstrap.Modal(document.getElementById('signinModalProprietario'));
            signinModal.show();
        @endif

        // Mostrar modal de cadastro do Profissional se houver erros de login
        @if ($errors->has('nome') || $errors->has('data_nascimento') || $errors->has('cpf') || $errors->has('telefone') || $errors->has('emailCadasProf') || $errors->has('senhaCadasProf'))
            var signupModal = new bootstrap.Modal(document.getElementById('signupModalProfissional'));
            signupModal.show();
        @endif

        // Mostrar modal de login do Profissional se houver erros de login
        @if ($errors->has('emailLoginProf') || $errors->has('senhaLoginProf'))
            var signinModal = new bootstrap.Modal(document.getElementById('signinModalProfissional'));
            signinModal.show();
        @endif
    });

    document.addEventListener("DOMContentLoaded", function() {
        const flatpickrInstance = flatpickr("#floatingDate", {
            dateFormat: "Y-m-d",
            altInput: true, // Exibe um campo separado para visualização amigável
            altFormat: "d/m/Y", // Formato amigável para exibição
            maxDate: "today",
            locale: "pt",
            allowInput: true, // Permite que o usuário digite a data
            yearRange: 100 // Intervalo de anos visível no seletor
        });

        IMask(flatpickrInstance.altInput, {
            mask: '00/00/0000'
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#floatingTerminoExpediente", {
            enableTime: true, // Ativa a seleção de horário
            noCalendar: true, // Desativa a seleção de data
            dateFormat: "H:i", // Formato de saída para a hora
            time_24hr: true, // Exibir no formato 24 horas
            minuteIncrement: 1 // Incrementos de minutos
        });
    });

    IMask(
        document.getElementById('floatingTelefoneProf'),
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
        document.getElementById('floatingTelefoneEstab'),
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

    IMask(
        document.getElementById('floatingCNPJ'),
        {
            mask: '00.000.000/0000-00',
        },
    );

    IMask(
        document.getElementById('floatingCEP'),
        {
            mask: '00000-000',
        },
    );
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection