<?php

namespace App\Models\Matricula;

use App\Models\Admitido;
use App\Models\Ciclo;
use App\Models\CursoProgramaPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreMatriculaCurso extends Model
{
    use HasFactory;

    protected $table = 'tbl_prematricula_curso';
    protected $primaryKey = 'id_prematricula_curso';
    protected $fillable = [
        'id_prematricula_curso',
        'id_admitido',
        'id_curso_programa_plan',
        'id_ciclo',
        'estado'
    ];
    public $timestamps = false;
    protected $casts = [
        'estado' => 'boolean'
    ];

    public function admitido()
    {
        return $this->belongsTo(Admitido::class, 'id_admitido', 'id_admitido');
    }

    public function cursoProgramaPlan()
    {
        return $this->belongsTo(CursoProgramaPlan::class, 'id_curso_programa_plan', 'id_curso_programa_plan');
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'id_ciclo', 'id_ciclo');
    }
}
