<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Brother;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pacientes = Brother::all();
        $men = $woman = 0;
        $age10 = $age20 = $age30 = $age40 = $age50 = $age60 = $age60plus = 0;
        foreach($pacientes as $patient){
            switch($patient->sexo){
                case 'Masculino': $men++; break;
                case 'Femenino': $woman++; break;
                case 'No seleccionado': break;
            }
            $age = new Date($patient->birth);
            $patient->age = $age->diffInYears();
            if($patient->age<=10){      $age10++;}
            elseif($patient->age<=20){  $age20++;}
            elseif($patient->age<=30){  $age30++;}
            elseif($patient->age<=40){  $age40++;}
            elseif($patient->age<=50){  $age50++;}
            elseif($patient->age<=60){  $age60++;}
            elseif($patient->age>60){   $age60plus++;}

        }
        $sexo = array( 'hombre' => $men, 'mujer' => $woman );
        $edad = array( 'age10' => $age10, 'age20' => $age20, 'age30' => $age30, 'age40' => $age40, 'age50' => $age50, 'age60' => $age60, 'age60plus' => $age60plus);

        return view('adminlte::stats.index')->with('sexo',$sexo)->with('edad',$edad);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function tree()
    {
        $hoy = new Date();//::format('Y-m-d H:i:s');
		$year = $hoy->format('Y');
		$month = $hoy->format('m');
		$day = $hoy->format('d');
        
        $user = Auth::user();

        if($user->hasRole(['medico']) ){
            $calendars = Calendar::where('medic_id', $user->id)
            ->whereYear('start','=', $year)
            ->whereMonth('start','=',$month)
            ->whereDay('start','<=',$day)// cambiar por $day
            ->get();
        }
        else{
            $calendars = Calendar::where('team_id', $user->team_id)
            ->whereYear('start','=', $year)
            ->whereMonth('start','=',$month)
            ->whereDay('start','<=',$day)// cambiar por $day
            ->get();
        }
        //return $day;
        $cancel = $fin = $asiste = $preciocancel = $preciofin = $precioasiste = 0;
        
        if($calendars->count() == 0 || empty($calendars)) {
            
            $suma = $asiste + $cancel + $fin;
            $pcancel = $cancel/1*100;
            $pfin = $fin/1*100;
            $pasiste = $asiste/1*100;
            $psuma = $pcancel +$pfin + $pasiste; 
        }
        else{ 
            
            foreach($calendars as $calendar){
                
                switch($calendar->status){
                    case 0: $asiste++; $precioasiste = $precioasiste + $calendar->medic->precio_consulta; break;
                    case 1: $fin++; $preciofin = $preciofin + $calendar->medic->precio_consulta; break;
                    case 2: $cancel++; $preciocancel = $preciocancel + $calendar->medic->precio_consulta; break;
                    default: break;
                }
                
            }
            
        $suma = $asiste + $cancel + $fin;
        $pcancel = $cancel/$suma*100;
        $pfin = $fin/$suma*100;
        $pasiste = $asiste/$suma*100;
        $psuma = $pcancel +$pfin + $pasiste; 
        
        }
        $preciosuma = $preciocancel + $preciofin + $precioasiste;


        $valor = array('cancel' => $preciocancel, 'fin' => $preciofin, 'asiste' => $precioasiste, 'suma' => $preciosuma);
        $porsentaje = array('cancel' => $pcancel, 'fin' => $pfin, 'asiste' => $pasiste, 'suma' => $psuma);
        $status = array( 'cancel' => $cancel, 'fin' => $fin, 'asiste' => $asiste, 'suma' => $suma );


        if($user->hasRole(['secretaria']) ){

            return view('adminlte::stats.tree')
                    ->with('status', $status)
                    ->with('porsentaje', $porsentaje)
                    ->with('valor', $valor)
                    ->with('mes',$hoy->format('F'));
        }
        elseif($user->hasRole(['medico']) ){

            $team = Team::where('id', $user->team_id)->first();
            if($team->type == 'Consulta'){
                // lista todos los secretarias
                $secreList = User::with('roles')->whereHas('roles', function($query){
                    $query->where('name','=','secretaria');
                })->where('team_id', $user->team_id)->orderBy('name','asc')->get();

                foreach($secreList as $secre){
                    $mcancel = $mfin = $masiste = 0;
                    $pmcancel = $pmfin = $pmasiste = 0;
                    foreach($calendars as $calendar){        
                        if($calendar->user_id == $secre->id) {
                            switch($calendar->status){
                                case 0: $masiste++; $pmasiste = $pmasiste + $calendar->medic->precio_consulta; break;
                                case 1: $mfin++; $pmfin = $pmfin + $calendar->medic->precio_consulta; break;
                                case 2: $mcancel++; $pmcancel = $pmcancel + $calendar->medic->precio_consulta; break;
                                default: break;
                            }
                        } 
                    }
                    $msuma = $mcancel + $mfin + $masiste;
                    $pmsuma = $pmcancel + $pmfin + $pmasiste;
                    $consultas[$secre->id] = array('cancel' => $mcancel, 'fin' => $mfin, 'asiste' => $masiste, 'suma' => $msuma);
                    $precio[$secre->id] = array('cancel' => $pmcancel, 'fin' => $pmfin, 'asiste' => $pmasiste, 'suma' => $pmsuma);
                }
                
                return view('adminlte::stats.tree')
                        ->with('status', $status)
                        ->with('porsentaje', $porsentaje)
                        ->with('valor', $valor)
                        ->with('mes',$hoy->format('F'))
                        ->with('secreList',$secreList)
                        ->with('consultas',$consultas)
                        ->with('precio',$precio)
                        ->with('flag', true);
            }
            else{
                $flag = false;
                return view('adminlte::stats.tree')
                        ->with('status', $status)
                        ->with('porsentaje', $porsentaje)
                        ->with('valor', $valor)
                        ->with('mes',$hoy->format('F'))
                        ->with('flag', $flag);
            }
        }
        else{
            // lista todos los médicos
            $medicList = User::with('roles')->whereHas('roles', function($query){
                               $query->where('name','=','medico');
                           })->where('team_id', $user->team_id)->orderBy('name','asc')->get();
            //return $medicList->count();

            foreach($medicList as $medic){
                $mcancel = $mfin = $masiste = 0;
                $pmcancel = $pmfin = $pmasiste = 0;
                foreach($calendars as $calendar){
                    if($calendar->medic_id == $medic->id) {            
                        switch($calendar->status){
                            case 0: $masiste++; $pmasiste = $pmasiste + $calendar->medic->precio_consulta; break;
                            case 1: $mfin++; $pmfin = $pmfin + $calendar->medic->precio_consulta; break;
                            case 2: $mcancel++; $pmcancel = $pmcancel + $calendar->medic->precio_consulta; break;
                            default: break;
                        }
                    } 
                }
                $msuma = $mcancel + $mfin + $masiste;
                $pmsuma = $pmcancel + $pmfin + $pmasiste;
                $medicos[$medic->id] = array('cancel' => $mcancel, 'fin' => $mfin, 'asiste' => $masiste, 'suma' => $msuma);
                $pmedicos[$medic->id] = array('cancel' => $pmcancel, 'fin' => $pmfin, 'asiste' => $pmasiste, 'suma' => $pmsuma);
            }

            return view('adminlte::stats.tree')
                   ->with('status', $status)
                   ->with('porsentaje', $porsentaje)
                   ->with('valor', $valor)
                   ->with('mes',$hoy->format('F'))
                   ->with('medicList', $medicList)
                   ->with('medicos',$medicos)
                   ->with('pmedicos',$pmedicos);
        }
    }

    //public function cancel(){

    public function cancel(CancelDataTable $dataTable)
    {
        return $dataTable->render('adminlte::stats.cancel');
    }



}
