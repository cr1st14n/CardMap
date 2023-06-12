<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Empresas;
use App\Models\Marca;
use App\Models\Tipo;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class vehiculoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function view_1()
    {
        $emp = Empresas::select('Empresa', 'NombEmpresa')->get();
        foreach ($emp as $key => $value) {
            $emp[$key]['Empresa'] = rtrim($value->Empresa);
            $emp[$key]['FechaIniPer'] = Carbon::parse($value->FechaIniPer)->format('d-m-Y');
            $emp[$key]['FechaFinPer'] = Carbon::parse($value->FechaFinPer)->format('d-m-Y');
        }
        $color = Color::get();
        $tipo = Tipo::get();
        $marca = Marca::get();
        $datos = ['emp' => $emp, 'color' => $color, 'tipo' => $tipo, 'marca' => $marca,];


        return view('vehiculo.vei_home')->with('datos', $datos);
    }
    public function query_list1()
    {
        // switch (session('aero')) {
        //     case 'LP':
        //         $aero = 'LPB';
        //         break;
        //     case 'CB':
        //         $aero = 'CBB';
        //         break;
        //     case 'SC':
        //         $aero = 'VVI';
        //         break;

        //     default:
        //         # code...
        //         break;
        // }
        return Vehiculo::where('ca_cod_usu', Auth::user()->id)->get();
    }
    public function query_detalle_1(Request $request)
    {
        $data = Vehiculo::where('id', $request->input('id'))
            ->join('Marca', 'Marca.Codigo ', 'Vehiculos.Marca')
            ->join('Tipo', 'Tipo.Codigo ', 'Vehiculos.Tipo')
            ->join('Color', 'Color.Codigo ', 'Vehiculos.Color')
            ->first();
        $data['FechaIniPer'] = Carbon::parse($data['FechaIniPer'])->format('d-m-Y');
        $data['FechaFinPer'] = Carbon::parse($data['FechaFinPer'])->format('d-m-Y');
        return $data;
    }
    public function create_1()
    {
        $emp = Empresas::select('Empresa', 'NombEmpresa')->get();
        $color = Color::get();
        $tipo = Tipo::get();
        $marca = Marca::get();

        return ['emp' => $emp, 'color' => $color, 'tipo' => $tipo, 'marca' => $marca,];
    }
    public function store_1(Request $request)
    {
        $new = new Vehiculo;
        $new->Empresa = $request->input('vi_emp');
        $new->Placa = $request->input('vi_placa');
        $new->NroPoliza = $request->input('vi_poliza');
        $new->Responsable = $request->input('vi_resp');
        $new->EmpresaAseg = $request->input('vi_empAse');
        $new->FechaIniPer = Carbon::parse($request->input('vi_feI'))->format('Y-m-d H:i');
        $new->FechaFinPer = Carbon::parse($request->input('vi_fef'))->format('Y-m-d H:i');
        $new->FechaSolic = null;
        $new->Motivo = $request->input('vi_mo');
        $new->AutorizadoPor = $request->input('vi_aut');
        $new->Color = $request->input('vi_color');
        $new->Tipo = $request->input('vi_tipo');
        $new->Marca = $request->input('vi_fab');
        $new->Areas = $request->input('vi_AreasCp');
        $new->Vicom = "0";
        $new->Banderola = "0";
        $new->Banderola = "0";
        $new->ca_cod_usu = Auth::user()->id;
        $new->Estado = 1;
        // $new->created_at=Carbon::now()->format('Y-d-m H:i:s');
        // return $new;
        $re = $new->save();
        return $re;
    }

    // * UPDATE DATA VEHICULO
    public function update_1(Request $request)
    {
        $upVei = Vehiculo::find($request->input('idVei'));
        $upVei->Empresa = $request->input('vi_emp_edit');
        $upVei->Placa = $request->input('vi_placa_edit');
        $upVei->NroPoliza = $request->input('vi_poliza_edit');
        $upVei->Responsable = $request->input('vi_resp_edit');
        $upVei->EmpresaAseg = $request->input('vi_empAse_edit');
        $upVei->FechaIniPer = Carbon::parse($request->input('vi_feI_edit'))->format('Y-m-d H:i');
        $upVei->FechaFinPer = Carbon::parse($request->input('vi_fef_edit'))->format('Y-m-d H:i');
        $upVei->FechaSolic = null;
        $upVei->Motivo = $request->input('vi_mo_edit');
        $upVei->AutorizadoPor = $request->input('vi_aut_edit');
        $upVei->Color = $request->input('vi_color_edit');
        $upVei->Tipo = $request->input('vi_tipo_edit');
        $upVei->Marca = $request->input('vi_fab_edit');
        $upVei->Areas = $request->input('vi_AreasCp_edit');
        $upVei->Vicom = "0";
        $upVei->Banderola = "0";
        $upVei->Banderola = "0";
        $upVei->ca_cod_usu = Auth::user()->id;
        $upVei->Estado = 1;
        return $res = $upVei->save();
    }




    public function pdf_viñeta_1($tipo, $region, $id)
    {
        $data = Vehiculo::where('Vehiculos.id', $id)
            ->join('Marca', 'Marca.Codigo ', 'Vehiculos.Marca')
            ->join('Tipo', 'Tipo.Codigo ', 'Vehiculos.Tipo')
            ->join('Color', 'Color.Codigo ', 'Vehiculos.Color')
            ->join('Empresas', 'Empresas.Empresa', 'Vehiculos.Empresa')
            ->first();
        // return view(
        //     'vehiculo.vei_vineta',
        //     [
        //         'id' => $data->id,
        //         'Empresa' => $data->NombEmpresa,
        //         'Marca' => $data->Marca,
        //         'Placa' => $data->Placa,
        //         'Tipo' => $data->Tipo,
        //         'Color' => $data->Color,
        //         'Vence' => $data->FechaFinPer,
        //         'Vence' => Carbon::parse($data->FechaFinPer)->format('d-m-Y'),
        //         'Areas' => $data->Areas,
        //     ]
        // );
        $pdf = PDF::loadView('vehiculo.vei_vineta', [
            'id' => $data->id,
            'Empresa' => $data->NombEmpresa,
            'Marca' => $data->Marca,
            'Placa' => $data->Placa,
            'Tipo' => $data->Tipo,
            'Color' => $data->Color,
            'Vence' => Carbon::parse($data->FechaFinPer)->format('d-m-Y'),
            'Areas' => $data->Areas,
        ]);

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
        ]);
        $pdf->setPaper('5cm', '10cm');

        $pdf->setPaper([0, 0, 141.732, 283.465], 'landscape');
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $dompdf->set_option('margin-top', '0');
        $dompdf->set_option('margin-right', '0');
        $dompdf->set_option('margin-bottom', '0');
        $dompdf->set_option('margin-left', '0');
        return $pdf->stream('invoice.pdf');
    }
}
