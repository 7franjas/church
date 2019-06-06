<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\AreaDataTable;
use App\Area;
use App\Subarea;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AreaDataTable $dataTable)
    {
        return $dataTable->render('adminlte::area.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::area.create');
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
            'area' => 'required|max:255'
        ];
        $this->validate($request, $rules);


        # save user data
        $area = new Area;
        $area->area = $request->area;
        $area->description = $request->description;
        $area->observation = $request->observation;

        if($area->save()){     

            $alert = array(
                'message' => 'Se ha creado el area '.$area->area, 
                'alert-type' => 'success'
            );
            return redirect()->route('area.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al crear el area', 
                'alert-type' => 'warning'
            );
            return redirect()->route('area.create')->with($alert);
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
        $area = Area::where('id', $id)->first();
        $subarea = Subarea::where('area_id',$id)->get();

        if($area){
            return view('adminlte::area.show')
                    ->withArea($area)
                    ->withSubarea($subarea);

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
        $area = Area::where('id', $id)->first();

        if($area){
            return view('adminlte::area.edit')
                    ->withArea($area);
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
            'area' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        $area = Area::findOrFail($id);
        $area->area = $request->area;
        $area->description = $request->description;
        $area->observation = $request->observation;

        if($area->save()){     

            $alert = array(
                'message' => 'Se ha actualizado el area '.$area->area, 
                'alert-type' => 'success'
            );
            return redirect()->route('area.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al actualizar el area', 
                'alert-type' => 'warning'
            );
            return redirect()->route('area.edit')->with($alert);
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
        $area = Area::where('id', $request->id)->first();        
        $area->delete();

        return response()->json(['success' => 'ok', 'area' => $area->area]);
    }
}
