@extends('template-cliente')

@section('title', 'Realizar agendamento')

@section('content')
<section class="d-flex ms-5 me-5 mb-5" style="margin-top: 15rem;">
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
                        <option value="" disabled {{ old('servico') ? '' : 'selected' }}>Selecione um servico</option>
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
                        <label for="opcao_pag" class="form-label">Escolha o Serviço</label>
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
    $('#estabelecimento').change(function() {
        var idEstabelecimento = $(this).val();
        if (idEstabelecimento) {
            $.ajax({
                url: "{{ route('getProfissionais') }}", // Rota para obter profissionais
                type: "GET",
                data: { id: idEstabelecimento },
                success: function(data) {
                    $('#profissional').empty();
                    $('#profissional').append('<option value="" disabled selected>Selecione um profissional</option>');
                    $.each(data.profissionais, function(key, value) {
                        $('#profissional').append('<option value="' + value.id_profissional + '">' + value.nome + '</option>');
                    });
                }
            });
        }
    });

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
                    $('#servico').append('<option value="" disabled selected>Selecione um serviço</option>');
                    $.each(data.servicos, function(key, value) {
                        $('#servico').append('<option value="' + value.id_servico + '">' + value.nome + '</option>');
                    });
                }
            });
        }
    });

    $('#data').blur(function() {
    var idProfissional = $('#profissional').val();
    var dataRealizacao = $(this).val();

    // Verifica se a data está no formato completo YYYY-MM-DD
    if (idProfissional && dataRealizacao && dataRealizacao.length === 10) {
        $.ajax({
            url: "{{ route('getHorarios') }}", // Rota para obter horários
            type: "GET",
            data: { id_profissional: idProfissional, data_realizacao: dataRealizacao },
            success: function(data) {
                $('#horario_inicio').empty();
                $('#horario_inicio').append('<option value="" disabled selected>Selecione um horário</option>');
                $.each(data.horarios, function(key, value) {
                    $('#horario_inicio').append('<option value="' + value.intervalo_hora + '">' + value.intervalo_hora + '</option>');
                });
            },
            error: function() {
                alert('Erro ao carregar horários');
            }
        });
    }
});




});
</script>
@endsection
