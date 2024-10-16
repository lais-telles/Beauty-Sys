@extends('template-estab')

@section('title', 'Adm Proprietário')

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded" style="margin-top: 10rem;">
    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-12">
                <form action="{{ route ('AlteraCadastro') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Razao_social">Razão Social</label>
                                <input type="text" class="form-control" id="razao_social" name="razao_social" value="{{ $registro->razao_social }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="nome_fantasia">Nome Fantasia:</label>
                                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{ $registro->nome_fantasia }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="nome_fantasia">CNPJ:</label>
                                <input type="text" class="form-control" id="CNPJ" name="CNPJ" value="{{ $registro->CNPJ }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $registro->email }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $registro->telefone }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="logradouro">Logradouro:</label>
                                <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ $registro->logradouro }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="numero">Número:</label>
                                <input type="text" class="form-control" id="numero" name="numero" value="{{ $registro->numero }}" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bairro">Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $registro->bairro }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="cidade"> cidade:</label>
                                <input type="text" class="form-control" id="cidade"  name="cidade" value="{{ $registro->cidade }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <input type="text" class="form-control" id="estado" name="estado" value="{{ $registro->estado }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="cep">CEP:</label>
                                <input type="text" class="form-control" id="cep" name="CEP" value="{{ $registro->CEP }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="inicio_expediente">Início Expediente:</label>
                                <input type="text" class="form-control" id="inicio_expediente" name="inicio_expediente" value="{{ $registro->inicio_expediente }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="termino_expediente">Término Expediente:</label>
                                <input type="text" class="form-control" id="termino_expediente" name="termino_expediente" value="{{ $registro->termino_expediente }}" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <!-- Botão de editar -->
                        <button id="edita_cadastro" class="btn btn-custom px-5 mb-5" type="button">Editar informações</button>
                        <!-- Botão de salvar inicialmente oculto -->
                        <button id="salva_alteracoes" class="btn btn-custom2 px-5 mb-5" type="submit" style="display: none;">Salvar alterações</button>
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
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('edita_cadastro').addEventListener('click', function() {
        // Seleciona todos os campos do formulário
        var inputs = document.querySelectorAll('input[type="text"], input[type="email"]');
        inputs.forEach(function(input) {
            // Altera o atributo readonly para permitir edição
            input.readOnly = false;
        });
        // Mostra o botão de salvar
        document.getElementById('salva_alteracoes').style.display = 'block';
        // Esconde o botão de editar
        this.style.display = 'none';
    });
</script>
@endsection
