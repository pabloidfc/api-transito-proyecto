<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function Listar() {
        return Ruta::all();
    }

    public function ListarUno($idRuta) {
        $ruta = Ruta::findOrFail($idRuta);
    }
}
