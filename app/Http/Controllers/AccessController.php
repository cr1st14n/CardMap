<?php

namespace App\Http\Controllers;

use App\Models\access;
use App\Http\Requests\StoreaccessRequest;
use App\Http\Requests\UpdateaccessRequest;
use App\Models\Empleados;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    function searchCod_1($cod, $area)
    {
        $res = Empleados::where('CodigoTarjeta', $cod)->first();

        if (empty($res)) {
            return response()->json(['status' => 'NOK', 'message' => 'Sin Datos', 'cod' => $res]);
        }
        $posicion = stripos($res->AreasAut, $area);

        if ($posicion !== false) {
            $estAccess = true;
        } else {
            $estAccess = false;
        }
        return response()->json(['status' => 'OK', 'estAccess' => $estAccess, 'data' => $res]);
    }
    function access_verificacion(Request $request)
    {
        $res = Empleados::where('CodigoTarjeta', $request->input('codigo'))->first();

        if (empty($res)) {
            return response()->json(['status' => 'NOK', 'message' => 'Sin Datos', 'cod' => $res]);
        }
        $posicion = stripos($res->AreasAut, $request->input('area'));

        if ($posicion !== false) {
            $estAccess = true;
        } else {
            $estAccess = false;
        }
        return response()->json(['status' => 'OK', 'estAccess' => $estAccess, 'area' => $request->input('area'), 'data' => $res]);
    }
}
