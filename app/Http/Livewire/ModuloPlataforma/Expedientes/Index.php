<?php

namespace App\Http\Livewire\ModuloPlataforma\Expedientes;

use App\Jobs\ProcessUpdateFichaInscripcion;
use App\Models\Admision;
use App\Models\Evaluacion;
use App\Models\Expediente;
use App\Models\ExpedienteAdmision;
use App\Models\ExpedienteInscripcion;
use App\Models\Inscripcion;
use App\Models\Persona;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads; // para subir archivos

    public $filtro_proceso; // variable para el filtro de proceso
    public $admision; // variable para la admision activa
    public $admisiones; // variable para todas las admisiones
    public $expedientes; // variable para los expedientes
    public $expedientes_model; // variable para los expedientes
    public $inscripcion; // variable para la inscripcion
    public $id_inscripcion; // variable para el id de la inscripcion
    public $admitido; // variable para el admitido
    public $mostrar_acciones_expediente = false; // variable para mostrar las acciones del expediente

    // variables para el modal
    public $titulo_modal = 'Nuevo expediente'; // titulo del modal
    public $expediente_id; // variable para el id del expediente
    public $expediente_inscripcion_id; // variable para el id del expediente de la inscripcion
    public $expediente; // variable para el expediente
    public $expediente_nombre = ''; // variable para el nombre del expediente
    public $boton_modal = 'Agregar'; // texto del boton del modal
    public $modo = 'crear'; // variable para el modo del modal
    public $iteration = 0; // variable para la iteracion del modal

    protected $listeners = [
        'expediente_registrado' => 'mount',
    ];

    public function mount()
    {
        $this->admision = Admision::where('admision_estado', 1)->first(); // obtenemos la admision activa
        $this->filtro_proceso = $this->admision->id_admision; // asignamos el valor de la admision activa a la variable filtro_proceso
        // $this->admisiones = Admision::orderBy('cod_admi', 'desc')->get(); // obtenemos todas las admisiones
        $persona = Persona::where('id_persona', auth('plataforma')->user()->id_persona)->first(); // obtenemos la persona
        $this->inscripcion = $persona->inscripcion()->orderBy('id_inscripcion', 'desc')->first();
        $this->admisiones = Inscripcion::where('id_persona', $persona->id_persona)->groupBy('id_programa_proceso')->orderBy('id_inscripcion', 'desc')->get(); // obtenemos todas las inscripciones de la persona
        $this->id_inscripcion = $this->inscripcion ? $this->inscripcion->id_inscripcion : null; // asignamos el valor de la inscripcion a la variable id_inscripcion
        $this->expedientes = $this->inscripcion ? $this->inscripcion->expediente_inscripcion : collect(); // obtenemos los expedientes de la inscripcion
        $this->admitido = $persona->admitido()->orderBy('id_admitido', 'desc')->first(); // obtenemos el admitido
        $this->expedientes_model = ExpedienteAdmision::join('expediente', 'expediente.id_expediente', '=', 'expediente_admision.id_expediente')
            ->where('expediente_admision.id_admision', $this->admitido ? $this->admitido->programa_proceso->id_admision : $this->inscripcion->programa_proceso->id_admision)
            ->where(function ($query) {
                $query->where('expediente.expediente_tipo', 0)
                    ->orWhere('expediente.expediente_tipo', $this->admitido ? $this->admitido->programa_proceso->programa_plan->programa->programa_tipo : $this->inscripcion->inscripcion_tipo_programa);
            })->get(); // obtenemos los expedientes segun tipo de programa
        $this->filtro_proceso = $this->admitido ? $this->admitido->id_programa_proceso : $this->inscripcion->id_programa_proceso; // asignamos el valor de la inscripcion a la variable filtro_proceso
        if ($this->admitido) {
            $evaluacion_admitido = $this->admitido->evaluacion; // obtenemos la evaluacion del admitido
            $evaluacion_inscripcion = Evaluacion::where('id_inscripcion', $this->id_inscripcion)->orderBy('id_evaluacion', 'desc')->first(); // obtenemos la evaluacion de la inscripcion
            if ($evaluacion_admitido && $evaluacion_inscripcion) {
                if ($evaluacion_admitido->id_evaluacion != $evaluacion_inscripcion->id_evaluacion) {
                    $this->admitido = null; // asignamos null a la variable admitido
                } else {
                    $inscripcion = Inscripcion::where('id_inscripcion', $evaluacion_admitido->id_inscripcion)->first(); // obtenemos la inscripcion
                    $programa_proceso = $inscripcion->programa_proceso; // obtenemos el programa proceso
                    $admision = $programa_proceso->admision; // obtenemos la admision
                    $fecha_fin_inscripcion = $admision->admision_fecha_fin_inscripcion; // obtenemos la fecha fin de inscripcion
                    $fecha_fin_inscripcion = date('Y-m-d', strtotime($fecha_fin_inscripcion . '+1 month')); // sumamos un mes a la fecha fin de inscripcion
                    if ($fecha_fin_inscripcion <= date('Y-m-d')) {
                        $this->mostrar_acciones_expediente = true; // asignamos null a la variable admitido
                    } else {
                        $this->mostrar_acciones_expediente = false; // asignamos null a la variable admitido
                    }
                }
            }
        }
    }

    public function aplicar_filtro()
    {
        if ($this->filtro_proceso == null) { // si el filtro de proceso esta vacio
            // alerta de error
            $this->dispatchBrowserEvent('alerta-expedientes', [
                'title' => '¡Error!',
                'text' => 'Debe seleccionar un proceso de admisión.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return back();
        }
        $persona = Persona::where('id_persona', auth('plataforma')->user()->id_persona)->first(); // obtenemos la persona
        $this->inscripcion = Inscripcion::where('id_persona', $persona->id_persona)
            ->where('id_programa_proceso', $this->filtro_proceso)->first(); // obtenemos la inscripcion
        $this->expedientes_model = ExpedienteAdmision::join('expediente', 'expediente.id_expediente', '=', 'expediente_admision.id_expediente')
            ->where('expediente_admision.id_admision', $this->inscripcion->programa_proceso->id_admision)
            ->where(function ($query) {
                $query->where('expediente.expediente_tipo', 0)
                    ->orWhere('expediente.expediente_tipo', $this->inscripcion->inscripcion_tipo_programa);
            })->get(); // obtenemos los expedientes segun tipo de programa
        $this->expedientes = ExpedienteInscripcion::where('id_inscripcion', $this->inscripcion->id_inscripcion)->get(); // obtenemos los expedientes de la inscripcion
    }

    public function resetear_filtro()
    {
        $this->mount();
    }

    public function cargar_expediente_inscripcion($id)
    {
        $expediente_inscripcion = ExpedienteInscripcion::find($id); // obtenemos el expediente de la inscripcion
        $this->expediente_id = $expediente_inscripcion->id_expediente_admision; // asignamos el valor del id del expediente a la variable expediente_id
        $this->expediente_nombre = $expediente_inscripcion->expediente_admision->expediente->expediente; // asignamos el valor del nombre del expediente a la variable expediente_nombre
        $this->boton_modal = 'Actualizar'; // asignamos el valor del texto del boton del modal a la variable boton_modal
        $this->titulo_modal = 'Actualizar expediente'; // asignamos el valor del titulo del modal a la variable titulo_modal
        $this->modo = 'editar'; // asignamos el valor del modo del modal a la variable modo
    }

    public function cargar_expediente($id)
    {
        $expediente = ExpedienteAdmision::find($id); // obtenemos el expediente
        $this->expediente_id = $expediente->id_expediente_admision; // asignamos el valor del id del expediente a la variable expediente_id
        $this->expediente_nombre = $expediente->expediente->expediente; // asignamos el valor del nombre del expediente a la variable expediente_nombre
        $this->boton_modal = 'Agregar'; // asignamos el valor del texto del boton del modal a la variable boton_modal
        $this->titulo_modal = 'Nuevo expediente'; // asignamos el valor del titulo del modal a la variable titulo_modal
        $this->modo = 'crear'; // asignamos el valor del modo del modal a la variable modo
    }

    public function limpiar_expediente()
    {
        $this->expediente_id = ''; // asignamos el valor del id del expediente a la variable expediente_id
        $this->expediente_nombre = ''; // asignamos el valor del nombre del expediente a la variable expediente_nombre
        $this->boton_modal = 'Agregar'; // asignamos el valor del texto del boton del modal a la variable boton_modal
        $this->titulo_modal = 'Nuevo expediente'; // asignamos el valor del titulo del modal a la variable titulo_modal
        $this->modo = 'crear'; // asignamos el valor del modo del modal a la variable modo
        $this->iteration++; // incrementamos la iteracion del modal
    }

    public function registrar_expediente()
    {
        $this->validate([
            'expediente' => 'required|file|max:10240|mimetypes:application/octet-stream,application/pdf,application/x-pdf,application/x-download,application/force-download', // validamos el expediente
        ]); // validamos los campos

        if ($this->modo == 'crear') {
            if ($this->expediente != null) {
                // obtenemos la admision
                $admision = $this->inscripcion->programa_proceso->admision->admision;
                // obtenemos el numero de documento
                $numero_documento = $this->inscripcion->persona->numero_documento;
                // obtenemos el nombre del expediente
                $expediente = $this->expediente;
                // obtenemos el id del expediente
                $id_expediente_admision = $this->expediente_id;
                // obtenemos la inscripcion
                $inscripcion = $this->inscripcion;

                // llamamos a la funcion registrarExpedientes
                registrarExpedientes($admision, $numero_documento, $expediente, $id_expediente_admision, $inscripcion, $this->modo);

                // alerta de exito
                $this->dispatchBrowserEvent('alerta-expedientes', [
                    'title' => '¡Exito!',
                    'text' => 'El expediente se registró correctamente.',
                    'icon' => 'success',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'success'
                ]);
            } else {
                // alerta de error
                $this->dispatchBrowserEvent('alerta-expedientes', [
                    'title' => '¡Error!',
                    'text' => 'No se encontró el expediente.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
            }
        } else if ($this->modo == 'editar') {
            if ($this->expediente != null) {
                // obtenemos la admision
                $admision = $this->inscripcion->programa_proceso->admision->admision;
                // obtenemos el numero de documento
                $numero_documento = $this->inscripcion->persona->numero_documento;
                // obtenemos el nombre del expediente
                $expediente = $this->expediente;
                // obtenemos el id del expediente
                $id_expediente_admision = $this->expediente_id;
                // obtenemos la inscripcion
                $inscripcion = $this->inscripcion;

                // llamamos a la funcion registrarExpedientes
                registrarExpedientes($admision, $numero_documento, $expediente, $id_expediente_admision, $inscripcion, $this->modo);

                // alerta de exito
                $this->dispatchBrowserEvent('alerta-expedientes', [
                    'title' => '¡Exito!',
                    'text' => 'El expediente se actualizó correctamente.',
                    'icon' => 'success',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'success'
                ]);
            } else {
                // alerta de error
                $this->dispatchBrowserEvent('alerta-expedientes', [
                    'title' => '¡Error!',
                    'text' => 'No se encontró el expediente.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
            }
        }

        $this->limpiar_expediente(); // limpiamos los campos del expediente
        $this->emit('expediente_registrado'); // emitimos el evento expedienteRegistrado
        $this->dispatchBrowserEvent('modal_expediente', ['action' => 'hide']); // ocultamos el modal

        if ($this->mostrar_acciones_expediente == false) {
            ProcessUpdateFichaInscripcion::dispatch($this->inscripcion); // despachamos el proceso de actualizacion de la ficha de inscripcion
        }
    }

    public function render()
    {
        $fecha_fin_admision = Carbon::parse($this->admision->admision_fecha_fin_inscripcion); // convertimos la fecha de fin de admision a formato carbon
        $fecha_fin_admision = $fecha_fin_admision->locale('es')->isoFormat('D [de] MMMM [de] YYYY'); // formateamos la fecha de fin de admision a español
        return view('livewire.modulo-plataforma.expedientes.index', [
            'fecha_fin_admision' => $fecha_fin_admision
        ]);
    }
}
