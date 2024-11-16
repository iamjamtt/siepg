<?php

namespace App\Http\Livewire\ModuloAdministrador\GestionMatricula;

use App\Models\Admision;
use App\Models\Ciclo;
use App\Models\Coordinador;
use App\Models\MatriculaGestion;
use App\Models\ProgramaProceso;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads; // trait de carga de archivos
    use WithPagination; // trait de paginacion
    protected $paginationTheme = 'bootstrap'; // tema de paginacion

    public $matricula_gestion;

    //variables del modal
    public $title_modal = 'Nueva Matricula';
    public $modo = 'create';
    public $proceso;
    public $programa_academico;
    public $ciclo;
    public $fecha_inicio, $fecha_fin, $fecha_extemporanea_inicio, $fecha_extemporanea_fin;
    public $alumnos_minimos;
    public $nombre_resolucion, $resolucion;
    public $nombre_resolucion_form = "", $resolucion_form = "";
    public $iteration = 0;

    // variables de filtro
    public $filtro_proceso;
    public $proceso_data;
    public $filtro_programa;
    public $programa_data;
    public $filtro_ciclo;
    public $ciclo_data;

    protected $queryString = [
        'filtro_proceso' => ['except' => ''],
        'proceso_data' => ['except' => ''],
        'filtro_programa' => ['except' => ''],
        'programa_data' => ['except' => ''],
        'filtro_ciclo' => ['except' => ''],
        'ciclo_data' => ['except' => ''],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'proceso' => 'required',
            'programa_academico' => 'required',
            'ciclo' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'fecha_extemporanea_inicio' => 'required|date|after_or_equal:fecha_fin',
            'fecha_extemporanea_fin' => 'required|date|after_or_equal:fecha_extemporanea_inicio',
            'alumnos_minimos' => 'required|numeric|min:1'
        ]);
    }

    public function modo()
    {
        $this->limpiar_modal();
        $this->modo = 'create';
        $this->title_modal = 'Nueva Matricula';
        $this->nombre_resolucion_form = "Nombre de la Resolucion";
        $this->resolucion_form = "Documento de la Resolucion";
    }

    public function limpiar_modal()
    {
        $this->reset(
            'proceso',
            'programa_academico',
            'ciclo',
            'fecha_inicio',
            'fecha_fin',
            'fecha_extemporanea_inicio',
            'fecha_extemporanea_fin',
            'alumnos_minimos',
            'nombre_resolucion',
            'resolucion'
        );
        $this->resetErrorBag();
        $this->resetValidation();
        $this->iteration++;
    }

    public function aplicar_filtro()
    {
        $this->proceso_data = $this->filtro_proceso;
        $this->programa_data = $this->filtro_programa;
        $this->ciclo_data = $this->filtro_ciclo;
    }

    public function resetear_filtro()
    {
        $this->reset([
            'filtro_proceso',
            'proceso_data',
            'filtro_programa',
            'programa_data',
            'filtro_ciclo',
            'ciclo_data'
        ]);
    }

    public function cargar_matricula(MatriculaGestion $matricula_gestion)
    {
        $this->modo = 'edit';
        $this->title_modal = 'Editar Matricula';
        $this->nombre_resolucion_form = "Nombre de la Resolucion";
        $this->resolucion_form = "Documento de la Resolucion";
        $this->matricula_gestion = $matricula_gestion;
        $this->proceso = $matricula_gestion->id_admision;
        $this->programa_academico = $matricula_gestion->id_programa_proceso;
        $this->ciclo = $matricula_gestion->id_ciclo;
        $this->fecha_inicio = $matricula_gestion->matricula_gestion_fecha_inicio;
        $this->fecha_fin = $matricula_gestion->matricula_gestion_fecha_fin;
        $this->fecha_extemporanea_inicio = $matricula_gestion->matricula_gestion_fecha_extemporanea_inicio;
        $this->fecha_extemporanea_fin = $matricula_gestion->matricula_gestion_fecha_extemporanea_fin;
        $this->alumnos_minimos = $matricula_gestion->matricula_gestion_minimo_alumnos;
        $this->nombre_resolucion = $matricula_gestion->matricula_gestion_resolucion;
    }

    public function cargar_matricula_ampliacion(MatriculaGestion $matricula_gestion)
    {
        $this->modo = 'ampliacion';
        $this->title_modal = 'Editar Matricula para Ampliacion';
        $this->nombre_resolucion_form = "Nombre de la Resolucion de Ampliacion";
        $this->resolucion_form = "Documento de la Resolucion de Ampliacion";
        $this->matricula_gestion = $matricula_gestion;
        $this->proceso = $matricula_gestion->id_admision;
        $this->programa_academico = $matricula_gestion->id_programa_proceso;
        $this->ciclo = $matricula_gestion->id_ciclo;
        $this->fecha_inicio = $matricula_gestion->matricula_gestion_fecha_inicio;
        $this->fecha_fin = $matricula_gestion->matricula_gestion_fecha_fin;
        $this->fecha_extemporanea_inicio = $matricula_gestion->matricula_gestion_fecha_extemporanea_inicio;
        $this->fecha_extemporanea_fin = $matricula_gestion->matricula_gestion_fecha_extemporanea_fin;
        $this->alumnos_minimos = $matricula_gestion->matricula_gestion_minimo_alumnos;
        $this->nombre_resolucion = $matricula_gestion->matricula_gestion_resolucion_ampliacion;
    }

    public function guardar_matricula()
    {
        $this->validate([
            'proceso' => 'required',
            'programa_academico' => 'required',
            'ciclo' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'fecha_extemporanea_inicio' => 'required|date|after_or_equal:fecha_fin',
            'fecha_extemporanea_fin' => 'required|date|after_or_equal:fecha_extemporanea_inicio',
            'alumnos_minimos' => 'required|numeric|min:1',
            'nombre_resolucion' => $this->modo == 'create' || $this->modo == 'ampliacion' ? 'required' : 'nullable',
            'resolucion' => $this->modo == 'create' || $this->modo == 'ampliacion' ? 'required|mimes:pdf|max:10240' : 'nullable|mimes:pdf|max:10240',
        ]);

        if ($this->modo == 'create')
        {
            $matricula_gestion = new MatriculaGestion();
            $matricula_gestion->id_programa_proceso = $this->programa_academico;
            $matricula_gestion->id_admision = $this->proceso;
            $matricula_gestion->id_ciclo = $this->ciclo;
            $matricula_gestion->matricula_gestion_fecha_inicio = $this->fecha_inicio;
            $matricula_gestion->matricula_gestion_fecha_fin = $this->fecha_fin;
            $matricula_gestion->matricula_gestion_fecha_extemporanea_inicio = $this->fecha_extemporanea_inicio;
            $matricula_gestion->matricula_gestion_fecha_extemporanea_fin = $this->fecha_extemporanea_fin;
            $matricula_gestion->matricula_gestion_fecha_creacion = date('Y-m-d H:i:s');
            $matricula_gestion->matricula_gestion_estado = 1;
            $matricula_gestion->matricula_gestion_minimo_alumnos = $this->alumnos_minimos;
            $matricula_gestion->matricula_gestion_resolucion = $this->nombre_resolucion;
            if($this->resolucion)
            {
                $slug_resolucion = Str::slug($this->nombre_resolucion);
                $path = 'Posgrado/Matricula/Resolucion/';
                $filename = $slug_resolucion.'-'.date('YmdHis').'.pdf';
                $nombre_db = $path.$filename;
                $data = $this->resolucion;
                $data->storeAs($path, $filename, 'files_publico');
                $matricula_gestion->matricula_gestion_resolucion_url = $nombre_db;
            }
            $matricula_gestion->save();
        }
        else if ($this->modo == 'edit')
        {
            $this->matricula_gestion->id_programa_proceso = $this->programa_academico;
            $this->matricula_gestion->id_admision = $this->proceso;
            $this->matricula_gestion->id_ciclo = $this->ciclo;
            $this->matricula_gestion->matricula_gestion_fecha_inicio = $this->fecha_inicio;
            $this->matricula_gestion->matricula_gestion_fecha_fin = $this->fecha_fin;
            $this->matricula_gestion->matricula_gestion_fecha_extemporanea_inicio = $this->fecha_extemporanea_inicio;
            $this->matricula_gestion->matricula_gestion_fecha_extemporanea_fin = $this->fecha_extemporanea_fin;
            $this->matricula_gestion->matricula_gestion_minimo_alumnos = $this->alumnos_minimos;
            $this->matricula_gestion->matricula_gestion_resolucion = $this->nombre_resolucion;
            if($this->resolucion)
            {
                $slug_resolucion = Str::slug($this->nombre_resolucion);
                $path = 'Posgrado/Matricula/Resolucion/';
                $filename = $slug_resolucion.'-'.date('YmdHis').'.pdf';
                $nombre_db = $path.$filename;
                $data = $this->resolucion;
                $data->storeAs($path, $filename, 'files_publico');
                $this->matricula_gestion->matricula_gestion_resolucion_url = $nombre_db;
            }
            $this->matricula_gestion->save();
        }
        else if ($this->modo == 'ampliacion')
        {
            $this->matricula_gestion->matricula_gestion_fecha_fin = $this->fecha_fin;
            $this->matricula_gestion->matricula_gestion_fecha_extemporanea_inicio = $this->fecha_extemporanea_inicio;
            $this->matricula_gestion->matricula_gestion_fecha_extemporanea_fin = $this->fecha_extemporanea_fin;
            $this->matricula_gestion->matricula_gestion_resolucion_ampliacion = $this->nombre_resolucion;
            if($this->resolucion)
            {
                $slug_resolucion = Str::slug($this->nombre_resolucion);
                $path = 'Posgrado/Matricula/Resolucion/';
                $filename = $slug_resolucion.'-'.date('YmdHis').'.pdf';
                $nombre_db = $path.$filename;
                $data = $this->resolucion;
                $data->storeAs($path, $filename, 'files_publico');
                $this->matricula_gestion->matricula_gestion_resolucion_ampliacion_url = $nombre_db;
            }
            $this->matricula_gestion->save();
        }

        // evento para cerrar el modal
        $this->dispatchBrowserEvent('modal_gestion_matricula', ['action' => 'hide']);

        // evento para mostrar mensaje de éxito
        if ($this->modo == 'create')
        {
            $this->dispatchBrowserEvent('alerta_matricula', [
                'title' => '¡Éxito!',
                'text' => 'Matricula registrada correctamente.',
                'icon' => 'success',
                'confirmButtonText' => 'Aceptar',
                'color' => 'success'
            ]);
        }
        else if ($this->modo == 'edit')
        {
            $this->dispatchBrowserEvent('alerta_matricula', [
                'title' => '¡Éxito!',
                'text' => 'Matricula actualizada correctamente.',
                'icon' => 'success',
                'confirmButtonText' => 'Aceptar',
                'color' => 'success'
            ]);
        }
        else if ($this->modo == 'ampliacion')
        {
            $this->dispatchBrowserEvent('alerta_matricula', [
                'title' => '¡Éxito!',
                'text' => 'Ampliación de matricula registrada correctamente.',
                'icon' => 'success',
                'confirmButtonText' => 'Aceptar',
                'color' => 'success'
            ]);
        }
    }

    public function render()
    {
        $matriculas = MatriculaGestion::where('id_admision', $this->proceso_data ? '=' : '!=', $this->proceso_data)
            ->where('id_programa_proceso', $this->programa_data ? '=' : '!=', $this->programa_data)
            ->where('id_ciclo', $this->ciclo_data ? '=' : '!=', $this->ciclo_data)
            ->orderBy('id_matricula_gestion', 'desc')
            ->paginate(10);

        $admisiones = Admision::orderBy('admision', 'desc')->get();

        if ($this->proceso)
        {
            $programas_model = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
                ->where('programa_proceso.id_admision', $this->proceso)
                ->get();
            $ciclos_model = collect();
        }
        else
        {
            $programas_model = collect();
            $this->programa_academico = null;
            $ciclos_model = collect();
            $this->ciclo = null;
        }

        if ($this->programa_academico)
        {
            $programa = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
                ->where('programa_proceso.id_programa_proceso', $this->programa_academico)
                ->first();

            if($programa)
            {
                $ciclos_model = Ciclo::where(function ($query) use ($programa){
                                            $query->where('ciclo_programa', $programa->programa_tipo)
                                                ->orWhere('ciclo_programa', 0);
                                        })
                                        ->get();
            }
            else
            {
                $ciclos_model = collect();
                $this->ciclo = null;
            }
        }
        else
        {
            $ciclos_model = collect();
            $this->ciclo = null;
        }

        if ($this->filtro_proceso)
        {
            $programas_model_filtro = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
                ->where('programa_proceso.id_admision', $this->filtro_proceso)
                ->get();
            $ciclos_model_filtro = collect();
        }
        else
        {
            $programas_model_filtro = collect();
            $this->filtro_programa = null;
            $this->programa_data = null;
            $ciclos_model_filtro = collect();
            $this->filtro_ciclo = null;
            $this->ciclo_data = null;
        }

        if ($this->filtro_programa)
        {
            $programa = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
                ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
                ->where('programa_proceso.id_programa_proceso', $this->filtro_programa)
                ->first();

            if($programa)
            {
                $ciclos_model_filtro = Ciclo::where(function ($query) use ($programa){
                                            $query->where('ciclo_programa', $programa->programa_tipo)
                                                ->orWhere('ciclo_programa', 0);
                                        })
                                        ->get();
            }
            else
            {
                $ciclos_model_filtro = collect();
                $this->filtro_ciclo = null;
                $this->ciclo_data = null;
            }
        }
        else
        {
            $ciclos_model_filtro = collect();
            $this->filtro_ciclo = null;
            $this->ciclo_data = null;
        }

        return view('livewire.modulo-coordinador.gestion-matricula.index', [
            'matriculas' => $matriculas,
            'admisiones' => $admisiones,
            'programas_model' => $programas_model,
            'programas_model_filtro' => $programas_model_filtro,
            'ciclos_model' => $ciclos_model,
            'ciclos_model_filtro' => $ciclos_model_filtro
        ]);
    }
}
