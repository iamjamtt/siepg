<?php

namespace App\Http\Livewire\ModuloInscripcion\RegistroDocente;

use App\Models\CategoriaDocente;
use App\Models\Docente;
use App\Models\GradoAcademico;
use App\Models\TipoDocente;
use App\Models\TipoDocumento;
use App\Models\Trabajador;
use App\Models\TrabajadorTipoTrabajador;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $paso = 1;

    public $prefijo;
    public $tipo_documento;
    public $documento;
    public $nombres;
    public $apellidos;
    public $direccion;
    public $correo;
    public $grado;
    public $iteration;

    public $trabajador_id;

    public $declaracion_jurada;
    //DOCENTE
    public $tipo_docente;
    public $cv;
    public $categoria_docente;

    public function updated($propertyName)
    {
        if($this->paso == 1) {
            $this->validateOnly($propertyName, [
                'tipo_documento' => 'required|exists:tipo_documento,id_tipo_documento',
                'documento' => 'required|numeric|unique:trabajador,trabajador_numero_documento|digits:8',
                'nombres' => 'required',
                'apellidos' => 'required',
                'direccion' => 'required',
                'correo' => 'required|email',
                'grado' => 'required|exists:grado_academico,id_grado_academico'
            ]);
        } else {
            $this->validateOnly($propertyName, [
                'tipo_docente' => 'required|exists:tipo_docente,id_tipo_docente',
                'cv' => 'required|file|mimes:pdf',
                'categoria_docente' => 'required|exists:categoria_docente,id_categoria_docente'
            ]);
        }
    }

    public function paso_1()
    {
        $this->paso = 1;
    }

    public function paso_2()
    {
        $this->validar_registro();
        $this->paso = 2;
    }

    public function validar_registro()
    {
        if($this->paso === 1) {
            $this->resetErrorBag();
            $this->resetValidation();
            $this->validate([
                'tipo_documento' => 'required|exists:tipo_documento,id_tipo_documento',
                'documento' => 'required|numeric|unique:trabajador,trabajador_numero_documento|digits:8',
                'nombres' => 'required',
                'apellidos' => 'required',
                'direccion' => 'required',
                'correo' => 'required|email',
                'grado' => 'required|exists:grado_academico,id_grado_academico'
            ]);
        } else if($this->paso === 2) {
            $this->resetErrorBag();
            $this->resetValidation();
            $this->validate([
                'tipo_docente' => 'required|exists:tipo_docente,id_tipo_docente',
                'cv' => 'required|file|mimes:pdf',
                'categoria_docente' => 'required|exists:categoria_docente,id_categoria_docente'
            ]);
        }
    }

    public function guardarRegistro()
    {
        //Creamos el trabajador
        $trabajador = new Trabajador();
        $trabajador->trabajador_nombre = mb_strtoupper($this->nombres, 'UTF-8');
        $trabajador->trabajador_apellido = mb_strtoupper($this->apellidos, 'UTF-8');
        $trabajador->trabajador_nombre_completo = mb_strtoupper($this->nombres, 'UTF-8').' '.mb_strtoupper($this->apellidos, 'UTF-8');
        $trabajador->trabajador_numero_documento = $this->documento;
        $trabajador->trabajador_correo = strtolower($this->correo);
        $trabajador->trabajador_direccion = mb_strtoupper($this->direccion, 'UTF-8');
        $trabajador->id_grado_academico = $this->grado;
        $trabajador->trabajador_estado = 1;
        $trabajador->save();

        // extraemos el primer nombre, primer apellido y los dos ultimos digitos del documento para generar su correo electronico de usuario
        $nombre = explode(' ', $this->nombres);
        $apellido = explode(' ', $this->apellidos);
        $correo = strtolower($nombre[0].'_'.$apellido[0].'@unu.edu.pe');

        // asignamos el trabajador a la tabla docente
        $docente = new Docente();
        $docente->id_tipo_docente = $this->tipo_docente;
        $docente->id_categoria_docente = $this->categoria_docente;
        $docente->docente_estado = 1;
        $docente->id_trabajador = $trabajador->id_trabajador;
        $docente->save();

        $data = $this->cv;
        if($data != null){
            $path =  'Docente/';
            $filename = "cv-".$this->trabajador_id.uniqid().".".$data->getClientOriginalExtension();
            $data = $this->cv;
            $data->storeAs($path, $filename, 'files_publico');

            $docente_nuevo = Docente::find($docente->id_docente);
            $docente_nuevo->docente_cv_url = $filename;
            $docente_nuevo->save();
        }

        // asignamos el trabajador a la tabla trabajador_tipo_trabajador
        $trabajador_tipo_trabajador_create = new TrabajadorTipoTrabajador();
        $trabajador_tipo_trabajador_create->id_tipo_trabajador = 1;
        $trabajador_tipo_trabajador_create->id_trabajador = $trabajador->id_trabajador;
        $trabajador_tipo_trabajador_create->trabajador_tipo_trabajador_estado = 1;
        $trabajador_tipo_trabajador_create->save();

        // Creamos el usuario
        $usuario = new Usuario();
        $usuario->usuario_nombre = $trabajador->trabajador_nombre_completo;
        $usuario->usuario_correo = $correo;
        $usuario->usuario_password = Hash::make($trabajador->trabajador_numero_documento);
        $usuario->id_trabajador_tipo_trabajador = $trabajador_tipo_trabajador_create->id_trabajador_tipo_trabajador;
        $usuario->usuario_estado = 2;
        $usuario->save();

        $this->dispatchBrowserEvent('alerta-contador', [
            'id_docente' => $docente->id_docente,
        ]);
    }

    public function render()
    {
        $tipo_documentos = TipoDocumento::where('tipo_documento_estado', 1)->get();
        $grados_academicos = GradoAcademico::where('grado_academico_estado', 1)->orderBy('grado_academico', 'desc')->get();
        $tipo_docentes = TipoDocente::where('tipo_docente_estado', 1)->get();
        $categoria_docentes = CategoriaDocente::where('categoria_docente_estado', 1)->get();

        return view('livewire.modulo-inscripcion.registro-docente.index', [
            'tipo_documentos' => $tipo_documentos,
            'grados_academicos' => $grados_academicos,
            'tipo_docentes' => $tipo_docentes,
            'categoria_docentes' => $categoria_docentes
        ]);
    }
}
