@extends('template-cliente')

@section('title', 'Adm Cliente')

@section('content')
<section class="d-flex ms-5 me-5 mb-5 rounded" style="margin-top: 15rem;">
    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-12">
                <form action="{{ route ('alteraCadastroCli') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
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

<script src="https://unpkg.com/imask"></script>

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

    IMask(
        document.getElementById('telefone'),
        {
            mask: [
                {
                    mask: '(00) 0000-0000',
                },
                {
                    mask: '(00) 00000-0000',
                }
            ],
        }
    );
</script>
@endsection