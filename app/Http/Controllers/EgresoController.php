<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\EgresoDataTable;
use App\Egreso;
use Jenssegers\Date\Date;

class EgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EgresoDataTable $dataTable)
    {
        return $dataTable->render('adminlte::egresos.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::egresos.create');
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
            'area' => 'required|max:255',
            'subarea' => 'required|max:255',
            'brother' => 'required|max:255',
            'monto' => 'required|numeric'
        ];
        $this->validate($request, $rules);
//return $request;

        # save user data
        $egreso = new Egreso;
        $egreso->area_id = $request->area_id;
        $egreso->subarea_id = $request->subarea_id;
        $egreso->brother_id = $request->brother_id;
        $egreso->date = $request->date;
        $egreso->monto = $request->monto;
        $egreso->type = $request->type;
        $egreso->observation = $request->observation;

        if($egreso->save()){     

            $alert = array(
                'message' => 'Se ha creado el egreso Nº'.$egreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('egresos.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al crear el egreso', 
                'alert-type' => 'warning'
            );
            return redirect()->route('egresos.create')->with($alert);
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
        $egreso = Egreso::where('id', $id)->first();

        if($egreso){

            $date =  ucfirst(Date::parse($egreso->date)->format('d \d\e ')); 
            $date .=  ucfirst(Date::parse($egreso->date)->format('F, Y')); 
            return view('adminlte::egresos.show')
                    ->withEgreso($egreso)
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
        $egreso = Egreso::where('id', $id)->first();

        if($egreso){
            return view('adminlte::egresos.edit')
                    ->withEgreso($egreso);
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
            'area' => 'required|max:255',
            'subarea' => 'required|max:255',
            'brother' => 'required|max:255',
            'monto' => 'required|numeric'
        ];
        $this->validate($request, $rules);

        $egreso = Egreso::findOrFail($id);
        $egreso->area_id = $request->area_id;
        $egreso->subarea_id = $request->subarea_id;
        $egreso->brother_id = $request->brother_id;
        $egreso->date = $request->date;
        $egreso->monto = $request->monto;
        $egreso->type = $request->type;
        $egreso->observation = $request->observation;

        if($egreso->save()){     

            $alert = array(
                'message' => 'Se ha modificado el egreso '.$egreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('egresos.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al modificar el egreso '.$egreso->id, 
                'alert-type' => 'warning'
            );
            return redirect()->route('egresos.create')->with($alert);
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
        $egreso = Egreso::where('id', $request->id)->first();        
        $egreso->delete();

        return response()->json(['success' => 'ok', 'egreso' => $egreso->id]);
        //
    }
}
