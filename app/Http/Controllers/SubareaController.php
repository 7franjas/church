<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\SubareaDataTable;
use App\Subarea;

class SubareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubareaDataTable $dataTable)
    {
        return $dataTable->render('adminlte::subarea.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::subarea.create');
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
            'subarea' => 'required|max:255',
            'area' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        //return $request;
        # save user data
        $subarea = new Subarea;
        $subarea->subarea = $request->subarea;
        $subarea->area_id = $request->area_id;
        $subarea->description = $request->description;
        $subarea->observation = $request->observation;

        if($subarea->save()){     

            $alert = array(
                'message' => 'Se ha creado la subarea '.$subarea->subarea, 
                'alert-type' => 'success'
            );
            return redirect()->route('subarea.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al crear la subarea', 
                'alert-type' => 'warning'
            );
            return redirect()->route('subarea.create')->with($alert);
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
        $subarea = Subarea::where('id', $id)->first();

        if($subarea){
            return view('adminlte::subarea.show')
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
        $subarea = Subarea::where('id', $id)->first();

        if($subarea){
            return view('adminlte::subarea.edit')
                    ->withSubarea($subarea);
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
            'subarea' => 'required|max:255',
            'area' => 'required|max:255'
        ];
        $this->validate($request, $rules);
//return $request;
        $subarea = Subarea::findOrFail($id);
        $subarea->subarea = $request->subarea;
        $subarea->area_id = $request->area_id;
        $subarea->description = $request->description;
        $subarea->observation = $request->observation;

        if($subarea->save()){     

            $alert = array(
                'message' => 'Se ha actualizado la subarea '.$subarea->subarea, 
                'alert-type' => 'success'
            );
            return redirect()->route('subarea.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al actualizar la subarea', 
                'alert-type' => 'warning'
            );
            return redirect()->route('subarea.edit')->with($alert);
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
        $subarea = Subarea::where('id', $request->id)->first();        
        $subarea->delete();

        return response()->json(['success' => 'ok', 'subarea' => $subarea->subarea]);
    }
}
