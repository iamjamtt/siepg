<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ciclo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ciclo';
    protected $table = 'ciclo';
    protected $fillable = [
        'id_ciclo',
        'ciclo',
        'ciclo_programa',
        'ciclo_estado'
    ];

    public $timestamps = false;

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'id_ciclo');
    }
}
