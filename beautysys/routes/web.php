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
//Route::get('/home-pf', [IndexController::class, 'HomePf'])->name('PaginaInicialPf');
//Route::get('/home-pj', [IndexController::class, 'HomePj'])->name('PaginaInicialPj');
//Route::get('/home-profissional', [IndexController::class, 'HomeProfissional'])->name('PaginaInicialProfissional');
Route::get('/dashboard-pj', [IndexController::class, 'DashboardProprietario'])->name('DashboardPj');
Route::get('/admPj', [IndexController::class, 'AdmProprietario'])->name('AdmProprietario');
Route::get('/agendamento', [IndexController::class, 'Agendamento'])->name('agendamento');

// Rota para cadastrar um cliente usando o método 'cadastrarCliente'
Route::post('/clientes/cadastrar', [ClienteController::class, 'cadastrarCliente'])->name('cadastrarCliente');

// Rota para cadastrar um profissional usando o método 'cadastrarProfissional'
Route::post('/profissionais/cadastrar', [ProfissionalController::class, 'cadastrarProfissional'])->name('cadastrarProfissional');

// Rota para cadastrar um estabelecimento usando o método 'cadastrarEstabelecimento'
Route::post('/estabelecimentos/cadastrar', [EstabelecimentoController::class, 'cadastrarEstabelecimento'])->name('cadastrarEstabelecimento');

// Rota para realizar login do cliente usando o método 'loginCliente'
Route::post('cliente/login', [ClienteController::class, 'loginCliente'])->name('loginCliente');

// Rota para realizar login do estabelecimento usando o método 'loginEstab'
Route::post('estabelecimento/login', [EstabelecimentoController::class, 'loginEstab'])->name('loginEstab');

// Rota para realizar login do profissional usando o método 'loginProfissional'
Route::post('profissional/login', [ProfissionalController::class, 'loginProfissional'])->name('loginProfissional');

// Rota para realizar logout do cliente usando o método 'logoutCliente'
Route::post('cliente/logout', [ClienteController::class, 'logoutCliente'])->name('logoutCliente');

// Rota para realizar logout do estabelecimento usando o método 'logoutEstab'
Route::post('estabelecimento/logout', [EstabelecimentoController::class, 'logoutEstab'])->name('logoutEstab');

// Rota para realizar logout do profissional usando o método 'logoutProfissional'
Route::post('profissional/logout', [ProfissionalController::class, 'logoutProfissional'])->name('logoutProfissional');

//Rota para a tela de perfil do estabelecimento com as respectivas informações do estabelecimento logado
Route::get('estabelecimento/perfil', [EstabelecimentoController::class, 'buscar_estabelecimento'])->name('InfoCadastro');

//Rota para alterações cadastrais
Route::post('estabelecimento/atualiza', [EstabelecimentoController::class, 'alterar_cadastro']) ->name('AlteraCadastro');

// Rota para ir para a área de cadastro de grade horária usando o método 'gradeProf'
Route::get('profissional/grade', [ProfissionalController::class, 'gradeProf'])->name('gradeProf');

// Rota para deletar um horário com o método 'deletarHorario'
Route::delete('profissional/grade/{id}', [ProfissionalController::class, 'deletarHorario'])->name('deletarHorario');

// Rota para salvar um horário com o método 'salvarGrade'
Route::post('profissional/salvarG', [ProfissionalController::class, 'salvarGrade'])->name('salvarGrade');

//Rota para a página de serviços
Route::get('proprietario/servicos', [EstabelecimentoController::class, 'listaServicos'])->name('listaServicos');

//Rota para a realização do cadastro de serviços
Route::post('/cadastrar-servico', [EstabelecimentoController::class, 'cadastrarServico'])->name('cadastrarServico');

//Rota para exibição dos agendamentos realizados no estabelecimento logado
Route::get('/agendamentos', [EstabelecimentoController::class, 'exibirAgendamentosEstab'])->name('exibirAgendamentos');

// Rota para exibição dos agendamentos realizados pelo cliente
Route::get('/agendamentosCliente', [ClienteController::class, 'exibirAgendamentos'])->name('visAgdCliente');