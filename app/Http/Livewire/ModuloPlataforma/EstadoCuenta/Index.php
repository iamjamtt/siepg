<?php

namespace App\Http\Livewire\ModuloPlataforma\EstadoCuenta;

use App\Models\Admitido;
use App\Models\CostoEnseñanza;
use App\Models\Matricula;
use App\Models\MatriculaCurso;
use App\Models\Mensualidad;
use App\Models\Persona;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $usuario;
    public $persona;
    public $admitido;

    // opciones de busqueda
    public $search = '';

    // opciones de filtro
    public $filtro_matricula;
    public $data_matricula;
    public $costo_enseñanza;
    public $creditos_totales = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'filtro_matricula' => ['except' => '', 'as' => 'fm'],
        'data_matricula' => ['except' => '', 'as' => 'dm'],
    ];

    public function mount()
    {
        $this->usuario = auth('plataforma')->user();
        $this->persona = Persona::where('id_persona', $this->usuario->id_persona)->first();
        $this->admitido = Admitido::where('id_persona', $this->persona->id_persona)->orderBy('id_admitido', 'desc')->first();
        if ( $this->admitido == null )
        {
            abort(403);
        }
        // buscar ultima matricula
        $ultima_matricula = Matricula::where('id_admitido', $this->admitido->id_admitido)->where('matricula_estado', 1)->orderBy('id_matricula', 'desc')->first();

        // asuganamos la ultima matricula al filtro
        $this->filtro_matricula = $ultima_matricula ? $ultima_matricula->id_matricula : null;
        $this->data_matricula = $this->filtro_matricula;

        // buscar cursos de la ultima matricula
        $cursos = $ultima_matricula ?
            MatriculaCurso::join('curso_programa_plan', 'matricula_curso.id_curso_programa_plan', '=', 'curso_programa_plan.id_curso_programa_plan')
                                ->join('curso', 'curso_programa_plan.id_curso', '=', 'curso.id_curso')
                                ->where('matricula_curso.id_matricula', $ultima_matricula->id_matricula)
                                ->get() :
            collect([]);

        // sumar creditos de los cursos
        foreach($cursos as $curso)
        {
            $this->creditos_totales += $curso->curso_credito;
        }

        // buscamos el plan del admitido
        $plan_admitido = $this->admitido->programa_proceso->programa_plan->plan;

        // buscamos el costo de enseñanza del plan del admitido
        $this->costo_enseñanza = CostoEnseñanza::where('id_plan', $plan_admitido->id_plan)->where('programa_tipo', $this->admitido->programa_proceso->programa_plan->programa->programa_tipo)->first();
        // dd($this->costo_enseñanza);
    }

    public function aplicar_filtro()
    {
        $this->data_matricula = $this->filtro_matricula;
    }

    public function resetear_filtro()
    {
        $this->reset([
            'filtro_matricula',
            'data_matricula'
        ]);
        // buscar ultima matricula
        $ultima_matricula = Matricula::where('id_admitido', $this->admitido->id_admitido)->where('matricula_estado', 1)->orderBy('id_matricula', 'desc')->first();

        // asuganamos la ultima matricula al filtro
        $this->filtro_matricula = $ultima_matricula ? $ultima_matricula->id_matricula : null;
        $this->data_matricula = $this->filtro_matricula;

        $this->render();
    }

    public function render()
    {
        $id_matricula = $this->data_matricula;

        $mensualidades = Mensualidad::query()
            ->with([
                'matricula',
                'pago'
            ])
            ->where('id_admitido', $this->admitido->id_admitido)
            ->where('id_matricula', $id_matricula)
            ->orderBy('id_mensualidad', 'asc')
            ->paginate(10);

        $monto_total = calcularMontoTotalCostoPorEnsenhanzaEstudiante($this->admitido->id_admitido);
        $monto_pagado = calcularMontoPagadoCostoPorEnsenhanzaEstudiante($this->admitido->id_admitido);

        $deuda = $monto_total - $monto_pagado;

        // buscar matriculas del admitido
        $matriculas = Matricula::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_matricula', 'asc')->get();

        return view('livewire.modulo-plataforma.estado-cuenta.index', [
            'mensualidades' => $mensualidades,
            'monto_total' => $monto_total,
            'monto_pagado' => $monto_pagado,
            'deuda' => $deuda,
            'matriculas' => $matriculas
        ]);
    }
}
