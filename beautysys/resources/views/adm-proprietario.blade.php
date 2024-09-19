@extends('template2')

@section('title', 'Adm Proprietário')

@section('nav-buttons')
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="">Serviços</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">Profissionais</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">Ajuda</a>
        </li>
    </ul>
@endsection

@section('nav-buttons2')
<ul class="navbar-nav ms-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i id="minhaConta" class='fas fa-user-alt' style="color: white;"></i></a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="">Minha conta</a></li>
            <li><a class="dropdown-item" href="">Meus agendamentos</a></li>
            <li><a class="dropdown-item" href="{{ route('DashboardPj') }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="">Log out</a></li>
        </ul>
    </li>
</ul>
@endsection

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded" style="margin-top: 15rem;">
    <div class="container my-5">
        <div class="row align-items-center">
            <!-- Coluna da imagem de perfil à esquerda -->
            <div class="col-md-3 d-flex flex-column align-items-center">
                <img class="img-fluid rounded-circle mb-3" src="{{ asset('/images/salao-logo-1.jpg') }}">
                <figcaption class="mb-3">Espaço Bellas</figcaption>
                <button class="btn btn-custom px-5 mb-5" type="button">Editar informações</button>
            </div>
            
            <!-- Coluna dos cards centralizados -->
            <div class="col-md-9">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Agendamentos</h5>
                                <p class="card-text">Gerencie os agendamentos realizados no seu estabelecimento.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Segurança</h5>
                                <p class="card-text">Gerencie sua senha, e-mail, CPF e número de celular.</p>
                            </div>
                        </div>
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
