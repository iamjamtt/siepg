<?php

namespace App\Http\Livewire\ModuloInscripcion\RegistroAlumnos;

use App\Models\Admision;
use App\Models\Admitido;
use App\Models\CodigoEstudiante;
use App\Models\Discapacidad;
use App\Models\EstadoCivil;
use App\Models\Genero;
use App\Models\GradoAcademico;
use App\Models\Modalidad;
use App\Models\Persona;
use App\Models\ProgramaProceso;
use App\Models\Ubigeo;
use App\Models\Universidad;
use App\Models\UsuarioEstudiante;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Psy\Command\WhereamiCommand;

class Index extends Component
{
    public $paso = 1;

    //Variables para el paso 1
    public $admision;
    public $programa;
    public $modalidad;

    //Variables modelo para el paso 1
    public $programas_model;//Programas de la modalidad para el select
    public $modalidad_model;//Modalidades para el select


    //Variables para el paso 2
    public $id_persona;
    public $numero_documento;
    public $apellido_paterno;
    public $apellido_materno;
    public $nombre;
    public $genero;
    public $fecha_nacimiento;
    public $direccion;
    public $celular;
    public $celular_opcional;
    public $correo;
    public $correo_opcional;
    public $año_egreso;
    public $especialidad;
    public $centro_trabajo;
    public $discapacidad;
    public $estado_civil;
    public $grado_academico;
    public $universidad;
    public $ubigeo_direccion;
    public $ubigeo_nacimiento;
    public $pais_direccion;
    public $pais_nacimiento;
    public $pais_direccion_estado = false;
    public $pais_nacimiento_estado = false;
    //Declaracion jurada
    public $declaracion_jurada = false;

    //Variables para la tabla de admitidos
    public $admitido_codigo;

    //Valiables para modal de selecionar codigo de admitido
    public $numero_alumnos = 0;
    public $search = '';
    public $codigo_estudiante_model;
    public $fila_seleccionada = null;//Variable para seleccionar la fila de la tabla

    public function updated($propertyName)
    {
        if($this->paso == 1)
        {
            $this->validateOnly($propertyName, [
                'admision' => 'required',
                'programa' => 'required',
                'modalidad' => 'required',
                'admitido_codigo' => 'required',
            ]);
        }
        else
        {
            $this->validateOnly($propertyName, [
                'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                'apellido_paterno' => 'required|max:50|regex:/^[A-Za-z\s]+$/',
                'apellido_materno' => 'required|max:50|regex:/^[A-Za-z\s]+$/',
                'nombre' => 'required|max:50|regex:/^[A-Za-z\s]+$/',
                'genero' => 'required|numeric',
                'fecha_nacimiento' => 'required|date',
                'direccion' => 'required|max:100',
                'celular' => 'required|numeric|digits:9',
                'celular_opcional' => [
                    'nullable',
                    'numeric',
                    'digits:9',
                    function ($attribute, $value, $fail) {
                        if ($this->celular_opcional) {
                            if ($this->celular == $this->celular_opcional) {
                                $fail('El celular opcional no puede ser igual al celular.');
                            }
                        }
                    },
                ],
                'correo' => [
                    'required',
                    'email',
                    'max:50',
                    function ($attribute, $value, $fail) {
                        $query = Persona::where('correo', $value)
                                        ->orWhere('correo_opcional', $value)
                                        ->exists();
                        if ($query) {
                            $fail('El correo ya está en uso en el campo correo o correo opcional.');
                        }
                    },
                ],
                'correo_opcional' => [
                    'nullable',
                    'email',
                    'max:50',
                    function ($attribute, $value, $fail) {
                        if (!empty($value)) {
                            $query = Persona::where('correo', $value)
                                            ->orWhere('correo_opcional', $value)
                                            ->exists();
                            if ($query) {
                                $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                            }
                            if($this->correo_opcional == $this->correo){
                                $fail('El correo opcional no puede ser igual al correo.');
                            }
                        }
                    },
                ],
                'año_egreso' => 'required|numeric',
                'especialidad' => 'required|max:50',
                'centro_trabajo' => 'required|max:50',
                'discapacidad' => 'required|numeric',
                'estado_civil' => 'required|numeric',
                'grado_academico' => 'required|numeric',
                'universidad' => 'required|numeric',
                'ubigeo_direccion' => 'required|numeric',
                'ubigeo_nacimiento' => 'required|numeric',
                'pais_direccion' => 'required|max:50',
                'pais_nacimiento' => 'required|max:50',
            ]);
        }
    }

    public function mount()
    {
        $this->modalidad_model = Modalidad::all();
        $this->programas_model = collect();
        $this->codigo_estudiante_model = collect();
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

    public function guardarRegistro()
    {
        $this->validar_registro();

        // verificamos el pais de direccion
        $ubigeo_validar = Ubigeo::find($this->ubigeo_direccion)->ubigeo;
        if ($ubigeo_validar == 000000)
        {
            $this->pais_direccion = str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->pais_direccion);
        }
        else
        {
            $this->pais_direccion = 'PERU';
        }

        // verificamos el pais de nacimiento
        $ubigeo_validar = Ubigeo::find($this->ubigeo_nacimiento)->ubigeo;
        if ($ubigeo_validar == 000000)
        {
            $this->pais_nacimiento = str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->pais_nacimiento);
        }
        else
        {
            $this->pais_nacimiento = 'PERU';
        }

        //reemplazar tildes por letras sin tildes en los campos de apellido paterno, apellido materno y nombres
        $this->nombre = strtoupper(str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->nombre));
        $this->apellido_paterno = strtoupper(str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->apellido_paterno));
        $this->apellido_materno = strtoupper(str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->apellido_materno));
        $this->direccion = strtoupper(str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->direccion));
        $this->especialidad = strtoupper(str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->especialidad));
        $this->centro_trabajo = strtoupper(str_replace(["á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù"], ["a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U"], $this->centro_trabajo));
        $this->correo = strtolower(str_replace(' ', '', $this->correo));

        // dd($this->pais_nacimiento, $this->pais_direccion, $this->nombre, $this->apellido_paterno, $this->apellido_materno, $this->direccion, $this->especialidad, $this->centro_trabajo, strlen($this->numero_documento), $this->correo);

        //Validar la declaracion jurada
        if($this->declaracion_jurada == false)
        {
            // emitir evento para mostrar mensaje de alerta de declaracion jurada
            $this->dispatchBrowserEvent('registro_inscripcion', [
                'title' => '',
                'text' => 'Debe aceptar la declaración jurada para continuar con el registro de datos.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);

            // validar el campo de declaracion jurada para que no se envie el formulario
            $this->validate([
                'declaracion_jurada' => 'accepted',
            ]);

            // redireccionar a la misma pagina
            return redirect()->back();
        }

        //Validar que se haya registrado la persona en la base de datos
        $persona = Persona::where('numero_documento', $this->numero_documento)->first();
        if($persona)
        {
            // emitir evento para mostrar mensaje de alerta de declaracion jurada
            $this->dispatchBrowserEvent('registro_inscripcion', [
                'title' => '',
                'text' => 'El número de documento ya se encuentra registrado.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);

            // redireccionar a la misma pagina
            return redirect()->back();
        }

        // Guardamos los datos de la persona
        $persona = new Persona();
        $persona->numero_documento = $this->numero_documento;
        $persona->apellido_paterno = $this->apellido_paterno;
        $persona->apellido_materno = $this->apellido_materno;
        $persona->nombre = $this->nombre;
        $persona->nombre_completo = $this->apellido_paterno.' '.$this->apellido_materno.' '.$this->nombre;
        $persona->id_genero = $this->genero;
        $persona->fecha_nacimiento = $this->fecha_nacimiento;
        $persona->direccion = $this->direccion;
        $persona->celular = $this->celular;
        if($this->celular_opcional)
        {
            $persona->celular_opcional = $this->celular_opcional;
        }
        $persona->correo = $this->correo;
        if($this->correo_opcional)
        {
            $persona->correo_opcional = $this->correo_opcional;
        }
        $persona->año_egreso = $this->año_egreso;
        $persona->especialidad_carrera = $this->especialidad;
        $persona->centro_trabajo = $this->centro_trabajo;
        if(strlen($this->numero_documento) == 8)
        {
            $persona->id_tipo_documento = 1;
        }
        else
        {
            $persona->id_tipo_documento = 2;
        }
        $persona->id_discapacidad = $this->discapacidad;
        $persona->id_estado_civil = $this->estado_civil;
        $persona->id_grado_academico = $this->grado_academico;
        $persona->id_universidad = $this->universidad;
        $persona->ubigeo_direccion = Ubigeo::find($this->ubigeo_direccion)->id_ubigeo;
        $persona->ubigeo_nacimiento = Ubigeo::find($this->ubigeo_nacimiento)->id_ubigeo;
        $persona->pais_direccion = $this->pais_direccion;
        $persona->pais_nacimiento = $this->pais_nacimiento;
        $persona->save();

        //Guardamos los datos de admitido
        $admitido = new Admitido();
        $admitido->admitido_codigo = $this->admitido_codigo;
        $admitido->id_persona = $persona->id_persona;
        $admitido->id_evaluacion = null;
        $admitido->id_programa_proceso = $this->programa;
        $admitido->id_programa_proceso_antiguo = null;
        $admitido->id_tipo_estudiante = 1;
        $admitido->admitido_estado = 2;
        $admitido->admitido_alerta = 1;
        $admitido->save();

        //Creamos sus credenciales en la tabla usuario_estudiante
        $usuario_estudiante = new UsuarioEstudiante();
        $usuario_estudiante->usuario_estudiante = $persona->correo;
        $usuario_estudiante->usuario_estudiante_password = Hash::make($persona->numero_documento);
        $usuario_estudiante->usuario_estudiante_creacion = date('Y-m-d H:i:s');
        $usuario_estudiante->usuario_estudiante_estado = 1;
        $usuario_estudiante->id_persona = $persona->id_persona;
        $usuario_estudiante->usuario_estudiante_perfil_url = null;
        $usuario_estudiante->save();

        //Inactivamos el codigo del estudiante registrado
        $updCodigo = CodigoEstudiante::where('codigo_estudiante', $this->admitido_codigo)->first();
        $updCodigo->codigo_estudiante_estado = 0;
        $updCodigo->save();

        $this->dispatchBrowserEvent('alerta_final_registro', [
            'id_persona' => $persona->id_persona,
        ]);
    }

    public function validar_registro()
    {
        if($this->paso === 1)
        {
            $this->resetErrorBag();
            $this->resetValidation();
            $this->validate([
                'admision' => 'required|numeric',
                'modalidad' => 'required|numeric',
                'programa' => 'required|numeric',
                'admitido_codigo' => 'required',
            ]);
        }
        else if($this->paso === 2)
        {
            $this->resetErrorBag();
            $this->resetValidation();

            if($this->ubigeo_direccion && $this->ubigeo_nacimiento)
            {
                $ubi_direccion = Ubigeo::find($this->ubigeo_direccion)->ubigeo;
                $ubi_nacimiento = Ubigeo::find($this->ubigeo_nacimiento)->ubigeo;

                if($ubi_direccion == 000000 && $ubi_nacimiento == 000000)
                {
                    $this->validate([
                        'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                        'apellido_paterno' => 'required|max:50',
                        'apellido_materno' => 'required|max:50',
                        'nombre' => 'required|max:50',
                        'genero' => 'required|numeric',
                        'fecha_nacimiento' => 'required|date',
                        'direccion' => 'required|max:100',
                        'celular' => 'required|numeric|digits:9',
                        'celular_opcional' => [
                            'nullable',
                            'numeric',
                            'digits:9',
                            function ($attribute, $value, $fail) {
                                if ($this->celular_opcional) {
                                    if ($this->celular == $this->celular_opcional) {
                                        $fail('El celular opcional no puede ser igual al celular.');
                                    }
                                }
                            },
                        ],
                        'correo' => [
                            'required',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                $query = Persona::where('correo', $value)
                                                ->orWhere('correo_opcional', $value)
                                                ->exists();
                                if ($query) {
                                    $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                }
                            },
                        ],
                        'correo_opcional' => [
                            'nullable',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                if (!empty($value)) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                    }
                                    if($this->correo_opcional == $this->correo){
                                        $fail('El correo opcional no puede ser igual al correo.');
                                    }
                                }
                            },
                        ],
                        'año_egreso' => 'required|numeric',
                        'especialidad' => 'required|max:50',
                        'centro_trabajo' => 'required|max:50',
                        'discapacidad' => 'required|numeric',
                        'estado_civil' => 'required|numeric',
                        'grado_academico' => 'required|numeric',
                        'universidad' => 'required|numeric',
                        'ubigeo_direccion' => 'required|numeric',
                        'ubigeo_nacimiento' => 'required|numeric',
                        'pais_direccion' => 'required|max:50',
                        'pais_nacimiento' => 'required|max:50',
                    ]);
                }
                else if($ubi_direccion == 000000)
                {
                    $this->validate([
                        'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                        'apellido_paterno' => 'required|max:50',
                        'apellido_materno' => 'required|max:50',
                        'nombre' => 'required|max:50',
                        'genero' => 'required|numeric',
                        'fecha_nacimiento' => 'required|date',
                        'direccion' => 'required|max:100',
                        'celular' => 'required|numeric|digits:9',
                        'celular_opcional' => [
                            'nullable',
                            'numeric',
                            'digits:9',
                            function ($attribute, $value, $fail) {
                                if ($this->celular_opcional) {
                                    if ($this->celular == $this->celular_opcional) {
                                        $fail('El celular opcional no puede ser igual al celular.');
                                    }
                                }
                            },
                        ],
                        'correo' => [
                            'required',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                $query = Persona::where('correo', $value)
                                                ->orWhere('correo_opcional', $value)
                                                ->exists();
                                if ($query) {
                                    $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                }
                            },
                        ],
                        'correo_opcional' => [
                            'nullable',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                if (!empty($value)) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                    }
                                    if($this->correo_opcional == $this->correo){
                                        $fail('El correo opcional no puede ser igual al correo.');
                                    }
                                }
                            },
                        ],
                        'año_egreso' => 'required|numeric',
                        'especialidad' => 'required|max:50',
                        'centro_trabajo' => 'required|max:50',
                        'discapacidad' => 'required|numeric',
                        'estado_civil' => 'required|numeric',
                        'grado_academico' => 'required|numeric',
                        'universidad' => 'required|numeric',
                        'ubigeo_direccion' => 'required|numeric',
                        'ubigeo_nacimiento' => 'required|numeric',
                        'pais_direccion' => 'required|max:50',
                        'pais_nacimiento' => 'nullable|max:50',
                    ]);
                }
                else if($ubi_nacimiento == 000000)
                {
                    $this->validate([
                        'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                        'apellido_paterno' => 'required|max:50',
                        'apellido_materno' => 'required|max:50',
                        'nombre' => 'required|max:50',
                        'genero' => 'required|numeric',
                        'fecha_nacimiento' => 'required|date',
                        'direccion' => 'required|max:100',
                        'celular' => 'required|numeric|digits:9',
                        'celular_opcional' => [
                            'nullable',
                            'numeric',
                            'digits:9',
                            function ($attribute, $value, $fail) {
                                if ($this->celular_opcional) {
                                    if ($this->celular == $this->celular_opcional) {
                                        $fail('El celular opcional no puede ser igual al celular.');
                                    }
                                }
                            },
                        ],
                        'correo' => [
                            'required',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                $query = Persona::where('correo', $value)
                                                ->orWhere('correo_opcional', $value)
                                                ->exists();
                                if ($query) {
                                    $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                }
                            },
                        ],
                        'correo_opcional' => [
                            'nullable',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                if (!empty($value)) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                    }
                                    if($this->correo_opcional == $this->correo){
                                        $fail('El correo opcional no puede ser igual al correo.');
                                    }
                                }
                            },
                        ],
                        'año_egreso' => 'required|numeric',
                        'especialidad' => 'required|max:50',
                        'centro_trabajo' => 'required|max:50',
                        'discapacidad' => 'required|numeric',
                        'estado_civil' => 'required|numeric',
                        'grado_academico' => 'required|numeric',
                        'universidad' => 'required|numeric',
                        'ubigeo_direccion' => 'required|numeric',
                        'ubigeo_nacimiento' => 'required|numeric',
                        'pais_direccion' => 'nullable|max:50',
                        'pais_nacimiento' => 'required|max:50',
                    ]);
                }else{
                    $this->validate([
                        'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                        'apellido_paterno' => 'required|max:50',
                        'apellido_materno' => 'required|max:50',
                        'nombre' => 'required|max:50',
                        'genero' => 'required|numeric',
                        'fecha_nacimiento' => 'required|date',
                        'direccion' => 'required|max:100',
                        'celular' => 'required|numeric|digits:9',
                        'celular_opcional' => [
                            'nullable',
                            'numeric',
                            'digits:9',
                            function ($attribute, $value, $fail) {
                                if ($this->celular_opcional) {
                                    if ($this->celular == $this->celular_opcional) {
                                        $fail('El celular opcional no puede ser igual al celular.');
                                    }
                                }
                            },
                        ],
                        'correo' => [
                            'required',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                $query = Persona::where('correo', $value)
                                                ->orWhere('correo_opcional', $value)
                                                ->exists();
                                if ($query) {
                                    $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                }
                            },
                        ],
                        'correo_opcional' => [
                            'nullable',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                if (!empty($value)) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                    }
                                    if($this->correo_opcional == $this->correo){
                                        $fail('El correo opcional no puede ser igual al correo.');
                                    }
                                }
                            },
                        ],
                        'año_egreso' => 'required|numeric',
                        'especialidad' => 'required|max:50',
                        'centro_trabajo' => 'required|max:50',
                        'discapacidad' => 'required|numeric',
                        'estado_civil' => 'required|numeric',
                        'grado_academico' => 'required|numeric',
                        'universidad' => 'required|numeric',
                        'ubigeo_direccion' => 'required|numeric',
                        'ubigeo_nacimiento' => 'required|numeric',
                        'pais_direccion' => 'nullable|max:50',
                        'pais_nacimiento' => 'nullable|max:50',
                    ]);
                }
            }
            else
            {
                if($this->ubigeo_direccion && $this->ubigeo_nacimiento == null)
                {
                    $ubi_direccion = Ubigeo::find($this->ubigeo_direccion)->ubigeo;
                    if($ubi_direccion == 000000)
                    {
                        $this->validate([
                            'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                            'apellido_paterno' => 'required|max:50',
                            'apellido_materno' => 'required|max:50',
                            'nombre' => 'required|max:50',
                            'genero' => 'required|numeric',
                            'fecha_nacimiento' => 'required|date',
                            'direccion' => 'required|max:100',
                            'celular' => 'required|numeric|digits:9',
                            'celular_opcional' => [
                                'nullable',
                                'numeric',
                                'digits:9',
                                function ($attribute, $value, $fail) {
                                    if ($this->celular_opcional) {
                                        if ($this->celular == $this->celular_opcional) {
                                            $fail('El celular opcional no puede ser igual al celular.');
                                        }
                                    }
                                },
                            ],
                            'correo' => [
                                'required',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                    }
                                },
                            ],
                            'correo_opcional' => [
                                'nullable',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    if (!empty($value)) {
                                        $query = Persona::where('correo', $value)
                                                        ->orWhere('correo_opcional', $value)
                                                        ->exists();
                                        if ($query) {
                                            $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                        }
                                        if($this->correo_opcional == $this->correo){
                                            $fail('El correo opcional no puede ser igual al correo.');
                                        }
                                    }
                                },
                            ],
                            'año_egreso' => 'required|numeric',
                            'especialidad' => 'required|max:50',
                            'centro_trabajo' => 'required|max:50',
                            'discapacidad' => 'required|numeric',
                            'estado_civil' => 'required|numeric',
                            'grado_academico' => 'required|numeric',
                            'universidad' => 'required|numeric',
                            'ubigeo_direccion' => 'required|numeric',
                            'ubigeo_nacimiento' => 'required|numeric',
                            'pais_direccion' => 'required|max:50',
                            'pais_nacimiento' => 'nullable|max:50',
                        ]);
                    }
                    else
                    {
                        $this->validate([
                            'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                            'apellido_paterno' => 'required|max:50',
                            'apellido_materno' => 'required|max:50',
                            'nombre' => 'required|max:50',
                            'genero' => 'required|numeric',
                            'fecha_nacimiento' => 'required|date',
                            'direccion' => 'required|max:100',
                            'celular' => 'required|numeric|digits:9',
                            'celular_opcional' => [
                                'nullable',
                                'numeric',
                                'digits:9',
                                function ($attribute, $value, $fail) {
                                    if ($this->celular_opcional) {
                                        if ($this->celular == $this->celular_opcional) {
                                            $fail('El celular opcional no puede ser igual al celular.');
                                        }
                                    }
                                },
                            ],
                            'correo' => [
                                'required',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                    }
                                },
                            ],
                            'correo_opcional' => [
                                'nullable',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    if (!empty($value)) {
                                        $query = Persona::where('correo', $value)
                                                        ->orWhere('correo_opcional', $value)
                                                        ->exists();
                                        if ($query) {
                                            $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                        }
                                        if($this->correo_opcional == $this->correo){
                                            $fail('El correo opcional no puede ser igual al correo.');
                                        }
                                    }
                                },
                            ],
                            'año_egreso' => 'required|numeric',
                            'especialidad' => 'required|max:50',
                            'centro_trabajo' => 'required|max:50',
                            'discapacidad' => 'required|numeric',
                            'estado_civil' => 'required|numeric',
                            'grado_academico' => 'required|numeric',
                            'universidad' => 'required|numeric',
                            'ubigeo_direccion' => 'required|numeric',
                            'ubigeo_nacimiento' => 'required|numeric',
                            'pais_direccion' => 'nullable|max:50',
                            'pais_nacimiento' => 'nullable|max:50',
                        ]);
                    }
                }
                else if($this->ubigeo_nacimiento && $this->ubigeo_direccion == null)
                {
                    $ubi_nacimiento = Ubigeo::find($this->ubigeo_nacimiento)->ubigeo;
                    if($ubi_nacimiento == 000000)
                    {
                        $this->validate([
                            'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                            'apellido_paterno' => 'required|max:50',
                            'apellido_materno' => 'required|max:50',
                            'nombre' => 'required|max:50',
                            'genero' => 'required|numeric',
                            'fecha_nacimiento' => 'required|date',
                            'direccion' => 'required|max:100',
                            'celular' => 'required|numeric|digits:9',
                            'celular_opcional' => [
                                'nullable',
                                'numeric',
                                'digits:9',
                                function ($attribute, $value, $fail) {
                                    if ($this->celular_opcional) {
                                        if ($this->celular == $this->celular_opcional) {
                                            $fail('El celular opcional no puede ser igual al celular.');
                                        }
                                    }
                                },
                            ],
                            'correo' => [
                                'required',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                    }
                                },
                            ],
                            'correo_opcional' => [
                                'nullable',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    if (!empty($value)) {
                                        $query = Persona::where('correo', $value)
                                                        ->orWhere('correo_opcional', $value)
                                                        ->exists();
                                        if ($query) {
                                            $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                        }
                                        if($this->correo_opcional == $this->correo){
                                            $fail('El correo opcional no puede ser igual al correo.');
                                        }
                                    }
                                },
                            ],
                            'año_egreso' => 'required|numeric',
                            'especialidad' => 'required|max:50',
                            'centro_trabajo' => 'required|max:50',
                            'discapacidad' => 'required|numeric',
                            'estado_civil' => 'required|numeric',
                            'grado_academico' => 'required|numeric',
                            'universidad' => 'required|numeric',
                            'ubigeo_direccion' => 'required|numeric',
                            'ubigeo_nacimiento' => 'required|numeric',
                            'pais_direccion' => 'nullable|max:50',
                            'pais_nacimiento' => 'required|max:50',
                        ]);
                    }
                    else
                    {
                        $this->validate([
                            'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                            'apellido_paterno' => 'required|max:50',
                            'apellido_materno' => 'required|max:50',
                            'nombre' => 'required|max:50',
                            'genero' => 'required|numeric',
                            'fecha_nacimiento' => 'required|date',
                            'direccion' => 'required|max:100',
                            'celular' => 'required|numeric|digits:9',
                            'celular_opcional' => [
                                'nullable',
                                'numeric',
                                'digits:9',
                                function ($attribute, $value, $fail) {
                                    if ($this->celular_opcional) {
                                        if ($this->celular == $this->celular_opcional) {
                                            $fail('El celular opcional no puede ser igual al celular.');
                                        }
                                    }
                                },
                            ],
                            'correo' => [
                                'required',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                    }
                                },
                            ],
                            'correo_opcional' => [
                                'nullable',
                                'email',
                                'max:50',
                                function ($attribute, $value, $fail) {
                                    if (!empty($value)) {
                                        $query = Persona::where('correo', $value)
                                                        ->orWhere('correo_opcional', $value)
                                                        ->exists();
                                        if ($query) {
                                            $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                        }
                                        if($this->correo_opcional == $this->correo){
                                            $fail('El correo opcional no puede ser igual al correo.');
                                        }
                                    }
                                },
                            ],
                            'año_egreso' => 'required|numeric',
                            'especialidad' => 'required|max:50',
                            'centro_trabajo' => 'required|max:50',
                            'discapacidad' => 'required|numeric',
                            'estado_civil' => 'required|numeric',
                            'grado_academico' => 'required|numeric',
                            'universidad' => 'required|numeric',
                            'ubigeo_direccion' => 'required|numeric',
                            'ubigeo_nacimiento' => 'required|numeric',
                            'pais_direccion' => 'nullable|max:50',
                            'pais_nacimiento' => 'nullable|max:50',
                        ]);
                    }
                }
                else
                {
                    $this->validate([
                        'numero_documento' => 'required|numeric|digits_between:8,9|unique:persona,numero_documento',
                        'apellido_paterno' => 'required|max:50',
                        'apellido_materno' => 'required|max:50',
                        'nombre' => 'required|max:50',
                        'genero' => 'required|numeric',
                        'fecha_nacimiento' => 'required|date',
                        'direccion' => 'required|max:100',
                        'celular' => 'required|numeric|digits:9',
                        'celular_opcional' => [
                            'nullable',
                            'numeric',
                            'digits:9',
                            function ($attribute, $value, $fail) {
                                if ($this->celular_opcional) {
                                    if ($this->celular == $this->celular_opcional) {
                                        $fail('El celular opcional no puede ser igual al celular.');
                                    }
                                }
                            },
                        ],
                        'correo' => [
                            'required',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                $query = Persona::where('correo', $value)
                                                ->orWhere('correo_opcional', $value)
                                                ->exists();
                                if ($query) {
                                    $fail('El correo ya está en uso en el campo correo o correo opcional.');
                                }
                            },
                        ],
                        'correo_opcional' => [
                            'nullable',
                            'email',
                            'max:50',
                            function ($attribute, $value, $fail) {
                                if (!empty($value)) {
                                    $query = Persona::where('correo', $value)
                                                    ->orWhere('correo_opcional', $value)
                                                    ->exists();
                                    if ($query) {
                                        $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                                    }
                                    if($this->correo_opcional == $this->correo){
                                        $fail('El correo opcional no puede ser igual al correo.');
                                    }
                                }
                            },
                        ],
                        'año_egreso' => 'required|numeric',
                        'especialidad' => 'required|max:50',
                        'centro_trabajo' => 'required|max:50',
                        'discapacidad' => 'required|numeric',
                        'estado_civil' => 'required|numeric',
                        'grado_academico' => 'required|numeric',
                        'universidad' => 'required|numeric',
                        'ubigeo_direccion' => 'required|numeric',
                        'ubigeo_nacimiento' => 'required|numeric',
                        'pais_direccion' => 'nullable|max:50',
                        'pais_nacimiento' => 'nullable|max:50',
                    ]);
                }
            }
        }
    }

    public function updatedModalidad($modalidad)
    {
        $this->programas_model = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
                                        ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
                                        ->where('programa.id_modalidad', $modalidad)
                                        ->where('programa_proceso.id_admision',$this->admision)
                                        ->get();
    }

    public function updatedAdmision($admision)
    {
        $this->programas_model = ProgramaProceso::join('programa_plan', 'programa_plan.id_programa_plan', 'programa_proceso.id_programa_plan')
                                        ->join('programa', 'programa.id_programa', 'programa_plan.id_programa')
                                        ->where('programa.id_modalidad', $this->modalidad)
                                        ->where('programa_proceso.id_admision',$admision)
                                        ->get();
    }

    public function updatedUbigeoDireccion($ubigeo_direccion)
    {
        $ubi = Ubigeo::find($ubigeo_direccion);
        if($ubi->ubigeo == 000000)
        {
            $this->pais_direccion_estado = true;
        }
        else
        {
            $this->pais_direccion_estado = false;
            $this->reset('pais_direccion');
            $this->resetErrorBag('pais_direccion');
        }
    }

    public function updatedUbigeoNacimiento($ubigeo_nacimiento)
    {
        $ubi = Ubigeo::find($ubigeo_nacimiento);
        if($ubi->ubigeo == 000000)
        {
            $this->pais_nacimiento_estado = true;
        }
        else
        {
            $this->pais_nacimiento_estado = false;
            $this->reset('pais_nacimiento');
            $this->resetErrorBag('pais_nacimiento');
        }
    }

    public function updatedSearch($search)
    {
        if($search || $search != '')
        {
            $this->codigo_estudiante_model = CodigoEstudiante::where('codigo_estudiante', 'like', '%'.$search.'%')
                                                    ->orWhere('codigo_estudiante_nombre', 'like', '%'.$search.'%')
                                                    ->get();
        }
        else
        {
            if($this->fila_seleccionada)
            {
                $this->codigo_estudiante_model = CodigoEstudiante::where('id_codigo_estudiante', $this->fila_seleccionada)->get();
            }
            else
            {
                $this->codigo_estudiante_model = collect();
            }
        }
    }

    public function updatedCorreo($correo)
    {
        $this->validate([
            'correo' => [
                'required',
                'email',
                'max:50',
                function ($attribute, $value, $fail) {
                    $query = Persona::where('correo', $value)
                                    ->orWhere('correo_opcional', $value)
                                    ->exists();
                    if ($query) {
                        $fail('El correo ya está en uso en el campo correo o correo opcional.');
                    }
                },
            ],
            'correo_opcional' => [
                'nullable',
                'email',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        $query = Persona::where('correo', $value)
                                        ->orWhere('correo_opcional', $value)
                                        ->exists();
                        if ($query) {
                            $fail('El correo opcional ya está en uso en el campo correo o correo opcional.');
                        }
                        if($this->correo_opcional == $this->correo){
                            $fail('El correo opcional no puede ser igual al correo.');
                        }
                    }
                },
            ],
        ]);
    }

    public function updatedCelular($celular)
    {
        $this->validate([
            'celular' => 'required|numeric|digits:9',
            'celular_opcional' => [
                'nullable',
                'numeric',
                'digits:9',
                function ($attribute, $value, $fail) {
                    if ($this->celular_opcional) {
                        if ($this->celular == $this->celular_opcional) {
                            $fail('El celular opcional no puede ser igual al celular.');
                        }
                    }
                },
            ],
        ]);
    }

    public function updatedDeclaracionJurada($declaracion_jurada)
    {
        $this->validate([
            'declaracion_jurada' => 'accepted',
        ]);
    }

    public function seleccionarCodigo($id_codigo_estudiante)
    {
        $this->admitido_codigo = CodigoEstudiante::find($id_codigo_estudiante)->codigo_estudiante;
        $this->numero_alumnos = 0;
        $this->codigo_estudiante_model = collect();
        $this->search = '';
        $this->reset('search');
        $this->resetErrorBag('admitido_codigo');
        $this->emit('codigo_seleccionado');
        //Cerrar modal
        $this->dispatchBrowserEvent('modal', [
            'titleModal' => '#modalBuscarCodigo',
        ]);
        $this->fila_seleccionada = $id_codigo_estudiante;
    }

    public function eliminarCodigo()
    {
        $this->reset('admitido_codigo', 'fila_seleccionada');
    }

    //Abrir modal de buscar codigo
    public function abrirModal()
    {
        $this->limpiar();
        $this->dispatchBrowserEvent('abrir-modal', [
            'titleModal' => '#modalBuscarCodigo',
        ]);
    }

    //Limpiamos las variables del modal
    public function limpiar()
    {
        $this->reset('search');
        if($this->fila_seleccionada)
        {
            $this->codigo_estudiante_model = CodigoEstudiante::where('id_codigo_estudiante', $this->fila_seleccionada)->get();
        }
        else
        {
            $this->codigo_estudiante_model = collect();
        }
    }

    public function render()
    {

        return view('livewire.modulo-inscripcion.registro-alumnos.index',
        [
            'admision_model' => Admision::all(),
            'ubigeo_model' => Ubigeo::all(),
            'genero_model' => Genero::all(),
            'grado_academico_model' => GradoAcademico::all(),
            'estado_civil_model' => EstadoCivil::all(),
            'discapacidad_model' => Discapacidad::all(),
            'universidad_model' => Universidad::all(),
        ]);
    }
}
