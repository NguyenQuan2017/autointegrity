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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/make',['as'=>'make','uses'=>'CarPartController@make']);
Route::get('/model',['as'=>'model','uses'=>'CarPartController@model']);
Route::get('/badge',['as'=>'badge','uses'=>'CarPartController@badge']);
Route::get('/series',['as'=>'series','uses'=>'CarPartController@series']);
Route::get('/index',['as'=>'index','uses'=>'CarPartController@NumberPrice']);
Route::get('/edit/{id}',['as'=>'edit','uses'=>'CarPartController@EditNumberPrice']);
Route::get('/search',['as'=>'search','uses'=>'CarPartController@searchPartNumber']);