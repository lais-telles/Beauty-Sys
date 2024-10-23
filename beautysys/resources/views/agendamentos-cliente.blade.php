@extends('template-cliente')

@section('title','Agendamentos')

@section('content')
<section class="d-flex flex-column container" style="margin-top: 10rem;">
    <div class="container mt-5">
        <h2>Agendamentos</h2>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                @if(!empty($agendamentos))
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="d-none d-md-table-cell">Profissional</th> <!-- Oculto em telas menores que 'md' -->
                        <th>Serviço</th>
                        <th>Data</th>
                        <th class="d-none d-sm-table-cell">Horário de Início</th> <!-- Oculto em telas menores que 'sm' -->
                        <th class="d-none d-sm-table-cell">Horário de Término</th> <!-- Oculto em telas menores que 'sm' -->
                        <th class="d-none d-lg-table-cell">Valor Total</th> <!-- Oculto em telas menores que 'lg' -->
                        <th class="d-none d-lg-table-cell">Forma de Pagamento</th> <!-- Oculto em telas menores que 'lg' -->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td>{{ $agendamento->id_agendamento }}</td>
                            <td class="d-none d-md-table-cell">{{ $agendamento->profissional }}</td>
                            <td>{{ $agendamento->servico }}</td>
                            <td>{{ $agendamento->data_realizacao }}</td>
                            <td class="d-none d-sm-table-cell">{{ $agendamento->horario_inicio }}</td>
                            <td class="d-none d-sm-table-cell">{{ $agendamento->horario_termino }}</td>
                            <td class="d-none d-lg-table-cell">{{ $agendamento->valor_total }}</td>
                            <td class="d-none d-lg-table-cell">{{ $agendamento->forma_pagamento }}</td>
                            <td>{{ $agendamento->status }}</td>
                        </tr>
                    @endforeach   
                @else
                    <tr>
                        <td colspan="9" class="text-center">Nenhum agendamento realizado.</td>
                    </tr>
                @endif 
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
