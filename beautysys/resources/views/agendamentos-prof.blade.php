@extends('template-profissional')

@section('title', 'Agendamentos')

@section('content')
<section class="d-flex flex-column" style="margin:10rem">
    <div class="mt-5">
        <h2>Agendamentos</h2>

        @if(!empty($agendamentos))
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Horário de Início</th>
                        <th>Horário de Término</th>
                        <th>Valor Total</th>
                        <th>Forma de Pagamento</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td>{{ $agendamento->id_agendamento }}</td>
                            <td>{{ $agendamento->nome_cliente }}</td>
                            <td>{{ $agendamento->servico }}</td>
                            <td>{{ $agendamento->data_realizacao }}</td>
                            <td>{{ $agendamento->horario_inicio }}</td>
                            <td>{{ $agendamento->horario_termino }}</td>
                            <td>{{ $agendamento->valor_total }}</td>
                            <td>{{ $agendamento->formas_pagamento }}</td>
                            <td>{{ $agendamento->status }}</td>
                            <td>
                                <button class="btn btn-primary" id="button-{{ $agendamento->id_agendamento }}" onclick="toggleSelect({{ $agendamento->id_agendamento }})">
                                    Alterar Status
                                </button>
                                <form action="{{ route('agendamentosStatus') }}" method="POST" id="form-status-{{ $agendamento->id_agendamento }}" style="display:none; margin-top: 10px;">
                                    @csrf
                                    <input type="hidden" name="id_agendamento" value="{{ $agendamento->id_agendamento }}">
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        @foreach($statusAgendamentos as $status)
                                            <option value="{{ $status->descricao }}" {{ $agendamento->status == $status->descricao ? 'selected' : '' }}>
                                                {{ $status->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>

                            </td>
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
</section>

<script>
    function toggleSelect(id) {
        var form = document.getElementById('form-status-' + id);
        var button = document.getElementById('button-' + id);
        
        if (form.style.display === 'none') {
            form.style.display = 'block';
            button.style.display = 'none'; // Oculta o botão
        } else {
            form.style.display = 'none';
            button.style.display = 'inline-block'; // Exibe o botão novamente
        }
    }
</script>
@endsection
