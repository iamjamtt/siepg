<?php

namespace App\Http\Controllers\ModuloAdministrador;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessRegistroFichaInscripcion2;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index()
    {
        return view('modulo-administrador.gestion-admision.inscripcion.index');
    }

    public function generarFichasInscripcion()
    {
        $inscripciones = Inscripcion::join('programa_proceso', 'inscripcion.id_programa_proceso', 'programa_proceso.id_programa_proceso')
            ->join('admision', 'programa_proceso.id_admision', 'admision.id_admision')
            ->where('admision.admision_estado', 1)
            ->where('inscripcion.envio_inscripcion', 0)
            ->get();

        foreach ($inscripciones as $inscripcion) {
            ProcessRegistroFichaInscripcion2::dispatch($inscripcion, 'create'); // Proceso para generar el pdf de inscripcion y enviarlo al correo
        }

        return response()->json([
            'message' => 'Fichas de inscripcion generadas'
        ]);
    }
}
