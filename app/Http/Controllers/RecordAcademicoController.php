<?php

namespace App\Http\Controllers;

use App\Models\Admitido;
use App\Models\Ciclo;
use App\Models\Matricula\Matricula;
use App\Models\Persona;
use App\Models\Plan;
use App\Models\ProgramaProceso;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RecordAcademicoController extends Controller
{
    public function index()
    {
        return view('modulo-record.inicio.index');
    }

    public function buscar(Request $request, Admitido $admitido)
    {
        if ($admitido == null) {
            abort(404);
        }

        $persona = Persona::find($admitido->id_persona);

        $programa = ProgramaProceso::query()
            ->join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
            ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
            ->where('programa_proceso.id_programa_proceso', $admitido->id_programa_proceso)
            ->first();

        $plan = Plan::query()
            ->where('id_plan', $programa->id_plan)
            ->first();

        $ciclos = Ciclo::query()
            ->where(function ($query) use ($programa){
                $query->where('ciclo_programa', 0)
                    ->orWhere('ciclo_programa', $programa->programa_tipo);
            })->orderBy('id_ciclo', 'asc')
            ->get();

        $ultima_matricula = Matricula::query()
            ->where('id_admitido', $admitido->id_admitido)
            ->orderBy('id_matricula', 'desc')
            ->first();

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

        return $pdf->stream('record-academico.pdf');
    }
}
