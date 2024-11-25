@extends('template-estab')

@section('title', 'Adm Proprietário')

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded" style="margin-top: 10rem;">
    @if (session('alert') || session('success') || session('error'))
        <!-- Modal Trigger -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                alertModal.show();
            });
        </script>

        <!-- Modal -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertModalLabel">Aviso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center {{ session('success') ? 'alert alert-success' : (session('error') ? 'alert alert-danger' : 'alert alert-info') }}">
                        {{ session('alert') ?? session('success') ?? session('error') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center mt-5">
        <!-- Coluna de informações -->
        <div class="col-md-7">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informações do Estabelecimento</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('AlteraCadastro') }}" method="POST">
                        @csrf
                        <!-- Seção de Informações Básicas -->
                        <h6 class="mb-3">Informações Básicas</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome_fantasia" class="form-label">Nome Fantasia:</label>
                                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{ $registro->nome_fantasia }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $registro->email }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $registro->telefone }}" readonly required>
                            </div>
                        </div>

                        <!-- Seção de Endereço -->
                        <h6 class="mb-3">Endereço</h6>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="logradouro" class="form-label">Logradouro:</label>
                                <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ $registro->logradouro }}" readonly required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero" class="form-label">Número:</label>
                                <input type="text" class="form-control" id="numero" name="numero" value="{{ $registro->numero }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bairro" class="form-label">Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $registro->bairro }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cidade" class="form-label">Cidade:</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $registro->cidade }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado:</label>
                                <input type="text" class="form-control" id="estado" name="estado" value="{{ $registro->estado }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cep" class="form-label">CEP:</label>
                                <input type="text" class="form-control" id="cep" name="cep" value="{{ $registro->CEP }}" readonly required>
                            </div>
                        </div>

                        <!-- Seção de Horário de Funcionamento -->
                        <h6 class="mb-3">Horário de Funcionamento</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inicio_expediente" class="form-label">Início:</label>
                                <input type="text" class="form-control" id="inicio_expediente" name="inicio_expediente" value="{{ $registro->inicio_expediente }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="termino_expediente" class="form-label">Término:</label>
                                <input type="text" class="form-control" id="termino_expediente" name="termino_expediente" value="{{ $registro->termino_expediente }}" readonly required>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="text-end mt-4">
                            <button id="edita_cadastro" class="btn btn-warning" type="button">Editar Informações</button>
                            <button id="salva_alteracoes" class="btn btn-success" type="submit" style="display: none;">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Coluna da imagem de perfil -->
        <div class="col-md-4 text-center">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <!-- Exibição da imagem -->
                    @if (auth()->user()->imagem_perfil)
                        <img src="{{ asset('imagem_perfil/' . auth()->user()->imagem_perfil) }}" alt="Foto de perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img src="{{ asset('imagem_perfil/sem_foto.png') }}" alt="Foto de perfil padrão" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif

                    <!-- Formulário de upload -->
                    <form action="{{ route('imagem_uploadE') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group text-start">
                            <label for="imagem_perfil" class="form-label">Atualizar Foto de Perfil:</label>
                            <input type="file" id="imagem_perfil" name="imagem_perfil" accept="image/*" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Enviar Foto</button>
                    </form>

                    @error('imagem_perfil')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/imask"></script>
<script>
    document.getElementById('edita_cadastro').addEventListener('click', function() {
        var inputs = document.querySelectorAll('input[readonly]');
        inputs.forEach(function(input) {
            input.readOnly = false;
        });
        document.getElementById('salva_alteracoes').style.display = 'block';
        this.style.display = 'none';
    });

    IMask(document.getElementById('telefone'), {
        mask: [
            { mask: '(00) 0000-0000' },
            { mask: '(00) 00000-0000' }
        ],
    });
</script>
@endsection
