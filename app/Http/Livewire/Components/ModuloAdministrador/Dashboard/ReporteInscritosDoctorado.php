<?php

namespace App\Http\Livewire\Components\ModuloAdministrador\Dashboard;

use App\Models\Admision;
use App\Models\Inscripcion;
use Livewire\Component;

class ReporteInscritosDoctorado extends Component
{
    public $admision;

    public $programas_doctorado;

    protected $listeners = ['filtro_aplicado_maestria' => 'filtro_aplicado'];

    public function render()
    {
        return view('livewire.components.modulo-administrador.dashboard.reporte-inscritos-doctorado');
    }

    public function filtro_aplicado($filtro_proceso_data)
    {
        $this->admision = Admision::find($filtro_proceso_data);
        $this->programas_doctorado = Inscripcion::join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'inscripcion.id_programa_proceso')
            ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
            ->join('programa','programa_plan.id_programa','=','programa.id_programa')
            ->select('programa.subprograma', 'programa.mencion', 'programa.programa', Inscripcion::raw('count(inscripcion.id_programa_proceso) as cantidad'), Inscripcion::raw('sum(case when inscripcion.inscripcion_estado = 1 then 1 else 0 end) as verificados'))
            ->where('programa.programa_estado',1)
            ->where('programa.programa_tipo',2) // 1 = Doctorado
            ->where('programa_proceso.id_admision', $filtro_proceso_data)
            ->where('inscripcion.retiro_inscripcion', 0)
            ->groupBy('inscripcion.id_programa_proceso')
            ->orderBy(Inscripcion::raw('count(inscripcion.id_programa_proceso)'), 'desc')
            ->get();
    }
}
