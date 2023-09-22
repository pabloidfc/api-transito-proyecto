<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ViajeAsignado extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function Viaje() {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }

    public function Lote() {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

    public function Vehiculo() {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}