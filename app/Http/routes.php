<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('tariff', function(){
	return view('template');
});


Route::get('form', 'SearchController@form');
Route::post('procesa', 'SearchController@search');
Route::get('input', function(){
	return view('input');
});



Route::get('array_search', 'SearchController@getArrSearch');
Route::get('get_result', 'SearchController@getResult');
Route::post('get_item', 'SearchController@getItem');
