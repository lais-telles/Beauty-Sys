<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

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

Route::get('/beautysys', function () {
    return view('index');
});

Route::get('/pessoa-física', [IndexController::class, 'PessoaFisica'])->name('PessoaFisica');
Route::get('/parceiros', [IndexController::class, 'Parceiro'])->name('Parceiro');
Route::get('/home-pf', [IndexController::class, 'HomePf'])->name('PaginaInicialPf');
Route::get('/home-pj', [IndexController::class, 'HomePj'])->name('PaginaInicialPj');
Route::get('/home-profissional', [IndexController::class, 'HomeProfissional'])->name('PaginaInicialProfissional');
Route::get('/dashboard-pj', [IndexController::class, 'DashboardProprietario'])->name('DashboardPj');
Route::get('/AdmPj', [IndexController::class, 'AdmProprietario'])->name('AdmProprietario');