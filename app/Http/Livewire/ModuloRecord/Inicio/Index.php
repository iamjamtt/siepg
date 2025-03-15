<?php

namespace App\Http\Livewire\ModuloRecord\Inicio;

use App\Models\Admitido;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $buscar = '';

    protected $queryString = [
        'buscar' => ['except' => ''],
    ];

    public $mostrarAlumnos = false;

    public function render()
    {
        if ($this->mostrarAlumnos) {
            $buscar = $this->buscar;
            $alumnos = Admitido::query()
                ->join('persona', 'persona.id_persona', '=', 'admitido.id_persona')
                ->join('programa_proceso', 'programa_proceso.id_programa_proceso', '=', 'admitido.id_programa_proceso')
                ->join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
                ->where(function ($query) use ($buscar) {
                    $query->where('persona.nombre_completo', 'like', '%' . $buscar . '%')
                        ->orWhere('persona.numero_documento', 'like', '%' . $buscar . '%')
                        ->orWhere('admitido.admitido_codigo', 'like', '%' . $buscar . '%');
                })
                ->where('admitido.admitido_estado', 1)
                ->orderBy('persona.nombre_completo')
                ->paginate(10);
        } else {
            $alumnos = collect();
        }

        return view('livewire.modulo-record.inicio.index', [
            'alumnos' => $alumnos
        ]);
    }

    public function mount()
    {
        $this->buscar = request()->get('buscar');

        if($this->buscar != '')
        {
            $this->buscarAlumno();
        }
    }


    public function buscarAlumno(): void
    {
        if ($this->buscar == '') {
            $this->mostrarAlumnos = false;
        } else {
            $this->mostrarAlumnos = true;
        }

        $this->resetPage();
    }
}
