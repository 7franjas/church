<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get ('/test','HomeController@test');

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

	/**
	 * Users Route
	 */
    Route::resource('/users','UserController');	// Display Users CRUD

    /**
	 * Profile Route
	 */
    Route::get('/profile','UserController@profile')->name('profile'); // Display Profile
		Route::put('/updateprofile/{id}','UserController@updateprofile')->name('updateprofile'); // Display Update Profile
    
	/**
	 * Brothers Route
	 */
		Route::resource('/brothers','BrotherController')->middleware('role:superadministrador');	// Display Users CRUD
	

	/**
	 * Familys Route
	 */
    Route::resource('/familys','FamilyController')->middleware('role:superadministrador');	// Display Users CRUD

	/**
	 * 
	 */
		Route::resource('/area','AreaController')->middleware('role:superadministrador');	// Display Users CRUD		
		Route::resource('/subarea','SubareaController')->middleware('role:superadministrador');	// Display Users CRUD		
		
	/**
	 * Ingresos Route
	 */
		Route::resource('/diezmos','DiezmoController')->middleware('role:superadministrador');	// Display Users CRUD
		Route::resource('/ofrendas','OfrendaController')->middleware('role:superadministrador');	// Display Users CRUD
		Route::resource('/ingarea','IngareaController')->middleware('role:superadministrador');	// Display Users CRUD
	
		/**
	 * Egresos
	 */
		Route::resource('/egresos','EgresoController')->middleware('role:superadministrador');	// Display Users CRUD

	/**
	 * Reportes
	 */
	Route::resource('/stats','StatsController')->middleware('role:superadministrador');	// Display Users CRUD
	

	/**
	 * Ajax Route
	 */
		Route::get('/datatable_lang','AjaxController@datatable_lang')->name('ajax.datatable_lang'); // Get Datatable Language (español)
		Route::post('/avatar','AjaxController@profile_avatar')->name('ajax.avatar'); // Save avatar ajax


	/**
	 * Ajax Route
	 */
		Route::prefix('ajax')->middleware('role:superadministrador')->group(function(){
			Route::get('/autocomplete/family','AjaxController@autoCompleteFamily')->name('ajax.autocomplete.family'); // Get live autocomplete for patients
			Route::get('/autocomplete/area','AjaxController@autoCompleteArea')->name('ajax.autocomplete.area'); // Get live autocomplete for area
			Route::get('/autocomplete/subarea','AjaxController@autoCompleteSubarea')->name('ajax.autocomplete.subarea'); // Get live autocomplete for subarea
			Route::get('/autocomplete/brother','AjaxController@autoCompleteBrother')->name('ajax.autocomplete.brother'); // Get live autocomplete for subarea
	});

	
});
