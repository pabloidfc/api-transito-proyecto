<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Viaje;
use App\Models\VehiculoTransporta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function Crear(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "ruta_id"     => "required|integer|exists:ruta,id",
            "vehiculo_id" => "required|integer|exists:vehiculo,id",
            "idsLotes"    => "required|array", 
            "idsLotes.*"  => "exists:lote,id",
            "salida"      => "nullable|date|date_format:Y-m-d H:i:s"
        ]);

        $validaciones->after(function ($validator) use ($req) {
            $idVehiculo = $req->input('vehiculo_id');
            $idsLotes = $req->input('idsLotes');
        
            $count = VehiculoTransporta::where('vehiculo_id', $idVehiculo)
                ->whereIn('lote_id', $idsLotes)
                ->count();
        
            if ($count !== count($idsLotes)) {
                $validator->errors()->add('idsLotes', 'Los IDs de lotes y vehiculo_id no coinciden en la tabla VehiculoTransporta.');
            }
        });

        if($validaciones->fails())
            return response($validaciones->errors(), 400);

        $viaje = new Viaje;
        $viaje -> Ruta() -> associate($req -> input("ruta_id"));
        $viaje -> save();
        $idsLotes = $req -> input("idsLotes", []);

        foreach ($idsLotes as $idLote) {
            $viaje -> ViajeAsignado() -> create([
                "viaje_id"    => $viaje -> id,
                "vehiculo_id" => $req   -> input("vehiculo_id"),
                "lote_id"     => $idLote
            ]);
        }

        $viaje -> ViajeAsignado;
        return $viaje;

    }
}
