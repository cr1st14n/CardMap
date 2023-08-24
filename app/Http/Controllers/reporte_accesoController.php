<?php

namespace App\Http\Controllers;

use App\Models\marcacion;
use App\Models\puntoAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class reporte_accesoController extends Controller
{
    function view_1()
    {
        $accesos = puntoAcceso::where('p_aeroIata', Auth::user()->aeropuerto)->get();
        return view('reportes.acceso_1', ['Acceso' => $accesos]);
    }
    function listAccesos_1(Request $request)
    {
        $idEmp = $request->input('id');
        $fecha_1 = $request->input('fecha1');
        $fecha_2 = $request->input('fecha2');
        $fecha_2 = $fecha_2 . ' 23:59';
        $empMarca = marcacion::where('id_puntoAcceso', $idEmp)
            ->whereBetween('created_at', [$fecha_1, $fecha_2])
            ->get();
        return response()->json(['data' => $empMarca]);
    }
    function empleadoMarcaciones(Request $request)
    {
        $fechaInicio = $request->input('fecha_1');
        $fechaFin = $request->input('fecha_2');
        $usuario = $request->input('codUsu');

        $resultados = marcacion::where('id_empleado', $usuario)
            ->whereBetween('marcacions.created_at', [$fechaInicio, $fechaFin])
            ->join('Empleados as e', 'marcacions.id_empleado', 'e.idEmpleado')
            ->join('punto_accesos as p', 'marcacions.id_puntoAcceso', 'p.id')
            ->orderBy('marcacions.id', 'desc')
            ->select(
                'marcacions.id',
                'marcacions.created_at',
                'p.p_aeroIata',
                'p.p_nombre',
                'Codigo',
                'Nombre',
                'Paterno',
                'Materno',
            )
            ->get();
        return response()->json($resultados);
    }
}
