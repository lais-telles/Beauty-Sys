@extends('template-profissional')

@section('title', 'Vínculo Profissional')

@section('content')
<section class="d-flex" style="margin-top: 13rem; margin-bottom: 10rem;">
    <div class="container mt-4">
        <h2 class="mb-3">Meus vínculos</h2>
        <!-- Tabela de Vínculos Cadastrados -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Estabelecimento</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if(count($vinculo) > 0)
                    @foreach($vinculo as $v)
                        <tr>
                            <td>{{ $v->nome_estabelecimento }}</td>
                            <td>{{ $v->status_vinculo }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Nenhum vínculo cadastrada para este profissional.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-primary w-100" onclick="abrirModal()">Solicitar novo vínculo</button>
        </div>
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
</section>

<!-- pop-up para solicitar novo vinculo -->
<div class="modal fade" id="solVinculo" tabindex="-1" aria-labelledby="solVinculo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Solicitar Vínculo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('profissional.solicitarVinculo') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select rounded-3" id="floatingSelect" name="id_estabelecimento" aria-label="Selecione o estabelecimento">
                            <option selected disabled>Selecione um estabelecimento</option>
                            @foreach($estabelecimentos as $estabelecimento)
                                <option value="{{ $estabelecimento->id_estabelecimento }}">{{ $estabelecimento->nome_fantasia }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Nome do estabelecimento</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Solicitar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModal() {
        var modal = new bootstrap.Modal(document.getElementById('solVinculo'));
        modal.show();
    }
</script>
@endsection