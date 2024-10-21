@extends('template-cliente')

@section('title', 'Profissionais disponíveis')

@section('content')
<section class="mx-5" style="margin-top: 15rem;">
    <h1 class="ms-5">Profissionais Disponíveis</h1>

    @if(empty($profissionais))
        <p>Nenhum profissional disponível no momento.</p>
    @else
        <div class="row justify-content-between mx-5">
            @foreach($profissionais as $profissional)
                <div class="col-md-4 mb-4">
                    <form action="{{ route('dadosRealizarAgendamento') }}" method="GET">
                        @csrf
                        <!-- Corrigi o nome do campo para "profissional" -->
                        <input type="hidden" name="profissional" value="{{ $profissional->id_profissional }}">
                        <input type="hidden" name="estabelecimento" value="{{ $profissional->estabel_vinculado }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $profissional->nome }}</h5>
                                <p class="card-text">
                                    Telefone: {{ $profissional->telefone }}<br>
                                    Email: {{ $profissional->email }}<br>
                                    Estabelecimento: {{ $profissional->nome_fantasia }}
                                </p>
                                <button type="submit" class="btn btn-primary">Agendar</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
