<?php

namespace App\Http\Livewire\ModuloAdministrador\Dashboard;

use App\Exports\reporte\moduloAdministrador\matriculados\listaGruposExport;
use App\Models\Admision;
use App\Models\Admitido;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Pago;
use App\Models\ProgramaProceso;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use NumberFormatter;

class Index extends Component
{

    public $admisiones, $admision; // variable para almacenar las admisiones y filtrar
    public $filtro_proceso; // variable para filtrar por proceso de admision
    public $ingreso_total, $ingreso_inscripcion, $ingreso_constancia, $ingreso_matricula; // variables para los totales
    public $ingreso_por_dia_total, $ingreso_por_dia_inscripcion, $ingreso_por_dia_constancia, $ingreso_por_dia_matricula; // Variables para las cantidades diarias
    public $ingreso_costo_enseñanza, $ingreso_por_dia_costo_enseñanza;
    public $programas_maestria, $programas_doctorado; // variables para almacenar los programas
    public $matriculados_programas; // variables para almacenar los matriculados
    public $proceso, $programa;

    public function mount()
    {
        $this->admisiones = Admision::query()
            ->orderBy('admision_año', 'desc')
            ->get();
        $admision = Admision::where('admision_estado', 1)->first();
        $this->filtro_proceso = $admision->id_admision;
        $this->admision = Admision::where('id_admision', $this->filtro_proceso)->first();

        $this->ingreso_total = Pago::where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->sum('pago_monto');

        // Se calcula el ingreso por concepto de constancias
        $this->ingreso_constancia = Pago::where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->where('id_concepto_pago', 2)
            ->sum('pago_monto');
        $ingreso_constancia_matricula = Pago::where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->where('id_concepto_pago',4)
            ->get();
        $ingreso_constancia_matricula_extemporanea = Pago::where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->where('id_concepto_pago',6)
            ->get();
        $sum_constancia_matricula = $ingreso_constancia_matricula->sum('pago_monto');
        $count_constancia_matricula = $ingreso_constancia_matricula->count();
        $diferencia_constancia_matricula = $sum_constancia_matricula - ($count_constancia_matricula * 150);
        $sum_constancia_matricula_extemporanea = $ingreso_constancia_matricula_extemporanea->sum('pago_monto');
        $count_constancia_matricula_extemporanea = $ingreso_constancia_matricula_extemporanea->count();
        $diferencia_constancia_matricula_extemporanea = $sum_constancia_matricula_extemporanea - ($count_constancia_matricula_extemporanea * 200);
        $this->ingreso_constancia = $this->ingreso_constancia + $diferencia_constancia_matricula + $diferencia_constancia_matricula_extemporanea;

        // Se calcula el ingreso por concepto de matriculas
        $this->ingreso_matricula = Pago::where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->where(function($query){
                $query->where('id_concepto_pago', 3)
                    ->orWhere('id_concepto_pago', 5);
            })
            ->sum('pago_monto');
        $diferencia_matricula_constancia = $sum_constancia_matricula - ($count_constancia_matricula * 30);
        $diferencia_matricula_constancia_extemporanea = $sum_constancia_matricula_extemporanea - ($count_constancia_matricula_extemporanea * 30);
        $this->ingreso_matricula = $this->ingreso_matricula + $diferencia_matricula_constancia + $diferencia_matricula_constancia_extemporanea;

        $this->ingreso_inscripcion = Inscripcion::join('pago', 'pago.id_pago', '=', 'inscripcion.id_pago')
            ->join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
            ->where('programa_proceso.id_admision', $this->filtro_proceso)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->where('pago.pago_estado', 2)
            ->where('pago.pago_verificacion', 2)
            ->sum('pago.pago_monto');

        $this->ingreso_por_dia_total = Pago::whereDate('pago_fecha', Carbon::today())
            ->where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->sum('pago_monto');
        $this->ingreso_por_dia_constancia = Pago::where('id_concepto_pago', 2)
            ->whereDate('pago_fecha', Carbon::today())
            ->where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->sum('pago_monto');
        $this->ingreso_por_dia_inscripcion = Pago::where('id_concepto_pago', 1)
            ->whereDate('pago_fecha', Carbon::today())
            ->where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->sum('pago_monto');

        // Se calcula el ingreso por concepto de costos de enseñanza
        $this->ingreso_costo_enseñanza = Pago::where('id_concepto_pago', 7)
            ->where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->sum('pago_monto');
        $this->ingreso_por_dia_costo_enseñanza = Pago::where('id_concepto_pago', 7)
            ->whereDate('pago_fecha', Carbon::today())
            ->where('pago_estado', 2)
            ->where('pago_verificacion', 2)
            ->sum('pago_monto');

        $this->programas_maestria = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
            ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
            ->join('programa','programa_plan.id_programa','=','programa.id_programa')
            ->select('programa.subprograma', 'programa.mencion', 'programa.programa', Inscripcion::raw('count(inscripcion.id_programa_proceso) as cantidad'), Inscripcion::raw('sum(case when inscripcion.inscripcion_estado = 1 then 1 else 0 end) as verificados'))
            ->where('programa.programa_estado',1)
            ->where('programa.programa_tipo',1) // 1 = Maestria
            ->where('programa_proceso.id_admision', $this->filtro_proceso)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->groupBy('inscripcion.id_programa_proceso')
            ->orderBy(Inscripcion::raw('count(inscripcion.id_programa_proceso)'), 'desc')
            ->get();
        $this->programas_doctorado = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
            ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
            ->join('programa','programa_plan.id_programa','=','programa.id_programa')
            ->select('programa.subprograma', 'programa.mencion', 'programa.programa', Inscripcion::raw('count(inscripcion.id_programa_proceso) as cantidad'), Inscripcion::raw('sum(case when inscripcion.inscripcion_estado = 1 then 1 else 0 end) as verificados'))
            ->where('programa.programa_estado',1)
            ->where('programa.programa_tipo',2) // 1 = Doctorado
            ->where('programa_proceso.id_admision', $this->filtro_proceso)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->groupBy('inscripcion.id_programa_proceso')
            ->orderBy(Inscripcion::raw('count(inscripcion.id_programa_proceso)'), 'desc')
            ->get();

        $this->matriculados_programas = Admitido::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'admitido.id_programa_proceso')
            ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
            ->join('programa','programa_plan.id_programa','=','programa.id_programa')
            ->select('admitido.id_programa_proceso', 'programa.subprograma', 'programa.mencion', 'programa.programa', Admitido::raw('count(admitido.id_programa_proceso) as cantidad'),)
            ->where('programa.programa_estado',1)
            ->where('programa_proceso.id_admision', $this->filtro_proceso)
            ->where('admitido.admitido_estado', 1)
            ->groupBy('admitido.id_programa_proceso')
            ->orderBy(Admitido::raw('count(admitido.id_programa_proceso)'), 'desc')
            ->get();

        $this->ingreso_total = $this->ingreso_constancia + $this->ingreso_matricula + $this->ingreso_inscripcion + $this->ingreso_costo_enseñanza;
    }

    public function aplicar_filtro()
    {
        if($this->filtro_proceso == null || $this->filtro_proceso == "")
        {
            $this->mount();
        }
        else
        {
            $this->admision = Admision::where('id_admision', $this->filtro_proceso)->first();
            $this->ingreso_inscripcion = Inscripcion::join('pago', 'pago.id_pago', '=', 'inscripcion.id_pago')
                                        ->join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
                                        ->where('programa_proceso.id_admision', $this->filtro_proceso)
                                        ->sum('pago.pago_monto');
            $this->programas_maestria = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
                ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa','programa_plan.id_programa','=','programa.id_programa')
                ->select('programa.subprograma', 'programa.mencion', 'programa.programa', Inscripcion::raw('count(inscripcion.id_programa_proceso) as cantidad'), Inscripcion::raw('sum(case when inscripcion.inscripcion_estado = 1 then 1 else 0 end as verificados'))
                ->where('programa.programa_estado',1)
                ->where('programa.programa_tipo',1) // 1 = Maestria
                ->where('programa_proceso.id_admision', $this->filtro_proceso)
                ->where('inscripcion.retiro_inscripcion', 0)
                ->groupBy('inscripcion.id_programa_proceso')
                ->orderBy(Inscripcion::raw('count(inscripcion.id_programa_proceso)'), 'DESC')
                ->get();
            $this->programas_doctorado = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
                ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa','programa_plan.id_programa','=','programa.id_programa')
                ->select('programa.subprograma', 'programa.mencion', 'programa.programa', Inscripcion::raw('count(inscripcion.id_programa_proceso) as cantidad'), Inscripcion::raw('sum(case when inscripcion.inscripcion_estado = 1 then 1 else 0 end) as verificados'))
                ->where('programa.programa_estado',1)
                ->where('programa.programa_tipo',2) // 1 = Doctorado
                ->where('programa_proceso.id_admision', $this->filtro_proceso)
                ->where('inscripcion.retiro_inscripcion', 0)
                ->groupBy('inscripcion.id_programa_proceso')
                ->orderBy(Inscripcion::raw('count(inscripcion.id_programa_proceso)'), 'DESC')
                ->get();
        }
    }

    public function resetear_filtro()
    {
        $this->mount();
    }

    public function updatedProceso()
    {
        $this->programa = null;
    }

    public function limpiar()
    {
        $this->reset([
            'proceso',
            'programa'
        ]);
    }

    public function descargar_reporte_matriculados()
    {
        $this->validate([
            'proceso' => 'required',
            'programa' => 'required'
        ]);
        // verificamos si el programa tiene matriculados
        $matriculados = Matricula::join('admitido', 'matricula.id_admitido', '=', 'admitido.id_admitido')
            ->join('programa_proceso', 'admitido.id_programa_proceso', '=', 'programa_proceso.id_programa_proceso')
            ->join('programa_plan', 'programa_proceso.id_programa_plan', '=', 'programa_plan.id_programa_plan')
            ->join('programa', 'programa_plan.id_programa', '=', 'programa.id_programa')
            ->where('admitido.id_programa_proceso', $this->programa)
            ->get();
        if ($matriculados->count() == 0) {
            $this->dispatchBrowserEvent('alerta-usuario', [
                'title' => 'No hay matriculados',
                'text' => 'El programa seleccionado no tiene matriculados registrados',
                'icon' => 'warning',
                'confirmButtonText' => 'Aceptar',
                'color' => 'warning'
            ]);
            return;
        }
        $nombre = Str::slug('Reporte de Matriculados ' . $this->programa, '-');
        $this->dispatchBrowserEvent('modal', [
            'id' => '#modal-reporte-matriculados',
            'action' => 'hide'
        ]);
        $id_programa = $this->programa;
        $this->limpiar();
        return Excel::download(new listaGruposExport($id_programa), $nombre . '.xlsx');
    }

    public function render()
    {
        if ($this->proceso) {
            $programas = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
                ->where('programa_proceso.id_admision', $this->proceso)
                ->where('programa.id_modalidad', 2)
                ->get();
        } else {
            $programas = collect();
        }

        return view('livewire.modulo-administrador.dashboard.index', [
            'programas' => $programas
        ]);
    }
}
