@extends('template-estab')

@section('title', 'Proprietário')

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded align-items-center" style="margin-top: 15rem;">
    <div class="container my-5">
        <div class="position-relative p-5 text-center text-muted border border-dashed rounded-5" style="background-color: #FAECE3;">
            <!-- Exibição da foto de perfil ou imagem padrão -->
            @if (auth()->user()->imagem_perfil)
                <img src="{{ asset('imagem_perfil/' . auth()->user()->imagem_perfil) }}" alt="Foto de perfil" class="img-perfil mb-3">    
                @if(!empty(auth()->user()->nome_fantasia))
                    <h1 class="text-body-emphasis">{{ auth()->user()->nome_fantasia }}</h1>
                @else
                    <h1 class="text-body-emphasis">Olá</h1>
                @endif
            @else
                <img src="{{ asset('imagem_perfil/sem_foto.png') }}" alt="Foto de perfil padrão" class="img-perfil mb-3">              
                @if(!empty(auth()->user()->nome_fantasia))
                    <h1 class="text-body-emphasis">{{ auth()->user()->nome_fantasia }}</h1>
                @else
                    <h1 class="text-body-emphasis">Olá</h1>
                @endif  
            @endif
            <p class="col-lg-6 mx-auto mb-4">
                Um ambiente acolhedor e profissional para cuidar da sua auto-estima!
            </p>
            <p><a class="btn btn-custom" href="{{ route('dashboardPj') }}">Gestão Comercial</a></p>
        </div>
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

