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
<div class="container mt-4">
    <h2 class="mb-3">Cadastro de Grade Horária</h2>

    <!-- Formulário de Cadastro/Edicão -->
    <form id="form-grade-horario" action="{{ route('salvarGrade') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <label for="dia_semana">Dia da Semana:</label>
                <select id="dia_semana" name="dia_semana" class="form-select" required>
                    <option value="1">Segunda-feira</option>
                    <option value="2">Terça-feira</option>
                    <option value="3">Quarta-feira</option>
                    <option value="4">Quinta-feira</option>
                    <option value="5">Sexta-feira</option>
                    <option value="6">Sábado</option>
                    <option value="7">Domingo</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="hora_inicio">Hora de Início:</label>
                <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" step="1" required>
            </div>
            <div class="col-md-3">
                <label for="hora_termino">Hora de Término:</label>
                <input type="time" id="hora_termino" name="hora_termino" class="form-control" step="1" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Salvar</button>   
            </div>
        </div>
    </form>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mt-2 alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabela de Horários Cadastrados -->
    <div class="mt-5">
        <h3>Horários Cadastrados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Dia da Semana</th>
                    <th>Início Expediente</th>
                    <th>Fim Expediente</th>
                    <th>Ações</th>
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
                            <td>
                                <form action="{{ route('deletarHorario', $horario->id_grade) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este horário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Nenhuma grade cadastrada para este profissional.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

</section>
@endsection
