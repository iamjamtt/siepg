<?php

namespace App\Models;

use App\Models\Matricula\Matricula;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_mensualidad';
    protected $table = 'mensualidad';
    protected $fillable = [
        'id_mensualidad',
        'id_matricula',
        'id_pago',
        'id_admitido',
        'mensualidad_fecha_creacion',
        'mensualidad_estado',
        'id_matricula_old'
    ];

    public $timestamps = false;

    // matricula
    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'id_matricula');
    }

    // pago
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'id_pago');
    }

    // admitido
    public function admitido()
    {
        return $this->belongsTo(Admitido::class, 'id_admitido');
    }
}
