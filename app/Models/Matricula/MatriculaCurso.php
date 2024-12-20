<?php

namespace App\Models\Matricula;

use App\Models\CursoProgramaPlan;
use App\Models\Docente;
use App\Models\ProgramaProcesoGrupo;
use App\Models\Reincorporacion;
use App\Models\Reingreso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriculaCurso extends Model
{
    use HasFactory;

    protected $table = 'tbl_matricula_curso';
    protected $primaryKey = 'id_matricula_curso';
    protected $fillable = [
        'id_matricula_curso',
        'id_matricula',
        'id_curso_programa_plan',
        'id_programa_proceso_grupo',
        'id_docente',
        'periodo',
        'es_acta_adicional',
        'es_acta_reingreso',
        'es_acta_incorporacion',
        'nota_evaluacion_permanente',
        'nota_evaluacion_medio_curso',
        'nota_evaluacion_final',
        'nota_promedio_final',
        'nota_observacion',
        'fecha_ingreso_nota',
        'estado',
        'activo',
        'id_reingreso',
        'id_incorporacion',
        'subsanacion_nota',
        'subsanacion_estado'
    ];
    public $timestamps = false;
    protected $casts = [
        'fecha_ingreso_nota' => 'date',
        'activo' => 'boolean'
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'id_matricula', 'id_matricula');
    }

    public function cursoProgramaPlan()
    {
        return $this->belongsTo(CursoProgramaPlan::class, 'id_curso_programa_plan', 'id_curso_programa_plan');
    }

    public function programaProcesoGrupo()
    {
        return $this->belongsTo(ProgramaProcesoGrupo::class, 'id_programa_proceso_grupo', 'id_programa_proceso_grupo');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    public function reingreso()
    {
        return $this->belongsTo(Reingreso::class, 'id_reingreso', 'id_reingreso');
    }

    public function incorporacion()
    {
        return $this->belongsTo(Reincorporacion::class, 'id_incorporacion', 'id_reincorporacion');
    }
}
