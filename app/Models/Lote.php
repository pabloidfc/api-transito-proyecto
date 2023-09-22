<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "lote";

    public function Almacen() {
        return $this -> belongsTo(Almacen::class, "almacen_destino");
    }

    public function Creador() {
        return $this -> belongsTo(User::class);
    }

    public function Vehiculo() {
        return $this->belongsToMany(Vehiculo::class, 'vehiculo_transporta', 'lote_id', 'vehiculo_id')
        ->withPivot(['orden', 'estado_viaje', 'salida_programada']);
    }

    public function ViajeAsignado() {
        return $this -> belongsToMany(ViajeAsignado::class, "lote_id", "viaje_id");
    }
}