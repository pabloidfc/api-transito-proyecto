<?php

namespace App\Http\Controllers;

use App\Models\Transportista;
use Illuminate\Http\Request;

class TransportistaController extends Controller
{
    public function Listar(Request $req) {
        return Transportista::all();
    }

    public function ListarUno(Request $req, $idTransportista) {
        $transportista = Transportista::findOrFail($idTransportista);
        return $transportista;
    }

    public function ListarTransportistaVehiculo(Request $req, $idTransportista) {
        $transportista = Transportista::findOrFail($idTransportista);
        $transportista->Vehiculo;
        return $transportista;
    }
}
