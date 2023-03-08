<?php

namespace App\Http\Controllers;

use App\Models\credRenov;
use App\Http\Requests\StorecredRenovRequest;
use App\Http\Requests\UpdatecredRenovRequest;
use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CredRenovController extends Controller
{
    public function query_estImprecion(Request $request)
    {
        $estadoRenoCreden = credRenov::where('id', $request->input('idRenovCred'))
            ->latest('id')->select('cr_tipo', 'idEmpleado', 'cr_estadoImp', 'id')
            ->first();
        $estadoRenoCreden->LicCategoria = Empleados::where('idEmpleado', $estadoRenoCreden->idEmpleado)->value('CategoriaLic');
        $est = true;
        if ($estadoRenoCreden == null) {
            $est = false;
        }
        if ($estadoRenoCreden->cr_estadoImp == 0) {
            $est = false;
        }
        return ['estado' => $est, 'data' => $estadoRenoCreden];
    }

    public function queryUpdateEstadoImpr(Request $request)
    {
        // return $request;
        $id = credRenov::where('idEmpleado', $request->input('id'))
            ->where('cr_tipo', $request->input('tipo'))
            ->latest('id')
            ->value('id');
        $up = credRenov::find($id);
        $up->cr_estadoImp = '0';
        $resp = $up->save();
        return $resp;
    }
    public function descImpr(Request $request): Response
    {
        $data = ['estado' => 0, 'mesansaje' => 'sin acceso'];
        if (Auth::user()->nivel == 1) {
            $updateEstImp = credRenov::find($request->idCreden);
            $updateEstImp->cr_estadoImp = 1;
            $res = $updateEstImp->save();
            $data = ($res) ?  ['estado' => 1, 'mesansaje' => 'procesado'] :  ['estado' => 3, 'mesansaje' => 'Error!'];
        }
        return response($data)->header('Content-type', 'json');
    }
}
