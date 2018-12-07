<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
