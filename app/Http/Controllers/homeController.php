<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function Index()
    {
        $data=session('aero');
        // return $data;
        switch ($data) {
            case 'LP':
                $region="NAABOL - LA PAZ";
                break;
            case 'CB':
                $region="NAABOL - COCHABAMBA";
                break;
            case 'SC':
                $region="NAABOL - SANTA CRUZ";
                break;
            
            default:
                # code...
                break;
        }
        return view('welcome')->with(['reg'=>$data,'region'=>$region]);
    }
}
