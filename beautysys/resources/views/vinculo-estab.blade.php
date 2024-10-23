@extends('template-estab')

@section('title', 'Vínculos')

@section('content')
<section class="d-flex" style="margin-top: 10rem; margin-bottom: 10rem;">
    
    <div class="container mt-5">
        <div class="table-responsive">
            <h2>Profissionais Vinculados</h2>

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
                            <th class="d-none d-sm-table-cell">Telefone</th>
                            <th class="d-none d-md-table-cell">Email</th>
                            <th class="d-none d-sm-table-cell">Data da solicitação</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vinculos as $vinculo)
                            <tr>
                                <td>{{ $vinculo->nome }}</td>
                                <td>{{ $vinculo->CPF }}</td>
                                <td class="d-none d-sm-table-cell">{{ $vinculo->telefone }}</td>
                                <td class="d-none d-md-table-cell">{{ $vinculo->email }}</td>
                                <td class="d-none d-sm-table-cell">{{ $vinculo->data_vinculo }}</td>
                                <td>{{ $vinculo->status_vinculo }}</td>
                                <td>
                                    <button class="btn btn-primary" id="button-{{ $vinculo->id_vinculo }}" onclick="toggleSelect({{ $vinculo->id_vinculo }})">
                                        Alterar Status
                                    </button>
                                    <form action="{{ route('atualizarStatusVinculo') }}" method="POST" id="form-status-{{ $vinculo->id_vinculo }}" style="display:none; margin-top: 10px;">
                                        @csrf
                                        <input type="hidden" name="id_vinculo" value="{{ $vinculo->id_vinculo }}">
                                        <select name="status_vinculo" class="form-select" onchange="this.form.submit()">
                                            <option value="pendente" {{ $vinculo->status_vinculo == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                            <option value="aprovado" {{ $vinculo->status_vinculo == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                            <option value="rejeitado" {{ $vinculo->status_vinculo == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                                        </select>
                                    </form> 
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">Nenhum profissional vinculado.</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
        </div>
    </div>
</section>

<script>
    function toggleSelect(id) {
        var form = document.getElementById('form-status-' + id);
        var button = document.getElementById('button-' + id);
        
        if (form.style.display === 'none') {
            form.style.display = 'block';
            button.style.display = 'none';
        } else {
            form.style.display = 'none';
            button.style.display = 'inline-block';
        }
    }
</script>
@endsection
