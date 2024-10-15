@extends('template-profissional')

@section('title', 'Grade Horaria')

@section('content')
<section class="d-flex" style="margin-top: 13rem; margin-bottom: 10rem;">
    <div class="container mt-3">
        <h3>Serviços Associados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome do serviço</th>
                    <th>Duração</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @if(count($servicos) > 0)
                    @foreach($servicos as $s)
                        <tr>
                            <td>{{ $s->nome }}</td>
                            <td>{{ $s->duracao }}</td>
                            <td>{{ $s->valor }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Nenhum serviço associado a este profissional.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-primary w-100" onclick="abrirModal()">Associar novo serviço</button>
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


<!-- pop-up para associar novo servico -->
<div class="modal fade" id="solVinculo" tabindex="-1" aria-labelledby="solVinculo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Associar servico</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="{{ route('associarServ') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select rounded-3" id="floatingSelect" name="id_servico" aria-label="Selecione o estabelecimento">
                            <option selected disabled>Selecione um serviço</option>
                            @foreach($lista as $l)
                                <option value="{{ $l ->id_servico }}">{{ $l->nome }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Nome do serviço</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Associar</button>
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
