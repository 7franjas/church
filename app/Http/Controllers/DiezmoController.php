<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\DiezmoDataTable;
use App\Ingreso;
use Jenssegers\Date\Date;

class DiezmoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DiezmoDataTable $dataTable)
    {
        return $dataTable->render('adminlte::diezmos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::diezmos.create');
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
            'brother_name' => 'required|max:255',
            'brother_id' => 'required|max:255',
            'monto' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $ingreso = new Ingreso;
        $ingreso->typeIng = 1;
        $ingreso->brother_id = $request->brother_id;
        $ingreso->monto = $request->monto;
        $ingreso->date = $request->date;
        $ingreso->observation = $request->observation;

        if($ingreso->save()){     

            $alert = array(
                'message' => 'Se ha guardado el diezmo '.$ingreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('diezmos.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al guardar el diezmo', 
                'alert-type' => 'warning'
            );
            return redirect()->route('diezmos.create')->with($alert);
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
        $diezmo = Ingreso::where('id', $id)->first();

        if($diezmo){
            $date =  ucfirst(Date::parse($diezmo->date)->format('d \d\e ')); 
            $date .=  ucfirst(Date::parse($diezmo->date)->format('F, Y')); 
            return view('adminlte::diezmos.show')
                ->withDiezmo($diezmo)
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
        $diezmo = Ingreso::where('id', $id)->first();

        if($diezmo){
            return view('adminlte::diezmos.edit')
                    ->withDiezmo($diezmo);
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
            'brother_name' => 'required|max:255',
            'brother_id' => 'required|max:255',
            'monto' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->brother_id = $request->brother_id;
        $ingreso->monto = $request->monto;
        $ingreso->date = $request->date;
        $ingreso->observation = $request->observation;

        if($ingreso->save()){     

            $alert = array(
                'message' => 'Se ha modificado el diezmo '.$ingreso->id, 
                'alert-type' => 'success'
            );
            return redirect()->route('diezmos.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al modificar el diezmo', 
                'alert-type' => 'warning'
            );
            return redirect()->route('diezmos.edit', $id)->with($alert);
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
        $diezmo = Ingreso::where('id', $request->id)->first();        
        $diezmo->delete();

        return response()->json(['success' => 'ok', 'diezmo' => $diezmo->id]);
        //
    }
}
