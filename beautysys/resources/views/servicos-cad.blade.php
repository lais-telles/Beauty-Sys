@extends('template-estab')

@section('title', 'Meus servicos')

@section('content')
<section class="d-flex flex-column" style="margin:10rem">
    <!-- Tabela de Serviços Cadastrados -->
    <div class="mt-5">
        <h3>Serviços Cadastrados</h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Id Serviço</th>
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
                        <td>{{ $servico->id_servico }}</td>
                        <td>{{ $servico->nome }}</td>
                        <td>{{ $servico->valor }}</td>
                        <td>{{ $servico->duracao }}</td>
                        <td>{{ $servico->id_categoria }}</td>
                        <td>
                            <form action="" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
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
    </div>
    <div class="mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cadServico">Cadastrar serviço</button>   
    </div>
</section>
@endsection


<!-- Poup-up de cadastro pro proprietário-->
<div class="modal fade" id="cadServico" tabindex="-1" aria-labelledby="cadServico" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Cadastro de Servicos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 pt-0">
                    <form action=" {{ route('cadastrarServico') }} " method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingNome" name="nome" placeholder="nome do serviço" required>
                            <label for="floatingNome">Nome</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingValor" name="valor" placeholder="R$ 0,00" required>
                            <label for="floatingValor">Valor</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="time" class="form-control rounded-3" id="floatingDuracao" name="Duracao" required step="1">
                            <label for="floatingDuracao">Duracao</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select id="id_categoria" name="id_categoria" class="form-select" required>
                                <option value="" disabled selected>Selecione uma categoria</option> <!-- Opção padrão não selecionável -->
                                <option value="1">Cabelo</option>
                                <option value="2">Estética facial</option>
                                <option value="3">Unhas</option>
                                <option value="4">Combo</option>
                            </select>
                            <label for="categoria">Categoria</label>
                        </div>
                        <input type="hidden" name="id_estabelecimento" value="{{ session('id_estabelecimento') }}">

                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Cadastrar</button>
                        <small class="text-body-secondary">Ao clicar em cadastrar, você concorda com os termos de uso.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>