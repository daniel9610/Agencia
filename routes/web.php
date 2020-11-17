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
    return redirect('/login');
});

Auth::routes();

Route::post('login', [
    'as' => '',
    'uses' => 'Auth\LoginController@login'
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('google', function () {
    return view('googleAuth');
});

Route::get('splash', function () {
    return view('splashs.splash_login');
});

// google oauth 
Route::get('auth/google', 'Auth\LoginController@redirectToGoogle')->name('google');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');


Route::middleware('auth')->group(function(){
    Route::resource('campanias', 'CampaniaController');
    Route::get('cliente', 'ClienteController@index');

    // Etapas
    Route::get('campaniaetapas/{campania_id}/', 'CampaniaEtapaController@indexCampaniaEtapas')->name('campania_etapas');
    Route::get('campaniaetapas/{campania_id}/{etapa_id}/generar-brief', 'CampaniaController@vistaSubirBrief');
    Route::get('campaniaetapas/{campania_id}/{etapa_id}/kickoff', 'CampaniaController@vistaKickoff');
    Route::get('campaniaetapas/{campania_id}/{etapa_id}/generar-investigacion-brief', 'CampaniaController@vistaGenerarInvestigacionBrief');
    Route::get('campaniaetapas/{campania_id}/{etapa_id}/generar-alinear-estrategia', 'CampaniaController@vistaGenerarAlinearEstrategia');
    Route::get('campaniaetapas/{campania_id}/{etapa_id}/generar-creatividad', 'CampaniaController@vistaGenerarCreatividad');
    Route::get('campaniaetapas/{campania_id}/{etapa_id}/planear-ejecucion', 'CampaniaController@vistaPlanearEjecucion');
    Route::resource('actividades', 'ActividadController');

    Route::get('agregarcampaniaetapa/{campania_id}/{etapa_id}/{estado_id}', 'CampaniaEtapaController@agregarCampaniaEtapa')->name('agregarcampaniaetapa')->middleware('permission:campanias.create');;
    Route::get('eliminarcampaniaetapa/{campania_id}/{etapa_id}', 'CampaniaEtapaController@eliminarCampaniaEtapa')->name('eliminarcampaniaetapa')->middleware('permission:campanias.create');;

    //Roles
    Route::get('asignacionroles', 'RolController@vistaRoles')->middleware('role:Director');
    Route::post('asignar_rol', 'RolController@asignarRoles')->name('asignar_rol')->middleware('role:Director');

    // google drive
    Route::post('subirArchivo/{campania_id}', 'BriefController@subirArchivo')->name('subirArchivo');
    Route::get('actualizarestadobrief/{campania_id}/{estado_id}', 'BriefController@actualizarEstado')->name('actualizar_estado_brief');
    Route::post('crearcarpetadrive', 'CampaniaController@store')->name('subir_folder')->middleware('permission:campanias.create');
    
    // google calendar
    Route::post('kickoff', 'KickoffController@programarKickOff')->name('crear_reunion');

    Route::get('creartablero/{campania_id}', 'TableroController@index')->name('creartablero')->middleware('permission:campanias.create');
    Route::post('guardarActividad', 'ActividadController@storeActividad')->middleware('permission:campanias.create');
    Route::post('actualizarActividad/{id}', 'ActividadController@updateActividad')->middleware('permission:campanias.create');

    Route::get('gantt', 'GanttController@index')->name('gantt.index');
});
