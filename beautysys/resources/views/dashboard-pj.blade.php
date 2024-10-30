@extends('template-estab')

@section('title', 'Proprietário')

@section('content')
<section  class="d-flex" style="margin-top: 12rem; margin-bottom: 10rem;">
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
                        Serviços populares
                    </div>
                    <div class="card-body">
                        <canvas id="servicosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Profissionais populares
                    </div>
                    <div class="card-body">
                        <canvas id="profissionaisChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Horários de pico
                    </div>
                    <div class="card-body">
                        <canvas id="horariosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<canvas id="agendamentosChart" width="400" height="200"></canvas>

<script>
Chart.register(ChartDataLabels);

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
                backgroundColor: 'rgba(255, 99, 132)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                datalabels: {
                    anchor: 'end', // Alinha o valor no final do ponto
                    align: 'top', // Alinha o valor acima do ponto
                    color: '#000', // Cor do valor
                    formatter: (value) => {
                        return value; // Exibe o valor acima de cada ponto
                    }
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
                label: 'Número de agendamentos',
                data: dataValues, // Usa os totais de agendamentos coletados
                backgroundColor: [
                    'rgba(120, 255, 235)',
                    'rgba(75, 192, 192)',
                    'rgba(255, 206, 86)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 99, 132)'
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
                legend: {
                    display: false // Oculta a legenda "Número de Serviços"
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#000',
                    formatter: (value) => {
                        return value; // Exibe o valor
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: Math.max(...dataValues) * 2.0 // Aumenta o limite máximo para 20% acima do valor mais alto
                }
            }
        },
    
    });


    // Coleta os dados dos profissionais populares da variável 'data'
    var ProfissionaisPopulares = @json($data['profissionais_populares']);
    
    // Mapeia os nomes dos profissionais e os totais de agendamentos
    var labels = ProfissionaisPopulares.map(profissional => profissional.nome_profissional);
    var dataValues = ProfissionaisPopulares.map(profissional => profissional.total_agendamentos);


    var ctx2 = document.getElementById('profissionaisChart').getContext('2d');
    var profissionaisChart = new Chart(ctx2, {
        type: 'pie', // Mude o tipo para 'pie'
        data: {
            labels: labels, // Usa os nomes dos profissionais
            datasets: [{
                label: 'Número de agendamentos',
                data: dataValues, // Usa os totais de agendamentos coletados
                backgroundColor: [
                    'rgba(54, 162, 235)',
                    'rgba(75, 192, 192)',
                    'rgba(255, 206, 86)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 99, 132)'
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
                        return value; // Exibe o valor no centro da fatia
                    }
                }
            }
        }
    });


    // Coleta os dados dos horários de pico da variável 'data'
    var HorariosPico = @json($data['horarios_pico']);

    // Mapeia os horários e as quantidades
    var labels = HorariosPico.map(horario => horario.horario_inicio); // Corrigido
    var dataValues = HorariosPico.map(horario => horario.quantidade); // Corrigido

    var ctx2 = document.getElementById('horariosChart').getContext('2d');
    var horariosChart = new Chart(ctx2, {
        type: 'polarArea', // Mude para 'bar' ou 'line'
        data: {
            labels: labels,
            datasets: [{
                label: 'Número de agendamentos',
                data: dataValues,
                backgroundColor: [
                    'rgba(255, 99, 132)', // Rosa
                    'rgba(54, 162, 235)', // Azul
                    'rgba(75, 192, 192)', // Verde Água
                    'rgba(255, 206, 86)', // Amarelo
                    'rgba(153, 102, 255)', // Roxo
                    'rgba(255, 159, 64)'  // Laranja
                ],

                borderColor: [
                    'rgba(255, 0, 0)',   
                    'rgba(0, 0, 255)',   
                    'rgba(0, 255, 0)',   
                    'rgba(255, 255, 0)', 
                    'rgba(255, 0, 255)', 
                    'rgba(255, 150, 100)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    anchor: 'center',
                    align: 'top',
                    color: '#000',
                    formatter: (value) => {
                        return value; // Exibe o valor no centro da fatia
                    }
                }
            },
            scales: {
                y: {
                    display: false,
                    beginAtZero: true,
                    max: Math.max(...dataValues) * 1.2 // Aumenta o limite máximo para 20% acima do valor mais alto
                }
            }
        }
    });

</script>
@endsection
