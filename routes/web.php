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

Route::get('/excel','ExcelController@index');
Route::get('/home','HomeController@index');

Route::get('home/avance','HomeController@avance_supervision');
Route::get('home/estado','HomeController@avance_estado');
Route::get('home/captura','HomeController@avance_captura');
