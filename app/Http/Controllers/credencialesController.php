<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use App\Models\Empresas;
use App\Models\termAero;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class credencialesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function view_1()
    {
        //  return Auth::user()->aeropuerto 
        switch (Auth::user()->aeropuerto) {
            case 'LP':
                $aero = 'LPB';
                break;
            case 'CB':
                $aero = 'CBB';
                break;
            case 'SC':
                $aero = 'VVI';
                break;
            default:
                # code...
                break;
        }
        $em = Empleados::where('aeropuerto', Auth::user()->aeropuerto)
            ->join('Empresas', 'Empresas.Empresa', 'Empleados.Empresa')
            ->select(
                'Empleados.idEmpleado',
                'Empleados.Codigo',
                'Empleados.Nombre',
                'Empleados.Paterno',
                'Empleados.Materno',
                'Empleados.CI',
                'Empleados.urlphoto',
                'Empleados.Vencimiento',
                'Empleados.NroRenovacion',
                'Empresas.NombEmpresa',
            )
            ->orderBy('codigo', 'asc')
            ->get();
        $termAero = termAero::where('ta_depen_cod', Auth::user()->aeropuerto)->orderBy('ta_sigla', 'asc')->get();
        $empresas = Empresas::orderBy('NombEmpresa', 'asc')->get();
        return view('credenciales.view_1')
            ->with('Empr', $empresas)
            ->with('e', $em)
            ->with('terminals', $termAero);
    }
    public function queryCreate_1(Request $request)
    {
        // return session('aero');
        switch (session('aero')) {
            case 'LP':
                $aero = 'LPB';
                break;
            case 'CB':
                $aero = 'CBB';
                break;
            case 'SC':
                $aero = 'VVI';
                break;

            default:
                # code...
                break;
        }
        $list_vehi = ['tipo' => $request->input('nc_ltt'), 'list' => $request->input('nc_lt')];

        $new = new Empleados();
        $new->Codigo = intval(Empleados::latest('idEmpleado')->where('aeropuerto', $aero)->value('Codigo')) + 1;
        $new->tipo = $request->input('nc_tipo');
        $new->CI = $request->input('nc_ci');
        $new->CategoriaLic = $request->input('nc_t_licencia');
        $new->data_vehi_aut = serialize($list_vehi);
        $new->Nombre = $request->input('nc_nom');
        $new->Paterno = $request->input('nc_pa');
        $new->Materno = $request->input('nc_ma');
        $new->Empresa = $request->input('nc_em');
        $new->Cargo = $request->input('nc_car');
        $new->CodigoTarjeta = $request->input('nc_codt');
        $new->CodMYFARE = $request->input('nc_codMy');
        $new->NroRenovacion = 0;
        $new->Herramientas = $request->input('nc_he');
        $new->AreasAut = $request->input('nc_areas_acceso');
        $new->AreasCP = $request->input('nc_AreasCp');
        $new->GSangre = $request->input('nc_gs');
        $new->aeropuerto = $aero;
        $new->Aeropuerto_2 = $request->input('nc_aeropuerto');
        // $new->estado = $request->input('nc_acci');

        $new->Vencimiento = ($request->input('nc_fv') == '') ? null :   Carbon::parse($request->input('nc_fv'))->format('Y-d-m H:i:s');
        $new->Fecha = ($request->input('nc_f_in') == '') ? null :   Carbon::parse($request->input('nc_f_in'))->format('Y-d-m H:i:s');
        $new->FechaNac = ($request->input('nc_FNac') == '') ? null :    Carbon::parse($request->input('nc_FNac'))->format('Y-d-m H:i:s');

        $new->EstCivil = $request->input('nc_estCiv');
        $new->Sexo = $request->input('nc_sexo');
        $new->Profesion = $request->input('nc_pro');
        $new->altura = $request->input('nc_est');
        $new->Ojos = $request->input('nc_colojo');
        $new->Peso = $request->input('nc_maCorp');
        $new->TelDom = $request->input('nc_Fono');
        $new->Direccion = $request->input('nc_10');
        $new->TelTrab = $request->input('nc_11');
        $new->DirTrab = $request->input('nc_12');
        $new->Observacion = $request->input('nc_13');
        $new->data_creden = serialize(array());
        $res = $new->save();
        return $res;
    }

    public function queryShow_1()
    {
        switch (session('aero')) {
            case 'LP':
                $aero = 'LPB';
                break;
            case 'CB':
                $aero = 'CBB';
                break;
            case 'SC':
                $aero = 'VVI';
                break;

            default:
                # code...
                break;
        }
        return Empleados::where('aeropuerto', $aero)
            ->join('Empresas', 'Empresas.Empresa', 'Empleados.Empresa')
            ->select(
                'Empleados.idEmpleado',
                'Empleados.Codigo',
                'Empleados.Nombre',
                'Empleados.Paterno',
                'Empleados.Materno',
                'Empleados.CI',
                'Empleados.urlphoto',
                'Empleados.Vencimiento',
                'Empleados.NroRenovacion',
                'Empleados.CategoriaLic',
                'Empresas.NombEmpresa'
            )
            ->orderBy('codigo', 'asc')
            ->get();
    }
    public function query_add_photo(Request $request, $e)
    {
        $request->validate([
            'file' => 'required|image|max:2048'
        ]);
        $imagenes = $request->file('file')->store('public/imagenes');
        $url = Storage::url($imagenes);
        return $res = Empleados::where('idEmpleado', $e)->update(['urlphoto' => 'public' . $url]);
    }

    // * formato de credencial
    public function pdf_creden_emp_a($e, $tipo)
    {
        $data = Empleados::where('idEmpleado', $e)->select(
            'Codigo',
            'idEmpleado',
            'Nombre',
            'Paterno',
            'Materno',
            'urlphoto',
            'AreasAut',
            'AreasCP',
            'Cargo',
            'CI',
            'Vencimiento',
            'FechaVencCP',
            'Herramientas',
            'NroRenovacion',
            'Empresa',
            'aeropuerto',
            'Aeropuerto_2',
            'CategoriaLic',
            'data_vehi_aut',
            'Tipo'
        )->first();
        switch (strlen($data['Codigo'])) {
            case 1:
                $data['Codigo'] = '000' . $data['Codigo'];
                break;
            case 2:
                $data['Codigo'] = '00' . $data['Codigo'];
                break;
            case 3:
                $data['Codigo'] = '0' . $data['Codigo'];
                break;
        }
        $empr = Empresas::where('Empresa', $data['Empresa'])->value('NombEmpresa');
        if (strlen($empr) > 18) {
            //? Entonces corta la cadena y ponle el sufijo
            $empr = substr($empr, 0, 18) . '...';
        }
        $meses = ['01' => 'ENE', '02' => 'FEB', '03' => 'MAR', '04' => 'ABR', '05' => 'MAY', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SEP', '10' => 'OCT', '11' => 'NOV', '12' => 'DIC'];
        $fe = Carbon::parse($data['Vencimiento']);
        $dfecha = $fe->format('d');
        $mfecha = $fe->format('m');
        $afecha = $fe->format('Y');
        $fechaFormLieteral = $dfecha . '-' . $meses[$mfecha] . '-' . $afecha;

        $feCP = Carbon::parse($data['FechaVencCP']);
        $dfechaCP = $feCP->format('d');
        $mfechaCP = $feCP->format('m');
        $afechaCP = $feCP->format('Y');
        $fechaFormLieteralCP = $dfechaCP . '-' . $meses[$mfechaCP] . '-' . $afechaCP;
        //? return view('credenciales.pdf_creden_emp_a');
        $rutaimgL = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/LAPAZAMVERSO.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/COCHABAMBA2022.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/SANTACRUZAMVERSO.jpg',
            'CIJ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-CIJ-L.jpg',
            'ORU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-ORU-L.jpg',
            'RBQ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RBQ-L.jpg',
            'UYU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-UYU-L.jpg',
            'GYA' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-GYA-L.jpg',
            'RIB' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RIB-L.jpg',
        ];
        $rutaimgT = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/TEMPORALLP.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/TEMPORALCBB.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/TEMPORALVVI.jpg',
            'CIJ' => 'resources/plantilla/CREDENCIALESFOTOS/TEMPORALL_cij.jpg',
            'ORU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-ORU-T.jpg',
            'RBQ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RBQ-T.jpg',
            'UYU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-UYU-T.jpg',
            'GYA' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-GYA-T.jpg',
            'RIB' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RIB-T.jpg',
        ];
        $rutaimgLC = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/CONDUCCION-PLATAFORMA-LP.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/CONDUCCION-PLATAFORMA-CBB.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/CONDUCCION-PLATAFORMA-VVI.jpg',
            'CIJ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-CIJ-PCP.jpg',
            'ORU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-ORU-PCP.jpg',
            'RBQ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RBQ-PCP.jpg',
            'UYU' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-UYU-PCP.jpg',
            'GYA' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-GYA-PCP.jpg',
            'RIB' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-RIB-PCP.jpg',
        ];
        switch ($data['Tipo']) {
            case 'N':
                $pdf = pdf::loadView(
                    'credenciales.pdf_creden_emp_T1',
                    [
                        'data' => $data,
                        'em' => $empr,
                        'M' => $meses[$mfecha],
                        'Y' => $fe->format('Y'),
                        'ruta' => 'resources/plantilla/CREDENCIALESFOTOS/NACIONALAMVERSO.jpg',
                        'aero' => $data['Aeropuerto_2'],
                        'tipo' => $data['Tipo'],
                    ]
                );
                break;
            case 'L':
                $pdf = pdf::loadView(
                    'credenciales.pdf_creden_emp_T1',
                    [
                        'data' => $data,
                        'em' => $empr,
                        'M' => $meses[$mfecha],
                        'Y' => $fe->format('Y'),
                        'ruta' => $rutaimgL[$data['Aeropuerto_2']],
                        'aero' => $data['Aeropuerto_2'],
                        'tipo' => $data['Tipo'],
                    ]
                );
                break;
            case 'T':
                $pdf = pdf::loadView(
                    'credenciales.pdf_creden_emp_T2',
                    [
                        'data' => $data,
                        'em' => $empr,
                        'fechaFormLieteral' => $fechaFormLieteral,
                        'M' => $meses[$mfecha],
                        'Y' => $fe->format('Y'),
                        'ruta' => $rutaimgT[$data['Aeropuerto_2']],
                        'aero' => $data['Aeropuerto_2'],
                        'tipo' => $data['Tipo'],
                    ]
                );
                break;
            default:
                # code...
                break;
        }
        if ($tipo == 2) {
            if ($data->CategoriaLic == "") {
                return;
            }

            $data->data_vehi_aut = unserialize($data->data_vehi_aut);


            $a = 0;
            $LiA = '';
            $LiB = '';
            $LiC = '';
            $LiMP = '';
            while ($a < 10) {
                if ($a < 4) {
                    if (in_array('A-' . $a + 1, $data->data_vehi_aut)) {

                        $LiA = $LiA . "1";
                    } else {

                        $LiA = $LiA . "0";
                    }
                }
                if ($a < 7) {
                    if (in_array('B-' . $a + 1, $data->data_vehi_aut)) {

                        $LiB = $LiB . "1";
                    } else {
                        $LiB = $LiB . "0";
                    }
                }
                if ($a < 9) {
                    if (in_array('C-' . $a + 1, $data->data_vehi_aut)) {

                        $LiC = $LiC . "1";
                    } else {
                        $LiC = $LiC . "0";
                    }
                }
                if ($a < 2) {
                    if (in_array('MP-' . $a + 1, $data->data_vehi_aut)) {

                        $LiMP = $LiMP . "1";
                    } else {
                        $LiMP = $LiMP . "0";
                    }
                }

                $a += 1;
            }
            // return $LiA;
            // $q = str_replace(',', '', $data->data_vehi_aut);

            $LiA = str_replace('1', 'X', $LiA);
            $LiA = str_replace('0', '.', $LiA);

            $LiB = str_replace('1', 'X', $LiB);
            $LiB = str_replace('0', '.', $LiB);

            $LiC = str_replace('1', 'X', $LiC);
            $LiC = str_replace('0', '.', $LiC);

            $LiMP = str_replace('1', 'X', $LiMP);
            $LiMP = str_replace('0', '.', $LiMP);

            $pdf = pdf::loadView(
                'credenciales.pdf_creden_emp_lc',
                [
                    'catLic' => $data->CategoriaLic,
                    'LiA' => $LiA,
                    'LiB' => $LiB,
                    'LiC' => $LiC,
                    'LiMP' => $LiMP,
                    'data' => $data,
                    'em' => $empr,
                    'M' => $meses[$mfecha],
                    'Y' => $afecha = $fe->format('Y'),
                    'fechaFormLieteral' => $fechaFormLieteralCP,
                    'ruta' => $rutaimgLC[$data['Aeropuerto_2']],
                    'aero' => $data['Aeropuerto_2'],
                ]
            );
        }
        $pdf->setpaper(array(0, 0, 341, 527), 'portrait');
        return $pdf->stream('invoice.pdf');
    }
    public function query_cons_1(Request $request)
    {
        return Empleados::where('idEmpleado', $request->input('id'))->value('CategoriaLic');
    }

    public function query_destroy_credencial(Request $request)
    {
        return Empleados::where('idEmpleado', $request->input('id'))->delete();
    }

    public function query_edit_emp(Request $request)
    {
        $emp = Empleados::select(
            'Codigo',
            'tipo',
            'CI',
            'CategoriaLic',
            'data_vehi_aut',
            'Nombre',
            'Paterno',
            'Materno',
            'Empresa',
            'Cargo',
            'CodigoTarjeta',
            'CodMYFARE',
            'NroRenovacion',
            'Herramientas',
            'AreasAut',
            'AreasCP',
            'GSangre',
            'aeropuerto',
            'aeropuerto_2',
            'Vencimiento',
            'Fecha',
            'FechaNac',
            'EstCivil',
            'Sexo',
            'Profesion',
            'altura',
            'Ojos',
            'Peso',
            'TelDom',
            'Direccion',
            'TelTrab',
            'DirTrab',
            'Observacion',
            'data_creden',
            'idEmpleado',

        )


            ->where('idEmpleado', $request->input('id'))->first();
        $emp->Vencimiento = Carbon::parse($emp['Vencimiento'])->format('Y-m-d');
        $emp->FechaNac = Carbon::parse($emp['FechaNac'])->format('Y-m-d');
        $emp->Fecha = Carbon::parse($emp['Fecha'])->format('Y-m-d');
        $emp->data_vehi_aut = ($emp->data_vehi_aut != null) ? unserialize($emp->data_vehi_aut) : '';
        return $emp;
    }
    public function query_update_emp(Request $request)
    {
        // return $request;
        $list_vehi = ['tipo' => $request->input('nc_ltt'), 'list' => $request->input('nc_lt')];
        return  Empleados::where('idEmpleado', $request->input('id'))->update(
            [
                'tipo' => $request->input('nc_tipo_edit'),
                'CI' => $request->input('nc_ci_edit'),
                'CategoriaLic' => $request->input('nc_t_licencia_edit'),
                'data_vehi_aut' => serialize($list_vehi),
                'Nombre' => $request->input('nc_nom_edit'),
                'Paterno' => $request->input('nc_pa_edit'),
                'Materno' => $request->input('nc_ma_edit'),
                'Empresa' => $request->input('nc_em_edit_id'),
                'Cargo' => $request->input('nc_car_edit'),
                'CodigoTarjeta' => $request->input('nc_codt_edit'),
                'CodMYFARE' => $request->input('nc_codMy_edit'),
                'Herramientas' => $request->input('nc_he_edit'),
                'AreasAut' => $request->input('nc_areas_acceso_edit'),
                'AreasCP' => $request->input('nc_AreasCp_edit'),
                'GSangre' => $request->input('nc_gs'),
                // $new->aeropuerto = $aero;
                'Aeropuerto_2' => $request->input('nc_aeropuerto_edit'),
                'estado' => $request->input('nc_acci_edit'),

                'Vencimiento' => ($request->input('nc_fv_edit') == '') ? null :   Carbon::parse($request->input('nc_fv_edit'))->format('Y-d-m'),
                'Fecha' => ($request->input('nc_f_in_edit') == '') ? null :   Carbon::parse($request->input('nc_f_in_edit'))->format('Y-d-m'),
                'FechaNac' => ($request->input('nc_FNac_edit') == '') ? null :    Carbon::parse($request->input('nc_FNac_edit'))->format('Y-d-m'),

                'EstCivil' => $request->input('nc_estCiv_edit'),
                'Sexo' => $request->input('nc_sexo_edit'),
                'Profesion' => $request->input('nc_pro_edit'),
                'altura' => $request->input('nc_est_edit'),
                'Ojos' => $request->input('nc_colojo_edit'),
                'Peso' => $request->input('nc_maCorp_edit'),
                'TelDom' => $request->input('nc_Fono_edit'),
                'Direccion' => $request->input('nc_10_edit'),
                'TelTrab' => $request->input('nc_11_edit'),
                'DirTrab' => $request->input('nc_12_edit'),
                'Observacion' => $request->input('nc_13_edit'),
                'data_creden' => serialize(array()),

            ]
        );
    }
    public function query_buscar_A(Request $request)
    {
        // return $request;
        $r = $request->input('text');
        switch (session('aero')) {
            case 'LP':
                $aero = 'LPB';
                break;
            case 'CB':
                $aero = 'CBB';
                break;
            case 'SC':
                $aero = 'VVI';
                break;

            default:
                # code...
                break;
        }
        if ($request->input('term') == 'todo' || $request->input('term') == '') {
            $em = Empleados::where('aeropuerto', $aero)->where(function ($query) use ($r) {
                $query->where('Empleados.Nombre', 'like', '%' . $r . '%')
                    ->orwhere('Empleados.Paterno', 'like', '%' . $r . '%')
                    ->orwhere('Empleados.Materno', 'like', '%' . $r . '%')
                    ->orwhere('Empleados.CI', 'like', '%' . $r . '%');
            })
                ->join('Empresas', 'Empresas.Empresa', 'Empleados.Empresa')
                ->join('term_aeros', 'term_aeros.ta_sigla', 'Empleados.aeropuerto_2')
                ->select(
                    'Empleados.idEmpleado',
                    'Empleados.Codigo',
                    'Empleados.Nombre',
                    'Empleados.Paterno',
                    'Empleados.Materno',
                    'Empleados.CI',
                    'Empleados.urlphoto',
                    'Empleados.Vencimiento',
                    'Empleados.NroRenovacion',
                    'Empleados.CategoriaLic',
                    'Empresas.Empresa',
                    'Empresas.NombEmpresa',
                    'term_aeros.ta_sigla',
                    'term_aeros.ta_nombre',

                )
                ->orderBy('codigo', 'asc')
                ->limit(40)
                ->get();
        } else {
            $em = Empleados::where('aeropuerto_2', $request->input('term'))->where(function ($query) use ($r) {
                $query->where('Empleados.Nombre', 'like', '%' . $r . '%')
                    ->orwhere('Empleados.Paterno', 'like', '%' . $r . '%')
                    ->orwhere('Empleados.Materno', 'like', '%' . $r . '%')
                    ->orwhere('Empleados.CI', 'like', '%' . $r . '%');
            })
                ->join('Empresas', 'Empresas.Empresa', 'Empleados.Empresa')
                ->join('term_aeros', 'term_aeros.ta_sigla', 'Empleados.aeropuerto_2')
                ->select(
                    'Empleados.idEmpleado',
                    'Empleados.Codigo',
                    'Empleados.Nombre',
                    'Empleados.Paterno',
                    'Empleados.Materno',
                    'Empleados.CI',
                    'Empleados.urlphoto',
                    'Empleados.Vencimiento',
                    'Empleados.NroRenovacion',
                    'Empleados.CategoriaLic',
                    'Empresas.Empresa',
                    'Empresas.NombEmpresa',
                    'term_aeros.ta_nombre',
                    'term_aeros.ta_nombre',

                )
                ->orderBy('codigo', 'asc')
                ->limit(40)
                ->get();
        }
        return $em;
    }
    public function query_buscar_B(Request $request)
    {
        // return Empleados::where('aeropuerto_2',$request->input('text'))
        // ->join('Empresas', 'Empresas.Empresa', 'Empleados.Empresa')
        // ->first();
        if ($request->input('text') == 'todo') {
            return  $em = Empleados::where('aeropuerto', Auth::user()->aeropuerto)
                ->join('Empresas', 'Empresas.Empresa', 'Empleados.Empresa')
                ->join('term_aeros', 'term_aeros.ta_sigla', 'Empleados.aeropuerto_2')
                ->select(
                    'Empleados.idEmpleado',
                    'Empleados.Codigo',
                    'Empleados.Nombre',
                    'Empleados.Paterno',
                    'Empleados.Materno',
                    'Empleados.CI',
                    'Empleados.urlphoto',
                    'Empleados.Vencimiento',
                    'Empleados.NroRenovacion',
                    'Empresas.Empresa',
                    'Empresas.NombEmpresa',
                    'term_aeros.ta_sigla',
                    'term_aeros.ta_nombre',
                )
                ->orderBy('codigo', 'asc')
                ->get();
        } else {
            # code...
            return
                $em = Empleados::where('aeropuerto_2', $request->input('text'))
                ->join('Empresas', 'Empresas.Empresa', 'Empleados.Empresa')
                ->join('term_aeros', 'term_aeros.ta_sigla', 'Empleados.aeropuerto_2')
                ->select(
                    'Empleados.idEmpleado',
                    'Empleados.Codigo',
                    'Empleados.Nombre',
                    'Empleados.Paterno',
                    'Empleados.Materno',
                    'Empleados.CI',
                    'Empleados.urlphoto',
                    'Empleados.Vencimiento',
                    'Empleados.NroRenovacion',
                    'Empleados.CategoriaLic',
                    'Empresas.Empresa',
                    'Empresas.NombEmpresa',
                    'term_aeros.ta_sigla',
                    'term_aeros.ta_nombre',
                )
                ->orderBy('codigo', 'asc')
                ->limit(100)
                ->get();
        }
    }
    public function query_renovar_creden($tipo, Request $request)
    {
        $data = Empleados::where('idEmpleado', $request->input('id'))->first();

        // * sector de lista de renovaciones acnteriores  $tipo == 1
        if ($tipo == 1) {
            return [
                'data' => unserialize($data['data_creden']),
                'cod'  => $data['CodigoTarjeta'],
            ];
        }
        if ($request->input('ren_cred_codigo') <= 999) {
            return 0;
        }

        // * sector de createa renovacion de credencial $tipo == 2
        $d = ($data['data_creden'] == NULL) ? array() : unserialize($data['data_creden']);
        $new = [
            'motivo' => $request->input('ren_cred_motivo'),
            'tarjeta' => $data['CodigoTarjeta'],
            'fecha' => Carbon::now()->format('d-m-Y'),
        ];
        array_push($d, $new);
        return Empleados::where('idEmpleado', $request->input('id'))->update([
            'data_creden' => serialize($d),
            'CodigoTarjeta' => $request->input('ren_cred_codigo'),
            'NroRenovacion' => intval($data['NroRenovacion']) + 1
        ]);
    }
    public function query_update_TLC(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required',
        ]);
        if ($validator->fails()) {
            return false;
        }

        if ($request->input('tipo') == 'N') {

            $up = Empleados::find($request->input('id'));
            $up->CategoriaLic =   $request->input('tipo');
            $r = $up->save();
            return $r;
        }
        $validator = Validator::make($request->all(), [
            'tipo' => 'required',
            'data' => 'required',
            'areas' => 'required',
            'pcp_fechaVencimiento' => 'required|date',
            'pcp_factura' => 'required',
        ]);

        if ($validator->fails()) {
            return false;
        }

        $tipo = $request->input('tipo');
        $data = $request->input('data');
        $AreasCP = $request->input('areas');

        $up = Empleados::find($request->input('id'));
        $up->CategoriaLic =   ($tipo == 'N') ? null : $tipo;
        $up->data_vehi_aut =   ($tipo == 'N') ? null : serialize($data);
        $up->AreasCP =   ($tipo == 'N') ? null : $AreasCP;
        $up->FechaVencCP =  ($tipo == 'N') ? null : Carbon::parse($request->input('pcp_fechaVencimiento'))->format('Y-d-m');
        // $up->FechaVencCP = Carbon::parse($request->input('pcp_fechaVencimiento'))->format('Y-m-d');
        // $up->AreasCP = $request->input('pcp_factura');
        $r = $up->save();
        return $r;
    }
}
