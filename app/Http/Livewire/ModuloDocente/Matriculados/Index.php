<?php

namespace App\Http\Livewire\ModuloDocente\Matriculados;

use App\Models\ActaDocente;
use App\Models\Curso;
use App\Models\CursoProgramaPlan;
use App\Models\Docente;
use App\Models\DocenteCurso;
use App\Models\MatriculaCurso;
use App\Models\NotaMatriculaCurso;
use App\Models\Programa;
use App\Models\ProgramaProcesoGrupo;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Index extends Component
{
    public $id_docente_curso;
    public $docente_curso;
    public $id_programa_proceso_grupo;
    public $curso_programa_plan;
    public $id_curso_programa_plan;
    public $id_admision;
    public $curso;
    public $grupo;

    public $id_matricula_curso;
    public $matricula_curso;
    public $nota_matricula_curso;
    public $modo_nota = 0;

    public $matriculados;
    public $notas = [];
    public $modo = 'hide';

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'modo' => ['except' => 'hide'],
    ];

    protected $listeners = [
        'asignar_nsp' => 'asignar_nsp',
    ];

    public function mount()
    {
        $usuario = auth('usuario')->user(); // obtenemos el usuario autenticado
        $trabajador_tipo_trabajador = $usuario->trabajador_tipo_trabajador; // obtenemos el trabajador_tipo_trabajador del usuario autenticado
        $trabajador = $trabajador_tipo_trabajador->trabajador; // obtenemos el trabajador del trabajador_tipo_trabajador del usuario autenticado
        $docente = Docente::where('id_trabajador', $trabajador->id_trabajador)->first(); // obtenemos el docente del trabajador del usuario autenticado

        $this->docente_curso = DocenteCurso::find($this->id_docente_curso);
        if ($this->docente_curso) {
            if ($this->docente_curso->id_docente != $docente->id_docente) {
                abort(403);
            }
        }
        else {
            abort(403);
        }

        $this->curso_programa_plan = CursoProgramaPlan::find($this->docente_curso->id_curso_programa_plan);
        $this->id_curso_programa_plan = $this->curso_programa_plan->id_curso_programa_plan;
        $this->id_programa_proceso_grupo = $this->docente_curso->id_programa_proceso_grupo;
        $this->id_admision = $this->docente_curso->id_admision;
        $this->curso = $this->curso_programa_plan->curso;
        $this->grupo = $this->docente_curso->programa_proceso_grupo;
    }

    public function updated($propertyName)
    {
        // Limpiar los mensajes de error cuando se modifiquen los campos
        $this->resetErrorBag($propertyName);
    }

    public function modo_ingresar_notas()
    {
        $matriculados_count = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->count();

        $matriculados_finalizados_count = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->where('matricula_curso.matricula_curso_estado', 2)
                        ->count();

        // emitir alerta de que todas las notas ya fueron ingresadas
        if ( $matriculados_count == $matriculados_finalizados_count )
        {
            $this->dispatchBrowserEvent('alerta_matriculados', [
                'title' => '¡Alerta!',
                'text' => 'Todas las notas ya fueron ingresadas.',
                'icon' => 'warning',
                'confirmButtonText' => 'Aceptar',
                'color' => 'warning'
            ]);
        }

        $this->modo = 'show';
    }

    public function modo_cancelar()
    {
        $this->modo = 'hide';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function esNotaValida($idMatricula, $campo)
    {
        // Verificar si la nota es válida
        if (isset($this->notas[$idMatricula][$campo]))
        {
            $nota = $this->notas[$idMatricula][$campo];

            // Realiza las validaciones necesarias
            // Por ejemplo, verifica si la nota está dentro de un rango específico
            // Si cumple las condiciones, retorna true, de lo contrario, retorna false
            return ($nota >= 0 && $nota <= 20);
        }

        return false;
    }

    public function limpiar_modal()
    {
        $this->reset([
            'nota',
        ]);
    }

    public function alerta_asignar_nsp(MatriculaCurso $matricula_curso)
    {
        $this->matricula_curso = $matricula_curso;
        $this->id_matricula_curso = $matricula_curso->id_matricula_curso;
        $this->nota_matricula_curso = NotaMatriculaCurso::where('id_matricula_curso', $matricula_curso->id_matricula_curso)->first();

        if ( $this->nota_matricula_curso )
        {
            if ( $this->nota_matricula_curso->id_estado_cursos == 4 )
            {
                // emitimos la alerta para mostrar mensaje sobre que el alumno ya fue asignado su nsp
                $this->dispatchBrowserEvent('alerta_matriculados', [
                    'title' => '¡Atención!',
                    'text' => 'El estudiante ya fue asignado su NSP.',
                    'icon' => 'warning',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'warning'
                ]);
                return;
            }
        }

        // emitir alerta para asignar nsp
        $this->dispatchBrowserEvent('alerta_matriculados_opciones', [
            'title' => '¡Atención!',
            'text' => '¿Está seguro que desea asignar NSP a este estudiante?',
            'icon' => 'warning',
            'confirmButtonText' => 'Si',
            'cancelButtonText' => 'Cancelar',
            'color' => 'warning',
            'confirmButtonColor' => 'warning',
            'cancelButtonColor' => 'danger',
        ]);
    }

    public function asignar_nsp()
    {
        if ($this->nota_matricula_curso)
        {
            $this->nota_matricula_curso->nota_evaluacion_permanente = 0;
            $this->nota_matricula_curso->nota_evaluacion_medio_curso = 0;
            $this->nota_matricula_curso->nota_evaluacion_final = 0;
            $this->nota_matricula_curso->nota_promedio_final = 0;
            $this->nota_matricula_curso->id_estado_cursos = 4;
            $this->nota_matricula_curso->save();
        }
        else
        {
            $this->nota_matricula_curso = new NotaMatriculaCurso();
            $this->nota_matricula_curso->id_matricula_curso = $this->id_matricula_curso;
            $this->nota_matricula_curso->nota_evaluacion_permanente = 0;
            $this->nota_matricula_curso->nota_evaluacion_medio_curso = 0;
            $this->nota_matricula_curso->nota_evaluacion_final = 0;
            $this->nota_matricula_curso->nota_promedio_final = 0;
            $this->nota_matricula_curso->nota_matricula_curso_fecha_creacion = date('Y-m-d H:i:s');
            $this->nota_matricula_curso->nota_matricula_curso_estado = 1;
            $this->nota_matricula_curso->id_estado_cursos = 4;
            $this->nota_matricula_curso->save();
        }

        // cambiamos el estado de la matricula_curso a finalizado
        $this->matricula_curso->matricula_curso_estado = 2; // 2 = curso finalizado
        $this->matricula_curso->save();

        $this->finalizar_curso();

        // emitimos alerta para mostrar mensaje de éxito
        $this->dispatchBrowserEvent('alerta_matriculados', [
            'title' => '¡Éxito!',
            'text' => 'Se asignó el NSP correctamente.',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);
    }

    public function updatedNota($value)
    {
        // Validar los campos
        $this->validate([
            'nota' => 'required|numeric|between:0,20',
        ]);
    }

    public function guardar_notas()
    {
        // validar si todos los campos de notas están vacíos y mostrar alerta
        $this->validate([
            'notas' => 'required|array|min:' . count($this->matriculados),
        ]);

        // validar todas las filas de notas
        $this->validate([
            'notas.*.nota1' => 'required|numeric|between:0,20',
            'notas.*.nota2' => 'required|numeric|between:0,20',
            'notas.*.nota3' => 'required|numeric|between:0,20',
        ]);

        // registrar las notas en la tabla nota_matricula_curso
        foreach ($this->notas as $key => $item)
        {
            $nota_matricula_curso = new NotaMatriculaCurso();
            $nota_matricula_curso->id_matricula_curso = $key;
            $nota_matricula_curso->nota_evaluacion_permanente = $item['nota1'];
            $nota_matricula_curso->nota_evaluacion_medio_curso = $item['nota2'];
            $nota_matricula_curso->nota_evaluacion_final = $item['nota3'];
            $promedio_final = ($item['nota1'] + $item['nota2'] + $item['nota3']) / 3;
            $nota_matricula_curso->nota_promedio_final = $promedio_final;
            $nota_matricula_curso->nota_matricula_curso_fecha_creacion = date('Y-m-d H:i:s');
            $nota_matricula_curso->nota_matricula_curso_estado = 1;
            if ( $promedio_final >= 14 )
            {
                $nota_matricula_curso->id_estado_cursos = 1;
            }
            else if ( $promedio_final >= 10 && $promedio_final < 14)
            {
                $nota_matricula_curso->id_estado_cursos = 2;
            }
            else
            {
                $nota_matricula_curso->id_estado_cursos = 3;
            }
            $nota_matricula_curso->id_docente = $this->docente_curso->id_docente;
            $nota_matricula_curso->save();

            // cambiamos el estado de la matricula_curso a finalizado
            $matricula_curso = MatriculaCurso::find($key);
            $matricula_curso->matricula_curso_estado = 2; // 2 = curso finalizado
            $matricula_curso->save();
        }

        $this->finalizar_curso();

        // emitir alerta de notas agregadas correctamente
        $this->dispatchBrowserEvent('alerta_matriculados', [
            'title' => '¡Éxito!',
            'text' => 'Se guardaron las notas correctamente.',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // emitir evento para renderizar la tabla
        $this->emit('render');
    }

    public function finalizar_curso()
    {
        $matriculados_count = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->count();

        $matriculados_finalizados_count = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->where('matricula_curso.matricula_curso_estado', 2)
                        ->count();

        // emitir alerta de que todas las notas ya fueron ingresadas
        if ( $matriculados_count == $matriculados_finalizados_count )
        {
            // cambiamos el estado del curso del docente a finalizado
            $this->docente_curso = DocenteCurso::find($this->id_docente_curso);
            $this->docente_curso->docente_curso_estado = 2; // 2 = curso finalizado
            $this->docente_curso->save();
        }

        $this->emit('render');
    }

    public function generar_acta_notas($id_docente_curso)
    {
        $docente_curso = DocenteCurso::find($id_docente_curso);
        $matriculados = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $docente_curso->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $docente_curso->id_programa_proceso_grupo)
                        ->orderBy('persona.nombre_completo', 'asc')
                        ->get();

        $fecha2 = date('YmdHis');

        $curso_programa_plan = CursoProgramaPlan::find($docente_curso->id_curso_programa_plan);
        $curso_model = Curso::find($curso_programa_plan->id_curso);
        $programa_proceso_grupo = ProgramaProcesoGrupo::find($docente_curso->id_programa_proceso_grupo);
        $programa_model = Programa::find($curso_programa_plan->programa_plan->id_programa);
        $docente_model = Docente::find($docente_curso->id_docente);
        $trabajador = $docente_model->trabajador;

        $admision_año = $docente_curso->admision->admision_año;

        $programa = $programa_model->programa_tipo == 1 ? 'Maestría' : 'Doctorado';
        $subprograma = $programa_model->subprograma;
        $mencion = $programa_model->mencion ? $programa_model->mencion : '';
        $curso = strtoupper($curso_model->curso_nombre);
        $codigo_curso = $curso_model->curso_codigo;
        $docente = ($trabajador->id_grado_academico == 4 ? 'Dr. ' : ($trabajador->id_grado_academico == 3 ? 'Mg. ' : 'Bach. ')) . strtoupper($trabajador->trabajador_nombre_completo);
        $codigo_docente = $trabajador->trabajador_numero_documento;
        $creditos = $curso_model->curso_credito;
        $ciclo = $curso_model->ciclo->ciclo;
        $grupo = $programa_proceso_grupo->grupo_detalle;

        $data = [
            'matriculados' => $matriculados,
            'programa' => $programa,
            'subprograma' => $subprograma,
            'mencion' => $mencion,
            'curso' => $curso,
            'codigo_curso' => $codigo_curso,
            'docente' => $docente,
            'codigo_docente' => $codigo_docente,
            'creditos' => $creditos,
            'ciclo' => $ciclo,
            'grupo' => $grupo,
            'admision_año' => $admision_año
        ];

        $nombre_pdf = 'acta-notas-' . date('dmYHis') . '-' . Str::slug($docente, '-') . '.pdf';
        $path = 'Posgrado/Docente/Actas/';
        if (!File::isDirectory(public_path($path))) {
            File::makeDirectory(public_path($path), 0755, true, true);
        }
        $pdf = Pdf::loadView('modulo-docente.acta-evaluacion.ficha-acta-evaluacion', $data)->save(public_path($path . $nombre_pdf));

        // registrar en la db el acta de notas
        $acta_docente = new ActaDocente();
        $acta_docente->acta_url = $path . $nombre_pdf;
        $acta_docente->id_docente_curso = $id_docente_curso;
        $acta_docente->acta_docente_fecha_creacion = date('Y-m-d H:i:s');
        $acta_docente->acta_docente_estado = 1;
        $acta_docente->save();

        // return $pdf->stream('acta-evaluacion-docente-'.$fecha2.'.pdf');
    }

    public function render()
    {
        $this->matriculados = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->where('matricula_curso.id_admision', $this->id_admision)
                        ->where(function ($query) {
                            $query->where('persona.nombre_completo', 'like', '%'.$this->search.'%')
                                ->orWhere('admitido.admitido_codigo', 'like', '%'.$this->search.'%');
                        })
                        ->orderBy('persona.nombre_completo', 'asc')
                        // ->paginate(50);
                        ->get();

        $matriculados_count = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->count();

        $matriculados_finalizados_count = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
                        ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
                        ->join('persona', 'admitido.id_persona', 'persona.id_persona')
                        ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->where('matricula_curso.matricula_curso_estado', 2)
                        ->count();

        // verificar si ya se agregaron todas las notas
        if ( $matriculados_count == $matriculados_finalizados_count )
        {
            $this->modo = 'hide';
        }

        // buscamos si el docente genero su acta de notas
        $acta_docente = ActaDocente::where('id_docente_curso', $this->id_docente_curso)->first();

        return view('livewire.modulo-docente.matriculados.index', [
            // 'matriculados' => $matriculados,
            'matriculados_count' => $matriculados_count,
            'matriculados_finalizados_count' => $matriculados_finalizados_count,
            'acta_docente' => $acta_docente
        ]);
    }
}
