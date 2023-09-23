<?php

use App\Http\Controllers\TransportistaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VehiculoTransportaController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\ViajeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TransportistaController::class) -> group(function () {
    Route::get("/transportista", "Listar");
    Route::get("/transportista/{id}", "ListarUno");
    Route::get("/transportista/{id}/vehiculo", "ListarTransportistaVehiculo");
});

Route::controller(VehiculoController::class) -> group(function () {
    Route::get("/vehiculo", "Listar");
    Route::get("/vehiculo/estado", "ListarPorEstado");
    Route::put("/vehiculo/estado", "ModificarEstado");
    Route::get("/vehiculo/{id}", "ListarUno");
    Route::get("/vehiculo/{id}/transportistas", "ListarVehiculoTransportistas");
    Route::post("/vehiculo/{id}/transportistas", "AsignarTransportistas");
    Route::post("/vehiculo/lotes", "CrearVehiculoTransporta");
});

Route::controller(VehiculoTransportaController::class) -> group(function () {
    Route::get("/vehiculoTransporta", "Listar");
    Route::get("/vehiculoTransporta/estado", "ListarPorEstado");
    Route::put("/vehiculoTransporta/estado", "ModificarEstado");
    Route::get("/vehiculoTransporta/{id}", "ListarPorVehiculo");
});

Route::controller(RutaController::class) -> group(function () {
    Route::get("/ruta", "Listar");
    Route::get("/ruta/{id}", "ListarUno");
});

Route::controller(ViajeController::class) -> group(function () {
    Route::post("/viaje", "Crear");
    Route::get("/viaje", "Listar");
    Route::get("/viaje/{id}", "ListarUno");
    Route::get("/viaje/{id}/viajeAsignado", "ListarUnoViajeAsignado");
});