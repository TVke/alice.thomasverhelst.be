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
//Route::get('/test', 'GameController@calculateScores');
Route::get('/leaderboard', 'PageController@leaderboard')->name('leaderboard');

Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/game/tiles', 'TileController@index');
Route::get('/game/players', 'PlayerController@index');

Route::post('/rotate/tile', 'TileController@rotate');
Route::post('/next/player', 'PlayerController@next');
Route::post('/found/object', 'GameController@objectFound');
Route::post('/first/object', 'GameController@firstObject');

Route::patch('/update/tiles', 'TileController@update');
Route::patch('/update/player/{pawn}', 'PlayerController@update');
Route::patch('/start/game/{session}', 'GameController@start');

Route::delete('/delete/player/{pawn}', 'PlayerController@destroy');

Route::get('/game/{session?}', 'GameController@index')->name('game');

//Auth::routes();
