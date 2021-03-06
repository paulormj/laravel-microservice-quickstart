<?php

namespace App\Http\Controllers\Api;

use App\Models\Genero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneroController extends Controller
{
    private  $rules = [
        "name"=>"required | max:255",
        "is_active"=>"boolean"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Genero::all();
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,$this->rules);
        $genero = Genero::create($request->all());
        $genero->refresh();
        return $genero;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genero  $genero
     * @return \Illuminate\Http\Response
     */
    public function show(Genero $genero)
    {
        return $genero;
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genero  $genero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genero $genero)
    {
        
       $this->validate($request,$this->rules);
       $genero->update($request->all());
       return $genero;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genero  $genero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genero $genero)
    {
        $genero->delete($genero);
        return response()->noContent();
    }
}
