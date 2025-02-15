<?php

namespace App\Http\Livewire\ModuloCoordinador\ReportePagos;

use App\Models\Admision;
use App\Models\Coordinador;
use App\Models\Modalidad;
use App\Models\ProgramaProceso;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $coordinador;

    // variables del modal
    public $title_modal = 'Buscar Programa Académico';
    public $programas;
    public $admision;
    public $filtro_modalidad;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function mount()
    {
        $usuario = auth('usuario')->user();
        $trabajador_tipo_trabajador = $usuario->trabajador_tipo_trabajador;
        $trabajador = $trabajador_tipo_trabajador->trabajador;
        $this->coordinador = Coordinador::where('id_trabajador', $trabajador->id_trabajador)->first();

        $this->programas = collect();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFiltroModalidad()
    {
        $this->buscar_programa($this->admision);
    }

    public function buscar_programa(Admision $admision)
    {
        $this->title_modal = 'Buscar Programa Académico - Proceso ' . $admision->admision_año;
        $this->admision = $admision;
        $this->programas = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
            ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
            ->join('modalidad', 'modalidad.id_modalidad', '=', 'programa.id_modalidad')
            ->where('programa_proceso.id_admision', $admision->id_admision)
            ->where('programa.id_facultad', $this->coordinador->id_facultad)
            ->where('programa.id_modalidad', $this->filtro_modalidad ? '=' : '!=', $this->filtro_modalidad)
            ->get();
    }

    public function limpiar_modal()
    {
        $this->reset(
            [
                'admision'
            ]
        );
    }

    public function render()
    {
        $procesos = Admision::query()
            ->where(function ($query) {
                $query->where('admision_año', 'like', '%'.$this->search.'%');
            })
            ->orderBy('admision_año', 'desc')
            // ->where('admision_estado', 1)
            ->paginate(6); // Obtener todos los procesos de admision

        $modalidades = Modalidad::where('modalidad_estado', 1)->get(); // Obtener todas las modalidades

        return view('livewire.modulo-coordinador.reporte-pagos.index', [
            'procesos' => $procesos,
            'modalidades' => $modalidades
        ]);
    }
}
