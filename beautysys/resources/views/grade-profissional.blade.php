@extends('template-profissional')

@section('title', 'Grade Horaria')

@section('content')
<section class="d-flex" style="margin-top: 11rem; margin-bottom: 10rem;">
<div class="container mt-4">
    <h2 class="mb-3">Cadastro de Grade Horária</h2>

    <!-- Formulário de Cadastro/Edicão -->
    <form id="form-grade-horario" action="{{ route('salvarGrade') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <label for="dia_semana">Dia da Semana:</label>
                <select id="dia_semana" name="dia_semana" class="form-select" required>
                    <option value="">Escolha o dia da semana</option>
                    <option value="1">Segunda-feira</option>
                    <option value="2">Terça-feira</option>
                    <option value="3">Quarta-feira</option>
                    <option value="4">Quinta-feira</option>
                    <option value="5">Sexta-feira</option>
                    <option value="6">Sábado</option>
                    <option value="7">Domingo</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="hora_inicio">Hora de Início:</label>
                <select id="hora_inicio" name="hora_inicio" class="form-select" required>
                    <option value="">Escolha o horário</option>
                    @foreach($select_horario as $horario)
                        <option value="{{ $horario }}">{{ $horario }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="hora_termino">Hora de Término:</label>
                <select id="hora_termino" name="hora_termino" class="form-select" required>
                    <option value="">Escolha o horário</option>
                    @foreach($select_horario as $horario)
                        <option value="{{ $horario }}">{{ $horario }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Salvar</button>   
            </div>
        </div>
    </form>
    @if (session('success'))
        <div class="mt-2 alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mt-2 alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabela de Horários Cadastrados -->
    <div class="mt-5">
        <h3>Horários Cadastrados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Dia da Semana</th>
                    <th>Início Expediente</th>
                    <th>Fim Expediente</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @if(count($horarios) > 0)
                    @foreach($horarios as $horario)
                        <tr>
                            <td>
                                @if($horario->dia_semana == '1')
                                    Segunda-feira
                                @elseif($horario->dia_semana == '2')
                                    Terça-feira
                                @elseif($horario->dia_semana == '3')
                                    Quarta-feira
                                @elseif($horario->dia_semana == '4')
                                    Quinta-feira
                                @elseif($horario->dia_semana == '5')
                                    Sexta-feira
                                @elseif($horario->dia_semana == '6')
                                    Sábado
                                @elseif($horario->dia_semana == '7')
                                    Domingo
                                @endif
                            </td>
                            <td>{{ $horario->hora_inicio }}</td>
                            <td>{{ $horario->hora_termino }}</td>
                            <td>
                                <form id="delete-form" action="{{ route('deletarHorario', $horario->id_grade) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Nenhuma grade cadastrada para este profissional.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este serviço?
                </div>
                <div class="modal-footer">
                    <!-- Botão Cancelar com foco -->
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- Formulário que será submetido ao clicar no botão Excluir -->
                    <form id="delete-form" action="{{ route('deletarHorario', $horario->id_grade) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


<script>
    // Garantir que o foco inicial seja no botão Cancelar ao abrir o modal
    $('#confirmModal').on('shown.bs.modal', function () {
        $(this).find('button[data-bs-dismiss="modal"]').focus();  // Foco no botão de Cancelar
    });
</script>