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
    }

    public function limpiar_modal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrir_modal()
    {
        // buscamos el admitido tiene prematricula
        $this->prematricula = Prematricula::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_prematricula', 'desc')->where('prematricula_estado', 1)->first();
        // dd($this->prematricula);
        if ( $this->prematricula ) {
            $this->curso_prematricula = PrematriculaCurso::where('id_prematricula', $this->prematricula->id_prematricula)
                ->where('prematricula_curso_estado', 1)
                ->get();
        }

        // buscamos si existen matriculas
        $matriculas_count = Matricula::where('id_admitido', $this->admitido->id_admitido)->count();
        // if ($matriculas_count > 0) {
        //     // // buscamos los cursos de prematricula del admitido
        //     // $this->prematricula = Prematricula::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_prematricula', 'desc')->first();

        //     // if ($this->prematricula) {
        //     //     $this->curso_prematricula = PrematriculaCurso::where('id_prematricula', $this->prematricula->id_prematricula)->get();
        //     // }
        //     // // buscamos su mensualidad
        //     // $mensualidades  = Mensualidad::join('matricula', 'mensualidad.id_matricula', '=', 'matricula.id_matricula')
        //     //         ->join('pago', 'mensualidad.id_pago', '=', 'pago.id_pago')
        //     //         ->where('mensualidad.id_admitido', $this->admitido->id_admitido)
        //     //         // ->where('matricula.id_ciclo', $ciclo_actual->id_ciclo)
        //     //         ->orderBy('mensualidad.id_mensualidad', 'asc')
        //     //         ->get();
        //     // // dd($mensualidades);
        //     // // buscamos el costo de enseñanza del ciclo actual
        //     // $costo_enseñanza = CostoEnseñanza::where('id_programa_plan', $this->admitido->programa_proceso->id_programa_plan)->where('id_ciclo', $ciclo_actual->id_ciclo)->first();
        //     // // dd($costo_enseñanza);
        //     // $monto_total = $costo_enseñanza->costo_ciclo;
        //     // $monto_pagado = 0;
        //     // foreach($mensualidades as $mensualidad)
        //     // {
        //     //     if ( $mensualidad->pago->pago_estado == 2 && $mensualidad->pago->pago_verificacion == 2 )
        //     //     {
        //     //         $monto_pagado += $mensualidad->pago->pago_monto;
        //     //     }
        //     // }
        //     // $deuda = $monto_total - $monto_pagado;
        //     // // verificamos si hay la gestion de matricula abierta
        //     // $matricula_gestion = MatriculaGestion::where('id_programa_proceso', $this->admitido->id_programa_proceso)
        //     //                 ->where('id_ciclo', $ciclo_actual->id_ciclo)
        //     //                 ->where('matricula_gestion_estado', 1)->first();
        //     // if ( $ciclo_actual->id_ciclo != 1 ) {
        //     //     if ( $matricula_gestion ) {
        //     //         if ( $matricula_gestion->matricula_gestion_fecha_inicio <= date('Y-m-d') && $matricula_gestion->matricula_gestion_fecha_extemporanea_fin >= date('Y-m-d') ) {
        //     //             $this->dispatchBrowserEvent('modal_matricula', ['action' => 'show']);
        //     //             return;
        //     //         } else {
        //     //             $this->dispatchBrowserEvent('alerta_generar_matricula', [
        //     //                 'title' => '¡Error!',
        //     //                 'text' => 'La matricula no esta disponible en este momento, termina el ' . date('d/m/Y', strtotime($matricula_gestion->matricula_gestion_fecha_fin)) . '.',
        //     //                 'icon' => 'error',
        //     //                 'confirmButtonText' => 'Aceptar',
        //     //                 'color' => 'danger'
        //     //             ]);
        //     //             return;
        //     //         }
        //     //     } else {
        //     //         $this->dispatchBrowserEvent('alerta_generar_matricula', [
        //     //             'title' => '¡Error!',
        //     //             'text' => 'No existe una matrícula abierta en este momento.',
        //     //             'icon' => 'error',
        //     //             'confirmButtonText' => 'Aceptar',
        //     //             'color' => 'danger'
        //     //         ]);
        //     //         return;
        //     //     }
        //     // }
        //     // buscamos su ultima matricula
        //     $matricula = Matricula::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_matricula', 'desc')->first();
        //     // // dd($matricula);
        //     // // dd($matricula_gestion);
        //     // if ( $matricula ) {
        //     //     if ( $deuda > 0 ) {
        //     //         $this->dispatchBrowserEvent('alerta_generar_matricula', [
        //     //             'title' => '¡Error!',
        //     //             'text' => 'Usted tiene una deuda de S/. ' . number_format($deuda, 2, ',', '.') . '. Pague su deuda para poder generar su matricula.',
        //     //             'icon' => 'error',
        //     //             'confirmButtonText' => 'Aceptar',
        //     //             'color' => 'danger'
        //     //         ]);
        //     //         return;
        //     //     }
        //     // }
        //     // dd($monto_total, $monto_pagado, $deuda);
        //     // buscamos los cursos de su ultima matricula
        //     if ( $matricula ) {
        //         $cursos = MatriculaCurso::join('curso_programa_proceso', 'curso_programa_proceso.id_curso_programa_proceso', '=', 'matricula_curso.id_curso_programa_proceso')
        //             ->join('curso', 'curso.id_curso', '=', 'curso_programa_proceso.id_curso')
        //             ->where('matricula_curso.id_matricula', $matricula->id_matricula)
        //             ->get();
        //         $contador_cursos = $cursos->count();
        //     } else {
        //         $cursos = collect();
        //         $contador_cursos = 0;
        //     }
        //     $verificar = false;
        //     $contador = 0;
        //     // dd($contador, $contador_cursos);
        //     if ( $contador_cursos != 0 ) {
        //         foreach ($cursos as $curso) {
        //             if ($curso->matricula_curso_estado == 2 || $curso->matricula_curso_estado == 3) {
        //                 $contador++;
        //             }
        //         }
        //         if ($contador == $contador_cursos) {
        //             $verificar = true;
        //         } else {
        //             $verificar = false;
        //         }
        //     }
        //     // buscamos su programa
        //     $programa = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', '=', 'programa_proceso.id_programa_plan')
        //         ->join('programa', 'programa.id_programa', '=', 'programa_plan.id_programa')
        //         ->where('programa_proceso.id_programa_proceso', $this->admitido->id_programa_proceso)
        //         ->first();
        //     // // dd($programa, $verificar);
        //     // // aumentamos el ciclo del admitido
        //     // if ( $verificar == true )
        //     // {
        //     //     $ciclo = AdmitidoCiclo::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_admitido_ciclo', 'desc')->first();
        //     //     $ciclo_count = AdmitidoCiclo::where('id_admitido', $this->admitido->id_admitido)->count();
        //     //     if ( $programa->programa_tipo == 1 ) {
        //     //         if ( $ciclo_count < 3 ) {
        //     //             $ciclo->admitido_ciclo_estado = 0;
        //     //             $ciclo->save();
        //     //             $ciclo_nuevo = new AdmitidoCiclo();
        //     //             $ciclo_nuevo->id_admitido = $this->admitido->id_admitido;
        //     //             $ciclo_nuevo->id_ciclo = $ciclo->id_ciclo + 1;
        //     //             $ciclo_nuevo->admitido_ciclo_estado = 1;
        //     //             $ciclo_nuevo->save();

        //     //             // crear pre matricula
        //     //             $prematricula = new Prematricula();
        //     //             $prematricula->prematricula_fecha_creacion = date('Y-m-d H:i:s');
        //     //             $prematricula->prematricula_estado = 1;
        //     //             $prematricula->id_admitido = $this->admitido->id_admitido;
        //     //             $prematricula->id_ciclo = $ciclo_nuevo->id_ciclo;
        //     //             $prematricula->save();

        //     //             // asignar los cursos a la pre matricula
        //     //             $cursos = CursoProgramaProceso::join('curso', 'curso.id_curso', '=', 'curso_programa_proceso.id_curso')
        //     //                 ->where('curso_programa_proceso.id_programa_proceso', $this->admitido->id_programa_proceso)
        //     //                 ->where('curso.id_ciclo', $ciclo_nuevo->id_ciclo)
        //     //                 ->get();
        //     //             foreach ($cursos as $curso) {
        //     //                 if ( $curso->curso_prerequisito ) {
        //     //                     // buscamos su ultima matricula
        //     //                     $matricula = Matricula::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_matricula', 'desc')->first();
        //     //                     // buscamos los el curso prerequisito de su ultima matricula
        //     //                     $curso_prerequisito = MatriculaCurso::join('curso_programa_proceso', 'curso_programa_proceso.id_curso_programa_proceso', '=', 'matricula_curso.id_curso_programa_proceso')
        //     //                         ->join('curso', 'curso.id_curso', '=', 'curso_programa_proceso.id_curso')
        //     //                         ->where('matricula_curso.id_matricula', $matricula->id_matricula)
        //     //                         ->where('curso.id_curso', $curso->curso_prerequisito)
        //     //                         ->first();
        //     //                     if ( $curso_prerequisito->matricula_curso_estado == 2 ) {
        //     //                         $prematricula_curso = new PrematriculaCurso();
        //     //                         $prematricula_curso->id_prematricula = $prematricula->id_prematricula;
        //     //                         $prematricula_curso->id_curso_programa_proceso = $curso->id_curso_programa_proceso;
        //     //                         $prematricula_curso->prematricula_curso_fecha_creacion = date('Y-m-d H:i:s');
        //     //                         $prematricula_curso->prematricula_curso_estado = 1;
        //     //                         $prematricula_curso->save();
        //     //                     }
        //     //                 } else {
        //     //                     $prematricula_curso = new PrematriculaCurso();
        //     //                     $prematricula_curso->id_prematricula = $prematricula->id_prematricula;
        //     //                     $prematricula_curso->id_curso_programa_proceso = $curso->id_curso_programa_proceso;
        //     //                     $prematricula_curso->prematricula_curso_fecha_creacion = date('Y-m-d H:i:s');
        //     //                     $prematricula_curso->prematricula_curso_estado = 1;
        //     //                     $prematricula_curso->save();
        //     //                 }
        //     //             }
        //     //         }
        //     //     } else {
        //     //         if ( $ciclo_count < 6 ) {
        //     //             $ciclo->admitido_ciclo_estado = 0;
        //     //             $ciclo->save();
        //     //             $ciclo_nuevo = new AdmitidoCiclo();
        //     //             $ciclo_nuevo->id_admitido = $this->admitido->id_admitido;
        //     //             $ciclo_nuevo->id_ciclo = $ciclo->id_ciclo + 1;
        //     //             $ciclo_nuevo->admitido_ciclo_estado = 1;
        //     //             $ciclo_nuevo->save();

        //     //             // crear pre matricula
        //     //             $prematricula = new Prematricula();
        //     //             $prematricula->prematricula_fecha_creacion = date('Y-m-d H:i:s');
        //     //             $prematricula->prematricula_estado = 1;
        //     //             $prematricula->id_admitido = $this->admitido->id_admitido;
        //     //             $prematricula->id_ciclo = $ciclo_nuevo->id_ciclo;
        //     //             $prematricula->save();

        //     //             // asignar los cursos a la pre matricula
        //     //             $cursos = CursoProgramaProceso::join('curso', 'curso.id_curso', '=', 'curso_programa_proceso.id_curso')
        //     //                 ->where('curso_programa_proceso.id_programa_proceso', $this->admitido->id_programa_proceso)
        //     //                 ->where('curso.id_ciclo', $ciclo_nuevo->id_ciclo)
        //     //                 ->get();
        //     //             foreach ($cursos as $curso) {
        //     //                 if ( $curso->curso_prerequisito ) {
        //     //                     // buscamos su ultima matricula
        //     //                     $matricula = Matricula::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_matricula', 'desc')->first();
        //     //                     // buscamos los el curso prerequisito de su ultima matricula
        //     //                     $curso_prerequisito = MatriculaCurso::join('curso_programa_proceso', 'curso_programa_proceso.id_curso_programa_proceso', '=', 'matricula_curso.id_curso_programa_proceso')
        //     //                         ->join('curso', 'curso.id_curso', '=', 'curso_programa_proceso.id_curso')
        //     //                         ->where('matricula_curso.id_matricula', $matricula->id_matricula)
        //     //                         ->where('curso.id_curso', $curso->curso_prerequisito)
        //     //                         ->first();
        //     //                     if ( $curso_prerequisito->matricula_curso_estado == 2 ) {
        //     //                         $prematricula_curso = new PrematriculaCurso();
        //     //                         $prematricula_curso->id_prematricula = $prematricula->id_prematricula;
        //     //                         $prematricula_curso->id_curso_programa_proceso = $curso->id_curso_programa_proceso;
        //     //                         $prematricula_curso->prematricula_curso_fecha_creacion = date('Y-m-d H:i:s');
        //     //                         $prematricula_curso->prematricula_curso_estado = 1;
        //     //                         $prematricula_curso->save();
        //     //                     }
        //     //                 } else {
        //     //                     $prematricula_curso = new PrematriculaCurso();
        //     //                     $prematricula_curso->id_prematricula = $prematricula->id_prematricula;
        //     //                     $prematricula_curso->id_curso_programa_proceso = $curso->id_curso_programa_proceso;
        //     //                     $prematricula_curso->prematricula_curso_fecha_creacion = date('Y-m-d H:i:s');
        //     //                     $prematricula_curso->prematricula_curso_estado = 1;
        //     //                     $prematricula_curso->save();
        //     //                 }
        //     //             }
        //     //         }
        //     //     }
        //     // }

        //     // // buscamos los cursos de prematricula del admitido
        //     // $this->prematricula = Prematricula::where('id_admitido', $this->admitido->id_admitido)->where('id_ciclo', $ciclo_actual->id_ciclo)->first();
        //     // // dd($this->prematricula);
        //     // if ( $this->prematricula ) {
        //     //     $this->curso_prematricula = PrematriculaCurso::where('id_prematricula', $this->prematricula->id_prematricula)->get();
        //     // }
        // }

        // abrimos el modal
        $this->dispatchBrowserEvent('modal_matricula', ['action' => 'show']);
    }

    public function alerta_generar_matricula()
    {
        // validamos el formulario
        // buscamos las matriculas del admitido
        $matriculas = Matricula::where('id_admitido', $this->admitido->id_admitido)->where('matricula_estado', 1)->get();
        if ($matriculas->count() == 0) {
            $this->validate([
                'grupo' => 'required|numeric',
                'check_pago' => 'required|array|min:1|max:1',
            ]);
        } else {
            $this->validate([
                'grupo' => 'nullable|numeric',
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
        // buscamos el pago
        $pago = Pago::find($this->check_pago[0]);
        $admitido = $this->admitido;

        // buscamos el grupo
        $grupo = $this->grupo;

        // generar codigo de matricula
        $codigo = 'M' . date('Y') . str_pad(1, 5, "0", STR_PAD_LEFT);

        // obtener el ultimo registro de matricula
        $matricula = Matricula::orderBy('id_matricula', 'desc')->first();

        if ($matricula) {
            $codigo = $matricula->matricula_codigo;
            $codigo = substr($codigo, 5);
            $codigo = (int)$codigo + 1;
            $codigo = 'M' . date('Y') . str_pad($codigo, 5, "0", STR_PAD_LEFT);
        } else {
            $codigo = 'M' . date('Y') . str_pad(1, 5, "0", STR_PAD_LEFT);
        }

        // buscamos las matriculas del admitido
        $matriculas = Matricula::where('id_admitido', $this->admitido->id_admitido)->where('matricula_estado', 1)->get();


        // obtener ultima matricula del admitido
        $ultima_matricula_admitido = Matricula::where('id_admitido', $this->admitido->id_admitido)->orderBy('id_matricula', 'desc')->first();
        $grup_antiguo = $ultima_matricula_admitido ? $ultima_matricula_admitido->id_programa_proceso_grupo : null;

        // registrar matricula
        $matricula = new Matricula();
        $matricula->matricula_codigo = $codigo;
        if ($matriculas->count() == 0) {
            $matricula->matricula_proceso = $admitido->programa_proceso->admision->admision_año . ' - ' . 1;
        } else {
            $matricula->matricula_proceso = $admitido->programa_proceso->admision->admision_año . ' - ' . ($matriculas->count() + 1);
        }
        $matricula->matricula_year = date('Y-m-d');
        $matricula->matricula_fecha_creacion = date('Y-m-d H:i:s');
        $matricula->matricula_estado = 1;
        $matricula->id_admitido = $admitido->id_admitido;
        if ($matriculas->count() == 0) {
            $matricula->id_programa_proceso_grupo = $grupo;
        } else {
            $matricula->id_programa_proceso_grupo = $grup_antiguo;
        }
        $matricula->id_pago = $pago->id_pago;
        if ($matriculas->count() == 0) {
            $matricula->matricula_primer_ciclo = 1; // si es la primera matricula del admitido
        }
        $matricula->save();

        // cambiar de estado
        $pago->pago_estado = 2;
        $pago->save();

        // registramos los cursos de la matricula
        // obetenmos los cursos del ciclo del admitido
        if ($matriculas->count() == 0) {
            $curso_programa_plan = CursoProgramaPlan::join('curso', 'curso.id_curso', 'curso_programa_plan.id_curso')
                ->where('curso_programa_plan.id_programa_plan', $admitido->programa_proceso->programa_plan->id_programa_plan)
                ->where('curso.id_ciclo', 1)
                ->get();
            foreach ($curso_programa_plan as $item) {
                $matricula_curso = new MatriculaCurso();
                $matricula_curso->id_matricula = $matricula->id_matricula;
                $matricula_curso->id_curso_programa_plan = $item->id_curso_programa_plan;
                $matricula_curso->id_admision = $admitido->programa_proceso->id_admision;
                $matricula_curso->id_programa_proceso_grupo = $grupo;
                $matricula_curso->matricula_curso_fecha_creacion = date('Y-m-d H:i:s');
                $matricula_curso->matricula_curso_estado = 1;
                $matricula_curso->save();
            }
        } else {
            foreach ($this->check_cursos as $item) {
                $matricula_curso = new MatriculaCurso();
                $matricula_curso->id_matricula = $matricula->id_matricula;
                $matricula_curso->id_curso_programa_plan = $item;
                $matricula_curso->id_admision = $admitido->programa_proceso->id_admision;
                $matricula_curso->id_programa_proceso_grupo = $grup_antiguo;
                $matricula_curso->matricula_curso_fecha_creacion = date('Y-m-d H:i:s');
                $matricula_curso->matricula_curso_estado = 1;
                $matricula_curso->save();

                // cambiar de estado al curso de la prematricula
                if ($this->prematricula) {
                    $prematricula_curso = PrematriculaCurso::where('id_prematricula', $this->prematricula->id_prematricula)->where('id_curso_programa_plan', $item)->first();
                    $prematricula_curso->prematricula_curso_estado = 2;
                    $prematricula_curso->save();
                }
            }
            if ($this->prematricula) {
                $this->prematricula->prematricula_estado = 2;
                $this->prematricula->save();
            }
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
    }

    public function alerta_ficha_matricula($id_matricula)
    {
        $this->id_matricula = $id_matricula;
        $this->dispatchBrowserEvent('alerta_generar_matricula_temporizador', [
            'title' => '¡Exito!',
            'text' => 'Se ha generado su ficha de matrícula correctamente',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);
    }

    public function ficha_matricula()
    {
        // buscamos el admitido
        $admitido = $this->admitido;

        // buscamos la matricula
        $matricula = Matricula::find($this->id_matricula);

        // buscamos el pago
        $pago = Pago::where('id_pago', $matricula->id_pago)->first();

        // buscamos los cursos de la matricula
        $cursos = MatriculaCurso::join('curso_programa_plan', 'curso_programa_plan.id_curso_programa_plan', 'matricula_curso.id_curso_programa_plan')
            ->join('curso', 'curso.id_curso', 'curso_programa_plan.id_curso')
            ->join('ciclo', 'ciclo.id_ciclo', 'curso.id_ciclo')
            ->where('matricula_curso.id_matricula', $matricula->id_matricula)
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
        $grupo = $matricula->programa_proceso_grupo->grupo_detalle;
        $admision = $admitido->programa_proceso->admision->admision;
        $modalidad = $admitido->programa_proceso->programa_plan->programa->id_modalidad == 1 ? 'PRESENCIAL' : 'DISTANCIA';
        $matricula_codigo = $matricula->matricula_codigo;
        // dd($programa, $subprograma, $mencion, $fecha, $numero_operacion, $plan, $ciclo, $codigo, $nombre, $domicilio, $celular, $cursos, $grupo, $admision, $modalidad);
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
            'modalidad' => $modalidad
        ];

        // Crear directorios para guardar los archivos
        $base_path = 'Posgrado/';
        $folders = [
            $admision,
            $admitido->persona->numero_documento,
            'Expedientes'
        ];

        // Asegurar que se creen los directorios con los permisos correctos
        $path = asignarPermisoFolders($base_path, $folders);

        // Nombre del archivo
        $nombre_pdf = Str::slug($nombre) . '-ficha-matricula-' . $matricula_codigo . '.pdf';
        $nombre_db = $path . $nombre_pdf;

        // Generar el PDF
        Pdf::loadView('modulo-plataforma.matriculas.ficha-matricula', $data)->save(public_path($path . $nombre_pdf));

        // registramos la url de la ficha de matricula
        $matricula->matricula_ficha_url = $nombre_db;
        $matricula->save();

        // Asignar todos los permisos al archivo
        chmod($nombre_db, 0777);

        // datos para el correo
        $nombre = ucwords(strtolower($admitido->persona->nombre_completo));
        $correo = $admitido->persona->correo;

        // enviar correo la ficha de matricula
        ProcessEnvioFichaMatricula::dispatch($data, $path, $nombre_pdf, $nombre, $correo);
    }

    public function render()
    {
        $usuario = auth('plataforma')->user(); // obtenemos el usuario autenticado en la plataforma
        $persona = Persona::where('id_persona', $usuario->id_persona)->first(); // obtenemos la persona del usuario autenticado en la plataforma
        $inscripcion_ultima = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first(); // inscripcion del usuario logueado

        $this->admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // obtenemos el admitido de la inscripcion de la persona del usuario autenticado en la plataforma
        $inscripcion_ultima = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first(); // inscripcion del usuario logueado
        $evaluacion = $this->admitido ? Evaluacion::where('id_evaluacion', $this->admitido->id_evaluacion)->first() : $inscripcion_ultima->evaluacion()->orderBy('id_evaluacion', 'desc')->first(); // evaluacion de la inscripcion del usuario logueado

        $grupos = $this->admitido ? ProgramaProcesoGrupo::where('id_programa_proceso', $this->admitido->id_programa_proceso)->get() : collect(); // grupos de la admision del usuario logueado
        $matriculas = $this->admitido ? Matricula::where('id_admitido', $this->admitido->id_admitido)->get() : collect(); // matriculas del usuario logueado

        $pagos = Pago::where(function ($query) {
            $query->where('pago_operacion', 'like', '%' . $this->search . '%')
                ->orWhere('id_pago', 'like', '%' . $this->search . '%');
        })
            ->where('pago_documento', $persona->numero_documento)
            ->where('pago_estado', 1)
            ->where('pago_verificacion', 2)
            ->where(function ($query) {
                $query->where('id_concepto_pago', 3)
                    ->orWhere('id_concepto_pago', 4)
                    ->orWhere('id_concepto_pago', 5)
                    ->orWhere('id_concepto_pago', 6);
            })
            ->orderBy('id_pago', 'desc')
            ->get(); // pagos del usuario logueado

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

        // obtenemos el ciclo mayor
        $id_ciclo = $this->obtenerCicloMayor($this->alumno->id_admitido);

        // generamos la prematricula
        $this->generarPrematricula ($id_ciclo, $this->alumno);

        // primero verificamos si hay una gestion de matricula activa
    }

    public function obtenerCicloMayor($id_admitido)
    {
        $ciclo = ModelMatricula::query()
            ->where('id_admitido', $id_admitido)
            ->orderBy('id_matricula', 'desc')
            ->first();
        return $ciclo->ciclo ?? 0;
    }

    public function generarPrematricula($id_ciclo, $alumno)
    {
        $cursosPrematricula = collect();

        // verificamos si el alumno tiene matriculas
        $tieneMatricula = ModelMatricula::query()
            ->where('id_admitido', $alumno->id_admitido)
            ->where('estado', 1)
            ->count() > 0;

        if ($tieneMatricula) {
            $matricula = ModelMatricula::query()
                ->where('id_admitido', $alumno->id_admitido)
                ->where('estado', 1)
                ->first();
            dd($matricula);
        }

        $programa = Programa::find($alumno->programa_proceso->programa_plan->programa->id_programa);
        $totalCiclos = $programa->duracion_ciclos;
        $id_ciclo = $id_ciclo + 1;
        $id_ciclo = $id_ciclo > $totalCiclos ? $totalCiclos : $id_ciclo;

        // obtemos los cursos del ciclo actual al que se va a matricular
        $cursos = CursoProgramaPlan::query()
            ->with([
                'curso' => function ($query) use ($id_ciclo) {
                    $query->where('id_ciclo', $id_ciclo);
                },
                'programa_plan'
            ])
            ->where('id_programa_plan', $alumno->programa_proceso->id_programa_plan)
            ->get();

        foreach ($cursos as $curso) {
            // verificamos si el cursos que tiene prerequisito se aprobo
            if ($curso->curso) {
                if ($curso->curso->curso_prerequisito) {
                    $matriculaCurso = ModelMatriculaCurso::query()
                        ->with([
                            'matricula' => function ($query) use ($alumno) {
                                $query->where('id_admitido', $alumno->id_admitido);
                            }
                        ])
                        ->where('id_curso_programa_plan', $curso->id_curso_programa_plan)
                        ->where('estado', 0) // 0 = desaprobado
                        ->first();
                    dd($matriculaCurso);
                } else {
                    $cursosPrematricula->push($curso);
                }
            }
        }

        // realizar la prematricula de los cursos
        foreach ($cursosPrematricula as $curso) {
            $prematriculaCurso = new ModelPreMatriculaCurso();
            $prematriculaCurso->id_admitido = $alumno->id_admitido;
            $prematriculaCurso->id_curso_programa_plan = $curso->id_curso_programa_plan;
            $prematriculaCurso->id_ciclo = $id_ciclo;
            $prematriculaCurso->estado = 1; // 1 = activo
            $prematriculaCurso->save();
        }
    }
}
