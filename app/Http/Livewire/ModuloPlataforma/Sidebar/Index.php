<?php

namespace App\Http\Livewire\ModuloPlataforma\Sidebar;

use App\Models\Admitido;
use App\Models\ConstanciaIngreso;
use App\Models\Evaluacion;
use App\Models\Inscripcion;
use App\Models\Matricula;
use App\Models\Pago;
use App\Models\Persona;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'actualizar_sidebar' => 'render',
        'update_avatar' => 'render',
    ];

    public function cerrar_sesion()
    {
        auth('plataforma')->logout();
        return redirect()->route('plataforma.login');
    }

    public function render()
    {
        $usuario = auth('plataforma')->user(); // obtenemos el usuario autenticado en la plataforma
        $persona = Persona::where('id_persona', $usuario->id_persona)->first(); // obtenemos la persona del usuario autenticado en la plataforma
        $admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // obtenemos el admitido de la inscripcion de la persona del usuario autenticado en la plataforma
        $inscripcion_ultima = Inscripcion::where('id_persona', $persona->id_persona)->orderBy('id_inscripcion', 'desc')->first(); // inscripcion del usuario logueado
        $evaluacion = $admitido ? Evaluacion::where('id_evaluacion', $admitido->id_evaluacion)->first() : $inscripcion_ultima->evaluacion()->orderBy('id_evaluacion', 'desc')->first(); // evaluacion de la inscripcion del usuario logueado
        $constancia = $admitido ? ConstanciaIngreso::where('id_admitido', $admitido->id_admitido)->orderBy('id_constancia_ingreso', 'desc')->first() : null; // constancia de ingreso del usuario logueado
        $ultima_matricula = $admitido ? $admitido->ultimaMatriculaNuevo : null;

        return view('livewire.modulo-plataforma.sidebar.index', [
            'usuario' => $usuario,
            'persona' => $persona,
            'inscripcion_ultima' => $inscripcion_ultima,
            'evaluacion' => $evaluacion,
            'admitido' => $admitido,
            'constancia' => $constancia,
            'ultima_matricula' => $ultima_matricula,
        ]);
    }
}
