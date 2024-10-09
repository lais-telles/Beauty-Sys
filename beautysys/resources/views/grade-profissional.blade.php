@extends('template2')

@section('title', 'Grade Horaria')


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
            <li><a class="dropdown-item" href="">Dashboard</a></li>
            <li>
                <form action="{{ route('logoutProfissional') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Log out</button>
                </form>
            </li>
        </ul>
    </li>
</ul>
@endsection

@section('content')
<section class="d-flex" style="margin-top: 13rem; margin-bottom: 10rem;">
    <div class="container">
        <h1>Grade Horária Atual</h1>

        <div class="col-md-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Dia da Semana</th>
                    <th>Início Expediente</th>
                    <th>Fim Expediente</th>
                </tr>
            </thead>
            <tbody>
                @if(count($horarios) > 0)
                    @foreach($horarios as $horario)
                        <tr>
                            <td>
                                @if($horario->dia_semana == '1')
                                    Segunda-feira
                                @elseif($horario->dia_semana == '2')
                                    Terça-feira
                                @elseif($horario->dia_semana == '3')
                                    Quarta-feira
                                @elseif($horario->dia_semana == '4')
                                    Quinta-feira
                                @elseif($horario->dia_semana == '5')
                                    Sexta-feira
                                @elseif($horario->dia_semana == '6')
                                    Sábado
                                @elseif($horario->dia_semana == '7')
                                    Domingo
                                @endif
                            </td>
                            <td>{{ $horario->hora_inicio }}</td>
                            <td>{{ $horario->hora_termino }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">Nenhuma grade cadastrada para este profissional.</td>
                    </tr>
                @endif
            </tbody>
        </table>

            <a href="" class="btn btn-custom mt-3">Editar grade</a>
        </div>
    </div>
</section>
@endsection
