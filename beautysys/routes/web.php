<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\EstabelecimentoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beautysys', [IndexController::class, 'Index'])->name('Index');
Route::get('/pessoa-física', [IndexController::class, 'PessoaFisica'])->name('PessoaFisica');
Route::get('/parceiros', [IndexController::class, 'Parceiro'])->name('Parceiro');
Route::get('/home-pf', [IndexController::class, 'HomePf'])->name('PaginaInicialPf');
Route::get('/home-pj', [IndexController::class, 'HomePj'])->name('PaginaInicialPj');
Route::get('/home-profissional', [IndexController::class, 'HomeProfissional'])->name('PaginaInicialProfissional');
//Route::get('/dashboard-pj', [IndexController::class, 'DashboardProprietario'])->name('DashboardPj');
Route::get('/admPj', [IndexController::class, 'AdmProprietario'])->name('AdmProprietario');
Route::get('/agendamento', [IndexController::class, 'Agendamento'])->name('agendamento');

// --------------------------------------Rotas do cliente ----------------------------------------------------
// Rota para cadastrar um cliente usando o método 'cadastrarCliente'
Route::post('/clientes/cadastrar', [ClienteController::class, 'cadastrarCliente'])->name('cadastrarCliente');

// Rota para realizar login do cliente usando o método 'loginCliente'
Route::post('cliente/login', [ClienteController::class, 'loginCliente'])->name('loginCliente');

// Rota para realizar logout do cliente usando o método 'logoutCliente'
Route::post('cliente/logout', [ClienteController::class, 'logoutCliente'])->name('logoutCliente');

// Rota para exibição dos agendamentos realizados pelo cliente
Route::get('/agendamentosCliente', [ClienteController::class, 'exibirAgendamentos'])->name('visAgdCliente');

// Rota para administração de conta do cliente com o método 'admCliente'
Route::get('/admCliente', [ClienteController::class, 'admCliente'])->name('admCliente');

//Rota para a tela de perfil do cliente com as respectivas informações do cliente logado
Route::get('cliente/perfil', [ClienteController::class, 'buscarCliente'])->name('infoCadastroCli');

//Rota para salvar alterações de cadastro
Route::post('cliente/atualiza', [ClienteController::class, 'alterarCadastro'])->name('alteraCadastroCli');

//Rota para coletar dados necessários para a realização de um agendamento
Route::get('realizar-agendamento', [ClienteController::class, 'dadosRealizarAgendamento'])->name('dadosRealizarAgendamento');

//Rota para a função AJAX responsável pela consulta dos profissionais disponíveis
Route::get('/get-profissionais', [ClienteController::class, 'getProfissionais'])->name('getProfissionais');

//Rota para a função AJAX responsável pela consulta dos serviços disponíveis
Route::get('/get-servicos', [ClienteController::class, 'getServicos'])->name('getServicos');

//Rota para a função AJAX responsável pela consulta dos horários disponíveis
Route::get('/get-horarios', [ClienteController::class, 'getHorarios'])->name('getHorarios');

//Rota responsável pela finalização de um agendamento
Route::post('agendamento/finalizar', [ClienteController::class, 'realizarAgendamento'])->name('realizarAgendamento');

//Rota para exibir todos os profissionais disponíveis na plataforma
Route::get('profissionais', [ClienteController::class, 'listaProfissionais'])->name('listaProfissionais');

//Rota para exibir todos os estabelecimentos disponíveis na plataforma
Route::get('estabelecimentos', [ClienteController::class, 'listaEstab'])->name('listaEstab');

//Rota para exibir todos os estabelecimentos disponíveis na plataforma da área de login
Route::get('estabelecimentos/login', [ClienteController::class, 'listaEstabLogin'])->name('listaEstabLogin');

// --------------------------------------- Rotas do Profissional -----------------------------------------------
// Rota para cadastrar um profissional usando o método 'cadastrarProfissional'
Route::post('/profissionais/cadastrar', [ProfissionalController::class, 'cadastrarProfissional'])->name('cadastrarProfissional');

// Rota para realizar login do profissional usando o método 'loginProfissional'
Route::post('profissional/login', [ProfissionalController::class, 'loginProfissional'])->name('loginProfissional');

// Rota para realizar logout do profissional usando o método 'logoutProfissional'
Route::post('profissional/logout', [ProfissionalController::class, 'logoutProfissional'])->name('logoutProfissional');

// Rota para ir para a área de cadastro de grade horária usando o método 'gradeProf'
Route::get('profissional/grade', [ProfissionalController::class, 'gradeProf'])->name('gradeProf');

// Rota para deletar um horário com o método 'deletarHorario'
Route::delete('profissional/grade/{id}', [ProfissionalController::class, 'deletarHorario'])->name('deletarHorario');

// Rota para salvar um horário com o método 'salvarGrade'
Route::post('profissional/salvarG', [ProfissionalController::class, 'salvarGrade'])->name('salvarGrade');

// Rota para deletar um horário com o método 'deletarServico'
Route::delete('profissional/servico/{id}', [ProfissionalController::class, 'deletarServico'])->name('deletarServico');

//Rota para atualizar o status dos agendamentos
Route::post('/agendamentos/status', [ProfissionalController::class, 'atualizarStatusAgendamentos'])->name('agendamentosStatus');

//Rota para exibição dos agendamentos realizados com o profissional logado
Route::get('/agendamentos', [ProfissionalController::class, 'exibirAgendamentosProf'])->name('exibirAgendamentosProf');

// Rota para administração de conta do Profissional com o método 'admProf'
Route::get('/admProfissional', [ProfissionalController::class, 'admProf'])->name('admProf');

//Rota para a tela de perfil do profissional com as respectivas informações do profissional logado
Route::get('profissional/perfil', [ProfissionalController::class, 'buscarProfissional'])->name('infoCadastroP');

//Rota para salvar alterações de cadastro
Route::post('profissional/atualiza', [ProfissionalController::class, 'alterarCadastro'])->name('alteraCadastroProf');

// Rota para tela de solicitação/ visuialização de vínculo
Route::get('profissional/vinculo', [ProfissionalController::class, 'vinculoProf'])->name('vinculoProf');

Route::post('/solicitar-vinculo', [ProfissionalController::class, 'solicitarVinculo'])->name('profissional.solicitarVinculo');

//Rota para a tela de associar serviços ao profissional
Route::get('servico/profissional', [ProfissionalController::class, 'servicosProf'])->name('servicosProf');

//Rota para associar um novo serviço
Route::post('associar/servico', [ProfissionalController::class, 'associarServ'])->name('associarServ');

// ---------------------------------------------- Rotas do Estabelecimento ---------------------------------------
// Rota para cadastrar um estabelecimento usando o método 'cadastrarEstabelecimento'
Route::post('/estabelecimentos/cadastrar', [EstabelecimentoController::class, 'cadastrarEstabelecimento'])->name('cadastrarEstabelecimento');

// Rota para realizar login do estabelecimento usando o método 'loginEstab'
Route::post('estabelecimento/login', [EstabelecimentoController::class, 'loginEstab'])->name('loginEstab');

// Rota para realizar logout do estabelecimento usando o método 'logoutEstab'
Route::post('estabelecimento/logout', [EstabelecimentoController::class, 'logoutEstab'])->name('logoutEstab');

//Rota para a tela de perfil do estabelecimento com as respectivas informações do estabelecimento logado
Route::get('estabelecimento/perfil', [EstabelecimentoController::class, 'buscarEstabelecimento'])->name('InfoCadastro');

//Rota para alterações cadastrais
Route::post('estabelecimento/atualiza', [EstabelecimentoController::class, 'alterarCadastro']) ->name('AlteraCadastro');

//Rota para a página de serviços
Route::get('proprietario/servicos', [EstabelecimentoController::class, 'listaServicos'])->name('listaServicos');

//Rota para a realização do cadastro de serviços
Route::post('/cadastrar-servico', [EstabelecimentoController::class, 'cadastrarServico'])->name('cadastrarServico');

//Rota para exibição dos agendamentos realizados no estabelecimento logado
Route::get('/agendamentos/estab', [EstabelecimentoController::class, 'exibirAgendamentosEstab'])->name('exibirAgendamentosEstab');

Route::get('estabelecimento/dashboard', [EstabelecimentoController::class, 'dashboardEstab'])->name('DashboardPj');

//Rota para exibição dos profissionais vinculados com o estabelecimento
Route::get('/estabelecimento/vinculo', [EstabelecimentoController::class, 'exibirVinculosEstab'])->name('exibirVinculosEstab');

//Rota para atualizar o status dos vinculos
Route::post('/vinculos/status', [EstabelecimentoController::class, 'atualizarStatusVinculo'])->name('atualizarStatusVinculo');