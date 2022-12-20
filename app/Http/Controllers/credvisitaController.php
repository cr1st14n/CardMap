<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use App\Models\termAero;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;


class credvisitaController extends Controller
{
    public function viewHome()
    {
        $termAero = termAero::where('ta_depen_cod', Auth::user()->aeropuerto)->orderBy('ta_sigla', 'asc')->get();

        return view('credenciales.view_cv')->with('emps',$termAero);
    }
    public function query_listCV(Request $request)
    {
        $aero = ['LP' => 'LPB', 'CB' => 'CBB', 'SC' => 'VVI'];
        // return $aero[ Auth::User()->aeropuerto];
        return Empleados::where('Tipo', "V")->where('aeropuerto', $aero[session('aero')])
            ->select(
                'Empleados.idEmpleado',
                'Empleados.Codigo',
                'Empleados.CodigoTarjeta',
                'Empleados.AreasAut',
                'Empleados.CodMYFARE',
                'Empleados.aeropuerto_2',
            )
            ->orderBy('Codigo', 'desc')
            ->get();
    }
    public function query_createCV(Request $request)
    {
        $aero = ['LP' => 'LPB', 'CB' => 'CBB', 'SC' => 'VVI'];
        $cod = Empleados::where('Tipo', "V")->where('aeropuerto', $aero[session('aero')])
            ->max('Codigo') + 1;
        $new = new Empleados();
        $new->Codigo = $cod;
        $new->CI = 0;
        $new->Tipo = 'V';
        $new->aeropuerto = $aero[session('aero')];
        $new->aeropuerto_2 = $request->input('ncv_aeropuerto');
        $new->CodigoTarjeta = $request->input('ncv_codt');
        $new->CodMYFARE = $request->input('ncv_codMy');
        $new->AreasAut = $request->input('ncv_areas_acceso');
        $new->Vencimiento = ($request->input('ncv_fechaLimite') == '') ? null :    Carbon::parse($request->input('ncv_fechaLimite'))->format('Y-m-d H:i');
        $res = $new->save();
        return $res;
    }
    public function query_crevis_destroy(Request $request)
    {
        return Empleados::where('idEmpleado', $request->input('id'))->delete();
    }
    public function pdf_creden_v($id)
    {
        $data = Empleados::where('idEmpleado', $id)->select(
            'Codigo',
            'AreasAut',
            'aeropuerto',
            'aeropuerto_2',
            'FechaVencCP',
        )->first();
        switch (strlen($data['Codigo'])) {
            case 1:
                $data['Codigo'] = '000' . $data['Codigo'].'-'.$data['aeropuerto_2'];
                break;
            case 2:
                $data['Codigo'] = '00' . $data['Codigo'].'-'.$data['aeropuerto_2'];
                break;
            case 3:
                $data['Codigo'] = '0' . $data['Codigo'].'-'.$data['aeropuerto_2'];
                break;
        }
        $meses = ['01' => 'ENE', '02' => 'FEB', '03' => 'MAR', '04' => 'ABR', '05' => 'MAY', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SEP', '10' => 'OCT', '11' => 'NOV', '12' => 'DIC'];
        $fe = Carbon::parse($data['Vencimiento']);

        $rutaimgV = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/V-LPB.jpg',
            'CIJ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-CIJ-VISITA.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/V-CBB.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/V-VVI.jpg',
        ];
        $pdf = pdf::loadView(
            'credenciales.pdf_creden_v',
            [
                'data' => $data,
                'ruta' => $rutaimgV[$data['aeropuerto_2']],
                'aero' => $data['aeropuerto'],
                'fecha' => $fe->format('d') . '-' . $meses[$fe->format('m')] . '-' . $fe->format('Y'),


            ]
        );


        $pdf->setpaper(array(0, 0, 341, 527), 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
