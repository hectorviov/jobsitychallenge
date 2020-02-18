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

Auth::routes();

Route::get('/', 'PagesController@index')->name('index');

Route::get('/users/{username}', 'UsersController@index')->name('user.profile');
Route::get('/users/{username}/tweets', 'UsersController@tweets')->name('user.tweets');
Route::post('/users/{username}/tweets/toggle/{id}', 'UsersController@toggleTweet')
    ->name('user.toggle_tweet')
    ->middleware('auth');

Route::get('/home', 'HomeController@index')->name('dashboard');

Route::get('/entries/add', 'EntriesController@add')
    ->name('entries.create')
    ->middleware('auth');
Route::post('/entries/add', 'EntriesController@add')
    ->name('entries.create')
    ->middleware('auth');

Route::get('/entries/{id}', 'EntriesController@view')
    ->name('entry.view');
Route::get('/entries/{id}/edit', 'EntriesController@edit')
    ->name('entries.edit')
    ->middleware('auth');
Route::post('/entries/{id}/edit', 'EntriesController@edit')
    ->name('entries.edit')
    ->middleware('auth');