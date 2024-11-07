@extends('template-profissional')

@section('title', 'Adm Profissional')

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded" style="margin-top: 15rem;">
    <div class="container my-5">
        <div class="row align-items-center">
            <!-- Coluna para o formulário de informações pessoais -->
            <div class="col-md-6">
                <form action="{{ route('alteraCadastroProf') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $registro->email }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $registro->telefone }}" readonly required>
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
                <!-- Mensagens de sucesso ou erro -->
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

            <!-- Coluna para o formulário de upload da foto -->
            <div class="col-md-6 text-center">
                <!-- Exibição da foto de perfil ou imagem padrão -->
                @if (auth()->user()->imagem_perfil)
                    <img src="{{ asset('storage/imagem_perfil/' . auth()->user()->imagem_perfil) }}" alt="Foto de perfil" class="img-perfil mb-3">
                @else
                    <img src="{{ asset('storage/imagem_perfil/sem_foto.png') }}" alt="Foto de perfil padrão" class="img-perfil mb-3">
                @endif

                <!-- Formulário de upload de foto de perfil -->
                <form action="{{ route('imagem_upload') }}" method="POST" enctype="multipart/form-data" class="text-start">
                    @csrf
                    <div class="form-group">
                        <label for="imagem_perfil" class="form-label">Escolha sua foto de perfil</label>
                        <input type="file" id="imagem_perfil" name="imagem_perfil" accept="image/*" class="form-control mt-1" required>
                    </div>

                    @error('imagem_perfil')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror

                    <div class="text-end mt-3">
                <button type="submit" class="btn btn-custom">Enviar Foto</button>
            </div>
                </form>
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
