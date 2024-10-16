@extends('template-estab')

@section('title', 'Vínculos')

@section('content')
<section class="d-flex flex-column" style="margin:10rem">
    
    <div class="mt-5">
        <h2>Profissionais Vinculado</h2>

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

        @if(!empty($vinculos))
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Data da solicitação</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vinculos as $vinculo)
                        <tr>
                            <td>{{ $vinculo->nome }}</td>
                            <td>{{ $vinculo->CPF }}</td>
                            <td>{{ $vinculo->telefone }}</td>
                            <td>{{ $vinculo->email }}</td>
                            <td>{{ $vinculo->data_vinculo }}</td>
                            <td>{{ $vinculo->status_vinculo }}</td>
                                <!-- <button class="btn btn-primary" id="button-{{ $vinculo->id_vinculo }}" onclick="toggleSelect({{ $vinculo->id_vinculo }})">
                                    Alterar Status
                                </button>
                                <form action="{{ route('atualizarStatusVinculo') }}" method="POST" id="form-status-{{ $vinculo->id_vinculo }}" style="display:none; margin-top: 10px;">
                                    @csrf
                                    <input type="hidden" name="id_vinculo" value="{{ $vinculo->id_vinculo }}">
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        @foreach($statusAgendamentos as $status)
                                            <option value="{{ $status->descricao }}" {{ $agendamento->status == $status->descricao ? 'selected' : '' }}>
                                                {{ $status->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form> -->
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center">Nenhum profissional vinculado.</td>
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