<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        // return $request;
        session()->forget('aero');
        $request->session()->get('aero');

        $u = User::where('codusr', $request->input('codusr'))->where('aeropuerto',$request->input('aeropuerto'))->first();
        if ($u == null) {
            return 0;
        }
        $credenciales = request()->only('codusr', 'password', 'aeropuerto');
        $credenciales = request()->only('codusr', 'password');
        if ($u['aeropuerto'] == 'LPB') {
        }
        if (Auth::attempt($credenciales)) {
            session(['aero' => $request->input('aeropuerto')]);
            return 'success';
        } else {
            return '1';
        }
        return 'fail';
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
