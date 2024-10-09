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
<!--<div class="container">
    <div class="form-section">
        <h2>Cadastrar Grade Horária</h2>
        <form>
            <label for="profissional">Profissional:</label>
            <input type="text" id="profissional" name="profissional" placeholder="Nome do profissional" required>

            <label for="dia">Dia da Semana:</label>
            <select id="dia" name="dia" required>
                <option value="segunda">Segunda-feira</option>
                <option value="terca">Terça-feira</option>
                <option value="quarta">Quarta-feira</option>
                <option value="quinta">Quinta-feira</option>
                <option value="sexta">Sexta-feira</option>
                <option value="sabado">Sábado</option>
                <option value="domingo">Domingo</option>
            </select>

            <label for="horario">Horário:</label>
            <input type="time" id="horario" name="horario" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <div class="schedule-section">
        <h2>Grade Cadastrada</h2>
        <ul class="schedule-list">
            <li class="schedule-item">
                <span>Segunda-feira, 08:00 - 12:00</span>
                <button class="edit-button">Editar</button>
            </li>
        </ul>
    </div>
</div>-->
@endsection
