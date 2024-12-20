<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Curso extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_curso';
    protected $table = 'curso';
    protected $fillable = [
        'id_curso',
        'curso_codigo',
        'curso_nombre',
        'curso_credito',
        'curso_horas',
        'curso_fecha_creacion',
        'curso_estado',
        'id_ciclo',
        'curso_prerequisito',
    ];

    public $timestamps = false;

    // ciclo
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'id_ciclo');
    }

    public function cursoProgramaPlan(): HasOne
    {
        return $this->hasOne(CursoProgramaPlan::class, 'id_curso');
    }
}
