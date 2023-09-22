<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Lote;
use App\Models\VehiculoTransporta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function CrearVehiculoTransporta(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "vehiculo_id" => ["required", "integer", Rule::exists('vehiculo', 'id')],
            "idsLotes"    => "required|array", 
            "idsLotes.*"  => "exists:lote,id",
            "salida_programada" => "required|date",
        ]);

        if ($validaciones->fails())
            return response($validaciones->errors(), 400);

        $vehiculo = Vehiculo::find($req->vehiculo_id);
        $idsLotes = $req -> input("idsLotes", []);

        $lotes = Lote::whereIn('id', $idsLotes)->get(); 

        $orden = 1;
        foreach ($lotes as $lote) {
            $vehiculo->Lotes()->attach($lote->id, [
                'orden' => $orden,
                'salida_programada' => $req->salida_programada,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $orden++;
        }

        $vehiculoTransporta = VehiculoTransporta::where('vehiculo_id', $vehiculo->id)
            ->first();

        $vehiculoTransportaInstances[] = $vehiculoTransporta;

        return $vehiculoTransporta;
    }
}
