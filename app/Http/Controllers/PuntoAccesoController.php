<?php

namespace App\Http\Controllers;

use App\Models\puntoAcceso;
use App\Http\Requests\StorepuntoAccesoRequest;
use App\Http\Requests\UpdatepuntoAccesoRequest;

class PuntoAccesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepuntoAccesoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepuntoAccesoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\puntoAcceso  $puntoAcceso
     * @return \Illuminate\Http\Response
     */
    public function show(puntoAcceso $puntoAcceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\puntoAcceso  $puntoAcceso
     * @return \Illuminate\Http\Response
     */
    public function edit(puntoAcceso $puntoAcceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepuntoAccesoRequest  $request
     * @param  \App\Models\puntoAcceso  $puntoAcceso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepuntoAccesoRequest $request, puntoAcceso $puntoAcceso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\puntoAcceso  $puntoAcceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(puntoAcceso $puntoAcceso)
    {
        //
    }
}
