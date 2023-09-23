<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiculoTransporta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VehiculoTransportaController extends Controller
{
    public function Listar() {
        return VehiculoTransporta::all();
    }
    
    public function ListarPorVehiculo(Request $req, $idVehiculo) {
        $vehiculoTransporta = VehiculoTransporta::where("vehiculo_id", "=", $idVehiculo)->get();
        return $vehiculoTransporta;
    }

    public function ListarPorEstado(Request $req) {
        $opciones = [
            "No iniciado" => "No iniciado",
            "En curso"    => "En curso",
            "Finalizado"  => "Finalizado"
        ];

        if (isset($opciones[$req->estado])) {
            $vehiculoTransporta = VehiculoTransporta::where("estado_viaje", "=", $req->estado) -> get();
            return $vehiculoTransporta;
        }

        return response(["msg" => "El estado no existe!"], 400);
    }

    public function ModificarEstado(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "vehiculo_id"       => ["required", "integer", Rule::exists('vehiculo', 'id')],
            "salida_programada" => "required|date|date_format:Y-m-d H:i:s",
            "estado_viaje"      => "required|in:No iniciado,En curso,Finalizado"
        ]);

        if($validaciones->fails()) 
            return response($validaciones->errors(), 400);

        $coleccionVehiculoTransporta = VehiculoTransporta::where("vehiculo_id", "=", $req->vehiculo_id)
            ->where("salida_programada", "=", $req->salida_programada)->get();

        foreach($coleccionVehiculoTransporta as $vehiculoTransporta) {
            $vehiculoTransporta -> estado_viaje = $req -> estado_viaje;
            $vehiculoTransporta->save();
        }

        return $coleccionVehiculoTransporta;
    }
}
