@extends('template')

@section('title', 'BeautySys')

@section('body-class', '')

@section('nav-buttons')
<ul class="nav d-flex flex-wrap justify-content-start">
    <li class="nav-item">
        <a href="{{ route('PessoaFisica') }}" class="btn btn-custom ms-4">Cliente</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('Parceiro') }}" class="btn btn-custom2 ms-2">Profissional/Estabelecimento</a>
    </li>
</ul>
@endsection

@section('content')
<section style="margin-top: 10rem;">
    @if (session('alert') || session('success') || session('error'))
        <!-- Modal Trigger -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
            });
        </script>

        <!-- Modal -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="alertModalLabel">Aviso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center 
                        @if(session('alert')) alert alert-warning 
                        @elseif(session('success')) alert alert-success 
                        @elseif(session('error')) alert alert-danger 
                        @endif">
                        {{ session('alert') ?? session('success') ?? session('error') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="video-container">
        <video id="video_apresentacao" autoplay muted loop>
            <source src="{{ asset('videos/apresentacao.mp4') }}">
            Your browser does not support the video tag.
        </video>
    </div>
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
                    <a href="{{ route('Parceiro') }}" class="btn btn-custom3 ms-4 btn-lg mt-5">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="funcoes">
    
</section>
@endsection
