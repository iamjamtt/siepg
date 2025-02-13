<?php

namespace App\Http\Livewire\ModuloAdministrador\GestionPagos\Pago;

use App\Jobs\ObservarInscripcionJob;
use App\Jobs\ObservarPagoJob;
use App\Models\CanalPago;
use App\Models\ConceptoPago;
use App\Models\ConstanciaIngreso;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\MatriculaCurso;
use App\Models\Pago;
use App\Models\PagoObservacion;
use App\Models\Persona;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination; // trait para paginar los datos
    protected $paginationTheme = 'bootstrap'; // tema de paginacion
    protected $queryString = [
        'search' => ['except' => ''],
        'filtro_concepto_pago' => ['except' => 'all'],
        'filtro_estado' => ['except' => 'all']
    ]; // variable para almacenar el texto de busqueda

    // public $pagos = null; // variable para almacenar los pagos
    public $search = ''; // variable para almacenar el texto de busqueda
    public $filtro_concepto_pago = "all"; // variable para almacenar el texto de busqueda
    public $filtro_estado = "all"; // variable para almacenar el texto de busqueda
    public $voucher; // variable para almacenar el voucher
    public $voucher_name; // variable para almacenar el voucher
    public $observacion; // variable para almacenar la observacion
    public $id_pago; // variable para almacenar el id del pago
    public $documento;
    public $nombres;
    public $operacion;
    public $monto;
    public $fecha_pago;
    public $canal_pago;
    public $concepto_pago;
    public $terminos_condiciones_pagos = false; // variable para los terminos y condiciones de los pagos

    public $titulo_modal_pago = 'Registrar Pago'; // titulo del modal de pago
    public $modo = 'create'; // variable para el modo de la vista
    public $activar_voucher = false; // variable para activar el voucher
    public $button_modal = 'Registrar Pago'; // variable para el boton del modal de registro

    protected $listeners = [
        'guardar_pago' => 'guardar_pago',
        'confirmar_eliminar_pago' => 'confirmar_eliminar_pago',
    ]; // listener para mostrar alertas

    public function updatedFiltroConceptoPago($value)
    {
        if ($value == 'all' || $value == '') {
            $this->filtro_concepto_pago = 'all';
        }
    }

    public function cargar_pago(Pago $pago, $value)
    {
        $this->id_pago = $pago->id_pago;
        if ($pago->pago_observacion->count() > 0) {
            $observacion = PagoObservacion::where('id_pago', $pago->id_pago)->where('pago_observacion_estado', 1)->orderBy('id_pago_observacion', 'desc')->first();
            if ($observacion) {
                $this->observacion = $observacion->pago_observacion;
            } else {
                $this->observacion = '';
            }
        } else {
            $this->observacion = '';
        }
        if ($value == false) {
            $this->voucher_name = $pago->pago_voucher_url;
            $this->canal_pago = $pago->canal_pago->canal_pago;
            $this->concepto_pago = $pago->concepto_pago->concepto_pago;
        } else {
            $this->canal_pago = $pago->id_canal_pago;
            $this->concepto_pago = $pago->id_concepto_pago;
        }
        $this->titulo_modal_pago = 'Editar Pago';
        $this->documento = $pago->pago_documento;
        $this->nombres = $pago->persona->nombre_completo;
        $this->operacion = $pago->pago_operacion;
        $this->monto = $pago->pago_monto;
        $this->fecha_pago = $pago->pago_fecha;
        $this->modo = 'edit';
        $this->button_modal = 'Editar Pago';
        if ($pago->pago_estado == 0 && $pago->pago_verificacion == 0) {
            $this->activar_voucher = true;
        } else {
            $this->activar_voucher = false;
        }
    }

    public function limpiar()
    {
        $this->reset('voucher', 'observacion');
    }

    public function validar_pago()
    {
        // validacion de los campos
        $this->validate([
            'observacion' => 'nullable|max:255',
        ]);

        // almacenar los datos
        $pago = Pago::find($this->id_pago);
        $pago->pago_estado = 2;
        $pago->pago_verificacion = 2;
        $pago->save();

        // almacenar los datos de observacion

        $observacion = PagoObservacion::where('id_pago', $this->id_pago)->where('pago_observacion_estado', 1)->orderBy('id_pago_observacion', 'desc')->first();
        if ($observacion) {
            $observacion->pago_observacion_estado = 0;
            $observacion->save();
        } else {
            if ($this->observacion != '' || $this->observacion != null) {
                $observacion = new PagoObservacion();
                $observacion->pago_observacion = $this->observacion;
                $observacion->id_pago = $this->id_pago;
                $observacion->pago_observacion_creacion = now();
                $observacion->pago_observacion_estado = 1;
                $observacion->save();
            }
        }

        // mostramos alerta de confirmacion
        $this->dispatchBrowserEvent('alerta', [
            'title' => '!Validado!',
            'text' => 'Pago validado correctamente',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // cerra el modal
        $this->dispatchBrowserEvent('modal', ['action' => 'hide']);

        // limpiar los campos
        $this->limpiar();
    }

    public function observar_pago()
    {
        // validacion de los campos
        $this->validate([
            'observacion' => 'required|max:255',
        ]);

        // almacenar los datos
        $pago = Pago::find($this->id_pago);
        $pago->pago_estado = 1;
        $pago->pago_verificacion = 0;
        $pago->save();

        // almacenar los datos de observacion
        $observacion = PagoObservacion::where('id_pago', $this->id_pago)->where('pago_observacion_estado', 1)->orderBy('id_pago_observacion', 'desc')->first();
        if ($observacion) {
            $observacion->pago_observacion = $this->observacion;
            $observacion->pago_observacion_estado = 1;
            $observacion->save();
        } else {
            if ($this->observacion != '' || $this->observacion != null) {
                $observacion = new PagoObservacion();
                $observacion->pago_observacion = $this->observacion;
                $observacion->id_pago = $this->id_pago;
                $observacion->pago_observacion_creacion = now();
                $observacion->pago_observacion_estado = 1;
                $observacion->save();
            }
        }

        // mostramos alerta de confirmacion
        $this->dispatchBrowserEvent('alerta', [
            'title' => '!Observado!',
            'text' => 'Pago observado correctamente',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // cerra el modal
        $this->dispatchBrowserEvent('modal', [
            'action' => 'hide'
        ]);

        // ejecutamos el job para enviar el correo de rechazo de pago
        ObservarPagoJob::dispatch($pago->id_pago);

        // limpiar los campos
        $this->limpiar();
    }

    public function rechazar_pago()
    {
        // validacion de los campos
        $this->validate([
            'observacion' => 'required|max:255',
        ]);

        // cambiar el estado de la verificacion a 0 (rechazado - observado)
        $pago = Pago::find($this->id_pago);
        $pago->pago_estado = 0;
        $pago->pago_verificacion = 0;
        $pago->pago_leido = 1;
        if ($pago->pago_voucher_url) {
            File::delete($pago->pago_voucher_url);
        }
        $pago->pago_voucher_url = null;
        $pago->save();

        // eliminar la constancia de ingreso
        $constancia = ConstanciaIngreso::where('id_pago', $this->id_pago)->orderBy('id_constancia_ingreso')->first();
        if ($constancia) {
            $constancia->constancia_ingreso_codigo = null;
            if ($constancia->constancia_ingreso_url) {
                File::delete($constancia->constancia_ingreso_url);
            }
            $constancia->constancia_ingreso_url = null;
            $constancia->save();
        }

        // almacenar los datos de observacion
        $observacion = PagoObservacion::where('id_pago', $this->id_pago)->where('pago_observacion_estado', 1)->orderBy('id_pago_observacion', 'desc')->first();
        if ($observacion) {
            $observacion->pago_observacion = $this->observacion;
            $observacion->pago_observacion_estado = 2;
            $observacion->save();
        } else {
            if ($this->observacion != '' || $this->observacion != null) {
                $observacion = new PagoObservacion();
                $observacion->pago_observacion = $this->observacion;
                $observacion->id_pago = $this->id_pago;
                $observacion->pago_observacion_creacion = now();
                $observacion->pago_observacion_estado = 2;
                $observacion->save();
            }
        }

        // mostramos alerta de confirmacion
        $this->dispatchBrowserEvent('alerta', [
            'title' => '!Rechazado!',
            'text' => 'Pago rechazado correctamente',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // cerra el modal
        $this->dispatchBrowserEvent('modal', [
            'action' => 'hide'
        ]);

        // limpiar los campos
        $this->limpiar();
    }

    public function limpiar_pago()
    {
        $this->reset([
            'voucher',
            'observacion',
            'id_pago',
            'documento',
            'nombres',
            'operacion',
            'monto',
            'fecha_pago',
            'canal_pago',
            'concepto_pago',
            'titulo_modal_pago',
            'modo',
            'button_modal',
            'activar_voucher'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->modo = 'create';
    }

    public function alerta_guardar_pago()
    {
        // validar formulario de registro de pago
        if ($this->modo == 'create') {
            $this->validate([
                'documento' => 'required|numeric|digits_between:8,9',
                'operacion' => 'required|numeric',
                'monto' => 'required|numeric',
                'fecha_pago' => 'required|date',
                'canal_pago' => 'required|numeric',
                'concepto_pago' => 'required|numeric',
                'voucher' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'terminos_condiciones_pagos' => 'accepted'
            ]);

            // validar si el estudiante existe en la plataforma
            $persona = Persona::where('numero_documento', $this->documento)->first();
            $admitido = $this->admitido;
            if ($persona == null) {
                $this->dispatchBrowserEvent('alerta', [
                    'title' => '¡Error!',
                    'text' => 'El número de documento ingresado no se encuentra registrado en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }
            if ($this->documento != $admitido->persona->numero_documento) {
                $this->dispatchBrowserEvent('alerta', [
                    'title' => '¡Error!',
                    'text' => 'El número de documento ingresado no coincide con el número de documento del postulante admitido.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento, fecha de operacion y concepto de pago ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->operacion)
                ->where('pago_documento', $this->documento)
                ->where('pago_fecha', $this->fecha_pago)
                ->where('id_concepto_pago', $this->concepto_pago)
                ->first();
            if ($pago) {
                $this->dispatchBrowserEvent('alerta', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, número de documento, fecha de operación y concepto de pago ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // valiadar si el numero de operacion, fecha de operacion y concepto de pago ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->operacion)
                ->where('pago_fecha', $this->fecha_pago)
                ->where('id_concepto_pago', $this->concepto_pago)
                ->first();
            if ($pago) {
                $this->dispatchBrowserEvent('alerta', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, fecha de operación y concepto de pago ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento y concepto de pago ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->operacion)
                ->where('pago_documento', $this->documento)
                ->where('id_concepto_pago', $this->concepto_pago)
                ->first();
            if ($pago) {
                $this->dispatchBrowserEvent('alerta', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, número de documento y concepto de pago ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento y fecha de operacion ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->operacion)
                ->where('pago_documento', $this->documento)
                ->where('pago_fecha', $this->fecha_pago)
                ->first();
            if ($pago) {
                $this->dispatchBrowserEvent('alerta', [
                    'title' => '¡Error!',
                    'text' => 'El número de operación, número de documento y fecha de operación ya se encuentran registrados en la plataforma.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }

            // validar si el numero de operacion, numero de documento ya se encuentran registrados
            $pago = Pago::where('pago_operacion', $this->operacion)
                ->where('pago_documento', $this->documento)
                ->first();
            if ($pago) {
                $this->dispatchBrowserEvent('alerta', [
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
            if ($this->monto < $concepto_pago->concepto_pago_monto) {
                $this->dispatchBrowserEvent('alerta', [
                    'title' => '¡Error!',
                    'text' => 'El monto de operación ingresado es menor al monto del concepto de pago seleccionado.',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }
        } else {
            if ($this->activar_voucher == true) {
                $this->validate([
                    'documento' => 'required|numeric|digits_between:8,9',
                    'operacion' => 'required|numeric',
                    'monto' => 'required|numeric',
                    'fecha_pago' => 'required|date',
                    'canal_pago' => 'required|numeric',
                    'concepto_pago' => 'required|numeric',
                    'voucher' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                    'terminos_condiciones_pagos' => 'nullable'
                ]);
            } else {
                $this->validate([
                    'documento' => 'required|numeric|digits_between:8,9',
                    'operacion' => 'required|numeric',
                    'monto' => 'required|numeric',
                    'fecha_pago' => 'required|date',
                    'canal_pago' => 'required|numeric',
                    'concepto_pago' => 'required|numeric',
                    'voucher' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                    'terminos_condiciones_pagos' => 'nullable'
                ]);
            }
        }

        if ($this->modo == 'create') {
            $this->dispatchBrowserEvent('alerta-2', [
                'title' => 'Confirmar Registro',
                'text' => '¿Está seguro de registrar el pago?',
                'icon' => 'question',
                'confirmButtonText' => 'Registrar',
                'cancelButtonText' => 'Cancelar',
                'confirmButtonColor' => 'primary',
                'cancelButtonColor' => 'danger'
            ]);
        } else {
            $this->dispatchBrowserEvent('alerta-2', [
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
        if ($this->modo == 'create') {
            $pago = new Pago();
            $pago->pago_documento = $this->documento;
            $pago->pago_operacion = $this->operacion;
            $pago->pago_monto = $this->monto;
            $pago->pago_fecha = $this->fecha_pago;
            $pago->pago_estado = 1;
            $pago->pago_verificacion = 1;
            if ($this->voucher) {
                $persona = Persona::where('numero_documento', $this->documento)->first();
                $inscripcion = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first();
                $admision = $inscripcion->programa_proceso->admision->admision;

                $base_path = 'Posgrado/';
                $folders = [
                    $admision,
                    $this->documento_identidad,
                    'Voucher'
                ];

                // Asegurar que se creen los directorios con los permisos correctos
                $path = asignarPermisoFolders($base_path, $folders);

                // Nombre del archivo
                $filename = 'voucher-pago-' . uniqid() . '.' . $this->voucher->getClientOriginalExtension();
                $nombre_db = $path . $filename;

                // Guardar el archivo
                $data = $this->voucher;
                $data->storeAs($path, $filename, 'files_publico');
                $pago->pago_voucher_url = $nombre_db;

                // Asignar todos los permisos al archivo
                chmod($nombre_db, 0777);
            }
            $pago->id_canal_pago = $this->canal_pago;
            $pago->id_concepto_pago = $this->concepto_pago;
            $pago->save();

            // registrar tipo de pago
            $this->registrar_tipo_pago($pago->id_pago);
        } else {
            $pago = Pago::find($this->id_pago);
            $pago->pago_documento = $this->documento;
            $pago->pago_operacion = $this->operacion;
            $pago->pago_monto = $this->monto;
            $pago->pago_fecha = $this->fecha_pago;
            if ($this->voucher) {
                $persona = Persona::where('numero_documento', $this->documento)->first();
                $inscripcion = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first();
                $admision = $inscripcion->programa_proceso->admision->admision;

                $base_path = 'Posgrado/';
                $folders = [
                    $admision,
                    $this->documento,
                    'Voucher'
                ];

                // Asegurar que se creen los directorios con los permisos correctos
                $path = asignarPermisoFolders($base_path, $folders);

                // Nombre del archivo
                $filename = 'voucher-pago-' . uniqid() . '.' . $this->voucher->getClientOriginalExtension();
                $nombre_db = $path . $filename;

                // Guardar el archivo
                $data = $this->voucher;
                $data->storeAs($path, $filename, 'files_publico');
                $pago->pago_voucher_url = $nombre_db;

                // Asignar todos los permisos al archivo
                chmod($nombre_db, 0777);
            }
            $pago->id_canal_pago = $this->canal_pago;
            $pago->id_concepto_pago = $this->concepto_pago;
            $pago->save();

            // cambiar de estado a la observacion del pago
            $observacion = PagoObservacion::where('id_pago', $pago->id_pago)->orderBy('id_pago_observacion', 'desc')->get();
            if ($observacion) {
                foreach ($observacion as $item) {
                    $item->pago_observacion_estado = 0;
                    $item->save();
                }
            }

            // emitir alerta de exito
            $this->dispatchBrowserEvent('alerta', [
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
        $this->dispatchBrowserEvent('modal', [
            'action' => 'hide'
        ]);
    }

    public function eliminar_pago($id_pago)
    {
        $this->id_pago = $id_pago;
        $this->dispatchBrowserEvent('alerta-3', [
            'title' => 'Confirmar Eliminación',
            'text' => '¿Está seguro de eliminar el pago?',
            'icon' => 'question',
            'confirmButtonText' => 'Eliminar',
            'cancelButtonText' => 'Cancelar',
            'confirmButtonColor' => 'primary',
            'cancelButtonColor' => 'danger',
            'function' => 'confirmar_eliminar_pago'
        ]);
    }

    public function confirmar_eliminar_pago()
    {
        $pago = Pago::find($this->id_pago);
        if ($pago->pago_voucher_url) {
            File::delete($pago->pago_voucher_url);
        }
        if ($pago->pago_observacion->count() > 0) {
            $observaciones = PagoObservacion::where('id_pago', $pago->id_pago)->get();
            foreach ($observaciones as $observacion) {
                $observacion->delete();
            }
        }
        if ($pago->id_concepto_pago == 1) {
            // $inscripcion = Inscripcion::where('id_pago', $pago->id_pago)->first();
            // if ($inscripcion) {
            //     $inscripcion->id_pago = null;
            //     $inscripcion->save();
            // }
        } else if ($pago->id_concepto_pago == 2 || $pago->id_concepto_pago == 4 || $pago->id_concepto_pago == 6) {
            $constancia = ConstanciaIngreso::where('id_pago', $pago->id_pago)->first();
            if ($constancia) {
                if ($constancia->constancia_ingreso_url) {
                    File::delete($constancia->constancia_ingreso_url);
                }
                $constancia->delete();
            }
        } else if ($pago->id_concepto_pago == 3 || $pago->id_concepto_pago == 4 || $pago->id_concepto_pago == 5 || $pago->id_concepto_pago == 6) {
            $matricula = Matricula::where('id_pago', $pago->id_pago)->first();
            if ($matricula) {
                $cursos = MatriculaCurso::where('id_matricula', $matricula->id_matricula)->get();
                foreach ($cursos as $curso) {
                    $curso->delete();
                }
                if ($matricula->matricula_url) {
                    File::delete($matricula->matricula_url);
                }
                $matricula->delete();
            }
        }
        $pago->delete();

        // emitir alerta de exito
        $this->dispatchBrowserEvent('alerta', [
            'title' => '!Exito!',
            'text' => 'Pago ha sido eliminado con exito.',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // emitir evento para actualizar el sidebar de la plataforma del estudiante
        $this->emit('actualizar_sidebar');
    }

    public function render()
    {
        $concepto_pagos = ConceptoPago::where('concepto_pago_estado', 1)->get();
        $canal_pagos = CanalPago::where('canal_pago_estado', 1)->get();
        $pagos = Pago::where(function ($query) {
                if ($this->filtro_concepto_pago != 'all') {
                    $query->where('id_concepto_pago', $this->filtro_concepto_pago);
                }
                if ($this->filtro_estado != 'all') {
                    $query->where('pago_verificacion', $this->filtro_estado);
                }
            })
            ->where(function ($query) {
                $query->where('pago_documento', 'like', '%' . $this->search . '%')
                    ->orWhere('pago_operacion', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id_pago', 'desc')
            ->paginate(100);

        return view('livewire.modulo-administrador.gestion-pagos.pago.index', [
            'pagos' => $pagos,
            'canales_pagos' => $canal_pagos,
            'concepto_pagos' => $concepto_pagos,
        ]);
    }

}
