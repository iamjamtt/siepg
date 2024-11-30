<?php

namespace App\Http\Livewire\ModuloDocente\Matriculados;

use App\Models\Curso;
use App\Models\Docente;
use Livewire\Component;
use App\Models\Programa;
use App\Models\ActaDocente;
use Illuminate\Support\Str;
use App\Models\DocenteCurso;
use App\Models\MatriculaCurso;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CursoProgramaPlan;
use App\Models\NotaMatriculaCurso;
use App\Models\ProgramaProcesoGrupo;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\reporte\moduloDocente\matriculados\listaMatriculadosExport;
use App\Models\Matricula\MatriculaCurso as ModelMatriculaCurso;

class Index extends Component
{
    public $id_docente_curso;
    public $docente_curso;
    public $id_programa_proceso_grupo;
    public $curso_programa_plan;
    public $id_curso_programa_plan;
    public $id_admision;
    public $curso;
    public $programa;
    public $grupo;

    public $id_matricula_curso;
    public $matricula_curso;
    public $nota_matricula_curso;
    public $modo_nota = 0;

    public $matriculados;
    public $notas = [];
    public $modo = 'hide';

    public int $matriculados_count = 0;
    public int $matriculados_finalizados_count = 0;

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
        $this->programa = $this->curso_programa_plan->programa_plan->programa;
        $this->grupo = $this->docente_curso->programa_proceso_grupo;
    }

    public function updated($propertyName)
    {
        // Limpiar los mensajes de error cuando se modifiquen los campos
        $this->resetErrorBag($propertyName);
    }

    public function modo_ingresar_notas()
    {
        // emitir alerta de que todas las notas ya fueron ingresadas
        if ( $this->matriculados_count == $this->matriculados_finalizados_count )
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

    public function alerta_asignar_nsp(ModelMatriculaCurso $matricula_curso)
    {
        $this->matricula_curso = $matricula_curso;
        $this->id_matricula_curso = $matricula_curso->id_matricula_curso;

        if ( $this->matricula_curso->estado = 3 ) {
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
        $this->matricula_curso->nota_evaluacion_permanente = 0;
        $this->matricula_curso->nota_evaluacion_medio_curso = 0;
        $this->matricula_curso->nota_evaluacion_final = 0;
        $this->matricula_curso->nota_promedio_final = 0;
        $this->matricula_curso->id_docente = $this->docente_curso->id_docente;
        $this->matricula_curso->estado = 3;
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
        // obtenemos los que tienen nsp
        $countMatriculadosNsp = ModelMatriculaCurso::query()
                        ->where('id_curso_programa_plan', $this->id_curso_programa_plan)
                        ->where('id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
                        ->where('estado', 3)
                        ->where('activo', 1)
                        ->count();

        $count_matriculados_sin_notas = $this->matriculados_count - $countMatriculadosNsp;

        // validar si todos los campos de notas están vacíos y mostrar alerta
        $this->validate([
            'notas' => 'required|array|min:' . $count_matriculados_sin_notas,
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
            $matriculaCurso = ModelMatriculaCurso::find($key);
            $matriculaCurso->id_docente = $this->docente_curso->id_docente;
            $matriculaCurso->nota_evaluacion_permanente = $item['nota1'];
            $matriculaCurso->nota_evaluacion_medio_curso = $item['nota2'];
            $matriculaCurso->nota_evaluacion_final = $item['nota3'];
            $matriculaCurso->nota_promedio_final = calcularPromedio($item['nota1'], $item['nota2'], $item['nota3']);
            $matriculaCurso->estado = $matriculaCurso->nota_promedio_final >= 14 ? 2 : 0;
            $matriculaCurso->save();
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
        // emitir alerta de que todas las notas ya fueron ingresadas
        if ( $this->matriculados_count == $this->matriculados_finalizados_count )
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
        $fecha2 = date('YmdHis');

        $curso_programa_plan = CursoProgramaPlan::find($docente_curso->id_curso_programa_plan);
        $curso_model = Curso::find($curso_programa_plan->id_curso);
        $programa_proceso_grupo = ProgramaProcesoGrupo::find($docente_curso->id_programa_proceso_grupo);
        $programa_model = Programa::find($curso_programa_plan->programa_plan->id_programa);
        $docente_model = Docente::find($docente_curso->id_docente);
        $trabajador = $docente_model->trabajador;
        $grado_academico = $trabajador->grado_academico;

        $admision_año = $docente_curso->admision->admision_año;

        $programa = $programa_model->programa_tipo == 1 ? 'Maestría' : 'Doctorado';
        $subprograma = $programa_model->subprograma;
        $mencion = $programa_model->mencion ? $programa_model->mencion : '';
        $curso = strtoupper($curso_model->curso_nombre);
        $codigo_curso = $curso_model->curso_codigo;
        $docente = $grado_academico->grado_academico_prefijo . ' ' . strtoupper($trabajador->trabajador_nombre_completo);
        $codigo_docente = $trabajador->trabajador_numero_documento;
        $creditos = $curso_model->curso_credito;
        $ciclo = $curso_model->ciclo->ciclo;
        $grupo = $programa_proceso_grupo->grupo_detalle;


        $matriculados = MatriculaCurso::query()
            ->join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
            ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
            ->join('persona', 'admitido.id_persona', 'persona.id_persona')
            ->where('matricula_curso.id_curso_programa_plan', $docente_curso->id_curso_programa_plan)
            ->where('matricula.id_programa_proceso_grupo', $docente_curso->id_programa_proceso_grupo)
            ->where('matricula_curso.matricula_curso_activo', 1)
            ->where('matricula_curso.acta_adicional', 0)
            ->where('matricula_curso.acta_reingreso', 0)
            ->where('matricula_curso.acta_reincorporacion', 0)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();
        $data_regular = [
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
            'admision_año' => $admision_año,
            'tipo' => 'regular'
        ];
        if ($matriculados->count() > 0) {
            $nombre_pdf = 'acta-notas-regular-' . date('dmYHis') . '-' . Str::slug($docente, '-') . '.pdf';
            $path = 'Posgrado/Docente/Actas/';
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }
            Pdf::loadView('modulo-docente.acta-evaluacion.ficha-acta-evaluacion', $data_regular)->save(public_path($path . $nombre_pdf));

            // registrar en la db el acta de notas
            $acta_docente = new ActaDocente();
            $acta_docente->acta_url = $path . $nombre_pdf;
            $acta_docente->id_docente_curso = $id_docente_curso;
            $acta_docente->acta_docente_fecha_creacion = date('Y-m-d H:i:s');
            $acta_docente->acta_docente_estado = 1;
            $acta_docente->es_regular = 1;
            $acta_docente->save();
        }

        $matriculados_adicional = MatriculaCurso::query()
            ->join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
            ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
            ->join('persona', 'admitido.id_persona', 'persona.id_persona')
            ->where('matricula_curso.id_curso_programa_plan', $docente_curso->id_curso_programa_plan)
            ->where('matricula.id_programa_proceso_grupo', $docente_curso->id_programa_proceso_grupo)
            ->where('matricula_curso.matricula_curso_activo', 1)
            ->where('matricula_curso.acta_adicional', 1)
            ->where('matricula_curso.acta_reingreso', 0)
            ->where('matricula_curso.acta_reincorporacion', 0)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();
        $data_adicional = [
            'matriculados_adicional' => $matriculados_adicional,
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
            'admision_año' => $admision_año,
            'tipo' => 'adicional'
        ];
        if ($matriculados_adicional->count() > 0) {
            $nombre_pdf = 'acta-notas-adicional-' . date('dmYHis') . '-' . Str::slug($docente, '-') . '.pdf';
            $path = 'Posgrado/Docente/Actas/';
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }
            Pdf::loadView('modulo-docente.acta-evaluacion.ficha-acta-evaluacion', $data_adicional)->save(public_path($path . $nombre_pdf));

            // registrar en la db el acta de notas
            $acta_docente = new ActaDocente();
            $acta_docente->acta_url = $path . $nombre_pdf;
            $acta_docente->id_docente_curso = $id_docente_curso;
            $acta_docente->acta_docente_fecha_creacion = date('Y-m-d H:i:s');
            $acta_docente->acta_docente_estado = 1;
            $acta_docente->es_adicional = 1;
            $acta_docente->save();
        }

        $matriculados_reingreso = MatriculaCurso::query()
            ->join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
            ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
            ->join('persona', 'admitido.id_persona', 'persona.id_persona')
            ->where('matricula_curso.id_curso_programa_plan', $docente_curso->id_curso_programa_plan)
            ->where('matricula.id_programa_proceso_grupo', $docente_curso->id_programa_proceso_grupo)
            ->where('matricula_curso.matricula_curso_activo', 1)
            ->where('matricula_curso.acta_adicional', 0)
            ->where('matricula_curso.acta_reingreso', 1)
            ->where('matricula_curso.acta_reincorporacion', 0)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();
        $data_reingreso = [
            'matriculados_reingreso' => $matriculados_reingreso,
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
            'admision_año' => $admision_año,
            'tipo' => 'reingreso'
        ];
        if ($matriculados_reingreso->count() > 0) {
            $nombre_pdf = 'acta-notas-reingreso-' . date('dmYHis') . '-' . Str::slug($docente, '-') . '.pdf';
            $path = 'Posgrado/Docente/Actas/';
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }
            Pdf::loadView('modulo-docente.acta-evaluacion.ficha-acta-evaluacion', $data_reingreso)->save(public_path($path . $nombre_pdf));

            // registrar en la db el acta de notas
            $acta_docente = new ActaDocente();
            $acta_docente->acta_url = $path . $nombre_pdf;
            $acta_docente->id_docente_curso = $id_docente_curso;
            $acta_docente->acta_docente_fecha_creacion = date('Y-m-d H:i:s');
            $acta_docente->acta_docente_estado = 1;
            $acta_docente->es_reingreso = 1;
            $acta_docente->save();
        }

        $matriculados_reincorporacion = MatriculaCurso::query()
            ->join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
            ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
            ->join('persona', 'admitido.id_persona', 'persona.id_persona')
            ->where('matricula_curso.id_curso_programa_plan', $docente_curso->id_curso_programa_plan)
            ->where('matricula.id_programa_proceso_grupo', $docente_curso->id_programa_proceso_grupo)
            ->where('matricula_curso.matricula_curso_activo', 1)
            ->where('matricula_curso.acta_adicional', 0)
            ->where('matricula_curso.acta_reingreso', 0)
            ->where('matricula_curso.acta_reincorporacion', 1)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();
        $data_reincorporacion = [
            'matriculados_reincorporacion' => $matriculados_reincorporacion,
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
            'admision_año' => $admision_año,
            'tipo' => 'incorporacion'
        ];
        if ($matriculados_reincorporacion->count() > 0) {
            $nombre_pdf = 'acta-notas-incorporacion-' . date('dmYHis') . '-' . Str::slug($docente, '-') . '.pdf';
            $path = 'Posgrado/Docente/Actas/';
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }
            Pdf::loadView('modulo-docente.acta-evaluacion.ficha-acta-evaluacion', $data_reincorporacion)->save(public_path($path . $nombre_pdf));

            // registrar en la db el acta de notas
            $acta_docente = new ActaDocente();
            $acta_docente->acta_url = $path . $nombre_pdf;
            $acta_docente->id_docente_curso = $id_docente_curso;
            $acta_docente->acta_docente_fecha_creacion = date('Y-m-d H:i:s');
            $acta_docente->acta_docente_estado = 1;
            $acta_docente->es_reincorporacion = 1;
            $acta_docente->save();
        }

        // mostrar alerta de que se generó el acta de notas
        $this->dispatchBrowserEvent('alerta_matriculados', [
            'title' => '¡Éxito!',
            'text' => 'Se generó el acta de notas correctamente.',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);
    }

    public function descargar_actas($acta_docente)
    {
        $array_archivos = [];
        foreach ($acta_docente as $acta) {
            $array_archivos[] = [
                'nombre' => str_replace('Posgrado/Docente/Actas/', '', $acta['acta_url']),
                'url' => asset($acta['acta_url'])
            ];
        }

        $this->dispatchBrowserEvent('descargar_actas', [
            'array_archivos' => $array_archivos
        ]);
    }

    public function exportar_excel_lista_matriculados()
    {
        $matriculados = MatriculaCurso::join('matricula', 'matricula_curso.id_matricula', 'matricula.id_matricula')
            ->join('admitido', 'matricula.id_admitido', 'admitido.id_admitido')
            ->join('persona', 'admitido.id_persona', 'persona.id_persona')
            ->where('matricula_curso.id_curso_programa_plan', $this->id_curso_programa_plan)
            ->where('matricula.id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
            ->where('matricula_curso.id_admision', $this->id_admision)
            ->where('matricula_curso.matricula_curso_activo', 1)
            ->orderBy('persona.nombre_completo', 'asc')
            ->get();
        $nombre_programa = $this->programa->programa . 'EN '. $this->programa->subprograma . ($this->programa->mencion ? ' CON MENCION EN ' . $this->programa->mencion : '');
        $nombre_programa = Str::slug($nombre_programa, '-');
        $nombre_file = 'listado-matriculados-'.$nombre_programa.'-'.date('dmYHis').'.xlsx';
        return Excel::download(new listaMatriculadosExport($matriculados, $this->programa, $this->curso, $this->grupo), $nombre_file);
    }

    public function render()
    {
        $this->matriculados = ModelMatriculaCurso::query()
            ->with([
                'matricula' => function ($query) {
                    $query->with([
                        'admitido' => function ($query) {
                            $query->with([
                                'persona' => function ($query) {
                                    $query->where('nombre_completo', 'like', '%'.$this->search.'%');
                                }
                            ]);
                        }
                    ]);
                }
            ])
            ->where('id_curso_programa_plan', $this->id_curso_programa_plan)
            ->where('id_programa_proceso_grupo', $this->id_programa_proceso_grupo)
            ->where('activo', 1)
            ->whereHas('matricula.admitido.persona', function ($query) {
                $query->where('nombre_completo', 'like', '%'.$this->search.'%');
            })
            ->get();

        $this->matriculados_count = cantidadAlumnosMatriculadosCurso($this->id_curso_programa_plan, $this->id_programa_proceso_grupo);
        $this->matriculados_finalizados_count = cantidadAlumnosMatriculadosCursoFinalizado($this->id_curso_programa_plan, $this->id_programa_proceso_grupo);

        // verificar si ya se agregaron todas las notas
        if ( $this->matriculados_count == $this->matriculados_finalizados_count )
        {
            $this->modo = 'hide';
        }

        // buscamos si el docente genero su acta de notas
        $mostrar_acta = false;
        $acta_docente = ActaDocente::where('id_docente_curso', $this->id_docente_curso)->get();
        foreach ($acta_docente as $acta) {
            if ($acta->es_regular == 1) {
                $mostrar_acta = true;
            }
            if ($acta->es_adicional == 1) {
                $mostrar_acta = true;
            }
            if ($acta->es_reingreso == 1) {
                $mostrar_acta = true;
            }
            if ($acta->es_reincorporacion == 1) {
                $mostrar_acta = true;
            }
        }

        return view('livewire.modulo-docente.matriculados.index', [
            'acta_docente' => $acta_docente,
            'mostrar_acta' => $mostrar_acta
        ]);
    }
}
