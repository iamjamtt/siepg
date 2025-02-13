<?php

namespace App\Http\Livewire\ModuloPlataforma\Matriculas;

use App\Models\Pago;
use App\Models\Persona;
use Livewire\Component;
use App\Models\Admitido;
use App\Models\Matricula;
use App\Models\Evaluacion;
use App\Models\Inscripcion;
use Illuminate\Support\Str;
use App\Models\Prematricula;
use App\Models\CostoEnseñanza;
use App\Models\MatriculaCurso;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CursoProgramaPlan;
use App\Models\PrematriculaCurso;
use App\Models\ProgramaProcesoGrupo;
use Illuminate\Support\Facades\File;
use App\Jobs\ProcessEnvioFichaMatricula;
use App\Models\Matricula\Matricula as ModelMatricula;
use App\Models\Matricula\MatriculaCurso as ModelMatriculaCurso;
use App\Models\Matricula\PreMatriculaCurso as ModelPreMatriculaCurso;
use App\Models\MatriculaGestion;
use App\Models\Programa;

class Index extends Component
{
    public $search = ''; // variable de busqueda
    public $grupo; // variable para almacenar el grupo seleccionado
    public $check_pago = []; // variable para almacenar los checkbox de los pagos
    public $admitido; // variable para almacenar el admitido del usuario logueado
    public $id_matricula; // variable para almacenar el id de la matricula
    public $curso_prematricula; // variable para almacenar los cursos de la prematricula
    public $prematricula; // variable para almacenar la
    public $check_cursos = []; // variable para almacenar los checkbox de los cursos

    //

    public $alumno;
    public $gestion;
    public $id_ciclo;
    public $cursosPrematriculados;
    public int $creditosSeleccionados = 0;

    protected $listeners = [
        'generar_matricula' => 'generar_matricula',
        'ficha_matricula' => 'ficha_matricula',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'grupo' => 'nullable|numeric',
            'check_pago' => 'required|array|min:1|max:1',
            'check_cursos' => 'nullable|array',
        ]);

        $this->creditosSeleccionados = 0;
        foreach ($this->check_cursos as $item) {
            $curso = CursoProgramaPlan::query()
                ->where('id_curso_programa_plan', $item)
                ->with('curso')
                ->first();
            $this->creditosSeleccionados += $curso->curso->curso_credito;
        }
    }

    public function limpiar_modal()
    {
        $this->reset([
            'grupo',
            'check_pago',
            'check_cursos',
            'creditosSeleccionados'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->cursosPrematriculados = collect();
    }

    public function abrir_modal()
    {
        if (!$this->gestion) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'No existe una matrícula activa en estos momentos.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }

        // verificamos si estamos en fechas de matricula
        if (!$this->verificarFechasMatriculaGestion($this->gestion)) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'No se encuentra en fechas de matrícula.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }

        // verificamos si pago su costo por enseñanza de la matricula
        $monto_total = calcularMontoTotalCostoPorEnsenhanzaEstudiante($this->alumno->id_admitido);
        $monto_pagado = calcularMontoPagadoCostoPorEnsenhanzaEstudiante($this->alumno->id_admitido);
        if ($monto_total > $monto_pagado) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'No se puede matricular, aún no ha pagado el costo por enseñanza de la matrícula. Usted debe el monto de S/. ' . number_format($monto_total - $monto_pagado, 2) . ' soles.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }

        // generamos la prematricula
        $this->generarPrematricula($this->id_ciclo, $this->alumno);

        // cargamos los cursos prematriculados
        $this->cargarCursosPrematriculados($this->id_ciclo, $this->alumno->id_admitido);

        // abrimos el modal
        $this->dispatchBrowserEvent('modal_matricula', ['action' => 'show']);
    }

    public function alerta_generar_matricula()
    {
        // validamos el formulario
        $matriculasCount = $this->alumno->matriculas()
            ->where('estado', 1)
            ->count();

        $this->validate([
            'grupo' => $matriculasCount == 0 ? 'required|numeric' : 'nullable|numeric',
            'check_pago' => 'required|array|min:1|max:1',
            'check_cursos' => 'required|array|min:1',
        ]);

        if (count($this->check_cursos) == 0) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'Debe seleccionar un curso para generar la matrícula',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }

        // validar que el checkbox tenga al menos un pago seleccionado y como maximo sea un pago el seleccionado
        if (count($this->check_pago) == 0) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'Debe seleccionar un pago para generar la matrícula',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        } else if (count($this->check_pago) > 1) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'Solo puede seleccionar un pago para generar la matrícula',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }

        // validar que el contador de creditos seleccionados no sea mayor a 22
        if ($this->creditosSeleccionados > 22) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'No puede seleccionar más de 22 créditos para matricularse',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }

        $this->dispatchBrowserEvent('alerta_generar_matricula_2', [
            'title' => 'Confirmar matrícula',
            'text' => '¿Está seguro de generar la matrícula?',
            'icon' => 'question',
            'confirmButtonText' => 'Generar',
            'cancelButtonText' => 'Cancelar',
            'confirmButtonColor' => 'primary',
            'cancelButtonColor' => 'danger'
        ]);
    }

    public function generar_matricula()
    {
        // buscamos el grupo
        $grupo = $this->grupo;

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

        // obtener ultima matricula del admitido
        $ultimaMatricula = $this->alumno->ultimaMatriculaNuevo;
        if ($ultimaMatricula) {
            $grupo = obtenerIdGrupoDeMatricula($ultimaMatricula->id_matricula);

            // desactivar los cursos de la matricula anterior
            $cursos = $ultimaMatricula->cursos()
                ->where('activo', 1)
                ->get();

            foreach ($cursos as $curso) {
                $curso->activo = 0;
                $curso->save();
            }
        }

        // registrar matricula
        $matricula = new ModelMatricula();
        $matricula->id_matricula_gestion = $this->gestion->id_matricula_gestion;
        $matricula->id_admitido = $this->alumno->id_admitido;
        $matricula->ciclo = $this->id_ciclo;
        $matricula->codigo = $codigo;
        $matricula->fecha_matricula = date('Y-m-d');
        $matricula->id_pago = $this->check_pago[0];
        $matricula->save();

        // cambiar de estado
        $pago = Pago::find($this->check_pago[0]);
        $pago->pago_estado = 2;
        $pago->save();

        // registramos los cursos de la matricula
        foreach ($this->check_cursos as $item) {
            $matriculaCurso = new ModelMatriculaCurso();
            $matriculaCurso->id_matricula = $matricula->id_matricula;
            $matriculaCurso->id_curso_programa_plan = $item;
            $matriculaCurso->id_programa_proceso_grupo = $grupo;
            $matriculaCurso->id_docente = null;
            $matriculaCurso->periodo = calcularPeriodo($matricula->id_matricula);
            $matriculaCurso->es_acta_reingreso = verificarTieneReingreso($this->alumno->id_admitido) ? 1 : 0;
            $matriculaCurso->save();
        }

        // cambiamos el estado de los cursos de la prematricula
        foreach ($this->cursosPrematriculados as $curso) {
            $curso->estado = 0;
            $curso->save();
        }

        // emitimos una alerta de que se esta generando la matricula
        $this->dispatchBrowserEvent('alerta_generar_matricula', [
            'title' => '¡Exito!',
            'text' => 'Se ha generado su matrícula correctamente',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // cerramos el modal
        $this->dispatchBrowserEvent('modal_matricula', ['action' => 'hide']);

        // reseteamos las variables
        $this->limpiar_modal();
    }

    public function enviarFichaMatricula($id_matricula)
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
        $pago = $matricula->pago;
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

        // datos para el correo
        $nombre = ucwords(strtolower($admitido->persona->nombre_completo));
        $correo = $admitido->persona->correo;

        // enviar correo la ficha de matricula
        ProcessEnvioFichaMatricula::dispatch($data, $nombre, $correo);

        // emitimos una alerta de que se esta enviando la ficha de matricula
        $this->dispatchBrowserEvent('alerta_generar_matricula', [
            'title' => '¡Exito!',
            'text' => 'Se ha enviado la ficha de matrícula a su correo electrónico',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);
    }

    public function render()
    {
        $grupos = ProgramaProcesoGrupo::query()
            ->where('id_programa_proceso', $this->alumno->id_programa_proceso)
            ->get();

        $matriculas = $this->alumno->matriculas()
            ->where('estado', 1)
            ->get();

        $pagos = Pago::query()
            ->where('pago_documento', $this->alumno->persona->numero_documento)
            ->where('pago_estado', 1)
            ->where('pago_verificacion', 2)
            ->where(function ($query) {
                $query->where('id_concepto_pago', 3)
                    ->orWhere('id_concepto_pago', 4)
                    ->orWhere('id_concepto_pago', 5)
                    ->orWhere('id_concepto_pago', 6);
            })
            ->orderBy('id_pago', 'desc')
            ->get();

        return view('livewire.modulo-plataforma.matriculas.index', [
            'pagos' => $pagos,
            'grupos' => $grupos,
            'matriculas' => $matriculas
        ]);
    }

    public function mount()
    {
        $usuario = auth('plataforma')->user();
        $persona = Persona::find($usuario->id_persona);
        $this->alumno = Admitido::query()
            ->with('persona','programa_proceso')
            ->where('id_persona', $persona->id_persona)
            ->first();

        if (!$this->alumno) {
            abort(404, 'No se encontró el alumno');
        }
        $this->cursosPrematriculados = collect();

        // obtenemos el ciclo mayor
        $this->id_ciclo = $this->obtenerCicloMayor($this->alumno->id_admitido);

        $programa = Programa::find($this->alumno->programa_proceso->programa_plan->programa->id_programa);
        $totalCiclos = $programa->duracion_ciclos;
        $this->id_ciclo = $this->id_ciclo + 1;
        $this->id_ciclo = $this->id_ciclo > $totalCiclos ? $totalCiclos : $this->id_ciclo;

        // primero verificamos si hay una gestion de matricula activa
        $this->gestion = MatriculaGestion::query()
            ->where('id_programa_proceso', $this->alumno->id_programa_proceso)
            ->where('id_ciclo', $this->id_ciclo)
            ->where('matricula_gestion_estado', 1)
            ->first();
    }

    public function obtenerCicloMayor($id_admitido)
    {
        $ciclo = ModelMatricula::query()
            ->where('id_admitido', $id_admitido)
            ->orderBy('id_matricula', 'desc')
            ->first();
        return $ciclo->ciclo ?? 0;
    }

    public function verificarFechasMatriculaGestion($gestion)
    {
        $fechaActual = date('Y-m-d');
        $fechaInicio = $gestion->matricula_gestion_fecha_inicio;
        $fechaFin = $gestion->matricula_gestion_fecha_extemporanea_fin;

        if ($fechaActual >= $fechaInicio && $fechaActual <= $fechaFin) {
            return true;
        } else {
            return false;
        }
    }

    public function generarPrematricula($id_ciclo, $alumno)
    {
        $cursosPrematricula = collect();

        $cursosDesaprobados = collect();

        // verificamos si el alumno tiene matriculas
        $tieneMatricula = ModelMatricula::query()
            ->where('id_admitido', $alumno->id_admitido)
            ->where('estado', 1)
            ->count() > 0;

        if ($tieneMatricula) {
            $cursosDesaprobados = ModelMatriculaCurso::query()
                ->with([
                    'cursoProgramaPlan' => function ($query) use ($id_ciclo) {
                        $query->with('curso');
                    }
                ])
                ->whereHas('matricula', function ($query) use ($alumno) {
                    $query->where('id_admitido', $alumno->id_admitido);
                })
                ->where('estado', 0) // 0 = desaprobado
                ->get();

            foreach ($cursosDesaprobados as $curso) {
                // verificamos si el curso desaprobado ya se aprobo
                $seAprobo = ModelMatriculaCurso::query()
                    ->where('id_curso_programa_plan', $curso->id_curso_programa_plan)
                    ->whereHas('matricula', function ($query) use ($alumno) {
                        $query->where('id_admitido', $alumno->id_admitido);
                    })
                    ->where('estado', 2) // 2 = aprobado
                    ->count() > 0;
                if (!$seAprobo) {
                    // $cursosPrematricula->push($curso->cursoProgramaPlan);
                }
            }

            $cursosNsp = ModelMatriculaCurso::query()
                ->with([
                    'cursoProgramaPlan' => function ($query) use ($id_ciclo) {
                        $query->with('curso');
                    }
                ])
                ->whereHas('matricula', function ($query) use ($alumno) {
                    $query->where('id_admitido', $alumno->id_admitido);
                })
                ->where('estado', 3) // 3 = no se presento
                ->get();

            foreach ($cursosNsp as $curso) {
                // verificamos si el curso no se presento ya se aprobo
                $seAprobo = ModelMatriculaCurso::query()
                    ->where('id_curso_programa_plan', $curso->id_curso_programa_plan)
                    ->whereHas('matricula', function ($query) use ($alumno) {
                        $query->where('id_admitido', $alumno->id_admitido);
                    })
                    ->where('estado', 2) // 2 = aprobado
                    ->count() > 0;
                if (!$seAprobo) {
                    // $cursosPrematricula->push($curso->cursoProgramaPlan);
                }
            }
        }

        // obtemos los cursos de ciclos anteriores al que falta matricular
        $cursos = CursoProgramaPlan::query()
            ->with([
                'curso',
                'programa_plan'
            ])
            ->whereHas('curso', function ($query) use ($id_ciclo) {
                $query->where('id_ciclo', '<', $id_ciclo);
            })
            ->where('id_programa_plan', $alumno->programa_proceso->id_programa_plan)
            ->get();

        foreach ($cursos as $curso) {
            // verificamos si hay cursos que no estan en el historial de matriculas
            $existe = ModelMatriculaCurso::query()
                ->where('id_curso_programa_plan', $curso->id_curso_programa_plan)
                ->whereHas('matricula', function ($query) use ($alumno) {
                    $query->where('id_admitido', $alumno->id_admitido);
                })
                ->count() > 0;
            if (!$existe) {
                $cursosPrematricula->push($curso);
            }
        }

        // obtemos los cursos del ciclo actual al que se va a matricular
        $cursos = CursoProgramaPlan::query()
            ->with([
                'curso',
                'programa_plan'
            ])
            ->whereHas('curso', function ($query) use ($id_ciclo) {
                $query->where('id_ciclo', $id_ciclo);
            })
            ->where('id_programa_plan', $alumno->programa_proceso->id_programa_plan)
            ->get();

        foreach ($cursos as $curso) {
            if ($curso->curso) {
                // verificamos si el cursos con prerequisito se aprobo
                if ($curso->curso->curso_prerequisito) {
                    // verificamos si el curso se aprobo
                    $matriculaCurso = ModelMatriculaCurso::query()
                        ->with([
                            'matricula',
                            'cursoProgramaPlan' => function ($query) use ($curso) {
                                $query->with('curso');
                            }
                        ])
                        ->whereHas('matricula', function ($query) use ($alumno) {
                            $query->where('id_admitido', $alumno->id_admitido);
                        })
                        ->whereHas('cursoProgramaPlan', function ($query) use ($curso) {
                            $query->where('id_curso', $curso->curso->curso_prerequisito);
                        })
                        ->where('estado', 2) // 0 = aprobado
                        ->first();
                    if ($matriculaCurso) {
                        if ($matriculaCurso->cursoProgramaPlan && $matriculaCurso->matricula) {
                            if ($matriculaCurso->cursoProgramaPlan->curso->id_curso == $curso->curso->curso_prerequisito) {
                                $cursosPrematricula->push($curso);
                            }
                        }
                    }
                } else {
                    // verificamos si el curso se aprobo
                    $matriculaCurso = ModelMatriculaCurso::query()
                        ->with([
                            'matricula',
                            'cursoProgramaPlan' => function ($query) use ($curso) {
                                $query->with('curso');
                            }
                        ])
                        ->whereHas('matricula', function ($query) use ($alumno) {
                            $query->where('id_admitido', $alumno->id_admitido);
                        })
                        ->whereHas('cursoProgramaPlan', function ($query) use ($curso) {
                            $query->where('id_curso', $curso->curso->id_curso);
                        })
                        ->where('estado', 2) // 0 = aprobado
                        ->first();
                    if (!$matriculaCurso) {
                        $cursosPrematricula->push($curso);
                    }
                }
            }
        }

        // verificamos si el alumno tiene cursos de la prematricula
        $tienePreMatricula = ModelPreMatriculaCurso::query()
            ->where('id_admitido', $alumno->id_admitido)
            ->where('id_ciclo', $id_ciclo)
            ->where('estado', 1) // 1 = activo
            ->count() > 0;

        if (!$tienePreMatricula) {
            $this->prematricula($cursosPrematricula, $id_ciclo, $alumno);
        } else {
            $cursosPrematriculados = ModelPreMatriculaCurso::query()
                ->with([
                    'cursoProgramaPlan' => function ($query) {
                        $query->with('curso');
                    }
                ])
                ->where('id_admitido', $alumno->id_admitido)
                ->where('id_ciclo', $id_ciclo)
                ->where('estado', 1)
                ->get();

            $cursosParaPrematricular = collect();
            foreach ($cursosPrematricula as $curso) {
                $existe = $cursosPrematriculados->where('id_curso_programa_plan', $curso->id_curso_programa_plan)->first();
                if (!$existe) {
                    $cursosParaPrematricular->push($curso);
                }
            }

            if ($cursosParaPrematricular->count() > 0) {
                $this->prematricula($cursosParaPrematricular, $id_ciclo, $alumno);
            }
        }
    }

    public function prematricula($cursosPrematricula, $id_ciclo, $alumno)
    {
        // realizar la prematricula de los cursos
        foreach ($cursosPrematricula as $curso) {
            // verificamos si el curso ya esta prematriculado con estado 0
            $prematriculaCurso = ModelPreMatriculaCurso::query()
                ->where('id_admitido', $alumno->id_admitido)
                ->where('id_curso_programa_plan', $curso->id_curso_programa_plan)
                ->where('id_ciclo', $id_ciclo)
                ->where('estado', 0) // 0 = desaprobado
                ->first();
            if ($prematriculaCurso) {
                // verificamos si el curso prematriculado con estado 0, esta pendiente de aprobacion
                $matriculaCurso = ModelMatriculaCurso::query()
                    ->with([
                        'matricula',
                        'cursoProgramaPlan' => function ($query) use ($curso) {
                            $query->with('curso');
                        }
                    ])
                    ->whereHas('matricula', function ($query) use ($alumno) {
                        $query->where('id_admitido', $alumno->id_admitido);
                    })
                    ->whereHas('cursoProgramaPlan', function ($query) use ($curso) {
                        $query->where('id_curso_programa_plan', $curso->id_curso_programa_plan);
                    })
                    ->where('estado', 1) // 2 = aprobado
                    ->first();
                if (!$matriculaCurso) {
                    $prematriculaCurso = new ModelPreMatriculaCurso();
                    $prematriculaCurso->estado = 1; // 1 = activo
                    $prematriculaCurso->id_admitido = $alumno->id_admitido;
                    $prematriculaCurso->id_curso_programa_plan = $curso->id_curso_programa_plan;
                    $prematriculaCurso->id_ciclo = $id_ciclo;
                    $prematriculaCurso->save();
                }
            } else {
                // verificamos si el curso ya esta prematriculado
                $prematriculaCurso = ModelPreMatriculaCurso::query()
                    ->where('id_admitido', $alumno->id_admitido)
                    ->where('id_curso_programa_plan', $curso->id_curso_programa_plan)
                    ->where('id_ciclo', $id_ciclo)
                    ->where('estado', 1) // 1 = activo
                    ->first();
                if (!$prematriculaCurso) {
                    $prematriculaCurso = new ModelPreMatriculaCurso();
                    $prematriculaCurso->estado = 1; // 1 = activo
                }
                $prematriculaCurso->id_admitido = $alumno->id_admitido;
                $prematriculaCurso->id_curso_programa_plan = $curso->id_curso_programa_plan;
                $prematriculaCurso->id_ciclo = $id_ciclo;
                $prematriculaCurso->save();
            }
        }
    }

    public function cargarCursosPrematriculados($id_ciclo, $id_admitido)
    {
        $this->cursosPrematriculados = ModelPreMatriculaCurso::query()
            ->with([
                'cursoProgramaPlan' => function ($query) {
                    $query->with('curso');
                }
            ])
            ->where('id_admitido', $id_admitido)
            ->where('id_ciclo', $id_ciclo)
            ->where('estado', 1)
            ->get();
    }
}
