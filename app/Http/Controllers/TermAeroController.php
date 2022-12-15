<?php

namespace App\Http\Controllers;

use App\Models\termAero;
use App\Http\Requests\StoretermAeroRequest;
use App\Http\Requests\UpdatetermAeroRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermAeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('terminal.termAerHome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function query_list_1()
    {
        return termAero::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretermAeroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function query_create_1(Request $request)
    {
        $valida = $request->validate([
            't_nombre' => 'required|numeric',
            't_abr' => 'required',
            't_regdep' => 'required',
        ]);
        if ($valida==true) {
            return true;
        }
        return false;
        $nt = new termAero();
        $nt->ta_nombre = $request->input('t_nombre');
        $nt->ta_sigla = $request->input('t_abr');
        $nt->ta_depen_cod = $request->input('t_regdep');
        $nt->tipo = 'create';
        $nt->estado = 1;
        $nt->codUsu = Auth::user()->idEmpleado;
        return $res = $nt->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\termAero  $termAero
     * @return \Illuminate\Http\Response
     */
    public function show(termAero $termAero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\termAero  $termAero
     * @return \Illuminate\Http\Response
     */
    public function edit(termAero $termAero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetermAeroRequest  $request
     * @param  \App\Models\termAero  $termAero
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatetermAeroRequest $request, termAero $termAero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\termAero  $termAero
     * @return \Illuminate\Http\Response
     */
    public function destroy(termAero $termAero)
    {
        //
    }
}
