<?php

namespace App\Models\Matricula;

use App\Models\Admitido;
use App\Models\MatriculaGestion;
use App\Models\Pago;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'tbl_matricula';
    protected $primaryKey = 'id_matricula';
    protected $fillable = [
        'id_matricula',
        'id_matricula_gestion',
        'id_admitido',
        'ciclo',
        'codigo',
        'fecha_matricula',
        'creditos_disponibles',
        'id_pago',
        'estado'
    ];
    public $timestamps = false;
    protected $casts = [
        'fecha_matricula' => 'date'
    ];

    public function matriculaGestion()
    {
        return $this->belongsTo(MatriculaGestion::class, 'id_matricula_gestion', 'id_matricula_gestion');
    }

    public function admitido()
    {
        return $this->belongsTo(Admitido::class, 'id_admitido', 'id_admitido');
    }

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'id_pago', 'id_pago');
    }
}
