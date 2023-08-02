<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use App\Models\marcacion;
use App\Models\puntoAcceso;
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
        $puerta = puntoAcceso::where('p_ipCod', $request->input('area'))->first();

        if (empty($res)) {
            return response()->json(['status' => 'NOK', 'message' => 'Tarjeta no asociada']);
        }
        if (empty($puerta)) {
            return response()->json(['status' => 'NOK', 'message' => 'Puerta no registrada']);
        }

        $posicion = stripos($res->AreasAut, $request->input('area'));
        if ($posicion !== false) {
            $estAccess = true;
        } else {
            $estAccess = false;
        }

        $cr = new marcacion();
        $cr->id_puntoAcceso = 0;
        $cr->id_empleado = $res['idEmpleado'];
        $cr->ac_codigo = $res['Codigo'];
        $cr->ac_codTarjeta = $res['CodigoTarjeta'];
        $cr->ac_areaSolicitud = 0;
        $cr->ac_areaPermitidas = 0;
        $cr->ac_estadoAcceso = $estAccess;
        $cr->p_regional = 'LP';
        $cr->p_aeroIata = 'LPB';
        $cr->ca_usu = '010';
        $cr->ca_est = 0;
        $query = $cr->save();

        if (!$query) {
            return response()->json(['status' => 'NOK', 'message' => 'Error de insecion', 'cod' => $res]);
        }
        return response()->json([
            'status' => 'OK',
            'estAccess' => $estAccess,
            'area' => $request->input('area'),
            'data' => $res,
            'ip' => $request->input('ip'),
        ]);
    }
}
