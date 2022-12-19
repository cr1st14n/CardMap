<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class empresaController extends Controller
{
    public function view_2_empr()
    {
        $empr = Empresas::get();
        return view('empresa.view_1')->with('Emps' . $empr);
    }
    public function query_list()
    {
        return  Empresas::get();
    }
    public function query_buscar_A(Request $request)
    {
        return Empresas::where('Empresa', 'like', '%' . $request->input('data') . '%')
            ->orWhere('NombEmpresa', 'like', '%' . $request->input('data') . '%')
            ->orWhere('Email', 'like', '%' . $request->input('data') . '%')
            ->orWhere('RepLegal', 'like', '%' . $request->input('data') . '%')
            ->get();
    }
   
    public function query_create(Request $request)
    {
        $n = new Empresas();
        $n->Empresa = $request->input('Emp_abreviacion');
        $n->NombEmpresa = $request->input('Emp_nombre');
        $n->Direccion = $request->input('Emp_dir');
        $n->Telefono = $request->input('Emp_telf');
        $n->Casilla = $request->input('Emp_casi');
        $n->Fax = $request->input('Emp_fax');
        $n->Email = $request->input('Emp_email');
        $n->RepLegal = $request->input('Emp_repLeg');
        $n->Ruc = $request->input('Emp_ruc');
        return $res = $n->save();
    }
    public function query_orden_list_1(Request $request)
    {
        $retVal = (($request->input('o') % 2) == 0) ? 'asc' : 'desc';
        return  Empresas::orderBy('id', $retVal)->get();
    }
    public function query_edit(Request $request)
    {
        return Empresas::where('id', $request->input('id'))->first();
    }
    public function query_update($id, Request $request)
    {
        return Empresas::where('id', $id)->update([
            'NombEmpresa' => $request->input('Emp_nombre_edit'),
            'Empresa' => $request->input('Emp_abreviacion_edit'),
            'Telefono' => $request->input('Emp_telf_edit'),
            'Direccion' => $request->input('Emp_dir_edit'),
            'RepLegal' => $request->input('Emp_repLeg_edit'),
            'Casilla' => $request->input('Emp_casi_edit'),
            'Fax' => $request->input('Emp_fax_edit'),
            'Email' => $request->input('Emp_email_edit'),
            'Ruc' => $request->input('Emp_ruc_edit'),
        ]);
    }
}
