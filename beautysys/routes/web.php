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
Route::get('/dashboard-pj', [IndexController::class, 'DashboardProprietario'])->name('DashboardPj');
Route::get('/admPj', [IndexController::class, 'AdmProprietario'])->name('AdmProprietario');
Route::get('/agendamento', [IndexController::class, 'Agendamento'])->name('agendamento');

// Rota para cadastrar um cliente usando o método 'cadastrarCliente'
Route::post('/clientes/cadastrar', [ClienteController::class, 'cadastrarCliente'])->name('cadastrarCliente');

// Rota para cadastrar um profissional usando o método 'cadastrarProfissional'
Route::post('/profissionais/cadastrar', [ProfissionalController::class, 'cadastrarProfissional'])->name('cadastrarProfissional');

<<<<<<< HEAD
// Rota para realizar login do cliente usando o método 'loginCliente
Route::post('cliente/login', [ClienteController::class, 'loginCliente'])->name('loginCliente');
=======

// Rota para cadastrar um estabelecimento usando o método 'cadastrarEstabelecimento'
Route::post('/estabelecimentos/cadastrar', [EstabelecimentoController::class, 'cadastrarEstabelecimento'])->name('cadastrarEstabelecimento');
>>>>>>> b2808b2a64d6fdc6e76549f71163202b3600251b
