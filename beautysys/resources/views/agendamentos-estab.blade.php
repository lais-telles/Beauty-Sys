@extends('template-estab')

@section('title','Agendamentos')

@section('content')
<section class="d-flex" style="margin-top: 10rem; margin-bottom: 10rem;">
    <div class="container mt-5">
        <div class="table-responsive">
            <h2>Agendamentos</h2>

            @if(!empty($agendamentos))
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Profissional</th>
                            <th>Serviço</th>
                            <th>Data</th>
                            <th class="d-none d-lg-table-cell">Horário de Início</th>
                            <th class="d-none d-lg-table-cell">Horário de Término</th>
                            <th>Valor Total</th>
                            <th class="d-none d-sm-table-cell">Forma de Pagamento</th>
                            <th class="d-none d-sm-table-cell">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendamentos as $agendamento)
                            <tr>
                                <td>{{ $agendamento->nome_cliente }}</td>
                                <td>{{ $agendamento->nome_profissional }}</td>
                                <td>{{ $agendamento->servico }}</td>
                                <td>{{ $agendamento->data_realizacao }}</td>
                                <td class="d-none d-lg-table-cell">{{ $agendamento->horario_inicio }}</td>
                                <td class="d-none d-lg-table-cell">{{ $agendamento->horario_termino }}</td>
                                <td>{{ $agendamento->valor_total }}</td>
                                <td class="d-none d-sm-table-cell">{{ $agendamento->forma_pagamento }}</td>
                                <td class="d-none d-sm-table-cell">{{ $agendamento->status }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">Nenhum agendamento realizado.</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
        </div>
    </div>
</section>
@endsection