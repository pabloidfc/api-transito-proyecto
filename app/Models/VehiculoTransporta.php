<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiculoTransporta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehiculo_transporta";

    public function Lote() {
        return $this -> belongsTo(Lote::class);
    } 

    public function Vehiculo() {
        return $this -> belongsTo(Vehiculo::class);
    } 
}