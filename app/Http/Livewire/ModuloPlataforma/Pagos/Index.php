<?php

namespace App\Http\Livewire\ModuloPlataforma\Pagos;

use App\Models\Admision;
use App\Models\Admitido;
use App\Models\AdmitidoCiclo;
use App\Models\CanalPago;
use App\Models\ConceptoPago;
use App\Models\ConstanciaIngreso;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\MatriculaGestion;
use App\Models\Mensualidad;
use App\Models\Pago;
use App\Models\PagoObservacion;
use App\Models\Persona;
use App\Models\ProgramaProcesoGrupo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads; // trait para subir archivos
    use WithPagination; // trait para paginacion
    protected $paginationTheme = 'bootstrap'; // tema de paginacion

    public $titulo_modal_pago = 'Registrar Pago'; // titulo del modal de pago
    public $id_pago; // variable para el id del pago
    public $admitido; // variable para el admitido
    public $documento_identidad, $numero_operacion, $monto_operacion, $fecha_pago, $canal_pago, $concepto_pago, $voucher, $iteration = 0, $grupo; // variables para el formulario del modal de registro
    public $modo = 'create'; // variable para el modo de la vista
    public $activar_voucher = false; // variable para activar el voucher
    public $button_modal = 'Registrar Pago'; // variable para el boton del modal de registro
    public $terminos_condiciones_pagos = false; // variable para los terminos y condiciones de los pagos

    // variables para el filtro
    public $search = '';
    public $filtro_concepto_pago; // variable para el filtro de concepto de pago
    public $concepto_pago_data; // variable para el concepto de pago

    protected $queryString = [ // variables de la url
        'search' => ['except' => ''],
        'filtro_concepto_pago' => ['except' => ''],
        'concepto_pago_data' => ['except' => ''],
    ];

    protected $listeners = [
        'guardar_pago' => 'guardar_pago',
    ]; // listener para mostrar alertas

    public function mount()
    {
        $this->limpiar_pago();
        $this->documento_identidad = auth('plataforma')->user()->usuario_estudiante;
    }

    public function updated($propertyName)
    {
        if($this->modo == 'create')
        {
            $this->validateOnly($propertyName, [
                'documento_identidad' => 'required|numeric|digits_between:8,9',
                'numero_operacion' => 'required|numeric',
                'monto_operacion' => 'required|numeric',
                'fecha_pago' => 'required|date',
                'canal_pago' => 'required|numeric',
                'concepto_pago' => 'required|numeric',
                'voucher' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'terminos_condiciones_pagos' => 'accepted'
            ]);
        }
        elseif($this->modo == 'edit')
        {
            $this->validateOnly($propertyName, [
                'documento_identidad' => 'required|numeric|digits_between:8,9',
                'numero_operacion' => 'required|numeric',
                'monto_operacion' => 'required|numeric',
                'fecha_pago' => 'required|date',
                'canal_pago' => 'required|numeric',
                'concepto_pago' => 'required|numeric',
                'voucher' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'terminos_condiciones_pagos' => 'nullable'
            ]);
        }
    }

    public function aplicar_filtro()
    {
        $this->resetPage();
        $this->concepto_pago_data = $this->filtro_concepto_pago;
    }

    public function resetear_filtro()
    {
        $this->resetPage();
        $this->reset([
            'filtro_concepto_pago',
            'concepto_pago_data'
        ]);
    }

    public function modo()
    {
        $this->modo = 'create';
        $this->button_modal = 'Registrar Pago';
        $this->limpiar_pago();
    }

    public function cargar_pago(Pago $pago)
    {
        $this->id_pago = $pago->id_pago;
        $this->titulo_modal_pago = 'Editar Pago';
        $this->documento_identidad = $pago->pago_documento;
        $this->numero_operacion = $pago->pago_operacion;
        $this->monto_operacion = $pago->pago_monto;
        $this->fecha_pago = $pago->pago_fecha;
        $this->canal_pago = $pago->id_canal_pago;
        $this->concepto_pago = $pago->id_concepto_pago;
        $this->modo = 'edit';
        $this->button_modal = 'Editar Pago';
        if($pago->pago_estado == 0 && $pago->pago_verificacion == 0)
        {
            $this->activar_voucher = true;
        }
        else
        {
            $this->activar_voucher = false;
        }
    }

    public function limpiar_pago()
    {
        $this->reset(['numero_operacion', 'monto_operacion', 'fecha_pago', 'canal_pago', 'voucher', 'concepto_pago', 'terminos_condiciones_pagos']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->iteration++;
        $this->modo = 'create';
    }

    public function alerta_guardar_pago()
    {
        // validar formulario de registro de pago
        if($this->modo == 'create')
        {
            $this->validate([
                'documento_identidad' => 'required|numeric|digits_between:8,9',
                'numero_operacion' => 'required|numeric',
                'monto_operacion' => 'required|numeric',
                'fecha_pago' => 'required|date',
                'canal_pago' => 'required|numeric',
                'concepto_pago' => 'required|numeric',
                'voucher' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'terminos_condiciones_pagos' => 'accepted'
            ]);

            // validar si el estudiante existe en la plataforma
            $persona = Persona::where('numero_documento', $this->documento_identidad)->first();
            $admitido = $this->admitido;
            if($persona == null)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El número de documento ingresado no se encuentra registrado en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }
            if($this->documento_identidad != $admitido->persona->numero_documento)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El número de documento ingresado no coincide con el número de documento del postulante admitido.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento, fecha de operacion y concepto de pago ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->numero_operacion)
                        ->where('pago_documento', $this->documento_identidad)
                        ->where('pago_fecha', $this->fecha_pago)
                        ->where('id_concepto_pago', $this->concepto_pago)
                        ->first();
            if($pago)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, número de documento, fecha de operación y concepto de pago ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // valiadar si el numero de operacion, fecha de operacion y concepto de pago ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->numero_operacion)
                        ->where('pago_fecha', $this->fecha_pago)
                        ->where('id_concepto_pago', $this->concepto_pago)
                        ->first();
            if($pago)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, fecha de operación y concepto de pago ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento y concepto de pago ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->numero_operacion)
                        ->where('pago_documento', $this->documento_identidad)
                        ->where('id_concepto_pago', $this->concepto_pago)
                        ->first();
            if($pago)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, número de documento y concepto de pago ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento y fecha de operacion ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->numero_operacion)
                        ->where('pago_documento', $this->documento_identidad)
                        ->where('pago_fecha', $this->fecha_pago)
                        ->first();
            if($pago)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, número de documento y fecha de operación ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->numero_operacion)
                        ->where('pago_documento', $this->documento_identidad)
                        ->first();
            if($pago)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación y número de documento ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el monto de opreacion ingresado es menor al monto del concepto de pago seleccionado
            $concepto_pago = ConceptoPago::find($this->concepto_pago);
            if($this->monto_operacion < $concepto_pago->concepto_pago_monto)
            {
                $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                    'title' => '¡Error!',
                    'text' => 'El monto de operación ingresado es menor al monto del concepto de pago seleccionado.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el concepto es de constancia de ingreso y verificar si ya genero su constancia de ingreso
            if($this->concepto_pago == 2)
            {
                $persona = Persona::where('numero_documento', $this->documento_identidad)->first();
                $admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first();
                $constancia = ConstanciaIngreso::where('id_admitido', $admitido->id_admitido)->first();
                if($constancia)
                {
                    $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                        'title' => '¡Error!',
                        'text' => 'Usted ya generó su constancia de ingreso, por favor realice el proceso de matrícula.',
                        'icon' => 'error',
                        'confirmButtonText' => 'Aceptar',
                        'color' => 'danger'
                    ]);
                    return;
                }
            }

            // validar si el concepto es el de matriccula o matricula extemporanea y verificar si ya genero su constancia de ingreso
            if($this->concepto_pago == 3 || $this->concepto_pago == 5)
            {
                $persona = Persona::where('numero_documento', $this->documento_identidad)->first();
                $admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first();
                $constancia = ConstanciaIngreso::where('id_admitido', $admitido->id_admitido)->first();
                if($constancia == null)
                {
                    $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                        'title' => '¡Error!',
                        'text' => 'Constancia de Ingreso no generada, por favor realice el proceso para generar su Constancia de Ingreso.',
                        'icon' => 'error',
                        'confirmButtonText' => 'Aceptar',
                        'color' => 'danger'
                    ]);
                    return;
                }
            }

            // validar si el pago a registrar pertenece a la matricula extemporanea
            $fecha_matricula_extemporanea_inicio = Admision::where('admision_estado',1)->first()->admision_fecha_inicio_matricula_extemporanea;
            $fecha_matricula_extemporanea_fin = Admision::where('admision_estado',1)->first()->admision_fecha_fin_matricula_extemporanea;
            if($this->concepto_pago != 5 || $this->concepto_pago != 6)
            {
                if($this->concepto_pago == 3 || $this->concepto_pago == 4)
                {
                    if($this->fecha_pago >= $fecha_matricula_extemporanea_inicio && $this->fecha_pago <= $fecha_matricula_extemporanea_fin)
                    {
                        $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                            'title' => '¡Error!',
                            'text' => 'El pago que usted desea registrar pertenece a la matrícula extemporánea, por favor realice el proceso de matrícula extemporánea.',
                            'icon' => 'error',
                            'confirmButtonText' => 'Aceptar',
                            'color' => 'danger'
                        ]);
                        return;
                    }
                }
            }

            // validar si ya cuenta con el pago de su ficha de matricula del ciclo correspondiente

            // validar si el registro del pago es del ciclo correspondiente
        }
        else
        {
            if($this->activar_voucher == true)
            {
                $this->validate([
                    'documento_identidad' => 'required|numeric|digits_between:8,9',
                    'numero_operacion' => 'required|numeric',
                    'monto_operacion' => 'required|numeric',
                    'fecha_pago' => 'required|date',
                    'canal_pago' => 'required|numeric',
                    'concepto_pago' => 'required|numeric',
                    'voucher' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                    'terminos_condiciones_pagos' => 'nullable'
                ]);
            }
            else
            {
                $this->validate([
                    'documento_identidad' => 'required|numeric|digits_between:8,9',
                    'numero_operacion' => 'required|numeric',
                    'monto_operacion' => 'required|numeric',
                    'fecha_pago' => 'required|date',
                    'canal_pago' => 'required|numeric',
                    'concepto_pago' => 'required|numeric',
                    'voucher' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                    'terminos_condiciones_pagos' => 'nullable'
                ]);
            }
        }

        if($this->modo == 'create')
        {
            $this->dispatchBrowserEvent('alerta_pago_plataforma_2', [
                'title' => 'Confirmar Registro',
                'text' => '¿Está seguro de registrar el pago?',
                'icon' => 'question',
                'confirmButtonText' => 'Registrar',
                'cancelButtonText' => 'Cancelar',
                'confirmButtonColor' => 'primary',
                'cancelButtonColor' => 'danger'
            ]);
        }
        else
        {
            $this->dispatchBrowserEvent('alerta_pago_plataforma_2', [
                'title' => 'Confirmar Actualización',
                'text' => '¿Está seguro de actualizar el pago?',
                'icon' => 'question',
                'confirmButtonText' => 'Actualizar',
                'cancelButtonText' => 'Cancelar',
                'confirmButtonColor' => 'primary',
                'cancelButtonColor' => 'danger'
            ]);
        }
    }

    public function guardar_pago()
    {
        // guardar pago
        if($this->modo == 'create')
        {
            $pago = new Pago();
            $pago->pago_documento = $this->documento_identidad;
            $pago->pago_operacion = $this->numero_operacion;
            $pago->pago_monto = $this->monto_operacion;
            $pago->pago_fecha = $this->fecha_pago;
            $pago->pago_estado = 1;
            $pago->pago_verificacion = 1;
            if($this->voucher)
            {
                $persona = Persona::where('numero_documento', $this->documento_identidad)->first();
                $inscripcion = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first();
                $admision = $inscripcion->programa_proceso->admision->admision;
                $path = 'Posgrado/' . $admision . '/' . $this->documento_identidad . '/' . 'Voucher/';
                $filename = 'voucher-pago.' . $this->voucher->getClientOriginalExtension();
                $nombre_db = $path.$filename;
                $data = $this->voucher;
                $data->storeAs($path, $filename, 'files_publico');
                $pago->pago_voucher_url = $nombre_db;
            }
            $pago->id_canal_pago = $this->canal_pago;
            $pago->id_concepto_pago = $this->concepto_pago;
            $pago->save();

            // registrar tipo de pago
            $this->registrar_tipo_pago($pago->id_pago);
        }
        else
        {
            $pago = Pago::find($this->id_pago);
            $pago->pago_documento = $this->documento_identidad;
            $pago->pago_operacion = $this->numero_operacion;
            $pago->pago_monto = $this->monto_operacion;
            $pago->pago_fecha = $this->fecha_pago;
            $pago->pago_estado = 1;
            $pago->pago_verificacion = 1;
            $pago->pago_leido = 1;
            if($this->voucher)
            {
                $persona = Persona::where('numero_documento', $this->documento_identidad)->first();
                $inscripcion = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first();
                $admision = $inscripcion->programa_proceso->admision->admision;
                $path = 'Posgrado/' . $admision . '/' . $this->documento_identidad . '/' . 'Voucher/';
                $filename = 'voucher-pago.' . $this->voucher->getClientOriginalExtension();
                $nombre_db = $path.$filename;
                $data = $this->voucher;
                $data->storeAs($path, $filename, 'files_publico');
                $pago->pago_voucher_url = $nombre_db;
            }
            $pago->id_canal_pago = $this->canal_pago;
            $pago->id_concepto_pago = $this->concepto_pago;
            $pago->save();

            // cambiar de estado a la observacion del pago
            $observacion = PagoObservacion::where('id_pago', $pago->id_pago)->orderBy('id_pago_observacion', 'desc')->get();
            if($observacion)
            {
                foreach($observacion as $item)
                {
                    $item->pago_observacion_estado = 0;
                    $item->save();
                }
            }

            // emitir alerta de exito
            $this->dispatchBrowserEvent('alerta_pago_plataforma', [
                'title' => '!Exito!',
                'text' => 'Pago ha sido guardado con exito, espere a que sea validado por el administrador.',
                'icon' => 'success',
                'confirmButtonText' => 'Aceptar',
                'color' => 'success'
            ]);

            // emitir evento para actualizar el contador de notificaciones
            $this->emit('actualizar_notificaciones');
        }

        // emitir evento para actualizar el sidebar de la plataforma del estudiante
        $this->emit('actualizar_sidebar');

        // limpiar formulario
        $this->limpiar_pago();

        // cerra el modal
        $this->dispatchBrowserEvent('modal_pago_plataforma', [
            'action' => 'hide'
        ]);
    }

    public function registrar_tipo_pago($id_pago)
    {
        $pago = Pago::find($id_pago);
        $admitido = $this->admitido;

        // // generar codigo de matricula
        // $codigo = 'M000000001';

        // si el pago es de concepto de constancia de ingreso
        if( $pago->id_concepto_pago == 2 || $pago->id_concepto_pago == 4  || $pago->id_concepto_pago == 6 )
        {
            // registrar constancia de ingreso
            $constancia = new ConstanciaIngreso();
            $constancia->constancia_ingreso_fecha = date('Y-m-d');
            $constancia->id_pago = $pago->id_pago;
            $constancia->id_admitido = $admitido->id_admitido;
            $constancia->constancia_ingreso_estado = 1;
            $constancia->save();

            if( $pago->id_concepto_pago == 2 )
            {
                // cambiar de estado
                $pago->pago_estado = 2;
                $pago->save();
            }
        }
        // if ( $pago->id_concepto_pago == 3 || $pago->id_concepto_pago == 5 )
        // {
        //     $matricula = Matricula::orderBy('id_matricula', 'desc')->first();
        //     if ( $matricula )
        //     {
        //         $codigo = 'M' . str_pad($matricula->id_matricula + 1, 9, "0", STR_PAD_LEFT);
        //     }
        //     else
        //     {
        //         $codigo = 'M000000001';
        //     }
        //     // registrar matricula
        //     $matricula = new Matricula();
        //     $matricula->matricula_codigo = $codigo;
        //     $matricula->matricula_proceso = $admitido->programa_proceso->admision->admision;
        //     $matricula->matricula_year = date('Y-m-d');
        //     $matricula->matricula_fecha_creacion = date('Y-m-d');
        //     $matricula->matricula_estado = 1;
        //     $matricula->id_admitido = $admitido->id_admitido;
        //     $matricula->id_programa_proceso_grupo = $this->grupo;
        //     $matricula->id_ciclo = 1;
        //     $matricula->id_pago = $pago->id_pago;
        //     $matricula->save();

        //     // cambiar de estado
        //     $pago->pago_estado = 2;
        //     $pago->save();
        // }
        // if ( $pago->id_concepto_pago == 4  || $pago->id_concepto_pago == 6 )
        // {
        //     // registrar constancia de ingreso
        //     $constancia = new ConstanciaIngreso();
        //     $constancia->constancia_ingreso_fecha = date('Y-m-d');
        //     $constancia->id_pago = $pago->id_pago;
        //     $constancia->id_admitido = $admitido->id_admitido;
        //     $constancia->constancia_ingreso_estado = 1;
        //     $constancia->save();

        //     // creamos el codigo de matricula
        //     $matricula = Matricula::orderBy('id_matricula', 'desc')->first();
        //     if ( $matricula )
        //     {
        //         $codigo = 'M' . str_pad($matricula->id_matricula + 1, 9, "0", STR_PAD_LEFT);
        //     }
        //     else
        //     {
        //         $codigo = 'M000000001';
        //     }
        //     // registrar matricula
        //     $matricula = new Matricula();
        //     $matricula->matricula_codigo = $codigo;
        //     $matricula->matricula_proceso = $admitido->programa_proceso->admision->admision;
        //     $matricula->matricula_year = date('Y-m-d');
        //     $matricula->matricula_fecha_creacion = date('Y-m-d');
        //     $matricula->matricula_estado = 1;
        //     $matricula->id_admitido = $admitido->id_admitido;
        //     $matricula->id_programa_proceso_grupo = $this->grupo;
        //     $matricula->id_ciclo = 1;
        //     $matricula->id_pago = $pago->id_pago;
        //     $matricula->save();

        //     // cambiar de estado
        //     $pago->pago_estado = 2;
        //     $pago->save();
        // }

        // si el pago es de concepto de mensualidad
        if ( $pago->id_concepto_pago == 7 )
        {
            // buscar la matricula del admitido
            $ciclo = AdmitidoCiclo::where('id_admitido', $admitido->id_admitido)->where('admitido_ciclo_estado', 1)->orderBy('id_admitido_ciclo', 'desc')->first();
            $matricula = Matricula::where('id_admitido', $admitido->id_admitido)->where('id_ciclo', $ciclo->id_ciclo)->where('matricula_estado', 1)->first();
            // registrar mensualidad
            $mensualidad = new Mensualidad();
            $mensualidad->id_matricula = $matricula->id_matricula;
            $mensualidad->id_pago = $pago->id_pago;
            $mensualidad->id_admitido = $admitido->id_admitido;
            $mensualidad->mensualidad_fecha_creacion = date('Y-m-d H:i:s');
            $mensualidad->mensualidad_estado = 1;
            $mensualidad->save();

            // cambiar de estado
            $pago->pago_estado = 2;
            $pago->save();
        }
    }

    public function render()
    {
        $canal_pagos = CanalPago::where('canal_pago_estado', 1)->get();
        $pagos = Pago::where(function ($query) {
                            $query->where('pago_operacion', 'like', '%' . $this->search . '%')
                                ->orWhere('id_pago', 'like', '%' . $this->search . '%');
                        })
                        ->where('pago_documento', auth('plataforma')->user()->usuario_estudiante)
                        ->where('id_concepto_pago', $this->concepto_pago_data ? '=' : '!=', $this->concepto_pago_data)
                        ->orderBy('id_pago', 'desc')
                        ->paginate(5); // pagos del usuario logueado
        $persona = Persona::where('numero_documento', auth('plataforma')->user()->usuario_estudiante)->first(); // persona del usuario logueado
        $inscripcion_ultima = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first(); // inscripcion del usuario logueado
        $evaluacion = $inscripcion_ultima->evaluacion; // evaluacion de la inscripcion del usuario logueado
        $admision = null;
        $grupos = null;
        $constancia_ingreso = null;
        $matricula_gestion = null;
        $ciclo_actual = null;
        if($evaluacion)
        {
            $this->admitido = $persona->admitido->where('id_evaluacion', $evaluacion->id_evaluacion)->first(); // admitido de la inscripcion del usuario logueado
            if($this->admitido)
            {
                $ciclo_actual = AdmitidoCiclo::where('id_admitido', $this->admitido->id_admitido)->where('admitido_ciclo_estado', 1)->orderBy('id_admitido_ciclo', 'desc')->first(); // ciclo actual del admitido del usuario logueado
                // dd($ciclo_actual);
                $admision = $this->admitido->programa_proceso->admision; // admision del admitido del usuario logueado
                if ( $admision )
                {
                    $admision_actual = Admision::where('admision_estado', 1)->first(); // admision actual
                    if ( $admision_actual )
                    {
                        if ( $admision->id_admision != $admision_actual->id_admision )
                        {
                            $admision = null;
                        }
                    }

                    $grupos = ProgramaProcesoGrupo::where('id_programa_proceso', $this->admitido->id_programa_proceso)->get(); // grupos de la admision del usuario logueado

                    $constancia_ingreso = ConstanciaIngreso::where('id_admitido', $this->admitido->id_admitido)->first(); // constancia de ingreso del usuario logueado

                    $matricula_gestion = MatriculaGestion::where('id_programa_proceso', $this->admitido ? $this->admitido->id_programa_proceso : '')
                            ->where('matricula_gestion_estado', 1)
                            ->orderBy('id_matricula_gestion', 'desc')
                            ->first(); // gestion de matricula actual
                }
            }
        }
        else
        {
            $this->admitido = null;
        }
        $canales_pagos = CanalPago::where('canal_pago_estado', 1)->get(); // canales de pago
        $conceptos_pagos = ConceptoPago::where('concepto_pago_estado', 1)->get(); // canales de pago
        return view('livewire.modulo-plataforma.pagos.index', [
            'canal_pagos' => $canal_pagos,
            'pagos' => $pagos,
            'canales_pagos' => $canales_pagos,
            'conceptos_pagos' => $conceptos_pagos,
            'admision' => $admision,
            'constancia_ingreso' => $constancia_ingreso,
            'grupos' => $grupos,
            'matricula_gestion' => $matricula_gestion,
            'ciclo_actual' => $ciclo_actual,
        ]);
    }
}
