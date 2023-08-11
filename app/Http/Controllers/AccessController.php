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
        //   return  $res = Empleados::where('CodigoTarjeta', dechex($request->input('codigo')))->first();
        
        $res = Empleados::where('CodigoTarjeta', $request->input('codigo'))->first();
        $puerta = puntoAcceso::where('p_ipCod', $request->input('area'))->first();

        if (empty($res)) {
            return response()->json(['status' => 'NOK', 'message' => 'Tarjeta no asociada']);
        }
        if (empty($puerta)) {
            return response()->json(['status' => 'NOK', 'message' => 'Puerta no registrada']);
        }

        $permitoPuerta = str_replace("-", "", $puerta->p_areas);
        $permitoUsuario = str_replace("-", "", $res->AreasAut);

        $arreglo1 = str_split($permitoPuerta);
        $arreglo2 = str_split($permitoUsuario);
        $estadoAcceso = (empty(array_intersect($arreglo1, $arreglo2))) ? 0 : 1;


        $cr = new marcacion();
        $cr->id_puntoAcceso = 0;
        $cr->id_empleado = $res['idEmpleado'];
        $cr->ac_codigo = $res['Codigo'];
        $cr->ac_codTarjeta = $res['CodigoTarjeta'];
        $cr->ac_areaSolicitud = $res->AreasAut;
        $cr->ac_areaPermitidas = $puerta->p_areas;
        $cr->ac_estadoAcceso = $estadoAcceso;
        $cr->p_regional = $puerta->p_regional;
        $cr->p_aeroIata = $puerta->p_aeroIata;
        $cr->p_tipo = 'E';
        $cr->ca_usu = $puerta->p_ipCod;
        $cr->ca_est = 1;
        $query = $cr->save();

        if (!$query) {
            return response()->json(['status' => 'NOK', 'message' => 'Error de insecion', 'cod' => $res]);
        }
        $mar = marcacion::leftJoin('Empleados', 'marcacions.id_empleado', '=', 'Empleados.idEmpleado')
            ->orderBy('marcacions.created_at', 'desc')
            ->select('marcacions.*', 'Empleados.urlphoto', 'Empleados.Nombre', 'Empleados.Empresa', 'Empleados.Codigo')
            ->limit(5)
            ->get();
        return response()->json([
            'status' => 'OK',
            'estAccess' => $estadoAcceso,
            'area' => $request->input('area'),
            'data' => $res,
            'mar' => $mar
        ]);
    }
}
