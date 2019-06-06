<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\OfrendaDataTable;
use App\Ingreso;
use Jenssegers\Date\Date;

class OfrendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OfrendaDataTable $dataTable)
    {
        return $dataTable->render('adminlte::ofrendas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::ofrendas.create');
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
            'monto' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $ingreso = new Ingreso;
        $ingreso->typeIng = 2;
        $ingreso->monto = $request->monto;
        $ingreso->date = $request->date;
        $ingreso->observation = $request->observation;

        if($ingreso->save()){     

            $alert = array(
                'message' => 'Se ha guardado la ofrenda '.$ingreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('ofrendas.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al guardar la ofrenda', 
                'alert-type' => 'warning'
            );
            return redirect()->route('ofrendas.create')->with($alert);
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
        $ofrenda = Ingreso::where('id', $id)->first();

        if($ofrenda){
            $date =  ucfirst(Date::parse($ofrenda->date)->format('d \d\e ')); 
            $date .=  ucfirst(Date::parse($ofrenda->date)->format('F, Y')); 
            return view('adminlte::ofrendas.show')
                ->withOfrenda($ofrenda)
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
        $ofrenda = Ingreso::where('id', $id)->first();

        if($ofrenda){
            return view('adminlte::ofrendas.edit')
                    ->withOfrenda($ofrenda);

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
            'monto' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->monto = $request->monto;
        $ingreso->date = $request->date;
        $ingreso->observation = $request->observation;

        if($ingreso->save()){     

            $alert = array(
                'message' => 'Se ha modificado la ofrenda '.$ingreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('ofrendas.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al modificar la ofrenda', 
                'alert-type' => 'warning'
            );
            return redirect()->route('ofrendas.edit', $id)->with($alert);
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

        return response()->json(['success' => 'ok', 'ingreso' => $ingreso->id]);
        //
    }
}
