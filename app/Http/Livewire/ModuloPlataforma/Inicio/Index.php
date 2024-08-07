<?php

namespace App\Http\Livewire\ModuloPlataforma\Inicio;

use Livewire\Component;
use App\Models\Admision;
use App\Models\Admitido;
use App\Models\Encuesta;
use App\Models\Inscripcion;
use App\Models\LinkWhatsapp;
use App\Models\EncuestaDetalle;
use App\Models\EvaluacionDocente;
use App\Models\Matricula;
use App\Models\MatriculaCurso;
use App\Models\NotaMatriculaCurso;
use App\Models\ProgramaProceso;

class Index extends Component
{
    public $encuesta = []; // array de encuestas
    public $encuesta_otro = null; // campo de otros
    public $mostra_otros = false; // mostrar campo de otros

    public function open_modal_encuesta()
    {
        $id_persona = auth('plataforma')->user()->id_persona;

        $encuesta = EncuestaDetalle::where('id_persona', $id_persona)->get(); // buscamos si el usuario ya realizo la encuesta
        if($encuesta->count() == 0){
            $this->dispatchBrowserEvent('modal_encuesta', [
                'action' => 'show'
            ]);
        }

        // encuesta de evaluacion docente
       // $admitido = Admitido::where('id_persona', $id_persona)->orderBy('id_admitido', 'desc')->first(); // obtenemos el admitido de la inscripcion de la persona del usuario autenticado en la plataforma
       // $ultima_matricula = Matricula::where('id_admitido', $admitido->id_admitido)->orderBy('id_matricula', 'desc')->first();
       // $cursos_activos_matricula = NotaMatriculaCurso::query()
        //    ->join('matricula_curso', 'nota_matricula_curso.id_matricula_curso', '=', 'matricula_curso.id_matricula_curso')
       //     ->join('matricula', 'matricula_curso.id_matricula', '=', 'matricula.id_matricula')
       //     ->where('matricula_curso.id_matricula', $ultima_matricula->id_matricula)
        //    ->where('matricula_curso.matricula_curso_estado', 2)
        //    ->where('matricula_curso.matricula_curso_activo', 1)
        //    ->groupBy('nota_matricula_curso.id_matricula_curso')
        //    ->get();
        //$tiene_encuesta = false;
       // foreach ($cursos_activos_matricula as $item) {
         //   $evaluacion_docente = EvaluacionDocente::query()
          //      ->where('id_nota_matricula_curso', $item->id_nota_matricula_curso)
          //      ->where('id_docente', $item->id_docente)
          //     ->where('id_admitido', $item->id_admitido)
           //     ->first();
           // if ($evaluacion_docente) {
           //     $tiene_encuesta = false;
           // } else {
            //    $tiene_encuesta = true;
             //   break;
            //}
        //}

        //if ($tiene_encuesta) {
          //  $this->dispatchBrowserEvent('modal_encuesta_docente', [
           //     'action' => 'show'
           // ]);
      //  }
    }

    public function updatedEncuesta($value)
    {
        $contador = 0;
        foreach ($this->encuesta as $key => $value) {
            if($value == 8){
                $contador++;
            }
        }
        if($contador > 0){
            $this->mostra_otros = true;
        }else{
            $this->mostra_otros = false;
        }
    }

    public function guardar_encuesta()
    {
        // validamos los campos del formulario
        if($this->encuesta == null)
        {
            $this->dispatchBrowserEvent('alerta-encuesta', [
                'title' => 'Error',
                'text' => 'Debe seleccionar al menos una opción.',
                'icon' => 'error',
                'confirmButtonText' => 'Aceptar',
                'color' => 'danger'
            ]);
            return;
        }
        // validamos el campo otros
        if($this->mostra_otros == true)
        {
            if($this->encuesta_otro == null || $this->encuesta_otro == '')
            {
                $this->dispatchBrowserEvent('alerta-encuesta', [
                    'title' => 'Error',
                    'text' => 'Debe ingresar el campo "Otros".',
                    'icon' => 'error',
                    'confirmButtonText' => 'Aceptar',
                    'color' => 'danger'
                ]);
                return;
            }
        }

        // guardamos la encuesta
        foreach ($this->encuesta as $key => $value)
        {
            $encuesta = new EncuestaDetalle();
            $encuesta->id_persona = auth('plataforma')->user()->id_persona;
            $encuesta->id_admision = Admision::where('admision_estado', 1)->first()->id_admision;
            $encuesta->id_encuesta = $value;
            if($value == 8)
            {
                $encuesta->otros = $this->encuesta_otro;
            }
            else
            {
                $encuesta->otros = null;
            }
            $encuesta->encuesta_detalle_estado = 1;
            $encuesta->encuesta_detalle_creacion = now();
            $encuesta->save();
        }

        // mostrar alerta de registro de pago con exito
        $this->dispatchBrowserEvent('alerta-encuesta', [
            'title' => 'Exito',
            'text' => 'Encuesta registrada con exito.',
            'icon' => 'success',
            'confirmButtonText' => 'Aceptar',
            'color' => 'success'
        ]);

        // resetear el formulario
        $this->reset('encuesta', 'encuesta_otro', 'mostra_otros');

        // aqui cerra el modal de encuesta
        $this->dispatchBrowserEvent('modal_encuesta', [
            'action' => 'hide'
        ]);
    }

    public function alerta_admitido()
    {
        $this->dispatchBrowserEvent('modal', [
            'action' => 'show',
            'id' => '#modal-alerta-admitido'
        ]);
        $this->dispatchBrowserEvent('confetti');
        $this->dispatchBrowserEvent('confetti');
        $this->dispatchBrowserEvent('confetti');
    }

    public function mostrar_confetti()
    {
        $this->dispatchBrowserEvent('confetti');
        $this->dispatchBrowserEvent('confetti');
        $this->dispatchBrowserEvent('confetti');
    }

    public function cerrar_alerta_admitido($id_admitido)
    {
        $admitido = Admitido::find($id_admitido);
        $admitido->admitido_alerta = 1;
        $admitido->save();

        $this->dispatchBrowserEvent('modal', [
            'action' => 'hide',
            'id' => '#modal-alerta-admitido'
        ]);
    }

    public function render()
    {
        $encuestas = Encuesta::where('encuesta_estado', 1)->get(); // obtenemos las encuestas activas
        $usuario = auth('plataforma')->user();
        $persona = $usuario->persona;
        $inscripcion = $persona->inscripcion()->orderBy('id_inscripcion', 'desc')->first();
        if ($inscripcion) {
            $programa = ProgramaProceso::where('id_programa_proceso', $inscripcion->id_programa_proceso)->first();
            $programa = $programa->programa_plan->programa;
            if($programa->mencion){
                $programa = $programa->programa . ' EN ' . $programa->subprograma . ' CON MENCION EN ' . $programa->mencion;
            }else{
                $programa = $programa->programa . ' EN ' . $programa->subprograma;
            }
            $link = LinkWhatsapp::where('id_programa_proceso', $inscripcion->id_programa_proceso)->first();
            $link = $link->link_whatsapp;
        } else {
            $programa = null;
            $link = null;
        }
        $admitido = Admitido::where('id_persona', $persona->id_persona)->orderBy('id_admitido', 'desc')->first(); // obtenemos el admitido de la inscripcion de la persona del usuario autenticado en la plataforma
        return view('livewire.modulo-plataforma.inicio.index', [
            'encuestas' => $encuestas,
            'inscripcion' => $inscripcion,
            'programa' => $programa,
            'link' => $link,
            'admitido' => $admitido
        ]);
    }
}
