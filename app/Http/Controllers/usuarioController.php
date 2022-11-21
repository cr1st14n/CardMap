<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class usuarioController extends Controller
{
    public function view_1()
    {
        $u = User::get();
        return view('Usuarios.view_1')->with('users', $u);
    }
    public function create_user(Request $request)
    {
        // return $request;
        // $new = new User();
        // $new->Nombre = $request->input('usu_nombre');
        // $new->CodUsr = $request->input('usu_cod');
        // $new->Password = bcrypt($request->input('usu_pass'));
        // $new->Aeropuerto = $request->input('usu_aero');
        // $res = $new->save();

        return User::create([
            'Nombre' => $request->input('usu_nombre'),
            'CodUsr' => $request->input('usu_cod'),
            'Password' => bcrypt($request->input('usu_pass')),
            'Aeropuerto' => $request->input('usu_aero'),
            'nivel' => $request->input('usu_privilegio'),
        ]);


        // return $res;
    }
    public function query_list()
    {
        return User::get();
    }
    public function query_destroyUser(Request $request)
    {
        return User::where('id', $request->input('id'))->delete();
    }
}
