<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function Index() 
    {
        return view('index');
    }

    public function PessoaFisica() 
    {
        return view('pessoa-fisica');
    }

    public function Parceiro() 
    {
        return view('parceiros');
    }

    public function homePf() 
    {
        return view('home-pf');
    }

    public function homePj() 
    {
        return view('home-pj');
    }

    public function homeProfissional() 
    {
        return view('home-profissional');
    }

    public function admProprietario() 
    {
        return view('adm-proprietario');
    }

    public function admProfissional() 
    {
        return view('adm-profissional');
    }
}