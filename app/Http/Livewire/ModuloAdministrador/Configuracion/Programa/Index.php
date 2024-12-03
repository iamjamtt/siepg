<?php

namespace App\Http\Livewire\ModuloAdministrador\Configuracion\Programa;

use App\Models\Facultad;
use App\Models\Modalidad;
use App\Models\Programa;
use App\Models\Sede;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    //paginacion de bootstrap
    protected $paginationTheme = 'bootstrap';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'modalidadFiltro' => ['except' => ''],
        'facultadFiltro' => ['except' => ''],
        'sedeFiltro' => ['except' => ''],
        'tipoProgramaFiltro' => ['except' => ''],
    ];

    public $search = '';
    public $titulo = 'Crear Programa de Estudios';
    public $modo = 1;//1 = Crear, 2 = Actualizar, 3 = Detalle

    //Variables para el filtro de programas
    public $tipoProgramaFiltro;//Para la busqueda de programas por tipo
    public $filtro_tipo_programa;//Para el filtro de programas por tipo
    public $modalidadFiltro;//Para la busqueda de programas por modalidad
    public $filtro_modalidad;//Para el filtro de programas por modalidad
    public $facultadFiltro;//Para la busqueda de programas por facultad
    public $filtro_facultad;//Para el filtro de programas por facultad
    public $sedeFiltro;//Para la busqueda de programas por Sede
    public $filtro_sede;//Para el filtro de programas por Sede

    //Valiables de los modelos de Programa
    public $id_programa;
    public $programa_iniciales;
    public $programa;
    public $subprograma;
    public $mencion;
    public $id_sunedu;
    public $codigo_sunedu;
    public $modalidad;//1 = presencial, 2 = virtual
    public $facultad;
    public $sede;
    public $programa_tipo;// 1 = Maestria, 2 = Doctorado
    public $programa_estado;// 1 = Activo, 0 = Inactivo

    //Variables para mostrar en el modal de detalle
    public $facultadDetalle;
    public $sedeDetalle;
    public $modalidadDetalle;


    protected $listeners = ['render', 'cambiarEstado'];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'programa_iniciales' => 'required | string | max:255',
            'subprograma' => 'required | string | max:255',
            'mencion' => 'nullable | string | max:255',
            'id_sunedu' => 'required | numeric',
            'codigo_sunedu' => 'nullable | string | max:255',
            'modalidad' => 'required | numeric',
            'facultad' => 'required | numeric',
            'sede' => 'required | numeric',
            'programa_tipo' => 'required | numeric',
        ]);
    }

    public function modo()
    {
        $this->limpiar();
        $this->modo = 1;
        $this->titulo = 'Crear Programa de Estudios';
    }

    public function limpiar()
    {
        $this->resetErrorBag();//Elimina los mensajes de error de validacion
        $this->reset('programa_iniciales', 'subprograma', 'mencion', 'id_sunedu', 'codigo_sunedu', 'modalidad', 'facultad', 'sede', 'programa_tipo');//Limpiar todas las variables
        $this->modo = 1;//1 = Crear, 2 = Actualizar, 3 = Detalle
    }

    //Alerta de confirmacion
    public function alertaConfirmacion($title, $text, $icon, $confirmButtonText, $cancelButtonText, $confimrColor, $cancelColor, $metodo, $id)
    {
        $this->dispatchBrowserEvent('alertaConfirmacion', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
            'confirmButtonText' => $confirmButtonText,
            'cancelButtonText' => $cancelButtonText,
            'confimrColor' => $confimrColor,
            'cancelColor' => $cancelColor,
            'metodo' => $metodo,
            'id' => $id,
        ]);
    }

    //Alertas de exito o error
    public function alertaPrograma($title, $text, $icon, $confirmButtonText, $color)
    {
        $this->dispatchBrowserEvent('alerta-programa', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
            'confirmButtonText' => $confirmButtonText,
            'color' => $color
        ]);
    }

    //Mostar modal de confirmacion para cambiar el estado del programa
    public function cargarAlertaEstado($id)
    {   
        $programa = Programa::findOrFail($id);//Busca el programa por su id
        if($programa->mencion){
            $nombre = $programa->programa . ' EN ' . $programa->subprograma . ' CON MENCION EN ' . $programa->mencion;//Concatena el nombre del programa
        }else{
            $nombre = $programa->programa . ' EN ' . $programa->subprograma;//Concatena el nombre del programa
        }
        $this->alertaConfirmacion('¿Estás seguro?',"¿Desea cambiar el estado del programa de $nombre?",'question','Modificar','Cancelar','primary','danger','cambiarEstado',$id);
    }

    //Limpiamos los filtros
    public function resetear_filtro()
    {
        $this->reset('tipoProgramaFiltro', 'filtro_tipo_programa', 'modalidadFiltro', 'filtro_modalidad', 'facultadFiltro', 'filtro_facultad', 'sedeFiltro', 'filtro_sede');
    }

    //Asignamos los filtros
    public function filtrar()
    {
        $this->tipoProgramaFiltro = $this->filtro_tipo_programa;
        $this->modalidadFiltro = $this->filtro_modalidad;
        $this->facultadFiltro = $this->filtro_facultad;
        $this->sedeFiltro = $this->filtro_sede;
    }

    //Cambiar el estado del programa
    public function cambiarEstado(Programa $programa)
    {
        if ($programa->programa_estado == 1) {//Si el estado es 1 (activo), cambiar a 0 (inactivo)
            $programa->programa_estado = 0;
        } else {//Si el estado es 2 (inactivo), cambiar a 1 (activo)
            $programa->programa_estado = 1;
        }

        $programa->save();//Actualizar el estado del programa

        //Mostrar alerta de confirmacion de cambio de estado
        $this->alertaPrograma('¡Éxito!', "El estado del programa $programa->programa ha sido actualizado satisfactoriamente.", 'success', 'Aceptar', 'success');
    }

    //Cargar los datos del expediente en el formulario para actualizar
    public function cargarPrograma(Programa $programa, $modoTipo)
    {
        // $this->limpiar();
        $this->modo = $modoTipo;//Modo 2 = actualizar | Modo 3 = detalle

        //Cargar el titulo del modal dependiendo del modo
        $this->modo == 2 ? $this->titulo = 'Actualizar Programa' : $this->titulo = 'Detalle de Programa';

        //Cargar los datos del programa en las variables
        $this->id_programa = $programa->id_programa;
        $this->programa_iniciales = $programa->programa_iniciales;
        $this->programa = $programa->programa;
        $this->subprograma = $programa->subprograma;
        $this->mencion = $programa->mencion;
        $this->id_sunedu = $programa->id_sunedu;
        $this->codigo_sunedu = $programa->codigo_sunedu;
        $this->modalidad = $programa->id_modalidad;
        $this->facultad = $programa->id_facultad;
        $this->sede = $programa->id_sede;
        $this->programa_tipo = $programa->programa_tipo;

        //Variables para mostrar en el detalle
        $this->facultadDetalle = $programa->facultad->facultad;
        $this->sedeDetalle = $programa->sede->sede;
        $this->modalidadDetalle = $programa->modalidad->modalidad;
    }

    //Guardar o actualizar el programa
    public function guardarPrograma()
    {
        if ($this->modo == 1) {//Si el modo es 1 (crear), crear el programa
            $this->validate([
                'programa_iniciales' => 'required | string | max:255',
                'subprograma' => 'required | string | max:255',
                'mencion' => 'nullable | string | max:255',
                'id_sunedu' => 'required | numeric | unique:programa,id_sunedu,'.$this->id_programa.',id_programa',
                'codigo_sunedu' => 'nullable | string | max:255 | unique:programa,codigo_sunedu,'.$this->id_programa.',id_programa',
                'modalidad' => 'required | numeric',
                'facultad' => 'required | numeric',
                'sede' => 'required | numeric',
                'programa_tipo' => 'required | numeric',
            ]);

            //Validando que no exista el programa
            $programa = Programa::where('programa_iniciales', $this->programa_iniciales)
                                ->where('subprograma', $this->subprograma)
                                ->where('mencion', $this->mencion)
                                ->where('id_sunedu', $this->id_sunedu)
                                ->where('codigo_sunedu', $this->codigo_sunedu)
                                ->where('id_modalidad', $this->modalidad)
                                ->where('id_facultad', $this->facultad)
                                ->where('id_sede', $this->sede)
                                ->where('programa_tipo', $this->programa_tipo)
                                ->first();
            if($programa){
                $this->alertaPrograma('¡Error!', "El programa de $programa->programa EN $programa->subprograma ya se encuentra registrado.", 'error', 'Aceptar', 'danger');
                $this->limpiar();
                //Cerramos el modal
                $this->dispatchBrowserEvent('modal', [
                    'titleModal' => '#modalPrograma',
                ]);
                return;
            }

            //Validar que el id de sunedu o el codigo de sunedu no existan en otro programa
            $programa = Programa::where('id_sunedu', $this->id_sunedu)
                                ->orWhere('codigo_sunedu', $this->codigo_sunedu)
                                ->first();
            if($programa){
                $this->alertaPrograma('¡Error!', "El ID de SUNEDU o el código de SUNEDU ya se encuentra registrado en otro programa.", 'error', 'Aceptar', 'danger');
                return;
            }


            $programaModel = new Programa();
            $programaModel->programa_iniciales = $this->programa_iniciales;
            if($this->programa_tipo == 1){
                $programaModel->programa = 'MAESTRIA';
            }else{
                $programaModel->programa = 'DOCTORADO';
            }
            $programaModel->subprograma = $this->subprograma;
            $programaModel->mencion = $this->mencion;
            $programaModel->id_sunedu = $this->id_sunedu;
            $programaModel->codigo_sunedu = $this->codigo_sunedu;
            $programaModel->id_modalidad = $this->modalidad;
            $programaModel->id_facultad = $this->facultad;
            $programaModel->id_sede = $this->sede;
            $programaModel->programa_tipo = $this->programa_tipo;
            $programaModel->programa_estado = 1;
            $programaModel->save();

            $this->alertaPrograma('¡Éxito!', "El programa de $programaModel->programa EN $programaModel->subprograma ha sido registrado satisfactoriamente.", 'success', 'Aceptar', 'success');
            
        } else {//Si el modo es 2 (actualizar), actualizar el programa
            $this->validate([
                'programa_iniciales' => 'required | string | max:255',
                'subprograma' => 'required | string | max:255',
                'mencion' => 'nullable | string | max:255',
                'id_sunedu' => 'required | numeric',
                'codigo_sunedu' => 'nullable | string | max:255',
                'modalidad' => 'required | numeric',
                'facultad' => 'required | numeric',
                'sede' => 'required | numeric',
                'programa_tipo' => 'required | numeric',
            ]);
            
            $programaModel = Programa::findOrFail($this->id_programa);

            //Validando que no se hayan cambiado los datos del programa
            $programa = Programa::where('programa_iniciales', $this->programa_iniciales)
                                ->where('subprograma', $this->subprograma)
                                ->where('mencion', $this->mencion)
                                ->where('id_sunedu', $this->id_sunedu)
                                ->where('codigo_sunedu', $this->codigo_sunedu)
                                ->where('id_modalidad', $this->modalidad)
                                ->where('id_facultad', $this->facultad)
                                ->where('id_sede', $this->sede)
                                ->where('programa_tipo', $this->programa_tipo)
                                ->first();
            if($programa){
                $this->alertaPrograma('¡Información!', "No se registraron cambios en el programa de $programa->programa EN $programa->subprograma.", 'info', 'Aceptar', 'info');
                $this->limpiar();
                //Cerramos el modal
                $this->dispatchBrowserEvent('modal', [
                    'titleModal' => '#modalPrograma',
                ]);
                return;
            }

            //Validar que el id de sunedu o el codigo de sunedu no existan en otro programa
            $programa = Programa::where('id_sunedu', $this->id_sunedu)
                                ->where('id_programa', '!=', $this->id_programa)
                                ->where('id_modalidad', $this->modalidad)
                                ->orWhere('codigo_sunedu', $this->codigo_sunedu)
                                ->whereNotNull('codigo_sunedu')
                                ->first();
            if($programa){
                $this->alertaPrograma('¡Error!', "El ID de SUNEDU o el código de SUNEDU ya se encuentra registrado en otro programa.", 'error', 'Aceptar', 'danger');
                return;
            }
            
            $programaModel->programa_iniciales = $this->programa_iniciales;
            if($this->programa_tipo == 1){
                $programaModel->programa = 'MAESTRIA';
            }else{
                $programaModel->programa = 'DOCTORADO';
            }
            $programaModel->subprograma = $this->subprograma;
            $programaModel->mencion = $this->mencion;
            $programaModel->id_sunedu = $this->id_sunedu;
            $programaModel->codigo_sunedu = $this->codigo_sunedu;
            $programaModel->id_modalidad = $this->modalidad;
            $programaModel->id_facultad = $this->facultad;
            $programaModel->id_sede = $this->sede;
            $programaModel->programa_tipo = $this->programa_tipo;
            $programaModel->save();

            $this->alertaPrograma('¡Éxito!', "El programa de $programaModel->programa EN $programaModel->subprograma ha sido actualizado satisfactoriamente.", 'success', 'Aceptar', 'success');
        }
        
        $this->limpiar();
        //Cerramos el modal
        $this->dispatchBrowserEvent('modal', [
            'titleModal' => '#modalPrograma',
        ]);
    }
    
    public function render()
    {        
        $sede_model = Sede::all();
        $facultad_model = Facultad::all();
        $modalidad_model = Modalidad::all();

        $programaModel = Programa::Join('sede', 'programa.id_sede', '=', 'sede.id_sede')
                                ->Join('facultad', 'programa.id_facultad', '=', 'facultad.id_facultad')
                                ->Join('modalidad', 'programa.id_modalidad', '=', 'modalidad.id_modalidad')
                                ->where(function ($query){
                                    $query->where('programa', 'like', '%'.$this->search.'%')
                                    ->orWhere('subprograma', 'like', '%'.$this->search.'%')
                                    ->orWhere('mencion', 'like', '%'.$this->search.'%');
                                })
                                ->where('modalidad.id_modalidad', $this->modalidadFiltro == null ? '!=' : '=', $this->modalidadFiltro)
                                ->where('facultad.id_facultad', $this->facultadFiltro == null ? '!=' : '=', $this->facultadFiltro)
                                ->where('sede.id_sede', $this->sedeFiltro == null ? '!=' : '=', $this->sedeFiltro)
                                ->where('programa.programa_tipo', $this->tipoProgramaFiltro == null ? '!=' : '=', $this->tipoProgramaFiltro)
                                ->orderBy('id_programa', 'desc')
                                ->paginate(10);

        return view('livewire.modulo-administrador.configuracion.programa.index', [
            'programaModel' => $programaModel,
            'sede_model' => $sede_model,
            'facultad_model' => $facultad_model,
            'modalidad_model' => $modalidad_model,
        ]);
    }
}
