<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transportista;
use App\Models\Vehiculo;
use App\Models\VehiculoTransporta;
use App\Models\ViajeAsignado;
use App\Models\Viaje;
use Carbon\Carbon;

class ViajeController extends Controller
{
    public function VehiculoAsignado(Request $req) {
        $transportista_id = $req->attributes->get("transportista_id");
        $transportista = Transportista::find($transportista_id);
        
        if($transportista->vehiculo_id == null) return response(["msg" => "No tienes vehiculo asignado"], 400);
        $transportista->Vehiculo;
        return $transportista;
    }
    
    public function ViajeAsignado(Request $req) {
        $transportista_id = $req->attributes->get("transportista_id");
        $transportista = Transportista::find($transportista_id);
        $transporta = VehiculoTransporta::where("vehiculo_id", $transportista->vehiculo_id)->get();
        
        if(!$transporta) return response(["msg" => "No tienes viajes asignados"], 400);
        return response($transporta);
    }
    
    public function IniciarViaje(Request $req) {
        $transportista_id = $req->attributes->get("transportista_id");
        $transportista = Transportista::find($transportista_id);

        $transporta = VehiculoTransporta::where("vehiculo_id", $transportista->vehiculo_id)->get();
        $asignado = ViajeAsignado::where("vehiculo_id", $transportista->vehiculo_id)->get();
        $asignado_id = ViajeAsignado::where("vehiculo_id", $transportista->vehiculo_id)->first();
        $viaje = Viaje::where("id", $asignado_id->viaje_id)->first();

        $this->ModificarVehiculoTransporta($transporta);
        $this->FechaSalidaViaje($viaje);

        return response([
            "transporta" => $transporta,
            "viaje" => $viaje,
            "asignado" => $asignado,
        ]);
    }

    private function ModificarVehiculoTransporta($transporta) {
        foreach($transporta as $vehiculoTransporta) {
            $vehiculoTransporta->estado_viaje = "En curso";
            $vehiculoTransporta->save();
        }
    }

    private function FechaSalidaViaje($viaje) {
        $viaje->salida = Carbon::now('America/Montevideo')->format('Y-m-d H:i:s');
        $viaje->save();
    }

    public function ListarViaje(Request $req) {
        $usuario_id = $req->attributes->get("user_id");
        $transportista = $req->attributes->get("transportista_id");

        
    }
}