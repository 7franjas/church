<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\IngareaDataTable;
use App\Ingreso;
use Jenssegers\Date\Date;

class IngareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IngareaDataTable $dataTable)
    {
        return $dataTable->render('adminlte::ingarea.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::ingarea.create');
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
            'area_name' => 'required|max:255',
            'brother_name' => 'required|max:255',
            'monto' => 'required|max:255',
            'type' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $ingreso = new Ingreso;
        $ingreso->typeIng = 3;
        $ingreso->area_id = $request->area_id;
        $ingreso->brother_id = $request->brother_id;
        $ingreso->monto = $request->monto;
        $ingreso->type = $request->type;
        $ingreso->date = $request->date;
        $ingreso->observation = $request->observation;

        if($ingreso->save()){     

            $alert = array(
                'message' => 'Se ha guardado el ingreso '.$ingreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('ingarea.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al guardar el ingreso', 
                'alert-type' => 'warning'
            );
            return redirect()->route('ingarea.create')->with($alert);
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
        $ingarea = Ingreso::where('id', $id)->first();

        if($ingarea){
            $date =  ucfirst(Date::parse($ingarea->date)->format('d \d\e ')); 
            $date .=  ucfirst(Date::parse($ingarea->date)->format('F, Y')); 
            return view('adminlte::ingarea.show')
                    ->withIngarea($ingarea)
                    ->withDate($date);

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
        $ingarea = Ingreso::where('id', $id)->first();

        if($ingarea){
            return view('adminlte::ingarea.edit')
                    ->withIngarea($ingarea);

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
            'area_name' => 'required|max:255',
            'brother_name' => 'required|max:255',
            'monto' => 'required|max:255',
            'type' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->area_id = $request->area_id;
        $ingreso->brother_id = $request->brother_id;
        $ingreso->monto = $request->monto;
        $ingreso->type = $request->type;
        $ingreso->date = $request->date;
        $ingreso->observation = $request->observation;

        if($ingreso->save()){     

            $alert = array(
                'message' => 'Se ha modificado el ingreso '.$ingreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('ingarea.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al modificar el ingreso', 
                'alert-type' => 'warning'
            );
            return redirect()->route('ingarea.index')->with($alert);
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
        $ingreso = Ingreso::where('id', $request->id)->first();        
        $ingreso->delete();

        return response()->json(['success' => 'ok', 'name' => $request->id]);
        //
    }
}
