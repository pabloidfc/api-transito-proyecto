<?php

use App\Http\Controllers\TransportistaController;
use App\Http\Controllers\VehiculoController;
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
    Route::get("/vehiculo/{id}", "ListarUno");
    Route::get("/vehiculo/{id}/transportistas", "ListarTransportistaVehiculo");
});