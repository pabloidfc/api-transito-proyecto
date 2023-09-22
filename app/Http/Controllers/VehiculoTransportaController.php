<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehiculoTransporta;

class VehiculoTransportaController extends Controller
{
    public function Listar() {
        return VehiculoTransporta::all();
    }
}
