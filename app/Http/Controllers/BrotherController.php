<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\BrotherDataTable;
use App\Role;
use App\Brother;

class BrotherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(BrotherDataTable $dataTable)
    {
        return $dataTable->render('adminlte::brothers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::brothers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255'
        ];
        $this->validate($request, $rules);


        # save user data
        $brother = new Brother;
        $brother->name = $request->name;
        $brother->sexo = $request->sexo;
        $brother->email = $request->email;
        $brother->address = $request->address;
        $brother->birth = $request->birth;
        $brother->phone = $request->phone;
        $brother->celphone = $request->celphone;
        $brother->observation = $request->observation;

        if($brother->save()){     

            $alert = array(
                'message' => 'Se ha creado el hermano '.$brother->name, 
                'alert-type' => 'success'
            );
            return redirect()->route('brothers.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al crear el hermano', 
                'alert-type' => 'warning'
            );
            return redirect()->route('brothers.create')->with($alert);
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brother = Brother::where('id', $id)->first();

        if($brother){
            return view('adminlte::brothers.show')
                    ->withBrother($brother);

        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brother = Brother::where('id', $id)->first();

        if($brother){
            return view('adminlte::brothers.edit')
                    ->withBrother($brother);
        }else{
            abort(404);
        }
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
        $rules = [
            'name' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        $brother = Brother::findOrFail($id);
        $brother->name = $request->name;
        $brother->sexo = $request->sexo;
        $brother->email = $request->email;
        $brother->address = $request->address;
        $brother->birth = $request->birth;
        $brother->phone = $request->phone;
        $brother->celphone = $request->celphone;
        $brother->observation = $request->observation;

        if($brother->save()){     

            $alert = array(
                'message' => 'Se ha actualizado a '.$brother->name, 
                'alert-type' => 'success'
            );
            return redirect()->route('brothers.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al actualizar', 
                'alert-type' => 'warning'
            );
            return redirect()->route('brothers.create')->with($alert);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $brother = Brother::where('id', $request->id)->first();        
        $brother->delete();

        return response()->json(['success' => 'ok', 'brother' => $brother->name]);
    }
}
