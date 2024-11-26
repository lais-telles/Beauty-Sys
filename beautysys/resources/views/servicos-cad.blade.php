@extends('template-estab')

@section('title', 'Meus servicos')

@section('content')
<section class="d-flex" style="margin-top: 10rem; margin-bottom: 10rem;">
    <!-- Tabela de Serviços Cadastrados -->
    <div class="container mt-5">
        <div class="table-responsive">
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


                <h3>Serviços Cadastrados</h3>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Duração</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                    </thead>
                    <tbody>
                    @if(count($servicos) > 0)
                        @foreach($servicos as $servico)
                            <tr>
                                <td>{{ $servico->nome }}</td>
                                <td>{{ $servico->valor }}</td>
                                <td>{{ $servico->duracao }}</td>
                                <td>{{ $servico->id_categoria }}</td>
                                <td>
                                <form id="delete-form" action="{{ route('deletarServico', $servico->id_servico) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal">Excluir</button>
                                </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Nenhum serviço cadastrado.</td>
                        </tr>
                    @endif
                </tbody>
                </table>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cadServico">Cadastrar serviço</button>   
                </div>
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
                    <form id="delete-form" action="{{ route('deletarServico', $servico->id_servico) }}" method="POST">
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


<div class="modal fade" id="cadServico" tabindex="-1" aria-labelledby="cadServico" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Cadastro de Servicos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
            <form action="{{ route('cadastrarServico') }}" method="POST">
                @csrf
                <!-- Campo Nome -->
                <div class="form-floating mb-3">
                    <input 
                        type="text" 
                        class="form-control rounded-3 @error('nome') is-invalid @enderror" 
                        id="floatingNome" 
                        name="nome" 
                        placeholder="Nome do Serviço" 
                        value="{{ old('nome') }}" 
                        required>
                    <label for="floatingNome">Nome</label>
                    @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Valor -->
                <div class="form-floating mb-3">
                    <input 
                        type="number" 
                        step="0.01" 
                        class="form-control rounded-3 @error('valor') is-invalid @enderror" 
                        id="floatingValor" 
                        name="valor" 
                        placeholder="R$ 0,00" 
                        value="{{ old('valor') }}" 
                        required>
                    <label for="floatingValor">Valor</label>
                    @error('valor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Duração -->
                <div class="form-floating mb-3">
                    <input 
                        type="time" 
                        class="form-control rounded-3 @error('duracao') is-invalid @enderror" 
                        id="floatingDuracao" 
                        name="duracao" 
                        value="{{ old('duracao') }}" 
                        required>
                    <label for="floatingDuracao">Duração</label>
                    @error('duracao')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Categoria -->
                <div class="form-floating mb-3">
                    <select 
                        id="id_categoria" 
                        name="id_categoria" 
                        class="form-select @error('id_categoria') is-invalid @enderror" 
                        required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}" 
                                {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                {{ $categoria->descricao }}
                            </option>
                        @endforeach
                    </select>
                    <label for="id_categoria">Categoria</label>
                    @error('id_categoria')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botão de Cadastro -->
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Cadastrar</button>
            </form>

            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('cadServico'));
            modal.show();
        });
    </script>
@endif

<script>
    // Garantir que o foco inicial seja no botão Cancelar ao abrir o modal
    $('#confirmModal').on('shown.bs.modal', function () {
        $(this).find('button[data-bs-dismiss="modal"]').focus();  // Foco no botão de Cancelar
    });
</script>