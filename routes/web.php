<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/projects', 'ProjectController@index')->name('projects.index'); 

Route::get('/projects/create','ProjectController@create')->name('projects.create');
Route::get('/projects/show/{id}','ProjectController@show')->name('projects.show');
Route::get('/projects/edit/{id}','ProjectController@edit')->name('projects.edit');
Route::post('/projects/', 'ProjectController@store')->name('projects.store');
Route::put('/projects/{id}', 'ProjectController@update')->name('projects.update'); 
Route::delete('/projects/{id}', 'ProjectController@delete' )->name('projects.delete');


Route::post('/projecthours/starttime', 'ProjecthoursController@starttime')->name('projecthours.starttime'); 
Route::post('/projecthours/endtime', 'ProjecthoursController@endtime')->name('projecthours.endtime'); 
Route::get('/projecthours/{id}', 'ProjecthoursController@index')->name('projecthours.index');

Route::get('/projecthours/create','ProjecthoursController@create')->name('projecthours.create');
Route::get('/projecthours/show/{id}','ProjecthoursController@show')->name('projecthours.show');
Route::get('/projecthours/edit/{id}','ProjecthoursController@edit')->name('projecthours.edit');
Route::get('/projecthours/destroy/{id}','ProjecthoursController@destroy')->name('projecthours.destroy');
Route::post('/projecthours/datesubmit','ProjecthoursController@datesubmit')->name('projecthours.datesubmit');

