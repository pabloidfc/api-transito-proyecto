<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Transportista;

class ValidarTipoTransportista
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->attributes->get("user_id");
        $transportista = Transportista::where("user_id", $userId)->first();
    
        if ($transportista) {
            $request->attributes->add(["transportista_id" => $transportista["id"]]);
            return $next($request);
        }
    
        return response(["msg" => "No tienes permiso para acceder a esta ruta."], 403);
    }
}
