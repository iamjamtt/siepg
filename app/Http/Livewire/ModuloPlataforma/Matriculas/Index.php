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
    public $id_ciclo;
    public $cursosPrematriculados;

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
        $this->reset([
            'grupo',
            'check_pago',
            'check_cursos'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrir_modal()
    {
        // obtenemos el ciclo mayor
        $id_ciclo = $this->obtenerCicloMayor($this->alumno->id_admitido);

        $programa = Programa::find($this->alumno->programa_proceso->programa_plan->programa->id_programa);
        $totalCiclos = $programa->duracion_ciclos;
        $id_ciclo = $id_ciclo + 1;
        $this->id_ciclo = $id_ciclo > $totalCiclos ? $totalCiclos : $id_ciclo;

        // primero verificamos si hay una gestion de matricula activa
        $gestion = MatriculaGestion::query()
            ->where('id_programa_proceso', $this->alumno->id_programa_proceso)
            ->where('id_ciclo', $id_ciclo)
            ->where('matricula_gestion_estado', 1)
            ->first();

        if (!$gestion) {
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
        if (!$this->verificarFechasMatriculaGestion($gestion)) {
            $this->dispatchBrowserEvent('alerta_generar_matricula', [
                'title' => '¡Error!',
                'text' => 'No se encuentra en fechas de matrícula.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }

        // generamos la prematricula
        $this->generarPrematricula ($id_ciclo, $this->alumno);

        // cargamos los cursos prematriculados
        $this->cargarCursosPrematriculados($id_ciclo, $this->alumno->id_admitido);

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
            $cursos = $ultimaMatricula->cursos()->with('programaProcesoGrupo')->get();
            foreach ($cursos as $curso) {
                //
            }
        }

        // registrar matricula
        $matricula = new ModelMatricula();
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
        $grupos = ProgramaProcesoGrupo::query()
            ->where('id_programa_proceso', $this->alumno->id_programa_proceso)
            ->get();

        $matriculas = $this->alumno->matriculas()
            ->where('estado', 1)
            ->orderBy('id_matricula', 'desc')
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
