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

//movies

Route::get('/','MoviesController@index')->name('movies.index');
Route::get('/movies/{movie}','MoviesController@show')->name('movies.show');
// Route::get('/','MoviesController@index')->name('movies.index');


//actors
Route::get('/actors','ActorsController@index')->name('actors.index');
Route::get('/actors/page/{page?}','ActorsController@index');

Route::get('/actors/{actor}','ActorsController@show')->name('actors.show');


// tv show
Route::get('/tv','TvController@index')->name('tv.index');
Route::get('/tv/{id}','TvController@show')->name('tv.show');
