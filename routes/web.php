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
Route::get('/selectall', 'TaskController@selectAll')->name('selectall');
Route::post('/insert', 'TaskController@create')->name('insert');
Route::post('/update', 'TaskController@update')->name('update');
Route::get('/delet/{id}', 'TaskController@delet')->name('delet');