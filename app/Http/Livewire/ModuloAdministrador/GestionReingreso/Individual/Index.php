<?php

namespace App\Http\Livewire\ModuloAdministrador\GestionReingreso\Individual;

use App\Models\Admitido;
use App\Models\CursoProgramaPlan;
use App\Models\Matricula;
use App\Models\Matricula\Matricula as ModelMatricula;
use App\Models\MatriculaCurso;
use App\Models\Matricula\MatriculaCurso as ModelMatriculaCurso;
use App\Models\NotaMatriculaCurso;
use App\Models\ProgramaPlan;
use App\Models\ProgramaProceso;
use App\Models\ProgramaProcesoGrupo;
use App\Models\Reingreso;
use App\Models\Retiro;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; // tema de paginacion

    public $search = ''; // variable para la busqueda

    // variables del model
    public $title_modal = 'Nuevo Reingreso Individual';
    public $paso = 1;
    public $total_paso = 3;
    public $estudiante;
    public $detalle_estudiante;
    public $plan;
    public $proceso;
    public $grupo;
    public $notas = [];
    public $nsp = [];
    public $resolucion;
    public $resolucion_file;

    public array $selects = [];

    protected $queryString = [ // para que la paginacion se mantenga con el buscador
        'search' => ['except' => '', 'as' => 's'],
    ];

    public function updated($propertyName)
    {
        if ($this->paso == 1) {
            $this->validateOnly($propertyName, [
                'estudiante' => 'required',
                'plan' => 'required',
                'proceso' => 'required',
                'grupo' => 'required',
            ]);
        }

        if ($this->paso == 2) {
            $this->validateOnly($propertyName, [
                // 'notas' => 'required|array|min:1',
                'notas.*' => 'nullable|numeric|min:0|max:20',
            ]);
        }

        if ($this->paso == 3) {
            $this->validateOnly($propertyName, [
                'resolucion' => 'required',
                'resolucion_file' => 'nullable|file|mimes:pdf|max:10240',
            ]);
        }

        foreach ($this->notas as $key => $nota) {
            if ($nota == null || $nota == '') {
                // elimianr la nota del array
                unset($this->notas[$key]);
            }
        }
    }

    public function modo()
    {
        $this->limpiar_modal();
        $this->resetErrorBag();
        $this->resetValidation();

        $this->title_modal = 'Nuevo Reingreso Individual';
        $this->paso = 1;
    }

    public function limpiar_modal()
    {
        $this->reset([
            'title_modal',
            'paso',
            'estudiante',
            'detalle_estudiante',
            'plan',
            'proceso',
            'grupo',
            'notas',
            'resolucion',
            'resolucion_file',
        ]);
    }

    public function atras_paso()
    {
        if ($this->paso > 1) {
            $this->paso--;
        }

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function siguiente_paso()
    {
        if ($this->paso == 1) {
            $this->validate([
                'estudiante' => 'required',
                'plan' => 'required',
                'proceso' => 'required',
                'grupo' => 'required',
            ]);
        }

        if ($this->paso == 2) {

            // validamos si el array selects esta vacio
            if (count($this->selects) == 0) {
                $this->dispatchBrowserEvent('alerta-basica', [
                    'title' => '¡Error!',
                    'text' => 'Debe ingresar al menos una nota, para continuar con el proceso de reingreso.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validamos si se selecciono nsp pero sin su fecha de nota
            $hayNsp = false;
            foreach ($this->selects as $key => $item) {
                // verificamos si existe nsp y no tiene fecha de nota en el array
                if (isset($item['nsp']) && $item['nsp'] == $key && !isset($item['fecha_nota'])) {
                    $hayNsp = true;
                    break;
                }
            }
            if ($hayNsp) {
                $this->dispatchBrowserEvent('alerta-basica', [
                    'title' => '¡Error!',
                    'text' => 'Debe ingresar la fecha de la nota de NSP, para continuar con el proceso de reingreso.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            $this->validate([
                'selects.*' => 'required|array|min:1',
                'selects.*.nota' => 'nullable|numeric|min:0|max:20',
                'selects.*.periodo' => 'nullable|string',
                'selects.*.fecha_nota' => 'nullable|date',
                'selects.*.nsp' => 'nullable',
            ]);
        }

        if ($this->paso < $this->total_paso) {
            $this->paso++;
        }

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedEstudiante($id_estudiante)
    {
        $estudiante = Admitido::find($id_estudiante);
        $this->detalle_estudiante = $estudiante;
    }

    public function guardar_reingreso()
    {
        $this->validate([
            'resolucion' => 'required',
            'resolucion_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // generar codigo de reingreso
        $codigo = date('YmdHis');
        $codigo = 'R' . $codigo . 'I';

        // obtener el estudiante
        $estudiante = Admitido::find($this->estudiante);

        // obtener el programa del estudiante
        $programa = ProgramaProceso::join('programa_plan', 'programa_proceso.id_programa_plan', 'programa_plan.id_programa_plan')
                ->join('programa', 'programa_plan.id_programa', 'programa.id_programa')
                ->join('plan', 'programa_plan.id_plan', 'plan.id_plan')
                ->join('admision', 'programa_proceso.id_admision', 'admision.id_admision')
                ->where('programa.programa_tipo', $estudiante->programa_proceso->programa_plan->programa->programa_tipo)
                ->where('programa.id_programa', $estudiante->programa_proceso->programa_plan->programa->id_programa)
                ->where('plan.id_plan', $this->plan)
                ->where('admision.id_admision', $this->proceso)
                ->first();

        // registrar reingreso
        $reingreso = new Reingreso();
        $reingreso->reingreso_codigo = $codigo;
        $reingreso->id_admitido = $estudiante->id_admitido;
        $reingreso->id_programa_proceso = $programa->id_programa_proceso;
        $reingreso->id_programa_proceso_antiguo = $estudiante->id_programa_proceso;
        $reingreso->id_tipo_reingreso = 1; // Individual
        $reingreso->reingreso_resolucion = $this->resolucion;
        if ($this->resolucion_file) {
            $slug_resolucion = Str::slug($this->resolucion);
            $path = 'Posgrado/Reingreso/Resolucion/';
            $filename = 'reingreso-' . $slug_resolucion . '-' . date('YmdHis') . '.pdf';
            $nombre_db = $path.$filename;
            $data = $this->resolucion_file;
            $data->storeAs($path, $filename, 'files_publico');
            $reingreso->reingreso_resolucion_url = $nombre_db;
        }
        $reingreso->reingreso_fecha_creacion = date('Y-m-d H:i:s');
        $reingreso->reingreso_estado = 1; // Pendiente
        $reingreso->save();

        // actualizar programa del admitido (estudiante) y el estado
        $estudiante->id_programa_proceso_antiguo = $estudiante->id_programa_proceso;
        $estudiante->save();
        $estudiante->id_programa_proceso = $programa->id_programa_proceso;
        $estudiante->admitido_estado = 1;  // 1 = admitido normal | 2 = retirado | 0 = desactivado
        $estudiante->save();

        // Desactivar el registro de retirado del alumno que esta reingresando
        $retiro = Retiro::where('id_admitido', $estudiante->id_admitido)->orderBy('id_retiro', 'desc')->first();
        if ($retiro) {
            $retiro->retiro_estado = 0;
            $retiro->save();
        }

        // volvemos a octener el estudiante con su nuevo programa
        $estudiante = Admitido::find($this->estudiante);

        // guardar las notas de los cursos en una matricula cero (0)
        // generar codigo de matricula
        $codigo = 'M' . date('Y') . str_pad(1, 5, "0", STR_PAD_LEFT);

        // obtener el ultimo registro de matricula
        $matricula = ModelMatricula::orderBy('id_matricula', 'desc')->first();

        if ($matricula) {
            $codigo = $matricula->codigo;
            $codigo = substr($codigo, 5);
            $codigo = (int)$codigo + 1;
            $codigo = 'M' . date('Y') . str_pad($codigo, 5, "0", STR_PAD_LEFT);
        } else {
            $codigo = 'M' . date('Y') . str_pad(1, 5, "0", STR_PAD_LEFT);
        }

        $grupo = $this->grupo;

        // obtener ultima matricula del admitido
        $ultimaMatricula = $estudiante->ultimaMatriculaNuevo;
        if ($ultimaMatricula) {
            $grupo = obtenerIdGrupoDeMatricula($ultimaMatricula->id_matricula);
        }

        // registrar matricula
        $matricula = new ModelMatricula();
        $matricula->id_matricula_gestion = null;
        $matricula->id_admitido = $estudiante->id_admitido;
        $matricula->ciclo = 0;
        $matricula->codigo = $codigo;
        $matricula->fecha_matricula = date('Y-m-d');
        $matricula->id_pago = null;
        $matricula->save();

        // registramos los cursos de la matricula
        foreach ($this->selects as $key => $item) {
            // convertimos la nota a float
            $nota = isset($item['nota']) ? (float)$item['nota'] : 0;
            $estado = $nota >= 14 ? 2 : 0;
            if (isset($item['nsp']) && $item['nsp'] == $key) {
                $nota = 0;
                $estado = 3;
            }
            $matriculaCurso = new ModelMatriculaCurso();
            $matriculaCurso->id_matricula = $matricula->id_matricula;
            $matriculaCurso->id_curso_programa_plan = $key;
            $matriculaCurso->id_programa_proceso_grupo = $grupo;
            $matriculaCurso->id_docente = null;
            $matriculaCurso->periodo = isset($item['periodo']) ? $item['periodo'] : calcularPeriodo($matricula->id_matricula);
            $matriculaCurso->nota_promedio_final = $nota;
            $matriculaCurso->fecha_ingreso_nota = date('Y-m-d');
            $matriculaCurso->estado = $estado;
            $matriculaCurso->activo = 0;
            $matriculaCurso->save();
        }

        // cerrar modal
        $this->dispatchBrowserEvent('modal', [
            'modal' => '#modal_reingreso',
            'action' => 'hide',
        ]);

        // emitir evento para mostrar mensaje de confirmacion
        $this->dispatchBrowserEvent('alerta-basica', [
            'title' => '¡Éxito!',
            'text' => 'Reingreso individual registrado correctamente.',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // limpiar variables
        $this->limpiar_modal();
    }

    public function render()
    {
        $reingresos = Reingreso::join('admitido', 'reingreso.id_admitido', 'admitido.id_admitido')
            ->join('persona', 'admitido.id_persona', 'persona.id_persona')
            ->join('programa_proceso', 'admitido.id_programa_proceso', 'programa_proceso.id_programa_proceso')
            ->join('programa_plan', 'programa_proceso.id_programa_plan', 'programa_plan.id_programa_plan')
            ->join('programa', 'programa_plan.id_programa', 'programa.id_programa')
            ->where(function ($query) {
                $query->where('reingreso.reingreso_codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('persona.nombre_completo', 'like', '%' . $this->search . '%');
            })
            ->where('reingreso.id_tipo_reingreso', 1) // Individual
            ->orderBy('id_reingreso', 'desc')
            ->paginate(20);

        $estudiantes = Admitido::join('programa_proceso', 'admitido.id_programa_proceso', 'programa_proceso.id_programa_proceso')
            ->join('programa_plan', 'programa_proceso.id_programa_plan', 'programa_plan.id_programa_plan')
            ->join('programa', 'programa_plan.id_programa', 'programa.id_programa')
            ->join('persona', 'admitido.id_persona', 'persona.id_persona')
            ->where('admitido.admitido_estado', 2)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();

        // obtener planes y proceso
        if ($this->estudiante) {
            $estudiante = Admitido::find($this->estudiante);

            $planes = ProgramaPlan::join('programa', 'programa_plan.id_programa', 'programa.id_programa')
                ->join('plan', 'programa_plan.id_plan', 'plan.id_plan')
                ->orderBy('plan.plan', 'asc')
                ->select('plan.id_plan', 'plan.plan')
                ->distinct()
                ->get();

            if ($this->plan) {
                // if ($this->plan == $estudiante->programa_proceso->programa_plan->id_plan) {
                //     // emitir alerta de que el estudiante no puede reingresar al mismo plan de estudios
                //     $this->dispatchBrowserEvent('alerta-basica', [
                //         'title' => '¡Alerta!',
                //         'text' => 'El estudiante no puede reingresar al mismo plan de estudios',
                //         'icon' => 'warning',
                //         'confirmButtonText' => 'Aceptar',
                //         'color' => 'warning'
                //     ]);
                //     $procesos = collect();
                // } else {
                    $procesos = ProgramaProceso::join('programa_plan', 'programa_proceso.id_programa_plan', 'programa_plan.id_programa_plan')
                        ->join('programa', 'programa_plan.id_programa', 'programa.id_programa')
                        ->join('plan', 'programa_plan.id_plan', 'plan.id_plan')
                        ->join('admision', 'programa_proceso.id_admision', 'admision.id_admision')
                        ->where('programa.programa_tipo', $estudiante->programa_proceso->programa_plan->programa->programa_tipo)
                        ->where('plan.id_plan', $this->plan)
                        ->orderBy('admision.admision', 'asc')
                        ->select('admision.id_admision', 'admision.admision')
                        ->distinct()
                        ->get();
                // }
            } else {
                $procesos = collect();
            }
        } else {
            $planes = collect();
            $procesos = collect();
        }

        // cargar los cursos del nuevo plan de estudios
        if ($this->proceso) {
            $programa = ProgramaProceso::join('programa_plan', 'programa_proceso.id_programa_plan', 'programa_plan.id_programa_plan')
                ->join('programa', 'programa_plan.id_programa', 'programa.id_programa')
                ->join('plan', 'programa_plan.id_plan', 'plan.id_plan')
                ->join('admision', 'programa_proceso.id_admision', 'admision.id_admision')
                ->where('programa.programa_tipo', $estudiante->programa_proceso->programa_plan->programa->programa_tipo)
                ->where('plan.id_plan', $this->plan)
                ->where('admision.id_admision', $this->proceso)
                ->where('programa.id_programa', $estudiante->programa_proceso->programa_plan->programa->id_programa)
                ->first();
            if ($programa) {
                $cursos = CursoProgramaPlan::join('curso', 'curso_programa_plan.id_curso', 'curso.id_curso')
                    ->where('curso_programa_plan.id_programa_plan', $programa->id_programa_plan)
                    ->orderBy('curso.curso_codigo', 'asc')
                    ->orderBy('curso.id_ciclo', 'asc')
                    ->get();
                $ciclos = $cursos->unique('id_ciclo')->pluck('id_ciclo');
                $grupos = ProgramaProcesoGrupo::where('id_programa_proceso', $programa->id_programa_proceso)->get();
            } else {
                $cursos = collect();
                $ciclos = collect();
                $grupos = collect();
            }
        } else {
            $cursos = collect();
            $ciclos = collect();
            $grupos = collect();
        }



        return view('livewire.modulo-administrador.gestion-reingreso.individual.index', [
            'reingresos' => $reingresos,
            'estudiantes' => $estudiantes,
            'planes' => $planes,
            'procesos' => $procesos,
            'cursos' => $cursos,
            'ciclos' => $ciclos,
            'grupos' => $grupos,
        ]);
    }
}
