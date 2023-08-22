<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reporte_credenController extends Controller
{
    function view_1()
    {
        $empresas = Empresas::join('Empleados as e', 'Empresas.Empresa', '=', 'e.Empresa')
            ->groupBy('Empresas.NombEmpresa', 'e.Empresa')
            ->select('Empresas.NombEmpresa', 'e.Empresa', DB::raw('count(e.Empresa) as total'))
            ->orderBy('Empresas.NombEmpresa')
            ->get();

        return view('reportes.credencial_1', ['empresas' => $empresas]);
    }
    function empresas_t_1()
    {
        $totalEmpresas =    Empresas::count('Empresa');
        $total_empresas_empleado = Empresas::Join('Empleados as e', 'Empresas.NombEmpresa', '=', 'e.Empresa')
            ->orderBy('e.Aeropuerto_2')
            ->orderBy('e.Empresa')
            ->groupBy('e.Empresa', 'e.Aeropuerto_2')
            ->select('e.Aeropuerto_2', 'e.Empresa', DB::raw('count(e.Empresa) as total'))
            ->get();
        $data = [
            'totalEmpresas' => $totalEmpresas,
            'total_empresas_empleado' => $total_empresas_empleado,
        ];


        return response()->json($data);
    }
    function empresas_t_2(Request $request)
    {
        // $totalEmpresas =    Empresas::count('Empresa');
        $search_codEmpresa = $request->input('cod');
        $total_empresas_empleado = Empresas::leftJoin('Empleados as e', 'Empresas.Empresa', '=', 'e.Empresa')
            ->where('e.Empresa',  $search_codEmpresa)
            ->orderBy('e.Aeropuerto_2')
            ->orderBy('e.Empresa')
            ->groupBy('e.Empresa', 'e.Aeropuerto_2', 'Empresas.NombEmpresa')
            ->select('e.Aeropuerto_2', 'Empresas.NombEmpresa', 'e.Empresa', DB::raw('count(e.Empresa) as total'))
            ->get();
        $data = [
            // 'totalEmpresas' => $totalEmpresas,
            'total_empresas_empleado' => $total_empresas_empleado,
        ];


        return response()->json($data);
    }
}
