@extends('template2')

@section('title', 'Adm Proprietário')

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
            <li><a class="dropdown-item" href="{{ route('DashboardPj') }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="">Log out</a></li>
        </ul>
    </li>
</ul>
@endsection


@section('content')
<section class="d-flex ms-5 me-5 mb-5" style="margin-top: 15rem;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <img class="img-fluid" src="{{ asset ('/images/salao-logo-2.jpg') }}" style="width: 500px;">
            </div>
            <div class="col-md-6">
                <form id="formAgendamento">
                    <!-- Seleção do Serviço -->
                    <div class="mb-3">
                        <label for="servico" class="form-label">Escolha o Estabelecimento</label>
                        <select class="form-select" id="servico" required>
                        <option value="" disabled selected>Selecione um estabelecimento</option>
                        <option value="Corte de cabelo">Estabelecimento 1</option>
                        <option value="Manicure">Estabelecimento 2</option>
                        <option value="Pedicure">Estabelecimento 3</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="servico" class="form-label">Escolha o Serviço</label>
                        <select class="form-select" id="servico" required>
                        <option value="" disabled selected>Selecione um serviço</option>
                        <option value="Corte de cabelo">Corte de cabelo</option>
                        <option value="Manicure">Manicure</option>
                        <option value="Pedicure">Pedicure</option>
                        <option value="Coloração">Coloração</option>
                        </select>
                    </div>

                    <!-- Seleção da Data -->
                    <div class="mb-3">
                        <label for="data" class="form-label">Escolha o Dia</label>
                        <input type="date" class="form-control" id="data" required>
                    </div>

                    <!-- Seleção do Horário -->
                    <div class="mb-3">
                        <label for="horario" class="form-label">Escolha o Horário</label>
                        <select class="form-select" id="horario" required>
                            <option value="" disabled selected>Selecione um horário</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                        </select>
                    </div>
                <!-- Botão para Finalizar -->
                <button type="submit" class="btn btn-custom w-100">Finalizar Agendamento</button>
                </form>
            </div>
        </div>
</section>
@endsection
    

<script>
    document.getElementById('formAgendamento').addEventListener('submit', function(event) {
        event.preventDefault();

        // Captura os valores selecionados
        const servico = document.getElementById('servico').value;
        const data = document.getElementById('data').value;
        const horario = document.getElementById('horario').value;

        // Simula envio dos dados
        if(servico && data && horario) {
            alert(`Agendamento confirmado!\nServiço: ${servico}\nDia: ${data}\nHorário: ${horario}`);
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });
</script>

</body>
</html>
