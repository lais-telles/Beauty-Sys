@extends('template')

@section('title', 'Pessoa Física')

@section('body-class')

@section('nav-buttons')
    <li class="nav-item">
        <a href="{{ route('PaginaInicialPf') }}" class="btn btn-custom ms-4">Entrar</a>
    </li>

    <li class="nav-item">
        <button href="" type="button" id="btnAbrirCadastro" class="btn btn-custom2 ms-4" data-bs-toggle="modal" data-bs-target="#popupCadastro">Criar conta</button>
    </li>
@endsection

@section('content')

<section class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
    <div class="container text-center">
        <h1 class="display-4">Agende seus Serviços de Beleza com Facilidade</h1>
        <p class="lead">Encontre os melhores salões e agende em poucos cliques.</p>
        <a href="" class="btn btn-custom btn-lg mt-4">Agendar Agora</a>
        <a href="" class="btn btn-custom2 btn-lg mt-4">Ver Salões</a>
    </div>
</section>

<div class="b-example-divider"></div>

<section id="vantagens" class="py-5" style="background: #eb7af0;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <h3>Agendamento Simples</h3>
                <p>Agende seus serviços de beleza de forma rápida e prática.</p>
            </div>
            <div class="col-md-4">
                <h3>Variedade de Salões</h3>
                <p>Escolha entre diversos salões parceiros e encontre o que melhor atende suas necessidades.</p>
            </div>
            <div class="col-md-4">
                <h3>Avaliações e Comentários</h3>
                <p>Veja as opiniões de outros clientes para tomar a decisão certa.</p>
            </div>
        </div>
        <div class="row mt-4 text-center">
            <div class="col-md-12">
                <h3>Ofertas e Promoções</h3>
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

@endsection
