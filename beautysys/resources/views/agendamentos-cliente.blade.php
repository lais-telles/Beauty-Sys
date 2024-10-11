@extends('template-cliente')

@section('title','Agendamentos')

@section('content')
<section class="d-flex flex-column" style="margin:10rem">
    <div class="mt-5">
        <h2>Agendamentos</h2>
            <table class="table table-bordered text-center">
                @if(!empty($agendamentos))
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Profissional</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Horário de Início</th>
                        <th>Horário de Término</th>
                        <th>Valor Total</th>
                        <th>Forma de Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td>{{ $agendamento->id_agendamento }}</td>
                            <td>{{ $agendamento->profissional }}</td>
                            <td>{{ $agendamento->servico }}</td>
                            <td>{{ $agendamento->data_realizacao }}</td>
                            <td>{{ $agendamento->horario_inicio }}</td>
                            <td>{{ $agendamento->horario_termino }}</td>
                            <td>{{ $agendamento->valor_total }}</td>
                            <td>{{ $agendamento->forma_pagamento }}</td>
                        </tr>
                    @endforeach   
                @else
                    <tr>
                        <td colspan="4" class="text-center">Nenhum agendamento realizado.</td>
                    </tr>
                @endif 
                </tbody>
            </table>
    </div>
</section>
@endsection