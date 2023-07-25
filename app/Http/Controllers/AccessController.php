<?php

namespace App\Http\Controllers;

use App\Models\access;
use App\Http\Requests\StoreaccessRequest;
use App\Http\Requests\UpdateaccessRequest;
use App\Models\Empleados;

class AccessController extends Controller
{
    function searchCod_1($cod)
    {
        $res = Empleados::where('CodigoTarjeta', $cod)->first();
        if (empty($res)) {
            return response()->json(['status' => 'NOK', 'message' => 'Sin Datos', 'cod' => $res]);
        }
        return response()->json(['status' => 'OK', 'data' => $res]);
    }
}
