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
                        <p><a class="btn btn-lg btn-primary" href="{{ route('listaEstab') }}">Ver estabelecimentos</a></p>
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
                        <p><a class="btn btn-lg btn-primary" href="{{ route('listaProfissionais') }}">Ver profissionais</a></p>
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
        @if($estabPopulares)
            @foreach($estabPopulares as $estab)
                <div class="col-md-4">
                    <form action="{{ route('dadosRealizarAgendamento') }}" method="GET">
                    @csrf
                        <input type="hidden" name="estabelecimento" value="{{ $estab->id }}">
                        <div class="card" onclick="this.closest('form').submit()" style="cursor: pointer;">
                            <img class="card-img-top" src="{{ asset('imagem_perfil/' . $estab->imagem) }}" alt="Imagem do Estabelecimento">
                            <div class="card-body text-center">
                                <p class="card-text">{{ $estab->nome_fantasia }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        @endif
        </div>

        <div class="b-example-divider"></div>
        <h1 class="fw-bold text-start mb-3">Os profissionais mais populares</h1>
        <div class="row align-self-center align-items-center pb-5 mb-5">
            @if($profPopulares)
                @foreach($profPopulares as $prof)
                    <div class="col-md-4">
                        <form action="{{ route('dadosRealizarAgendamento') }}" method="GET">
                        @csrf
                        <input type="hidden" name="profissional" value="{{ $prof->id }}">
                        <input type="hidden" name="estabelecimento" value="{{ $prof->estabel_vinculado }}">
                            <div class="card" onclick="this.closest('form').submit()" style="cursor: pointer;">
                                <img class="card-img-top" src="{{ asset('imagem_perfil/' . $prof->imagem) }}" alt="Imagem do Estabelecimento">
                                <div class="card-body text-center">
                                    <p class="card-text">{{ $prof->nome }}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
</section>

<section class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-5">
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

