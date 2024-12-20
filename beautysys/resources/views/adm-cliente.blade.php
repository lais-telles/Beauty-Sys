@extends('template-cliente')

@section('title', 'Adm Cliente')

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded" style="margin-top: 15rem;">
    <div class="container my-5">
        <div class="row align-items-center">
            <!-- Coluna da imagem de perfil à esquerda -->
            <div class="col-md-3 d-flex flex-column align-items-center">
                <!-- imagem temporária -->
                <img class="img-fluid rounded-circle mb-3" src="{{ asset('/images/salao-logo-1.jpg') }}">
                <figcaption class="mb-3">{{$nome}}</figcaption>
            </div>
            
            <!-- Coluna dos cards centralizados -->
            <div class="col-md-9">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">  
                        <a href="{{ route('visAgdCliente') }}" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Agendamentos</h5>
                                    <p class="card-text">Consulte os agendamentos realizados por você.</p>
                                </div>
                            </div>
                        </a>                      
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('infoCadastroCli') }}" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Segurança</h5>
                                    <p class="card-text">Gerencie sua senha, e-mail e número de celular.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Card para implementação futura -->
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pedidos</h5>
                                <p class="card-text">Consulte os pedidos feitos por você.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection