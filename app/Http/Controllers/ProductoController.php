<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function GuestListarUno($idProducto) {
        $producto = Producto::find($idProducto);
        if (!$producto) return response(["msg" => "Not found!"], 404);
        return $producto;
    }
}
