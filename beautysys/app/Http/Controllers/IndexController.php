<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function PessoaFisica() {
        return view('pessoa-fisica');
    }

    public function Parceiro() {
        return view('parceiros');
    }

    public function HomePf() {
        return view('home-pf');
    }

    public function HomePj() {
        return view('home-pj');
    }

    public function HomeProfissional() {
        return view('home-profissional');
    }

    public function DashboardProprietario() {
        return view('dashboard-pj');
    }

    public function AdmProprietario() {
        return view('adm-proprietario');
    }
}
