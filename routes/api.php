<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user/login', 'UserController@login');


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('user/logout', 'UserController@logout');
    Route::get('article/by_user', 'ArticleController@by_user');
    Route::get('article/edit', 'ArticleController@edit');
    Route::put('article/update', 'ArticleController@update');
    Route::delete('article/delete', 'ArticleController@delete');
    Route::post('article/create', 'ArticleController@store');
    
});

Route::group(['middleware' => ['cors']], function(){
    Route::post('/image/upload', 'ArticleController@upload');
});


Route::get('article/all', 'ArticleController@all');
Route::get('article/show', 'ArticleController@show');
