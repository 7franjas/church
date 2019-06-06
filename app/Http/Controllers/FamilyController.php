<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\FamilyDataTable;
use App\Family;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(FamilyDataTable $dataTable)
    {
        return $dataTable->render('adminlte::familys.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::familys.create');
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
            'fam_name' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $family = new Family;
        $family->fam_name = $request->fam_name;
        $family->fam_observation = $request->fam_observation;

        if($family->save()){     

            $alert = array(
                'message' => 'Se ha creado la familia '.$family->fam_name, 
                'alert-type' => 'success'
            );
            return redirect()->route('familys.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al crear la familia', 
                'alert-type' => 'warning'
            );
            return redirect()->route('familys.create')->with($alert);
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
        $family = Family::where('id', $id)->first();

        if($family){
            return view('adminlte::familys.show')
                    ->withFamily($family);
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
        $family = Family::where('id', $id)->first();

        if($family){
            return view('adminlte::familys.edit')
                    ->withFamily($family);
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
            'fam_name' => 'required|max:255'
        ];
        $this->validate($request, $rules);

        # save user data
        $family = Family::findOrFail($id);;
        $family->fam_name = $request->fam_name;
        $family->fam_observation = $request->fam_observation;

        if($family->save()){     

            $alert = array(
                'message' => 'Se ha modificado la familia '.$family->fam_name, 
                'alert-type' => 'success'
            );
            return redirect()->route('familys.index')->with($alert);
        }else{
            $alert = array(
                'message' => 'Ocurrió un problema al modificar la familia', 
                'alert-type' => 'warning'
            );
            return redirect()->route('familys.edit')->with($alert);
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
        $family = Family::where('id', $request->id)->first();        
        $family->delete();

        return response()->json(['success' => 'ok', 'family' => $family->fam_name]);
    }
}
