@extends('template')

@section('title', 'Parceiros')

@section('body-class')

@section('nav-buttons')
    <li class="nav-item">
        <a href="{{ route('PaginaInicialPj') }}" class="btn btn-custom ms-4">Entrar</a>
    </li>
    <li class="nav-item">
        <a class="btn btn-custom2 ms-4" href="">Criar conta</a>
    </li>
@endsection

@section('content')

<section id="home" class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
    <div class="container text-center">
        <h1 class="display-4">Beauty Sys</h1>
        <p class="lead">Aumente sua produtividade e a satisfação de seus clientes!</p>
        <a href="{{ route('PaginaInicialProfissional') }}" class="btn btn-custom btn-lg mt-4">Sou um profissional</a>
        <a href="{{ route('PaginaInicialPj') }}" class="btn btn-custom2 btn-lg mt-4">Proprietário</a>
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

@endsection
