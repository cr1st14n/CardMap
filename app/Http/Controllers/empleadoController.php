<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;

class empleadoController extends Controller
{
    function search_1(Request $request)
    {
        $nombreApellido = $request->input('nombre_apellido');

        // Dividir el texto en nombre y apellido
        $partes = explode(' ', $nombreApellido);
        $nombre = $partes[0];
        $apellido = count($partes) > 1 ? $partes[1] : '';

        // Realizar la búsqueda en la base de datos
        $resultados = Empleados::where(function ($query) use ($nombre, $apellido) {
            $query->where('Nombre', 'LIKE', '%' . $nombre . '%')
                ->Where('Paterno', 'LIKE', '%' . $apellido . '%');
        })->limit(25)->get();
        return response()->json(['data'=>$resultados]);
    }
}
