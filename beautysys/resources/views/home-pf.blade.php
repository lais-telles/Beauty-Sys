@extends('template2')

@section('title', 'Home')

@section('nav-buttons')
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="">Estabelecimentos</a>
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
            <li><a class="dropdown-item" href="">Meus pedidos</a></li>
            <li><a class="dropdown-item" href="">Endereços</a></li>
            <li><a class="dropdown-item" href="">Log out</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="carrinho.php"><i id="carrinho" class="fas fa-cart-plus" style="color: white;"></i></a>
    </li>
</ul>
@endsection

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded align-items-center" style="margin-top: 15rem;">
    <div class="container">
    <h1 class="fw-bold text-start mb-3">Os salões mais populares</h1>
        <div class="row align-self-center align-items-center pb-5 mb-5">
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('/images/salao-logo-1.jpg') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('/images/salao-logo-2.jpg') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('/images/salao-logo-3.jpg') }}">
                </div>
            </div>
        </div>

        <div class="b-example-divider"></div>

        <div class="row align-self-center align-items-center pb-5 mt-5">
            <h1 class="fw-bold text-start mb-3">Os profissionais mais populares</h1>
            
            <div class="col-md-4">
                <div class="card position-relative">
                    <img class="card-img-top" src="{{ asset('/images/prof-popular-1.jpg') }}" alt="Profissional 1">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h5 class="card-title text-white fw-bold">JOHN MEMPHIS</h5>
                        <p class="card-text text-white">John é conhecido por sua tradicionalidade e simplicidade, 
                            tornando ainda mais surpreendente os seus resultados que, por mais simples que sejam,
                            sempre aparentam o mais alto grau de sofisticidade e elegância.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card position-relative">
                    <img class="card-img-top" src="{{ asset('/images/prof-popular-2.jpg') }}" alt="Profissional 2">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h5 class="card-title text-white fw-bold">JULIANA SILVA</h5>
                        <p class="card-text text-white">Juliana é conhecida por sua abordagem disruptiva, além 
                            de ampla presença em filmes de ficção científica, uma vez que uma de suas marcas é 
                            o visual futurístico e chocante.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card position-relative">
                    <img class="card-img-top" src="{{ asset('/images/prof-popular-3.jpg') }}" alt="Profissional 3">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h5 class="card-title text-white fw-bold">LAURA BAILEY</h5>
                        <p class="card-text text-white">Laura é uma profissional amplamente conhecida por sua presença 
                            assídua nos mais renomados festivais, desfiles de moda e filmes do mundo. Reconhecida por 
                            sua elegância e prêmios, Bailey se destaca no mundo da beleza como uma das melhores.
                        </p>
                    </div>
                </div>
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

