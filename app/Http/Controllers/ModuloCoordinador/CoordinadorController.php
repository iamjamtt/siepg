<?php

namespace App\Http\Controllers\ModuloCoordinador;

use App\Http\Controllers\Controller;
use App\Models\Admision;
use App\Models\Evaluacion;
use App\Models\Modalidad;
use App\Models\Programa;
use App\Models\TrabajadorTipoTrabajador;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CoordinadorController extends Controller
{
    public function inicio()
    {
        return view('modulo-coordinador.inicio.index');
    }

    public function programas($id)
    {
        $id_modalidad = $id;
        return view('modulo-coordinador.inicio.programas', [
            'id_modalidad' => $id_modalidad
        ]);
    }

    public function inscripciones($id, $id_admision)
    {
        $id_programa = $id;
        $id_admision = $id_admision;
        return view('modulo-coordinador.inicio.inscripciones', [
            'id_programa' => $id_programa,
            'id_admision' => $id_admision
        ]);
    }

    public function evaluaciones($id, $id_admision)
    {
        $id_programa = $id;
        $id_admision = $id_admision;
        return view('modulo-coordinador.inicio.evaluaciones.inscripciones', [
            'id_programa' => $id_programa,
            'id_admision' => $id_admision
        ]);
    }

    public function evaluacion_expediente($id, $id_admision, $id_evaluacion)
    {
        $id_programa = $id;
        $id_admision = $id_admision;
        $id_evaluacion = $id_evaluacion;
        return view('modulo-coordinador.inicio.evaluaciones.evaluacion-expediente', [
            'id_programa' => $id_programa,
            'id_admision' => $id_admision,
            'id_evaluacion' => $id_evaluacion
        ]);
    }

    public function evaluacion_investigacion($id, $id_admision, $id_evaluacion)
    {
        $id_programa = $id;
        $id_admision = $id_admision;
        $id_evaluacion = $id_evaluacion;
        return view('modulo-coordinador.inicio.evaluaciones.evaluacion-investigacion', [
            'id_programa' => $id_programa,
            'id_admision' => $id_admision,
            'id_evaluacion' => $id_evaluacion
        ]);
    }

    public function evaluacion_entrevista($id, $id_admision, $id_evaluacion)
    {
        $id_programa = $id;
        $id_admision = $id_admision;
        $id_evaluacion = $id_evaluacion;
        return view('modulo-coordinador.inicio.evaluaciones.evaluacion-entrevista', [
            'id_programa' => $id_programa,
            'id_admision' => $id_admision,
            'id_evaluacion' => $id_evaluacion
        ]);
    }

    public function perfil()
    {
        $id_tipo_trabajador = 2;
        return view('modulo-coordinador.perfil.index', [
            'id_tipo_trabajador' => $id_tipo_trabajador
        ]);
    }

    public function reporte_maestria($id_programa, $id_admision)
    {
        $evaluaciones = Evaluacion::join('inscripcion', 'evaluacion.id_inscripcion', '=', 'inscripcion.id_inscripcion')
            ->join('persona', 'inscripcion.id_persona', '=', 'persona.id_persona')
            ->join('programa_proceso', 'inscripcion.id_programa_proceso', '=', 'programa_proceso.id_programa_proceso')
            ->join('programa_plan', 'programa_proceso.id_programa_plan', '=', 'programa_plan.id_programa_plan')
            ->join('programa', 'programa_plan.id_programa', '=', 'programa.id_programa')
            ->join('facultad', 'programa.id_facultad', '=', 'facultad.id_facultad')
            ->where('programa.id_programa', $id_programa)
            ->where('programa_proceso.id_admision', $id_admision)
            ->where('inscripcion.inscripcion_estado', 1)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->where('inscripcion.es_traslado_externo', 0)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();

        $evaluaciones_trasalados_externos = Evaluacion::join('inscripcion', 'evaluacion.id_inscripcion', '=', 'inscripcion.id_inscripcion')
            ->join('persona', 'inscripcion.id_persona', '=', 'persona.id_persona')
            ->join('programa_proceso', 'inscripcion.id_programa_proceso', '=', 'programa_proceso.id_programa_proceso')
            ->join('programa_plan', 'programa_proceso.id_programa_plan', '=', 'programa_plan.id_programa_plan')
            ->join('programa', 'programa_plan.id_programa', '=', 'programa.id_programa')
            ->join('facultad', 'programa.id_facultad', '=', 'facultad.id_facultad')
            ->where('programa.id_programa', $id_programa)
            ->where('programa_proceso.id_admision', $id_admision)
            ->where('inscripcion.inscripcion_estado', 1)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->where('inscripcion.es_traslado_externo', 1)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();

        $facultad = Programa::join('facultad', 'programa.id_facultad', '=', 'facultad.id_facultad')
            ->where('programa.id_programa', $id_programa)
            ->first()->facultad;

        $fecha = date('Y-m-d');
        $fecha2 = date('dmY');

        $trabajador = TrabajadorTipoTrabajador::where('id_trabajador_tipo_trabajador', auth('usuario')->user()->id_trabajador_tipo_trabajador)
            ->first()
            ->trabajador;

        $coordinador = $trabajador->trabajador_apellido . ', ' . $trabajador->trabajador_nombre;

        $programa = Programa::where('id_programa', $id_programa)->first();
        $mencion = $programa->mencion ? ucwords(strtolower($programa->mencion)) : null;
        $maestria = ucwords(strtolower($programa->subprograma));

        $admision = Admision::where('id_admision', $id_admision)->first();
        $admision = ucwords(strtolower($admision->admision));

        $modalidad = Modalidad::where('id_modalidad', $programa->id_modalidad)->first();
        $modalidad = ucwords(strtolower($modalidad->modalidad));

        $data = [
            'evaluaciones' => $evaluaciones,
            'evaluaciones_trasalados_externos' => $evaluaciones_trasalados_externos,
            'facultad' => $facultad,
            'fecha' => $fecha,
            'coordinador' => $coordinador,
            'programa' => $programa,
            'admision' => $admision,
            'mencion' => $mencion,
            'maestria' => $maestria,
            'modalidad' => $modalidad
        ];

        $pdf = Pdf::loadView('modulo-coordinador.reporte-acta-evaluacion.reporte-evaluacion-maestria', $data);

        return $pdf->stream('acta-evaluacion-maestria-' . $fecha2 . '.pdf');
    }

    public function reporte_doctorado($id_programa, $id_admision)
    {
        $evaluaciones = Evaluacion::join('inscripcion', 'evaluacion.id_inscripcion', '=', 'inscripcion.id_inscripcion')
            ->join('persona', 'inscripcion.id_persona', '=', 'persona.id_persona')
            ->join('programa_proceso', 'inscripcion.id_programa_proceso', '=', 'programa_proceso.id_programa_proceso')
            ->join('programa_plan', 'programa_proceso.id_programa_plan', '=', 'programa_plan.id_programa_plan')
            ->join('programa', 'programa_plan.id_programa', '=', 'programa.id_programa')
            ->join('facultad', 'programa.id_facultad', '=', 'facultad.id_facultad')
            ->where('programa.id_programa', $id_programa)
            ->where('programa_proceso.id_admision', $id_admision)
            ->where('inscripcion.inscripcion_estado', 1)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->where('inscripcion.es_traslado_externo', 0)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();

        $evaluaciones_trasalados_externos = Evaluacion::join('inscripcion', 'evaluacion.id_inscripcion', '=', 'inscripcion.id_inscripcion')
            ->join('persona', 'inscripcion.id_persona', '=', 'persona.id_persona')
            ->join('programa_proceso', 'inscripcion.id_programa_proceso', '=', 'programa_proceso.id_programa_proceso')
            ->join('programa_plan', 'programa_proceso.id_programa_plan', '=', 'programa_plan.id_programa_plan')
            ->join('programa', 'programa_plan.id_programa', '=', 'programa.id_programa')
            ->join('facultad', 'programa.id_facultad', '=', 'facultad.id_facultad')
            ->where('programa.id_programa', $id_programa)
            ->where('programa_proceso.id_admision', $id_admision)
            ->where('inscripcion.inscripcion_estado', 1)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->where('inscripcion.es_traslado_externo', 1)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();

        $facultad = Programa::join('facultad', 'programa.id_facultad', '=', 'facultad.id_facultad')
            ->where('programa.id_programa', $id_programa)
            ->first()->facultad;

        $fecha = date('Y-m-d');
        $fecha2 = date('dmY');

        $trabajador = TrabajadorTipoTrabajador::where('id_trabajador_tipo_trabajador', auth('usuario')->user()->id_trabajador_tipo_trabajador)
            ->first()
            ->trabajador;

        $coordinador = $trabajador->trabajador_apellido . ', ' . $trabajador->trabajador_nombre;

        $programa = Programa::where('id_programa', $id_programa)->first();
        $mencion = $programa->mencion ? ucwords(strtolower($programa->mencion)) : null;
        $doctorado = ucwords(strtolower($programa->subprograma));

        $admision = Admision::where('id_admision', $id_admision)->first();
        $admision = ucwords(strtolower($admision->admision));

        $modalidad = Modalidad::where('id_modalidad', $programa->id_modalidad)->first();
        $modalidad = ucwords(strtolower($modalidad->modalidad));

        $data = [
            'evaluaciones' => $evaluaciones,
            'evaluaciones_trasalados_externos' => $evaluaciones_trasalados_externos,
            'facultad' => $facultad,
            'fecha' => $fecha,
            'coordinador' => $coordinador,
            'programa' => $programa,
            'admision' => $admision,
            'mencion' => $mencion,
            'doctorado' => $doctorado,
            'modalidad' => $modalidad
        ];

        $pdf = Pdf::loadView('modulo-coordinador.reporte-acta-evaluacion.reporte-evaluacion-doctorado', $data);

        return $pdf->stream('acta-evaluacion-doctorado-' . $fecha2 . '.pdf');
    }

    public function docentes()
    {
        return view('modulo-coordinador.gestion-docentes.index');
    }

    public function cursos()
    {
        return view('modulo-coordinador.gestion-cursos.index');
    }

    public function equivalencias_cursos()
    {
        return view('modulo-coordinador.gestion-cursos.equivalencia');
    }

    public function reporte_pagos()
    {
        return view('modulo-coordinador.reporte-pagos.index');
    }

    public function reporte_programas($id_programa_proceso)
    {
        return view('modulo-coordinador.reporte-pagos.reporte-programa', [
            'id_programa_proceso' => $id_programa_proceso
        ]);
    }

    public function reporte_programas_grupos($id_programa_proceso, $id_grupo)
    {
        return view('modulo-coordinador.reporte-pagos.reporte-programa-grupos', [
            'id_programa_proceso' => $id_programa_proceso,
            'id_grupo' => $id_grupo
        ]);
    }

    public function matriculas()
    {
        return view('modulo-coordinador.gestion-matriculas.index');
    }

    public function reingreso_individual()
    {
        return view('modulo-administrador.gestion-reingreso.individual.index');
    }

    public function reingreso_masivo()
    {
        return view('modulo-administrador.gestion-reingreso.masivo.index');
    }

    public function retiro()
    {
        return view('modulo-administrador.gestion-retiro.index');
    }
}
