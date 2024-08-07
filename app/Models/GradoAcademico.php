<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradoAcademico extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_grado_academico';
    protected $table = 'grado_academico';
    protected $fillable = [
        'id_grado_academico',
        'grado_academico',
        'grado_academico_prefijo',
        'grado_academico_estado',
    ];

    public $timestamps = false;

    // Persona
    public function persona()
    {
        return $this->hasMany(Persona::class, 'id_grado_academico', 'id_grado_academico');
    }
}
