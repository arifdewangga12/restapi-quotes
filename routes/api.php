<?php


Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');
Route::get('me' , 'Api\UserController@me')->middleware('auth:api');

Route::post('quote' , 'Api\QuoteController@store')->middleware('auth:api');
Route::get('quotes' , 'Api\QuoteController@index')->middleware('auth:api');
Route::get('show/{quote}' , 'Api\QuoteController@show')->middleware('auth:api');
Route::post('update/{quote}' , 'Api\QuoteController@update')->middleware('auth:api');
