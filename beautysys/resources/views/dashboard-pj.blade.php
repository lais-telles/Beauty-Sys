@extends('template-estab')

@section('title', 'Proprietário')

@section('content')
<section  class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
    <div class="container mt-4">
    <div class="row">
            <!-- Card Profissionais -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #73005B;">
                    <div class="card-body">
                        <h5 class="card-title">Profissionais</h5>
                        <p class="card-text">Número total: {{ $data['total_profissionais'] }}</p>
                    </div>
                </div>
            </div>
            <!-- Card Serviços -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #AD305A;">
                    <div class="card-body">
                        <h5 class="card-title">Serviços</h5>
                        <p class="card-text">Número total: {{ $data['total_servicos'] }}</p>
                    </div>
                </div>
            </div>
            <!-- Card Clientes -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #1E0056;">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <p class="card-text">Número total: {{ $data['total_clientes'] }}</p>
                    </div>
                </div>
            </div>
            <!-- Card Agendamentos -->
            <div class="col-md-3">
                <div class="card text-white mb-3" style="background-color: #D7685A;">
                    <div class="card-body">
                        <h5 class="card-title">Agendamentos</h5>
                        <p class="card-text">Número total: {{ $data['total_agendamentos'] }}</p>
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
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script
<canvas id="agendamentosChart" width="400" height="200"></canvas>

<script>
    // Extraindo os dados do array agendamentos_por_mes
    var meses = @json($data['agendamentos_por_mes']);
    
    // Array de nomes dos meses
    var nomeMeses = [
        "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", 
        "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
    ];
    
    // Prepare os labels e os dados para o gráfico
    var labels = meses.map(function(item) {
        return nomeMeses[item.mes - 1]; // Subtrai 1 para ajustar ao índice do array
    });

    var agendamentosData = meses.map(function(item) {
        return item.total_agendamentos; // Assume que "total_agendamentos" é o campo com a contagem
    });

    var ctx = document.getElementById('agendamentosChart').getContext('2d');
    var agendamentosChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Agendamentos',
                data: agendamentosData,
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

    // Coleta os dados dos serviços populares da variável 'data'
    var servicosPopulares = @json($data['servicos_populares']);
    
    // Mapeia os nomes dos serviços e os totais de agendamentos
    var labels = servicosPopulares.map(servico => servico.serviço);
    var dataValues = servicosPopulares.map(servico => servico.total_agendamentos);

    var ctx2 = document.getElementById('servicosChart').getContext('2d');
    var servicosChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labels, // Usa os nomes dos serviços coletados
            datasets: [{
                label: 'Número de Serviços',
                data: dataValues, // Usa os totais de agendamentos coletados
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
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    color: '#000',
                    formatter: (value) => {
                        return value; // Exibe o valor
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    
    });

</script>
@endsection
