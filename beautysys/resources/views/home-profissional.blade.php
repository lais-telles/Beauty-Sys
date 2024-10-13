@extends('template-profissional')

@section('title', 'Profissional')

@section('content')
<section class="d-flex" style="margin-top: 20rem; margin-bottom: 10rem;">
    <div class="container">
        <div class="row">
            <!-- Painel de Agendamentos -->
            <div class="col-md-6">
                <h3>Meus Próximos Agendamentos</h3>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cliente: Ana Souza
                        <span class="badge bg-primary rounded-pill">Hoje - 14:00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cliente: João Lima
                        <span class="badge bg-primary rounded-pill">Amanhã - 10:00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cliente: Carla Mendes
                        <span class="badge bg-primary rounded-pill">Quinta - 16:00</span>
                    </li>
                </ul>
                <a href="{{ route('exibirAgendamentosProf') }}" class="btn btn-custom mt-3">Ver todos os agendamentos</a>
            </div>

            <!-- Painel de Acesso Rápido -->
            <div class="col-md-6">
                <h3>Ferramentas Rápidas</h3>
                <div class="d-flex flex-column">
                    <a href="{{ route('gradeProf') }}" class="btn btn-custom mb-2">Gerenciar Horários</a>
                    <a href="{{ route('infoCadastroP') }}" class="btn btn-custom mb-2">Editar Perfil</a>
                    <a href="" class="btn btn-custom mb-2">Ver Estatísticas</a>
                    <a href="" class="btn btn-custom mb-2">Gerar Relatórios</a>
                </div>
            </div>
        </div>

        <!-- Notificações e Atualizações -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Notificações Recentes</h3>
                <ul class="list-group">
                    <li class="list-group-item">Novo agendamento confirmado com Ana Souza para Hoje - 14:00.</li>
                    <li class="list-group-item">Lembrete: Atualize sua disponibilidade de horários para esta semana.</li>
                    <li class="list-group-item">Promoção de corte de cabelo agendada para o próximo mês.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection

@section('content')

<section class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>ENTRE EM CONTATO</h3>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Seu email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Mensagem</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Sua mensagem"></textarea>
                    </div>
                    <button type="submit" class="btn btn-custom">Enviar</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3 style="color: #73005B">INFORMAÇÕES</h3>
                <p>Email: contato@beautysys.com</p>
                <p>Telefone: (11) 1234-5678</p>
                <p>Redes Sociais:</p>
                <ul class="list-unstyled">
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

