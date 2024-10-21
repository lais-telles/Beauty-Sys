@extends('template-cliente')

@section('title', 'Estabelecimentos disponíveis')

@section('content')
<section class="mx-5" style="margin-top: 15rem;">
    <h1 class="ms-5">Estabelecimentos Disponíveis</h1>

    @if(empty($estabelecimentos))
        <p>Nenhum estabelecimento disponível no momento.</p>
    @else
        <div class="row justify-content-between mx-5">
            @foreach($estabelecimentos as $e)
                <div class="col-md-4 mb-4">
                    <form action="{{ route('dadosRealizarAgendamento') }}" method="GET">
                        @csrf
                        <input type="hidden" name="estabelecimento" value="{{ $e->id_estabelecimento }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $e->nome_fantasia }}</h5>
                                <p class="card-text">
                                    Telefone: {{ $e->telefone }}<br>
                                    Email: {{ $e->email }}<br>
                                    Endereço: {{ $e->logradouro }}, {{ $e->numero }}, {{ $e->bairro }} - {{ $e->cidade }} - {{ $e->estado }}
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
