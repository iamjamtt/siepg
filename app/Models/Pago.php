<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = "id_pago";
    protected $table = 'pago';
    protected $fillable = [
        'id_pago',
        'pago_documento',
        'pago_operacion',
        'pago_monto',
        'pago_fecha',
        'pago_estado',
        'pago_verificacion',
        'pago_leido',
        'pago_voucher_url',
        'id_canal_pago',
        'id_concepto_pago',
        'id_persona',
    ];

    public function canal_pago(){
        return $this->belongsTo(CanalPago::class,
        'id_canal_pago','id_canal_pago');
    }

    public function concepto_pago(){
        return $this->belongsTo(ConceptoPago::class,
        'id_concepto_pago','id_concepto_pago');
    }

    public function inscripcion(){
        return $this->hasOne(Inscripcion::class,
        'id_pago','id_pago');
    }

    public function pago_observacion(){
        return $this->hasMany(PagoObservacion::class,
        'id_pago','id_pago');
    }

    public function persona(){
        return $this->belongsTo(Persona::class,
        'id_persona','id_persona');
    }

    public function mensualidad(){
        return $this->hasOne(Mensualidad::class,
        'id_pago','id_pago');
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
