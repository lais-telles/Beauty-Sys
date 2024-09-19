@extends('template2')

@section('title', 'Proprietário')

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
            <li><a class="dropdown-item" href="">Log out</a></li>
        </ul>
    </li>
</ul>
@endsection

@section('content')
<section  class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
    <div class="container mt-4">
        <div class="row">
            <!-- Card Profissionais -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #73005B;">
                    <div class="card-body">
                        <h5 class="card-title">Profissionais</h5>
                        <p class="card-text">Número total: 10</p>
                    </div>
                </div>
            </div>
            <!-- Card Serviços -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #AD305A;">
                    <div class="card-body">
                        <h5 class="card-title">Serviços</h5>
                        <p class="card-text">Número total: 25</p>
                    </div>
                </div>
            </div>
            <!-- Card Clientes -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #1E0056">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <p class="card-text">Número total: 50</p>
                    </div>
                </div>
            </div>
            <!-- Card Agendamentos -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #D7685A;">
                    <div class="card-body">
                        <h5 class="card-title">Agendamentos</h5>
                        <p class="card-text">Número total: 80</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico e estatísticas -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Estatísticas de Agendamentos
                    </div>
                    <div class="card-body">
                        <canvas id="agendamentosChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Estatísticas de Serviços
                    </div>
                    <div class="card-body">
                        <canvas id="servicosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('agendamentosChart').getContext('2d');
    var agendamentosChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
            datasets: [{
                label: 'Agendamentos',
                data: [10, 20, 30, 40, 50, 60],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx2 = document.getElementById('servicosChart').getContext('2d');
    var servicosChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Corte', 'Coloração', 'Manicure', 'Pedicure', 'Massagem', 'Maquiagem'],
            datasets: [{
                label: 'Número de Serviços',
                data: [15, 20, 10, 5, 8, 12],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
