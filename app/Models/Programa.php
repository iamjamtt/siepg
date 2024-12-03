<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_programa';
    protected $table = 'programa';
    protected $fillable = [
        'id_programa',
        'programa_iniciales',
        'programa',
        'subprograma',
        'mencion',
        'id_sunedu',
        'codigo_sunedu',
        'id_modalidad',
        'id_facultad',
        'id_sede',
        'programa_tipo',
        'programa_estado',
        'duracion_ciclos',
        'creditos_totales'
    ];

    public $timestamps = false;

    // sede
    public function sede(){
        return $this->belongsTo(Sede::class,'id_sede','id_sede');
    }

    // modalidad
    public function modalidad(){
        return $this->belongsTo(Modalidad::class,'id_modalidad','id_modalidad');
    }

    // facultad
    public function facultad(){
        return $this->belongsTo(Facultad::class,'id_facultad','id_facultad');
    }
}
