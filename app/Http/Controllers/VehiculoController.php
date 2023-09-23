<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Lote;
use App\Models\Transportista;
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

    public function ListarPorEstado(Request $req) {
        $opciones = [
            "Disponible"    => "Disponible",
            "No disponible" => "No disponible",
            "En reparación" => "En reparación"
        ];

        if (isset($opciones[$req->estado])) {
            $vehiculo = Vehiculo::where("estado", "=", $req->estado) -> get();
            return $vehiculo;
        }

        return response(["msg" => "El estado no existe!"], 400);
    }

    public function ModificarEstado(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "vehiculo_id" => ["required", "integer", Rule::exists('vehiculo', 'id')],
            "estado" => "required|in:Disponible,No disponible,En reparación"
        ]);

        if($validaciones->fails()) 
            return response($validaciones->errors(), 400);

        $vehiculo = Vehiculo::find($req -> vehiculo_id);
        $vehiculo -> estado = $req -> estado;
        $vehiculo -> save();

        return $vehiculo;
    }

    public function ListarVehiculoTransportistas(Request $req, $idVehiculo) {
        $vehiculo = Vehiculo::findOrFail($idVehiculo);
        $vehiculo->Transportistas;
        return $vehiculo;
    }

    public function CrearVehiculoTransporta(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "vehiculo_id"       => ["required", "integer", Rule::exists('vehiculo', 'id')],
            "idsLotes"          => "required|array", 
            "idsLotes.*"        => "exists:lote,id",
            "salida_programada" => "required|date|date_format:Y-m-d H:i:s",
        ]);

        if ($validaciones->fails())
            return response($validaciones->errors(), 400);

        $vehiculo = Vehiculo::find($req->vehiculo_id);
        $idsLotes = $req -> input("idsLotes", []);

        $lotes = Lote::whereIn('id', $idsLotes)->get(); 

        $orden = 1;
        foreach ($lotes as $lote) {
            $vehiculo->Lotes()->attach($lote->id, [
                'orden'             => $orden,
                'salida_programada' => $req->salida_programada,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);
            $orden++;
        }

        $vehiculoTransporta = VehiculoTransporta::whereIn('vehiculo_id', $vehiculo->id);

        return $vehiculoTransporta;
    }

    public function AsignarTransportistas(Request $req, $idVehiculo) {
        $vehiculo = Vehiculo::findOrFail($idVehiculo);
        $validaciones = Validator::make($req->all(), [
            "idsTransportistas" => "required|array",
            "idsTransportistas.*" => "exists:transportista,user_id",
        ]);

        if ($validaciones->fails())
            return response($validaciones->errors(), 400);

        $idsTransportistas = $req -> input("idsTransportistas", []);
        $transportistas = Transportista::whereIn("user_id", $idsTransportistas)->get();
        $vehiculo->Transportistas()->saveMany($transportistas);
        $vehiculo->Transportistas;

        return $vehiculo;
    }
}
