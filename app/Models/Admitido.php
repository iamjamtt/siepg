<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admitido extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_admitido';
    protected $table = 'admitido';
    protected $fillable = [
        'id_admitido',
        'admitido_codigo',
        'id_persona',
        'id_evaluacion',
        'id_programa_proceso',
        'admitido_estado'
    ];

    public $timestamps = false;

    // Evaluacion
    public function evaluacion(){
        return $this->belongsTo(Evaluacion::class,
        'id_evaluacion','id_evaluacion');
    }

    // Persona
    public function persona(){
        return $this->belongsTo(Persona::class,
        'id_persona','id_persona');
    }

    // Programa Proceso
    public function programa_proceso(){
        return $this->belongsTo(ProgramaProceso::class,
        'id_programa_proceso','id_programa_proceso');
    }
}
