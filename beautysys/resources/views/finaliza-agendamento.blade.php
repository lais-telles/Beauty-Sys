@extends('template-cliente')

@section('title', 'Adm Proprietário')

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
                            <option value="" disabled {{ old('estabelecimento') ? '' : 'selected' }}>Selecione um estabelecimento</option>
                            @foreach($estabelecimentos as $estabelecimento)
                                <option value="{{ $estabelecimento->id_estabelecimento }}" {{ old('estabelecimento') == $estabelecimento->id_estabelecimento ? 'selected' : '' }}>{{ $estabelecimento->nome_fantasia }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Seleção do Profissional -->
                    <div class="mb-3">
                        <label for="profissional" class="form-label">Escolha o Profissional</label>
                        <select class="form-select" id="profissional" name="profissional" required>
                            <option value="" disabled {{ old('profissional') ? '' : 'selected' }}>Selecione um profissional</option>
                            <!-- Profissionais serão preenchidos via AJAX -->
                        </select>
                    </div>

                    <!-- Seleção do Serviço -->
                    <div class="mb-3">
                        <label for="servico" class="form-label">Escolha o Serviço</label>
                        <select class="form-select" id="servico" name="servico" required>
                            <option value="" disabled {{ old('servico') ? '' : 'selected' }}>Selecione um serviço</option>
                            <!-- Serviços serão preenchidos via AJAX -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="opcao_pag" class="form-label">Escolha o Serviço</label>
                        <select class="form-select" id="opcao_pag" name="opcao_pag" required>
                            <option value="" disabled selected>Selecione uma forma de pagamento</option>
                            <option value="1">Pix</option>
                            <option value="1">Cartão de Crédito</option>
                            <option value="1">Cartão de débito</option>
                        </select>
                    </div>

                    <!-- Seleção da Data -->
                    <div class="mb-3">
                        <label for="data" class="form-label">Escolha o Dia</label>
                        <input type="date" class="form-control" id="data" name="data_realizacao" value="{{ old('data_realizacao') }}" required>
                    </div>

                    <!-- Seleção do Horário -->
                    <div class="mb-3">
                        <label for="horario" class="form-label">Escolha o Horário</label>
                        <select class="form-select" id="horario" name="horario_inicio" required>
                            <option value="" disabled {{ old('horario_inicio') ? '' : 'selected' }}>Selecione um horário</option>
                            @foreach(['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] as $horario)
                                <option value="{{ $horario }}" {{ old('horario_inicio') == $horario ? 'selected' : '' }}>{{ $horario }}</option>
                            @endforeach
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
});
</script>
@endsection
