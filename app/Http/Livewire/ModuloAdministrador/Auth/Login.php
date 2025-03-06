<?php

namespace App\Http\Livewire\ModuloAdministrador\Auth;

use App\Models\Administrativo;
use App\Models\TrabajadorTipoTrabajador;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public $email; // sirve para el login es la variable de email que se envia al controlador
    public $password; // sirve para el login es la variable de password que se envia al controlador

    public function updated($field)
    {
        $this->validateOnly($field, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    public function ingresar()
    {
        // validacion de los campos
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // simulamos un retraso de 3 segundos para evitar ataques de fuerza bruta
        sleep(3);

        // realizamos la consulta a la base de datos para verificar si el usuario existe
        $usuario = Usuario::where('usuario_correo',$this->email)->first();

        if(!$usuario)
        {
            // si no existe el usuario retornamos un mensaje de error
            session()->flash('message', 'Credenciales incorrectas');
            return redirect()->back();
        }
        else
        {
            if($usuario->usuario_estado == 0)
            {
                // si el usuario esta inactivo retornamos un mensaje de error
                session()->flash('message', 'Usuario inactivo');
                return redirect()->back();
            }
            else
            {
                // si el usuario esta activo verificamos la contraseña
                if(Hash::check($this->password, $usuario->usuario_password))
                {
                    // si la contraseña es correcta verificamos si el usuario tiene asiganado un trabajador
                    if($usuario->id_trabajador_tipo_trabajador)
                    {
                        // si tiene un trabajador verificamos si es un administrativo
                        $tra_tipo_tra = TrabajadorTipoTrabajador::where('id_trabajador_tipo_trabajador', $usuario->id_trabajador_tipo_trabajador)->first();

                        if($tra_tipo_tra->id_tipo_trabajador == 3)
                        {
                            // si es un administrativo verificamos si es de la area de TI
                            $administrativo = Administrativo::where('id_trabajador',$tra_tipo_tra->id_trabajador)->first();
                            if($administrativo->area_administrativo->id_area_administrativo == 3)
                            {
                                // si es de la area de TI lo redireccionamos a la vista de administrador
                                auth('usuario')->login($usuario);
                                return redirect()->route('administrador.dashboard');
                            }
                            elseif($administrativo->area_administrativo->id_area_administrativo == 1)
                            {
                                // si es de la area de contabilidad lo redireccionamos a la vista de contabilidad
                                auth('usuario')->login($usuario);
                                return redirect()->route('contable.inicio');
                            }
                            elseif($administrativo->area_administrativo->id_area_administrativo == 9)
                            {
                                // si es de la area de record academico lo redireccionamos a la vista de record academico
                                auth('usuario')->login($usuario);
                                return redirect()->route('record.inicio');
                            }
                            else
                            {
                                // si es de otra area sin vista mostrar un mensaje de error
                                session()->flash('message', 'Usuario administrativo sin vista');
                                return redirect()->back();
                            }
                        }
                        // verificamos si el usuario logueado es un coordinador
                        if($tra_tipo_tra->id_tipo_trabajador == 2)
                        {
                            // si es un coordinador lo redireccionamos a la vista de coordinador
                            auth('usuario')->login($usuario);
                            return redirect()->route('coordinador.inicio');
                        }
                        // verificamos si el usuario logueado es un docente
                        if($tra_tipo_tra->id_tipo_trabajador == 1)
                        {
                            // si es un docente mostrar un mensaje de error ya que no tiene vista
                            auth('usuario')->login($usuario);
                            return redirect()->route('docente.inicio');
                        }
                    }
                    else
                    {
                        // si el usuario logueado no tiene un trabajador asignado mostrar un mensaje de error
                        session()->flash('message', 'Usuario no asignado');
                        return redirect()->back();
                    }
                }
                else
                {
                    // si la contraseña es incorrecta retornamos un mensaje de error
                    session()->flash('message', 'Credenciales incorrectas');
                    return redirect()->back();
                }
            }
        }

    }

    public function render()
    {
        return view('livewire.modulo-administrador.auth.login');
    }
}
