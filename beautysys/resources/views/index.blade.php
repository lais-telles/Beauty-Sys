@extends('template')

@section('title', 'BeautySys')

@section('body-class', '')

@section('nav-buttons')
    <li class="nav-item">
        <a href="{{ route('PessoaFisica') }}" class="btn btn-custom ms-4">Pessoa física</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('Parceiro') }}" class="btn btn-custom2 ms-4">Parceiro</a>
    </li>
@endsection

@section('content')
<section>
    <video id="video_apresentacao" autoplay muted loop>
        <source src="{{ asset('videos/video-apresentacao.mp4') }}">
        Your browser does not support the video tag.
    </video>
</section>

<section id="caracteristicas" class="bg-white pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img class="img-fluid" src="{{ asset('images/profissional-1.jpg') }}">
            </div>
            <div class="col-sm-6">
                <h1>Beauty Sys</h1>
                <h2>BELEZA PLANEJADA: SERVIÇOS À SUA MEDIDA!</h2>
                <p>Organize seu salão de beleza como nunca antes! Nosso sistema de agendamentos te ajuda a controlar a agenda dos seus profissionais, enviar lembretes aos clientes e acompanhar o histórico de serviços. Mais organização, menos erros e mais tempo para cuidar do seu negócio.</p>

                <h2>Personalização</h2>
                <p>Adapte o sistema às suas necessidades e à identidade do seu salão.</p>

                <div class="b-example-divider mt-3 mb-3"></div>

                <h2>Flexibilidade</h2>
                <p>Ofereça diversas opções de serviços e horários para atender a todos os clientes.</p>

                <div class="b-example-divider mt-3 mb-3"></div>

                <h2>Controle total</h2>
                <p>Tenha o controle completo da sua agenda e dos seus profissionais.</p>

                <div class="d-flex justify-content-center">
                    <a href="" class="btn btn-custom3 ms-4 btn-lg mt-5">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="funcoes">
    
</section>
@endsection
