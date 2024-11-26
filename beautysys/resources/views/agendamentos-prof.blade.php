@extends('template-profissional')

@section('title', 'Agendamentos')

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
                        <th>Serviço</th>
                        <th>Data</th>
                        <th class="d-none d-lg-table-cell">Horário de Início</th>
                        <th class="d-none d-lg-table-cell">Horário de Término</th>
                        <th>Valor Total</th>
                        <th class="d-none d-sm-table-cell">Forma de Pagamento</th>
                        <th class="d-none d-sm-table-cell">Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                    <tr>
                        <td>{{ $agendamento->nome_cliente }}</td>
                        <td>{{ $agendamento->servico }}</td>
                        <td>{{ $agendamento->data_realizacao }}</td>
                        <td class="d-none d-lg-table-cell">{{ $agendamento->horario_inicio }}</td>
                        <td class="d-none d-lg-table-cell">{{ $agendamento->horario_termino }}</td>
                        <td>{{ $agendamento->valor_total }}</td>
                        <td class="d-none d-sm-table-cell">{{ $agendamento->formas_pagamento }}</td>
                        <td class="d-none d-sm-table-cell">{{ $agendamento->status }}</td>
                        <td>
                            <button class="btn btn-primary" id="button-{{ $agendamento->id_agendamento }}" onclick="toggleSelect({{ $agendamento->id_agendamento }})">
                                Alterar Status
                            </button>
                                    <button class="btn btn-primary" id="button-edit-{{ $agendamento->id_agendamento }}" data-bs-toggle="modal" data-bs-target="#EditarAgendamento">
                                        Editar
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
                <!-- Exibir a mensagem de sucesso ou erro -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </div>
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

<div class="modal fade" id="editarAgendamento" tabindex="-1" aria-labelledby="editarAgendamento" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Edição de agendamento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 pt-0">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <select class="form-select rounded-3" id="floatingServico" name="servicos" required>
                                <option value="" selected disabled>Selecione o Serviço</option>
                                @foreach ($servicos as $servico)
                                    <option value="{{ $servico->id_servico }}">{{ $servico->nome }} - R$ {{ number_format($servico->valor, 2, ',', '.') }} ({{ $servico->duracao }})</option>
                                @endforeach
                            </select>
                            <label for="floatingServico">Serviço</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control rounded-3" id="floatingData" name="data">
                            <label for="floatingData">Data</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="time" class="form-control rounded-3" id="floatingInicio" name="hora_inicio">
                            <label for="floatingInicio">Horário início</label>
                        </div>

                        <div class="form-floating mb-3">
                        <select class="form-select rounded-3" id="floatingPag" name="pag">
                            <option value="" selected disabled>Selecione a Forma de Pagamento</option>
                                <option value="1">Pix</option>
                                <option value="2">Cartão de crédito</option>
                                <option value="3">Cartão de débito</option>
                        </select>
                            <label for="floatingPag">Pagamento</label>
                        </div>
                        
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>