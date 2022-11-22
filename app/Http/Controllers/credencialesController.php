<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use App\Models\Empresas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Isset_;

class credencialesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function view_1()
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
        $em = Empleados::where('aeropuerto', $aero)
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
        $empresas = Empresas::get();
        return view('credenciales.view_1')->with('Empr', $empresas)->with('e', $em);
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

        $new->Vencimiento = $retVal = ($request->input('nc_fv') == '') ? null :   Carbon::parse($request->input('nc_fv'))->format('Y-d-m H:i:s');
        $new->Fecha = $retVal = ($request->input('nc_f_in') == '') ? null :   Carbon::parse($request->input('nc_f_in'))->format('Y-d-m H:i:s');
        $new->FechaNac = $retVal = ($request->input('nc_FNac') == '') ? null :    Carbon::parse($request->input('nc_FNac'))->format('Y-d-m H:i:s');

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
            'CI',
            'urlphoto',
            'AreasAut',
            'AreasCP',
            'Cargo',
            'CI',
            'Vencimiento',
            'Herramientas',
            'NroRenovacion',
            'Empresa',
            'aeropuerto',
            'Aeropuerto_2',
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
            // Entonces corta la cadena y ponle el sufijo
            $empr = substr($empr, 0, 18) . '...';
        }
        $fe = Carbon::parse($data['Vencimiento']);
        $dfecha = $fe->format('d');
        $mfecha = $fe->format('m');
        $afecha = $fe->format('Y');
        $meses = ['01' => 'ENE', '02' => 'FEB', '03' => 'MAR', '04' => 'ABR', '05' => 'MAY', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SEP', '10' => 'OCT', '11' => 'NOV', '12' => 'DIC'];
        // return view('credenciales.pdf_creden_emp_a');
        $rutaimgL = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/LAPAZAMVERSO.jpg',
            'CIJ' => 'resources/plantilla/CREDENCIALESFOTOS/LAPAZAMVERSO1.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/COCHABAMBA2022.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/SANTACRUZAMVERSO.jpg',
        ];
        $rutaimgT = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/TEMPORALLP.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/TEMPORALCBB.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/TEMPORALVVI.jpg',
        ];
        $rutaimgLC = [
            'LPB' => 'resources/plantilla/CREDENCIALESFOTOS/CONDUCCION-PLATAFORMA-LP.jpg',
            'CIJ' => 'resources/plantilla/CREDENCIALESFOTOS/LPB-CIJ-LC.jpg',
            'CBB' => 'resources/plantilla/CREDENCIALESFOTOS/CONDUCCION-PLATAFORMA-CBB.jpg',
            'VVI' => 'resources/plantilla/CREDENCIALESFOTOS/CONDUCCION-PLATAFORMA-VVI.jpg',
        ];

        switch ($data['Tipo']) {
            case 'N':
                $pdf = pdf::loadView(
                    'credenciales.pdf_creden_emp_T1',
                    [
                        'data' => $data,
                        'em' => $empr,
                        'M' => $meses[$mfecha],
                        'Y' => $afecha = $fe->format('Y'),
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
                        'Y' => $afecha = $fe->format('Y'),
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
                        'M' => $meses[$mfecha],
                        'Y' => $afecha = $fe->format('Y'),
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
            if ($data->data_vehi_aut == null && $tipo == 2) {
                return;
            }
            $data->data_vehi_aut = unserialize($data->data_vehi_aut);

            $q = str_replace(',', '', $data->data_vehi_aut['list']);
            $q = str_replace('1', 'X', $q);
            $q = str_replace('0', '.', $q);
            $pdf = pdf::loadView(
                'credenciales.pdf_creden_emp_lc',
                [
                    'lic_1' => $data->data_vehi_aut['tipo'],
                    'lic_2' => $q,
                    'data' => $data,
                    'em' => $empr,
                    'M' => $meses[$mfecha],
                    'Y' => $afecha = $fe->format('Y'),
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
        return Empleados::where('idEmpleado', $request->input('id'))->value('data_vehi_aut');
        if (Empleados::where('idEmpleado', $request->input('id'))->select('data_vehi_aut')->first() == '') {
            return false;
        }
        return true;
    }

    public function query_destroy_credencial(Request $request)
    {
        return Empleados::where('idEmpleado', $request->input('id'))->delete();
    }

    public function query_edit_emp(Request $request)
    {
        $emp = Empleados::where('idEmpleado', $request->input('id'))->first();
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
                'Empresa' => $request->input('nc_em_edit'),
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
        $em = Empleados::where('aeropuerto', $aero)->where(function ($query) use ($r) {
            $query->where('Empleados.Nombre', 'like', '%' . $r . '%')
                ->orwhere('Empleados.Paterno', 'like', '%' . $r . '%')
                ->orwhere('Empleados.Materno', 'like', '%' . $r . '%')
                ->orwhere('Empleados.CI', 'like', '%' . $r . '%');
        })
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
                'Empresas.NombEmpresa'
            )
            ->orderBy('codigo', 'asc')
            ->limit(100)
            ->get();
        return $em;
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
        // return $d;

        // return Empleados::where('idEmpleado', $request->input('id'))->update(['NroRenovacion' => intval(Empleados::where('idEmpleado', $request->input('id'))->value('NroRenovacion')) + 1]);
    }
}
