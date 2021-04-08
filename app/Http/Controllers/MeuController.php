<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MinhaModel;

class MeuController extends Controller
{    
    public function index(){
        $consulta = MinhaModel::all();
        return view('minhaView', compact('consulta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('criarView');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $consulta = new minhaModel;
        $consulta->name = $request->name;
        $consulta->description = $request->description;
        $consulta->save();
        return redirect()->route('rota.index')->with('message', 'Dados enviados para o sistema');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consulta = minhaModel::FindOrFail($id);
        return view('editarView', compact('consulta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $consulta = minhaModel::FindOrFail($id);
        $consulta->name = $request->name;
        $consulta->description = $request->description;
        $consulta->save();
        return redirect()->route('rota.index')->with('message', 'Dados enviados para o sistema');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consulta = minhaModel::FindOrFail($id);
        $consulta->delete();
        return redirect()->route('rota.index')->with('message', 'Dados enviados para o sistema');
    }
}
