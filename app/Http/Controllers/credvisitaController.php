<?php

namespace App\Http\Controllers;

use App\Models\credVisitante;
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

        return view('credenciales.view_cv')->with('emps', $termAero);
    }
    public function query_listCV(Request $request)
    {
        // return $aero[ Auth::User()->aeropuerto];
        return credVisitante::where('cv_Aeropuerto', session('aero'))
            ->orderBy('cv_Codigo', 'desc')
            ->get();
    }
    public function query_createCV(Request $request)
    {
        $new = new credVisitante();
        $new->cv_Codigo = credVisitante::where('cv_Aeropuerto_2', $request->input('ncv_aeropuerto'))->max('cv_Codigo') + 1;
        $new->cv_fechaEmi = Carbon::now()->format('Y-m-d');
        $new->cv_FechaVenc = Carbon::parse($request->input('ncv_fechaLimite'))->format('Y-m-d');
        $new->cv_areas = $request->input('ncv_areas_acceso');
        $new->cv_tarjRfid = $request->input('ncv_codt');
        $new->cv_tarjMyfare = $request->input('ncv_codMy');
        $new->cv_Aeropuerto = session('aero');
        $new->cv_Aeropuerto_2 = $request->input('ncv_aeropuerto');

        $new->tipo = 'create';
        $new->estado = 1;
        $new->codUsu = Auth::user()->id;
        $res = $new->save();

        if ($res) {
            return ['estado' => 1, 'data' => $new];
        }
        return ['estado' => 0];
    }

    public function query_crevis_destroy(Request $request)
    {
        return credVisitante::where('id', $request->input('id'))->delete();
    }

    public function pdf_creden_v($id)
    {
        $data = credVisitante::where('id', $id)->select(
            'cv_Codigo',
            'cv_areas',
            'cv_Aeropuerto',
            'cv_Aeropuerto',
            'cv_Aeropuerto_2',
            )->first();

        $data->cv_areas_2=str_repeat("0", 4- strlen( $data->cv_Codigo));
        switch (strlen($data['Codigo'])) {
            case 1:
                $data['Codigo'] = '000' . $data['Codigo'] . '-' . $data['aeropuerto_2'];
                break;
            case 2:
                $data['Codigo'] = '00' . $data['Codigo'] . '-' . $data['aeropuerto_2'];
                break;
            case 3:
                $data['Codigo'] = '0' . $data['Codigo'] . '-' . $data['aeropuerto_2'];
                break;
        }
        $meses = ['01' => 'ENE', '02' => 'FEB', '03' => 'MAR', '04' => 'ABR', '05' => 'MAY', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SEP', '10' => 'OCT', '11' => 'NOV', '12' => 'DIC'];
        $fe = Carbon::parse($data['cv_FechaVenc']);

        $rutaimgV = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/V-LPB.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/V-CBB.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/V-VVI.jpg',
            'CIJ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-CIJ-VISITA.jpg',
            'ORU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-ORU-VI.jpg',
            'RBQ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RBQ-VI.jpg',
            'UYU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-UYU-VI.jpg',
            'GYA' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-GYA-VI.jpg',
            'RIB' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RIB-VI.jpg',
            'TDD' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-TDD-VI.jpg',

            'POI' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-POI-VI.jpg',
            'BYC' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-BYC-VI.jpg',
            'TJA' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-TJA-VI.jpg',
            'SRE' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-SRE-VI.jpg',
        ];
        $pdf = pdf::loadView(
            'credenciales.pdf_creden_v',
            [
                'data' => $data,
                'ruta' => $rutaimgV[$data['cv_Aeropuerto_2']],
                'aero' => $data['cv_Aeropuerto'],
                'fecha' => $fe->format('d') . '-' . $meses[$fe->format('m')] . '-' . $fe->format('Y'),


            ]
        );


        $pdf->setpaper(array(0, 0, 341, 527), 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
