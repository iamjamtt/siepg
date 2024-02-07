<?php

namespace App\Http\Livewire\ModuloPlataforma\Perfil;

use App\Models\Admision;
use App\Models\Admitido;
use App\Models\Persona;
use App\Models\UsuarioEstudiante;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads; // trait para subir archivos
    public $perfil; // variable para el perfil del usuario logueado
    public $password, $confirm_password; // variables para el cambio de contraseña
    public $iteration = 0; // variable para la iteracion de la imagen
    public $usuario; // variable para el usuario logueado

    public function mount()
    {
        $this->usuario = UsuarioEstudiante::find(auth('plataforma')->user()->id_usuario_estudiante);
    }

    public function refresh()
    {
        $this->usuario = UsuarioEstudiante::find(auth('plataforma')->user()->id_usuario_estudiante);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'perfil' => 'nullable|image|max:2048', // validacion para la imagen
            'password' => 'nullable|min:8|max:20', // validacion para la contraseña
            'confirm_password' => 'nullable|same:password', // validacion para la confirmacion de la contraseña
        ]);
    }

    public function limpiar_perfil()
    {
        $this->reset([
            'perfil',
            'password',
            'confirm_password',
        ]);
    }

    public function remove_avatar()
    {
        $this->reset('perfil');
        $this->iteration++;
    }

    public function actualizar_perfil()
    {
        // validamos los campos del formulario
        $this->validate([
            'perfil' => 'nullable|image|max:2048', // validacion para la imagen
            'password' => 'nullable|min:8|max:20', // validacion para la contraseña
            'confirm_password' => 'nullable|same:password', // validacion para la confirmacion de la contraseña
        ]);

        // buscar usuario logueado para actualizar el perfil
        $usuario = UsuarioEstudiante::find(auth('plataforma')->user()->id_usuario_estudiante);

        if ($this->perfil) {
            if (file_exists($usuario->usuario_estudiante_perfil_url)) {
                unlink($usuario->usuario_estudiante_perfil_url);
            }
            $persona = Persona::where('id_persona', auth('plataforma')->user()->id_persona)->first();
            $inscripcion = $persona->inscripcion()->orderBy('id_inscripcion', 'desc')->first();
            $admision = null;
            $admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first();
            if ($admitido) {
                if ($admitido->id_programa_proceso_antiguo) {
                    $admision = $admitido->programa_proceso_antiguo->admision->admision;
                } else {
                    $admision = $admitido->programa_proceso->admision->admision;
                }
            } else {
                $admision = $inscripcion->programa_proceso->admision->admision;
            }

            $base_path = 'Posgrado/';
            $folders = [$admision, $persona->numero_documento, 'Perfil'];

            // Asegurar que se creen los directorios con los permisos correctos
            $path = asignarPermisoFolders($base_path, $folders);

            // Nombre del archivo
            $filename = 'foto-perfil-' . date('HisdmY') . '.' . $this->perfil->getClientOriginalExtension();
            $nombre_db = $path . $filename;

            // Guardar el archivo
            $this->perfil->storeAs($path, $filename, 'files_publico');
            $usuario->usuario_estudiante_perfil_url = $nombre_db;

            // Asignar todos los permisos al archivo
            chmod($nombre_db, 0777);
        }
        if ($this->password) {
            $usuario->usuario_estudiante_password = $this->password;
        }
        $usuario->save();

        // cerrar modal
        $this->dispatchBrowserEvent('modal_perfil', [
            'action' => 'hide'
        ]);

        // emitir alerta de exito
        if ($this->perfil || $this->password) {
            $this->dispatchBrowserEvent('update_perfil', [
                'title' => '¡Éxito!',
                'text' => 'Se ha actualizado el perfil del usuario correctamente.',
                'icon' => 'success',
                'confirmButtonText' => 'Aceptar',
                'color' => 'success'
            ]);
        } else {
            $this->dispatchBrowserEvent('update_perfil', [
                'title' => '¡Advertencia!',
                'text' => 'No se ingresaron datos para actualizar el perfil del usuario.',
                'icon' => 'warning',
                'confirmButtonText' => 'Aceptar',
                'color' => 'warning'
            ]);
        }

        // emitir evento para actualizar la imagen del usuario logueado
        $this->emit('update_avatar');

        // refrescar componente
        $this->refresh();

        // limpiar formulario
        $this->limpiar_perfil();
        $this->remove_avatar();
    }

    public function render()
    {
        $id_persona = auth('plataforma')->user()->id_persona; // documento del usuario logueado
        $persona = Persona::where('id_persona', $id_persona)->first(); // persona logueada
        $admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // admitido del usuario logueado')
        if (!$persona) {
            abort(404);
        }
        $inscripcion = $persona->inscripcion()->orderBy('id_inscripcion', 'desc')->first(); // inscripcion del usuario logueado
        return view('livewire.modulo-plataforma.perfil.index', [
            'persona' => $persona,
            'inscripcion' => $inscripcion,
            'admitido' => $admitido,
        ]);
    }
}
