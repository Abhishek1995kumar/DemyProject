<?php

namespace App\Http\Controllers;

use App\Models\Auther;
use App\Http\Requests\StoreAutherRequest;
use App\Http\Requests\UpdateAutherRequest;

class AutherController extends Controller
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
     * @param  \App\Http\Requests\StoreAutherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAutherRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auther  $auther
     * @return \Illuminate\Http\Response
     */
    public function show(Auther $auther)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auther  $auther
     * @return \Illuminate\Http\Response
     */
    public function edit(Auther $auther)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAutherRequest  $request
     * @param  \App\Models\Auther  $auther
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAutherRequest $request, Auther $auther)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auther  $auther
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auther $auther)
    {
        //
    }
}
