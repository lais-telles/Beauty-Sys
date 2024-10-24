@extends('template-cliente')

@section('title', 'Pesquisa')

@section('content')
<style>
    /* Efeito de hover para as linhas da tabela */
    .table tbody tr {
        transition: background-color 0.3s, transform 0.3s;
    }

    .table tbody tr:hover {
        background-color: #f2f2f2; /* Cor de fundo ao passar o mouse */
        transform: translateY(-2px); /* Levanta ligeiramente a linha */
    }
</style>

<section style="margin-top: 15rem;">
    <div class="container mt-5">
        <h1>Resultados da Pesquisa</h1>

        @if ($resultado_pesquisa && count($resultado_pesquisa) > 0)
            <table class="table responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Estabelecimento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultado_pesquisa as $item)
                    <tr>
                        <td>
                            <a class="text-decoration-none text-dark" 
                            href="{{ route('dadosRealizarAgendamento', ['id' => $item->id, 'estabelecimento' => $item->id_estabelecimento]) }}">
                                {{ $item->id }}
                            </a>
                        </td>
                        <td>
                            <a class="text-decoration-none text-dark" 
                            href="{{ route('dadosRealizarAgendamento', ['id' => $item->id, 'estabelecimento' => $item->id_estabelecimento]) }}">
                                {{ $item->descricao }}
                            </a>
                        </td>
                        <td>
                            <a class="text-decoration-none text-dark" 
                            href="{{ route('dadosRealizarAgendamento', ['id' => $item->id, 'estabelecimento' => $item->id_estabelecimento]) }}">
                                {{ $item->valor !== null ? 'R$ ' . number_format($item->valor, 2, ',', '.') : 'N/A' }}
                            </a>
                        </td>
                        <td>
                            <a class="text-decoration-none text-dark" 
                            href="{{ route('dadosRealizarAgendamento', ['id' => $item->id, 'estabelecimento' => $item->id_estabelecimento]) }}">
                                {{ $item->nome_fantasia }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        @else
            <p>Nenhum resultado encontrado para "{{ request()->input('termo_pesquisa') }}".</p>
        @endif
    </div>
</section>
@endsection
