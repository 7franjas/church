<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Family;
use App\Area;
use App\Subarea;
use App\Brother;

class AjaxController extends Controller
{
    //

	/**
	 *	Set user avatar
	 *  @param   $request
	 *  @return  json
	 */
    public function profile_avatar(Request $request){
        $data = $request->image;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $image_name= time().'.png';
        $path = public_path() . "/img/avatar/" . $image_name;

        file_put_contents($path, $data);

        $user = Auth::user();
        $user->avatar = $image_name;
        $user->save();

        return response()->json(['success' => 'ok']);
    }
    
    /**
     * Get datatable language es
     * @return json
     */
    public function datatable_lang(){

    	$language = array(
			
			"sProcessing"=>     "Procesando...",
			"sLengthMenu"=>     "Mostrar _MENU_ registros",
			"sZeroRecords"=>    "No se encontraron resultados",
			"sEmptyTable"=>     "Ningún dato disponible en esta tabla",
			"sInfo"=>           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty"=>      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered"=>   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix"=>    "",
			"sSearch"=>         "Buscar:",
			"sUrl"=>            "",
			"sInfoThousands"=>  ",",
			"sLoadingRecords"=> "Cargando...",
			"oPaginate" => [
				"sFirst"=>    "Primero",
				"sLast"=>     "Último",
				"sNext"=>     "Siguiente",
				"sPrevious"=> "Anterior"
			],
			"oAria" => [
				"sSortAscending"=>  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending"=> ": Activar para ordenar la columna de manera descendente"
			],
			"buttons" => [
                "create" => "Crear",
                "export" => "Exportar",
                "print" => "Imprimir",
                "reset" => "Reiniciar",
                "reload" => "Recargar"
			]

		);

        return response()->json($language);

		}
		


	public function autoCompleteFamily(Request $request) {

		$query = $request->get('term','');
		$user = Auth::user();

		$role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
		# get global role for name ASC and order ASC
		if(count($user->roles)==1){
			$role_priority = $user->roles[0];
		}else{
				foreach ($user->roles as $key => $role) {
						if($key === 0){
								$temp = $role;
						}else{
								if($temp->order <= $role->order){
										$role_priority = $temp;
								}else{
										$role_priority = $role;
										$temp = $role;
								}
						}

				}
		}
		// set user for user
		$familys=Family::where('name','LIKE','%'.$query.'%')->get();

		$data=array();
		foreach ($familys as $family) {
			$data[]=array('value'=>$family->fam_name,
							'id'=>$family->id, 
							'observation' => $family->fam_observation);
		}
		if(count($data)) return $data;
		else return ['value'=>'error'];

	}

	public function autoCompleteArea(Request $request) {

		$query = $request->get('term','');
		$user = Auth::user();

		$role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
		# get global role for name ASC and order ASC
		if(count($user->roles)==1){
			$role_priority = $user->roles[0];
		}else{
				foreach ($user->roles as $key => $role) {
						if($key === 0){
								$temp = $role;
						}else{
								if($temp->order <= $role->order){
										$role_priority = $temp;
								}else{
										$role_priority = $role;
										$temp = $role;
								}
						}

				}
		}
		// set user for user
		$areas=Area::where('area','LIKE','%'.$query.'%')->get();

		$data=array();
		foreach ($areas as $area) {
			$data[]=array('value'=>$area->area,
							'id'=>$area->id, 
							'description' => $area->description);
		}
		if(count($data)) return $data;
		else return ['value'=>'error'];

	}


	public function autoCompleteSubarea(Request $request) {

		$query = $request->get('term','');
		$user = Auth::user();

		$role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
		# get global role for name ASC and order ASC
		if(count($user->roles)==1){
			$role_priority = $user->roles[0];
		}else{
				foreach ($user->roles as $key => $role) {
						if($key === 0){
								$temp = $role;
						}else{
								if($temp->order <= $role->order){
										$role_priority = $temp;
								}else{
										$role_priority = $role;
										$temp = $role;
								}
						}

				}
		}
		// set user for user
		$subareas=Subarea::where('subarea','LIKE','%'.$query.'%')->where('area_id',$request->area_id)->get();

		$data=array();
		foreach ($subareas as $subarea) {
			$data[]=array('value'=>$subarea->subarea,
							'id'=>$subarea->id, 
							'description' => $subarea->description);
		}
		if(count($data)) return $data;
		if(empty($request->area_id)) return ['value'=>'error_area'];
		else return ['value'=>'error'];

	}


	public function autoCompleteBrother(Request $request) {

		$query = $request->get('term','');
		$user = Auth::user();

		$role_priority = (object) array('name'=>'invitado','display_name'=>'Invitado');
		# get global role for name ASC and order ASC
		if(count($user->roles)==1){
			$role_priority = $user->roles[0];
		}else{
				foreach ($user->roles as $key => $role) {
						if($key === 0){
								$temp = $role;
						}else{
								if($temp->order <= $role->order){
										$role_priority = $temp;
								}else{
										$role_priority = $role;
										$temp = $role;
								}
						}

				}
		}
		// set user for user
		$brothers=Brother::where('name','LIKE','%'.$query.'%')->get();

		$data=array();
		foreach ($brothers as $brother) {
			$data[]=array('value'=>$brother->name,
							'id'=>$brother->id);
		}
		if(count($data)) return $data;
		else return ['value'=>'error'];

	}
	
}
