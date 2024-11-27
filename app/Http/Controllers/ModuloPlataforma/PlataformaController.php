<?php

namespace App\Http\Controllers\ModuloPlataforma;

use App\Models\Pago;
use App\Models\Plan;
use App\Models\Ciclo;
use App\Models\Persona;
use App\Models\Admitido;
use App\Models\Matricula;
use App\Models\Matricula\Matricula as ModelMatricula;
use App\Models\Mensualidad;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CostoEnseñanza;
use App\Models\MatriculaCurso;
use App\Models\ProgramaProceso;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

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

    public function comprobante($id_pago)
    {
        // retornar un pdf de comprobante de pago
        $pago = Pago::where('id_pago', $id_pago)->first();
        if ($pago == null) {
            abort(403, 'No se encontro el registro del pago');
        }
        $persona = $pago->persona;
        $concepto_pago = $pago->concepto_pago;
        $canal_pago = $pago->canal_pago;

        if (auth('plataforma')->user()->id_persona != $persona->id_persona) {
            abort(403, 'Acceso no autorizado');
        }

        $admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // admitido del usuario logueado
        $admitido = $admitido ? true : false;

        $data = [
            'pago' => $pago,
            'persona' => $persona,
            'concepto_pago' => $concepto_pago,
            'canal_pago' => $canal_pago,
            'admitido' => $admitido,
        ];

        $pdf = Pdf::loadView('modulo-plataforma.pagos.comprobante', $data);
        $pdf->setPaper('a5', 'landscape'); // 'a6', 'landscape' | 'a6', 'portrait

        return $pdf->stream('comprobante-pago.pdf');
    }

    public function estado_cuenta()
    {
        return view('modulo-plataforma.estado-cuenta.index');
    }

    public function estado_cuenta_ficha($id_admitido)
    {
        $persona = Persona::where('id_persona', auth('plataforma')->user()->id_persona)->first(); // persona del usuario logueado
        $admitido_logueado = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // admitido del usuario logueado
        $admitido = Admitido::where('id_admitido', $id_admitido)->first(); // usuario logueado
        if ($admitido == null) {
            abort(403, 'No se encontro el registro del admitido');
        }
        if ($admitido_logueado->id_admitido != $admitido->id_admitido) {
            abort(403, 'No se encontro el registro del admitido');
        }
        $ultima_matricula = Matricula::where('id_admitido', $admitido->id_admitido)->orderBy('id_matricula', 'desc')->first(); // ultima matricula del usuario logueado
        $matriculas = Matricula::where('id_admitido', $admitido->id_admitido)->orderBy('id_matricula', 'desc')->get(); // matriculas del usuario logueado

        $costo_enseñanza = CostoEnseñanza::where('id_plan', $admitido->programa_proceso->programa_plan->id_plan)
            ->where('programa_tipo', $admitido->programa_proceso->programa_plan->programa->programa_tipo)
            ->first(); // costo de enseñanza del plan de la ultima matricula del usuario logueado

        $cursos_ultima_matricula = MatriculaCurso::join('curso_programa_plan', 'curso_programa_plan.id_curso_programa_plan', 'matricula_curso.id_curso_programa_plan')
            ->join('curso', 'curso.id_curso', 'curso_programa_plan.id_curso')
            ->where('matricula_curso.id_matricula', $ultima_matricula->id_matricula)
            ->orderBy('curso.id_curso', 'asc')
            ->get(); // cursos de la ultima matricula del usuario logueado

        $mensualidades_ultima_matricula = Mensualidad::where('id_matricula', $ultima_matricula->id_matricula)->orderBy('id_mensualidad', 'asc')->get(); // mensualidades de la ultima matricula del usuario logueado

        $creditos_totales = 0;
        $deuda = 0;
        $monto_total_pagado = 0;
        foreach ($cursos_ultima_matricula as $curso) {
            $creditos_totales += $curso->curso_credito;
        }
        $monto_total = $costo_enseñanza->costo_credito * $creditos_totales;

        foreach ($mensualidades_ultima_matricula as $mensualidad) {
            $monto_total_pagado += $mensualidad->pago->pago_verificacion == 2 ? $mensualidad->pago->pago_monto : 0;
        }

        $deuda = $monto_total - $monto_total_pagado;

        $programa = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
            ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
            ->where('programa_proceso.id_programa_proceso', $admitido->id_programa_proceso)
            ->first(); // programa del usuario logueado

        if ( $programa->programa_tipo == 1 ){
            $color = '#ebf9ff';
        } else {
            $color = '#ffebeb';
        }

        $data = [
            'admitido' => $admitido,
            'programa' => $programa,
            'ultima_matricula' => $ultima_matricula,
            'monto_total' => $monto_total,
            'monto_total_pagado' => $monto_total_pagado,
            'deuda' => $deuda,
            'matriculas' => $matriculas,
            'color' => $color,
        ];

        $pdf = Pdf::loadView('modulo-plataforma.estado-cuenta.pdf', $data);

        $slug_nombre = Str::slug($admitido->persona->nombre_completo, '-');

        return $pdf->download('estado-cuenta-'. $slug_nombre .'.pdf');
    }

    public function constancia()
    {
        return view('modulo-plataforma.constancia-ingreso.index');
    }

    public function matriculas()
    {
        return view('modulo-plataforma.matriculas.index');
    }

    public function record_academico()
    {
        return view('modulo-plataforma.record-academico.index');
    }

    public function record_academico_ficha($id_admitido)
    {
        $persona = Persona::where('id_persona', auth('plataforma')->user()->id_persona)->first(); // persona del usuario logueado
        $admitido_logueado = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // admitido del usuario logueado
        $admitido = Admitido::where('id_admitido', $id_admitido)->first(); // usuario logueado
        if ($admitido == null) {
            abort(403, 'No se encontro el registro del admitido');
        }
        if ($admitido_logueado->id_admitido != $admitido->id_admitido) {
            abort(403, 'No se encontro el registro del admitido');
        }
        $programa = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
            ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
            ->where('programa_proceso.id_programa_proceso', $admitido->id_programa_proceso)
            ->first(); // programa del usuario logueado
        $plan = Plan::where('id_plan', $programa->id_plan)->first();
        $ciclos = Ciclo::where(function ($query) use ($programa){
                $query->where('ciclo_programa', 0)
                    ->orWhere('ciclo_programa', $programa->programa_tipo);
            })->orderBy('id_ciclo', 'asc')
            ->get(); // ciclos del usuario logueado
        $ultima_matricula = Matricula::where('id_admitido', $admitido->id_admitido)->orderBy('id_matricula', 'desc')->first(); // ultima matricula del usuario logueado
        if ( $programa->programa_tipo == 1 ){
            $color = '#ebf9ff';
        } else {
            $color = '#ffebeb';
        }

        $data = [
            'admitido' => $admitido,
            'programa' => $programa,
            'plan' => $plan,
            'ciclos' => $ciclos,
            'ultima_matricula' => $ultima_matricula,
            'color' => $color,
        ];

        $pdf = Pdf::loadView('modulo-plataforma.record-academico.record-academico', $data);

        return $pdf->download('record-academico.pdf');
    }

    public function evaluacion_docente()
    {
        return view('modulo-plataforma.evaluacion-docente.index');
    }

    public function fichaMatricula($id_matricula)
    {
        // buscamos la matricula
        $matricula = ModelMatricula::query()
            ->with('admitido', 'pago', 'cursos')
            ->where('id_matricula', $id_matricula)
            ->first();

        if (!$matricula) {
            abort(404, 'No se encontro el registro de la matricula');
        }

        $admitido = $matricula->admitido;

        if (auth('plataforma')->user()->id_persona != $admitido->id_persona) {
            abort(403, 'Acceso no autorizado');
        }

        $pago = $matricula->pago;

        if (!$pago) {
            abort(403, 'No se encontro el registro del pago');
        }

        $cursos = $matricula->cursos()
            ->with('programaProcesoGrupo')
            ->get();

        $programa = null;
        $subprograma = null;
        $mencion = null;
        if ($admitido->programa_proceso->programa_plan->programa->mencion == null) {
            $programa = $admitido->programa_proceso->programa_plan->programa->programa;
            $subprograma = $admitido->programa_proceso->programa_plan->programa->subprograma;
            $mencion = null;
        } else {
            $programa = $admitido->programa_proceso->programa_plan->programa->programa;
            $subprograma = $admitido->programa_proceso->programa_plan->programa->subprograma;
            $mencion = $admitido->programa_proceso->programa_plan->programa->mencion;
        }
        $fecha = date('d/m/Y', strtotime($pago->pago_fecha));
        $numero_operacion = $pago->pago_operacion;
        $plan = $admitido->programa_proceso->programa_plan->plan->plan;
        $codigo = $admitido->admitido_codigo;
        $nombre = $admitido->persona->nombre_completo;
        $domicilio = $admitido->persona->direccion;
        $celular = $admitido->persona->celular;
        $grupo = obtenerGrupoDeMatricula($matricula->id_matricula);
        $admision = $admitido->programa_proceso->admision->admision;
        $modalidad = $admitido->programa_proceso->programa_plan->programa->id_modalidad == 1 ? 'PRESENCIAL' : 'DISTANCIA';
        $data = [
            'programa' => $programa,
            'subprograma' => $subprograma,
            'mencion' => $mencion,
            'fecha' => $fecha,
            'numero_operacion' => $numero_operacion,
            'plan' => $plan,
            'codigo' => $codigo,
            'nombre' => $nombre,
            'domicilio' => $domicilio,
            'celular' => $celular,
            'cursos' => $cursos,
            'grupo' => $grupo,
            'admision' => $admision,
            'modalidad' => $modalidad,
            'matricula' => $matricula,
        ];

        // Generar el PDF
        $matriciculaPdf = Pdf::loadView('modulo-plataforma.matriculas.ficha-matricula', $data)
            ->setPaper('a4', 'portrait')
            ->stream('ficha-matricula.pdf');

        return $matriciculaPdf;
    }
}
