<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function Listar(Request $req) {
        return Vehiculo::all();
    }

    public function ListarUno(Request $req, $idVehiculo) {
        $vehiculo = Vehiculo::findOrFail($idVehiculo);
        return $vehiculo;
    }

    public function ListarVehiculoTransportistas(Request $req, $idVehiculo) {
        $vehiculo = Vehiculo::findOrFail($idVehiculo);
        $vehiculo->Transportistas;
        return $vehiculo;
    }
}
