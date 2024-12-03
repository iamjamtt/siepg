<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id_matricula';
    protected $table = 'matricula';
    protected $fillable = [
        'id_matricula',
        'matricula_codigo',
        'matricula_proceso',
        'matricula_year',
        'matricula_ficha_url',
        'matricula_fecha_creacion',
        'matricula_estado',
        'id_admitido',
        'id_programa_proceso_grupo',
        'id_pago',
        'verificacion_costo_enseñanza',
        'matricula_primer_ciclo'
    ];

    // admitido
    public function admitido()
    {
        return $this->belongsTo(Admitido::class, 'id_admitido');
    }

    // programa proceso grupo
    public function programa_proceso_grupo()
    {
        return $this->belongsTo(ProgramaProcesoGrupo::class, 'id_programa_proceso_grupo');
    }

    // pago
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'id_pago');
    }

    public function matriculaCursos(): HasMany
    {
        return $this->hasMany(MatriculaCurso::class, 'id_matricula');
    }

    // protected static function boot() {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->created_by = auth()->id();
    //     });

    //     static::updating(function ($model) {
    //         $model->updated_by = auth()->id();
    //     });

    //     static::deleting(function ($model) {
    //         $model->deleted_by = auth()->id();
    //         $model->save();
    //     });
    // }
}
