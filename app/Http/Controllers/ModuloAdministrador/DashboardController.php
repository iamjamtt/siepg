<?php

namespace App\Http\Controllers\ModuloAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function auth()
    {
        return view('modulo-administrador.auth.login');
    }

    public function dashboard()
    {
        return view('modulo-administrador.dashboard.index');
    }

    public function perfil()
    {
        $id_tipo_trabajador = 3;
        return view('modulo-administrador.perfil.index', [
            'id_tipo_trabajador' => $id_tipo_trabajador
        ]);
    }
}
