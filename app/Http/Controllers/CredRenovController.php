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
        return credRenov::where('idEmpleado', $request->input('id'))
            ->where('cr_tipo', $request->input('tipo'))
            ->latest('id')
            ->value('cr_estadoImp');
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
