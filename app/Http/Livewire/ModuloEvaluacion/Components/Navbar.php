<?php

namespace App\Http\Livewire\ModuloEvaluacion\Components;

use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        $usuario = auth('evaluacion')->user();
        $avatar = 'https://ui-avatars.com/api/?name=' . $usuario->usuario_nombre . '&color=fff&background=1166fa&bold=true';
        return view('livewire.modulo-evaluacion.components.navbar', [
            'usuario' => $usuario,
            'avatar' => $avatar
        ]);
    }
}
