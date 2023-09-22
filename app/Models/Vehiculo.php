<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehiculo";

    public function Transportistas() {
        return $this -> hasMany(Transportista::class);
    }

    public function Lotes() {
        return $this->belongsToMany(Lote::class, 'vehiculo_transporta', 'vehiculo_id', 'lote_id')
        ->withPivot(['orden', 'estado_viaje', 'salida_programada']);
    }

    public function ViajeAsignado() {
        return $this -> belongsToMany(ViajeAsignado::class, "vehiculo_id", "viaje_id");
    }
}
