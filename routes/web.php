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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('google', function () {
    return view('googleAuth');
});

// google oauth 
Route::get('auth/google', 'Auth\LoginController@redirectToGoogle')->name('google');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');


Route::middleware('auth')->group(function(){
    Route::get('listararchivos', 'GoogleDriveController@getFolders');
    Route::get('subirarchivos', 'GoogleDriveController@uploadFiles');
    Route::post('subirarchivos', 'GoogleDriveController@uploadFiles');

});
// google drive
// Route::get('/drive', 'DriveController@getDrive'); // retreive folders
// Route::get('/drive/upload', 'DriveController@uploadFile'); // File upload form
// Route::post('/drive/upload', 'DriveController@uploadFile'); // Upload file to Drive from Form
// Route::get('/drive/create', 'DriveController@create'); // Upload file to Drive from Storage
// Route::get('/drive/delete/{id}', 'DriveController@deleteFile');