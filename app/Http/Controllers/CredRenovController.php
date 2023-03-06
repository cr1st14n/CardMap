<?php

namespace App\Http\Controllers;

use App\Models\credRenov;
use App\Http\Requests\StorecredRenovRequest;
use App\Http\Requests\UpdatecredRenovRequest;
use Illuminate\Http\Request;

class CredRenovController extends Controller
{
    public function query_estImprecion(Request $request)
    {
        $estadoRenoCreden = credRenov::where('id', $request->input('idRenovCred'))
            ->latest('id')->select('cr_tipo', 'idEmpleado', 'cr_estadoImp','id')
            ->first();
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
}
