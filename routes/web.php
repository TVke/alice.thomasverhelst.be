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

Route::get('/', 'PageController@info')->name('info');

Route::get('/game/tiles', 'TileController@index');
Route::get('/game/players', 'PlayerController@index');
Route::get('/game/objects', 'GameController@objects');

Route::put('/add/player', 'PlayerController@store');

Route::get('/game/{session?}', 'GameController@index')->name('game');

Auth::routes();
