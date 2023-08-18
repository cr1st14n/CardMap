<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use App\Models\marcacion;
use App\Models\puntoAcceso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessController extends Controller
{
    function view_1()
    {
        $area = Auth::user()->aeropuerto;
        $puerta = puntoAcceso::where('p_aeroIata', $area)->get();
        return view('ac.view_1_access', ['puertas' => $puerta]);
    }
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
        $codigouser = hexdec($request->input('codigo'));
        $codigouser = strval($codigouser);
        $completadoCeros = str_pad($codigouser, 10, '0', STR_PAD_LEFT);
        $completadoCeros = strval($completadoCeros);
        $res = Empleados::where('CodigoTarjeta', '=', $completadoCeros)
            ->orWhere('CodigoTarjeta', '=', $codigouser)
            ->leftJoin('Empresas as e', 'Empleados.Empresa', 'e.Empresa')
            ->select('Empleados.*', 'e.NombEmpresa')
            ->first();
        $puerta = puntoAcceso::where('p_ipCod', $request->input('area'))->first();

        // * VERIFICACION 
        if (empty($res)) {
            return response()->json(['status' => 'NOK', 'message' => 'Tarjeta no asociada ']);
        }
        if (empty($puerta)) {
            return response()->json(['status' => 'NOK', 'message' => 'Puerta no registrada']);
        }


        // *-----------------

        $permitoPuerta = str_replace("-", "", $puerta->p_areas);
        $permitoUsuario = str_replace("-", "", $res->AreasAut);

        // * COMPRAR AREAS PERMITIRDAS
        $arreglo1 = str_split($permitoPuerta);
        $arreglo2 = str_split($permitoUsuario);
        $estadoAcceso = (empty(array_intersect($arreglo1, $arreglo2))) ? 0 : 1;
        $message = ($estadoAcceso) ? 'Autorizado' : 'Denegado';

        if ($res->Tipo != 'N') {
            if ($puerta->p_aeroIata != $res->Aeropuerto_2) {
                $estadoAcceso = 0;
                $message = 'Denegado por región';
            }
        }


        $cr = new marcacion();
        $cr->id_puntoAcceso = $puerta['id'];
        $cr->id_empleado = $res['idEmpleado'];
        $cr->ac_codigo = $res['Codigo'];
        $cr->ac_codTarjeta = $res['CodigoTarjeta'];
        $cr->ac_areaSolicitud = $res->AreasAut;
        $cr->ac_areaPermitidas = $puerta->p_areas;
        $cr->ac_estadoAcceso = $estadoAcceso;
        $cr->p_regional = $puerta->p_regional;
        $cr->p_aeroIata = $puerta->p_aeroIata;
        $cr->ca_usu = $puerta->p_ipCod;
        $cr->ca_est = 1;

        $cr->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $query = $cr->save();

        if (!$query) {
            return response()->json(['status' => 'NOK', 'message' => 'Error de insecion', 'cod' => $res]);
        }
        $mar = marcacion::where('marcacions.id_puntoAcceso', $puerta->id)
            ->leftJoin('Empleados', 'marcacions.id_empleado', '=', 'Empleados.idEmpleado')
            ->orderBy('marcacions.id', 'desc')
            ->select(
                'marcacions.*',
                'Empleados.urlphoto',
                'Empleados.Nombre',
                'Empleados.Paterno',
                'Empleados.Empresa',
                'Empleados.Codigo',
                'Empleados.Aeropuerto_2',
            )
            ->limit(8)
            ->get();
        if (!empty($mar)) {
            foreach ($mar as $key => $value) {
                $mar[$key]['fecha_formate2'] = Carbon::parse($value->created_at)->format('d-m-Y H:i');
            }
        }
        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'estAccess' => $estadoAcceso,
            'area' => $request->input('area'),
            'data' => $res,
            'mar' => $mar
        ]);
    }
}
