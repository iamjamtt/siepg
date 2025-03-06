<?php

namespace App\Http\Livewire\ModuloRecord\Navbar;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $usuario = auth('usuario')->user();
        $avatar = 'https://ui-avatars.com/api/?name=' . $usuario->usuario_nombre . '&color=fff&background=1166fa&bold=true';

        return view('livewire.modulo-record.navbar.index', [
            'usuario' => $usuario,
            'avatar' => $avatar
        ]);
    }
}
