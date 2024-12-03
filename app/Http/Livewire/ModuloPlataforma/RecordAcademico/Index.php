<?php

namespace App\Http\Livewire\ModuloPlataforma\RecordAcademico;

use App\Models\Admitido;
use App\Models\Ciclo;
use App\Models\Matricula;
use App\Models\Persona;
use App\Models\ProgramaProceso;
use Livewire\Component;

class Index extends Component
{
    public $persona; // persona del usuario logueado
    public $admitido; // admitido del usuario logueado
    public $programa; // programa del usuario logueado
    public $ciclos; // ciclos del usuario logueado
    public $ultima_matricula; // ultima matricula del usuario logueado

    public function mount()
    {
        $this->persona = Persona::where('id_persona', auth('plataforma')->user()->id_persona)->first(); // persona del usuario logueado
        $this->admitido = Admitido::where('id_persona', $this->persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // admitido del usuario logueado
        if ($this->admitido == null) {
            abort(403, 'No se encontro el registro del admitido');
        }
        $this->programa = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
            ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
            ->where('programa_proceso.id_programa_proceso', $this->admitido->id_programa_proceso)
            ->first(); // programa del usuario logueado
        $this->ciclos = Ciclo::where(function ($query) {
                $query->where('ciclo_programa', 0)
                    ->orWhere('ciclo_programa', $this->programa->programa_tipo);
            })->orderBy('id_ciclo', 'asc')->get(); // ciclos del usuario logueado
        $this->ultima_matricula = $this->admitido->ultimaMatriculaNuevo; // ultima matricula del usuario logueado
    }

    public function render()
    {
        return view('livewire.modulo-plataforma.record-academico.index');
    }
}
