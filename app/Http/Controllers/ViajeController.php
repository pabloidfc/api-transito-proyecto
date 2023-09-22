<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Viaje;

class ViajeController extends Controller
{
    public function Listar() {
      return Viaje::all();
    }

    public function ListarUno($idViaje) {
        $viaje = Viaje::findOrFail($idViaje);
        return $viaje;
    } 

    public function ListarUnoViajeAsignado($idViaje) {
        $viaje = Viaje::findOrFail($idViaje);
        $viaje -> ViajeAsignado;
        return $viaje;
    } 
}
