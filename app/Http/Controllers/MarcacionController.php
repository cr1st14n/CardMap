<?php

namespace App\Http\Controllers;

use App\Models\marcacion;
use App\Http\Requests\StoremarcacionRequest;
use App\Http\Requests\UpdatemarcacionRequest;

class MarcacionController extends Controller
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
     * @param  \App\Http\Requests\StoremarcacionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoremarcacionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\marcacion  $marcacion
     * @return \Illuminate\Http\Response
     */
    public function show(marcacion $marcacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\marcacion  $marcacion
     * @return \Illuminate\Http\Response
     */
    public function edit(marcacion $marcacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemarcacionRequest  $request
     * @param  \App\Models\marcacion  $marcacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatemarcacionRequest $request, marcacion $marcacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\marcacion  $marcacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(marcacion $marcacion)
    {
        //
    }
}
