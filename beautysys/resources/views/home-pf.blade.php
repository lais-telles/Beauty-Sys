@extends('template-cliente')

@section('title', 'Home')

@section('content')
<section style="margin-top: 10rem;">
    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>Tudo em um lugar só.</h1>
                        <p class="opacity-75">Aqui você agenda seus serviços, tem acesso ao whatsapp do estabelecimento e 
                        pode visualizar o seu histórico de agendamentos.</p>
                        <p><a class="btn btn-lg btn-primary" href="{{ route ('dadosRealizarAgendamento') }}">Agende agora</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Conheça os estabelecimentos</h1>
                        <p>Conheça os estabelecimentos cadastrados e escolha aquele que melhor lhe atende!</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Ver estabelecimentos</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>
                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>Conheça os profissionais</h1>
                        <p>Assim como os estabelecimentos cadastrados, certificamos que os profissionais também sejam da mais alta qualidade e 
                            confiança.
                        </p>
                        <p><a class="btn btn-lg btn-primary" href="#">Ver profissionais</a></p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<section class="d-flex m-5 rounded align-items-center">
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

