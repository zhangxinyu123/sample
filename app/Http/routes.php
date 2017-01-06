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

Route::get('/', 'StaticPagesController@home')->name('home');//get('/', 'StaticPagesController@home');
Route::get('/help', 'StaticPagesController@help')->name('help');//get('/help', 'StaticPagesController@help');
Route::get('/about', 'StaticPagesController@about')->name('about');//get('/about', 'StaticPagesController@about');

get('signup','UsersController@create')->name('signup');
resource('users','UsersController');

get('login','SessionsController@create')->name('login');
post('login','SessionsController@store')->name('login');
delete('logout','SessionsController@destroy')->name('logout');
get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');