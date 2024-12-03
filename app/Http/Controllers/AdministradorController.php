<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function matriculas()
    {
        return view('modulo-administrador.gestion-matriculas.index');
    }
}
