<?php

namespace App\Http\Controllers\ModuloPlataforma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlataformaController extends Controller
{
    public function login()
    {
        return view('modulo-plataforma.auth.login');
    }

    public function inicio()
    {
        return view('modulo-plataforma.inicio.index');
    }

    public function admision()
    {
        return view('modulo-plataforma.admision.index');
    }

    public function perfil()
    {
        return view('modulo-plataforma.perfil.index');
    }

    public function expediente()
    {
        return view('modulo-plataforma.expedientes.index');
    }

    public function pago()
    {
        return view('modulo-plataforma.pagos.index');
    }

    public function constancia()
    {
        return view('modulo-plataforma.constancia-ingreso.index');
    }

    public function matriculas()
    {
        return view('modulo-plataforma.matriculas.index');
    }
}
