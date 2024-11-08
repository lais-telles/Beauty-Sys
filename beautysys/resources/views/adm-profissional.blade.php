@extends('template-profissional')

@section('title', 'Adm Profissional')

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded" style="margin-top: 15rem;">
    <div class="container my-5">
        <div class="row align-items-center">
            <!-- Exibição da foto de perfil ou imagem padrão -->
            @if (auth()->user()->imagem_perfil)
                <!-- Coluna da imagem de perfil à esquerda -->
                <div class="col-md-3 d-flex flex-column align-items-center">
                    <img src="{{ asset('imagem_perfil/' . auth()->user()->imagem_perfil) }}" alt="Foto de perfil" class="img-perfil mb-3">    
                    @if(!empty(auth()->user()->nome))
                        <figcaption class="mb-3">{{ auth()->user()->nome }}</figcaption>
                    @else
                        <figcaption class="mb-3">Olá</figcaption>
                    @endif
                </div>    
            @else
                <!-- Coluna da imagem de perfil à esquerda -->
                <div class="col-md-3 d-flex flex-column align-items-center">
                    <img src="{{ asset('imagem_perfil/sem_foto.png') }}" alt="Foto de perfil padrão" class="img-perfil mb-3">              
                    @if(!empty(auth()->user()->nome))
                        <figcaption class="mb-3">{{ auth()->user()->nome }}</figcaption>
                    @else
                        <figcaption class="mb-3">Olá</figcaption>
                    @endif
                </div>    
            @endif
            
            <!-- Coluna dos cards centralizados -->
            <div class="col-md-9">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('exibirAgendamentosProf') }}" class="text-decoration-none" >
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Agendamentos</h5>
                                    <p class="card-text">Gerencie os agendamentos realizados por você.</p>
                                </div>
                            </div>
                        </a>                      
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('infoCadastroP') }}" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Segurança</h5>
                                    <p class="card-text">Gerencie sua senha, e-mail, CPF e número de celular.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Monitoramento</h5>
                                <p class="card-text">Realize consultas para visualizar detalhes dos agendamentos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection