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
	 * Brothera Route
	 */
    Route::resource('/brothers','BrotherController')->middleware('role:superadministrador');	// Display Users CRUD


	/**
	 * Ajax Route
	 */
	Route::get('/datatable_lang','AjaxController@datatable_lang')->name('ajax.datatable_lang'); // Get Datatable Language (español)
	Route::post('/avatar','AjaxController@profile_avatar')->name('ajax.avatar'); // Save avatar ajax
});
