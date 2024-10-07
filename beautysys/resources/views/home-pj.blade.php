@extends('template2')

@section('title', 'Proprietário')

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
            <li><a class="dropdown-item" href="{{ route('AdmProprietario') }}">Minha conta</a></li>
            <li><a class="dropdown-item" href="">Meus agendamentos</a></li>
            <li><a class="dropdown-item" href="{{ route('DashboardPj') }}">Dashboard</a></li>
            <li>
                <form action="{{ route('logoutEstab') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Log out</button>
                </form>
            </li>
        </ul>
    </li>
</ul>
@endsection

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded align-items-center" style="margin-top: 15rem;">
    <div class="container my-5">
        <div class="position-relative p-5 text-center text-muted border border-dashed rounded-5" style="background-color: #FAECE3;">
            <img class="" src="{{ asset('/images/salao-logo-1.jpg') }}">
            <h1 class="text-body-emphasis">Espaço Bellas</h1>
            <p class="col-lg-6 mx-auto mb-4">
                Um ambiente acolhedor e profissional para cuidar da sua auto-estima!
            </p>
            <button class="btn btn-custom px-5 mb-5" type="button">
                Gestão comercial
            </button>
        </div>
    </div>
</section>

<section class="py-5 mt-5">
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

