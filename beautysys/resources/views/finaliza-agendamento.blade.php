@extends('template-cliente')

@section('title', 'Realizar agendamento')

@section('content')
<section class="d-flex ms-5 me-5 mb-5" style="margin-top: 13rem;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <img class="img-fluid" src="{{ asset('/images/beautysys-logo.png') }}" style="width: 500px;">
            </div>
            <div class="col-md-6">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                <form id="formAgendamento" action="{{ route('realizarAgendamento') }}" method="POST">
                    @csrf
                    <!-- Seleção do Estabelecimento -->
                    <div class="mb-3">
                        <label for="estabelecimento" class="form-label">Escolha o Estabelecimento</label>
                        <select class="form-select" id="estabelecimento" name="estabelecimento" required>
                            @if($id_estabelecimento)
                                <!-- Se um estabelecimento foi selecionado, exibe como padrão -->
                                <option value="{{ $id_estabelecimento }}" selected>
                                    {{ $estabelecimentos->where('id_estabelecimento', $id_estabelecimento)->first()->nome_fantasia }}
                                </option>
                            @else
                                <!-- Opção padrão quando não há seleção -->
                                <option value="" disabled {{ old('estabelecimento') ? '' : 'selected' }}>Selecione um estabelecimento</option>
                            @endif

                            @foreach($estabelecimentos as $estabelecimento)
                                <!-- Exibe as outras opções -->
                                @if($estabelecimento->id_estabelecimento != $id_estabelecimento) <!-- Evita duplicar a opção padrão -->
                                    <option value="{{ $estabelecimento->id_estabelecimento }}" 
                                        {{ old('estabelecimento') == $estabelecimento->id_estabelecimento ? 'selected' : '' }}>
                                        {{ $estabelecimento->nome_fantasia }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                    <!-- Seleção do Profissional -->
                    <div class="mb-3">
                        <label for="profissional" class="form-label">Escolha o Profissional</label>
                        <select class="form-select" id="profissional" name="profissional" required>
                            @if($id_profissional)
                                <!-- Se um estabelecimento foi selecionado, exibe como padrão -->
                                <option value="{{ $id_profissional }}" selected>
                                    {{ $profissional->where('id_profissional', $id_profissional)->first()->nome }}
                                </option>
                            @else
                                <!-- Opção padrão quando não há seleção -->
                                <option value="" disabled {{ old('profissional') ? '' : 'selected' }}>Selecione um profissional</option>
                            @endif

                            @foreach($profissional as $prof)
                                <!-- Exibe as outras opções -->
                                @if($prof->id_profissional != $id_profissional) <!-- Evita duplicar a opção padrão -->
                                    <option value="{{ $prof->id_profissional }}" 
                                        {{ old('prof') == $prof->id_profissional ? 'selected' : '' }}>
                                        {{ $prof->nome }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                    <!-- Seleção do Serviço -->
                    <div class="mb-3">
                        <label for="servico" class="form-label">Escolha o Serviço</label>
                        <select class="form-select" id="servico" name="servico" required>
                        <option value="" disabled {{ old('servico') ? '' : 'selected' }} required>Selecione um servico</option>
                             @if($servicos)
                                @foreach($servicos as $servico)
                                    <!-- Exibe as outras opções -->
                                    <option value="{{ $servico->id_servico }}" 
                                        {{ old('servico') == $servico->id_servico ? 'selected' : '' }}>
                                        {{ $servico->nome }}
                                    </option>
                                @endforeach
                            @else
                                <!-- Exibe a opção padrão -->
                                <option value="" disabled {{ old('profissional') ? '' : 'selected' }}>Selecione um serviço</option>
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="opcao_pag" class="form-label">Escolha a forma de pagamento</label>
                        <select class="form-select" id="opcao_pag" name="opcao_pag" required>
                            <option value="" disabled selected>Selecione uma forma de pagamento</option>
                            <option value="1">Pix</option>
                            <option value="2">Cartão de Crédito</option>
                            <option value="3">Cartão de débito</option>
                        </select>
                    </div>

                    <!-- Seleção da Data -->
                    <div class="mb-3">
                        <label for="data" class="form-label">Escolha o Dia</label>
                        <input type="date" class="form-control" id="data" name="data_realizacao" value="{{ old('data_realizacao') }}" required>
                    </div>

                    <!-- Seleção do Horário -->
                    <div class="mb-3">
                        <label for="horario_inicio" class="form-label">Escolha o Horário</label>
                        <select class="form-select" id="horario_inicio" name="horario_inicio" required>
                            <option value="" disabled {{ old('horario') ? '' : 'selected' }}>Selecione um horario</option>
                        </select>
                    </div>

                    <!-- Botão para Finalizar -->
                    <button type="submit" class="btn btn-custom w-100">Finalizar Agendamento</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Função para desativar selects
    function desativarSelects(ids) {
        ids.forEach(function(id) {
            $(id).empty().append('<option value="" disabled selected>Sem opções disponíveis</option>');
            $(id).prop('disabled', true);
        });
    }

    // Função para reativar um select
    function reativarSelect(id, defaultText) {
        $(id).empty().append('<option value="" disabled selected>' + defaultText + '</option>');
        $(id).prop('disabled', false);
    }

    // Evento de mudança do Estabelecimento
    $('#estabelecimento').change(function() {
        var idEstabelecimento = $(this).val();
        if (idEstabelecimento) {
            $.ajax({
                url: "{{ route('getProfissionais') }}", // Rota para obter profissionais
                type: "GET",
                data: { id: idEstabelecimento },
                success: function(data) {
                    $('#profissional').empty();
                    
                    if (data.profissionais.length === 0) {
                        desativarSelects(['#profissional', '#servico', '#horario_inicio']);
                    } else {
                        reativarSelect('#profissional', 'Selecione um profissional');
                        $.each(data.profissionais, function(key, value) {
                            $('#profissional').append('<option value="' + value.id_profissional + '">' + value.nome + '</option>');
                        });
                    }
                    desativarSelects(['#servico', '#horario_inicio']); // Desativa serviço e horário enquanto um profissional não é selecionado
                },
                error: function() {
                    alert('Erro ao carregar profissionais');
                }
            });
        }
    });

    // Evento de mudança do Profissional
    $('#profissional').change(function() {
        var idProfissional = $(this).val();
        var idEstabelecimento = $('#estabelecimento').val();
        if (idProfissional) {
            $.ajax({
                url: "{{ route('getServicos') }}", // Rota para obter serviços
                type: "GET",
                data: { id_profissional: idProfissional, id_estabelecimento: idEstabelecimento },
                success: function(data) {
                    $('#servico').empty();
                    
                    if (data.servicos.length === 0) {
                        desativarSelects(['#servico', '#horario_inicio']);
                    } else {
                        reativarSelect('#servico', 'Selecione um serviço');
                        $.each(data.servicos, function(key, value) {
                            $('#servico').append('<option value="' + value.id_servico + '">' + value.nome + '</option>');
                        });
                    }
                    desativarSelects(['#horario_inicio']); // Desativa horário enquanto um serviço não é selecionado
                },
                error: function() {
                    alert('Erro ao carregar serviços');
                }
            });
        }
    });

    // Evento de mudança da Data
    $('#data').blur(function() {
        var idProfissional = $('#profissional').val();
        var dataRealizacao = $(this).val();

        if (idProfissional && dataRealizacao && dataRealizacao.length === 10) {
            $.ajax({
                url: "{{ route('getHorarios') }}", // Rota para obter horários
                type: "GET",
                data: { id_profissional: idProfissional, data_realizacao: dataRealizacao },
                success: function(data) {
                    $('#horario_inicio').empty();
                    
                    if (data.horarios.length === 0) {
                        $('#horario_inicio').append('<option value="" disabled selected>Sem horários disponíveis</option>');
                        $('#horario_inicio').prop('disabled', true);
                    } else {
                        reativarSelect('#horario_inicio', 'Selecione um horário');
                        $.each(data.horarios, function(key, value) {
                            $('#horario_inicio').append('<option value="' + value.intervalo_hora + '">' + value.intervalo_hora + '</option>');
                        });
                    }
                },
                error: function() {
                    alert('Erro ao carregar horários');
                }
            });
        }
    });
});


$(document).ready(function() {
    // Função para verificar se todos os campos estão preenchidos
    function validarFormulario() {
        var estabelecimento = $('#estabelecimento').val();
        var profissional = $('#profissional').val();
        var servico = $('#servico').val();
        var opcaoPag = $('#opcao_pag').val();
        var dataRealizacao = $('#data').val();
        var horarioInicio = $('#horario_inicio').val();
        
        if (!estabelecimento || !profissional || !servico || !opcaoPag || !dataRealizacao || !horarioInicio) {
            alert("Por favor, preencha todos os campos antes de finalizar o agendamento.");
            return false; // Impede o envio do formulário
        }
        return true; // Permite o envio do formulário
    }

    // Intercepta o evento de envio do formulário
    $('#formAgendamento').on('submit', function(e) {
        if (!validarFormulario()) {
            e.preventDefault(); // Cancela o envio do formulário se houver campos vazios
        }
    });
});


</script>
@endsection
