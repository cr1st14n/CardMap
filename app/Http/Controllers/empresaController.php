<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use App\Models\Empresas;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class empresaController extends Controller
{
    public function view_2_empr()
    {
        $empr = Empresas::orderBy('NombEmpresa', 'asc')->get();
        return view('empresa.view_1')->with('Emps', $empr);
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
        $res = Empresas::find($id);
        $emp = Empleados::where('Empresa', $res->Empresa)->get();
        $res->NombEmpresa = $request->input('Emp_nombre_edit');
        $res->Empresa = $request->input('Emp_abreviacion_edit');
        $res->Telefono = $request->input('Emp_telf_edit');
        $res->Direccion = $request->input('Emp_dir_edit');
        $res->RepLegal = $request->input('Emp_repLeg_edit');
        $res->Casilla = $request->input('Emp_casi_edit');
        $res->Fax = $request->input('Emp_fax_edit');
        $res->Email = $request->input('Emp_email_edit');
        $res->Ruc = $request->input('Emp_ruc_edit');

        $r = $res->save();
        foreach ($emp as $key => $value) {
            $upEm = Empleados::find($value->idEmpleado);
            $upEm->Empresa = $res->Empresa;
            $r2 = $upEm->save();
        }
        return $r;


        $abEmp = $request->input('Emp_abreviacion_edit');

        if ($r) {
            return $r;
        }
        $r2 = Empleados::where('Empresa', $abEmp)->select('idEmpleado');
        return $r2;
        if ($r2) {
            return true;
        }
        return false;

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
    public function query_delete(Request $request)
    {
        $e1 = $request->input('e1');
          $e1sigla = Empresas::where('id', $e1)->value('Empresa');

        $e2 = $request->input('e2');
        $e2 = Empresas::where('id', $e2)->value('Empresa');
        
         $sig = Empleados::where('Empresa', $e1sigla)->get();
        $newE = Empresas::where('id', $e1)->delete();
        $cont = 0;
        if ($newE == 1) {
            foreach ($sig as $key => $value) {
                $upEm = Empleados::find($value->idEmpleado);
                $upEm->Empresa =trim($e2);
                $estado = $upEm->save();
                if ($estado) {
                    $cont += 1;
                }
            }
        }
        return ["estado" => $newE, "cant" => $cont];
    }
}
