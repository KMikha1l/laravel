<?php

use Illuminate\Http\Request;
use App\User;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(array('prefix' => 'users'), function()
{

  Route::put('/', array('uses' => 'UserApiController@store'));
  Route::put('/{user}', 'UserApiController@update', function($user){
    return $user;
  });

  Route::get('/', 'UserApiController@index');
  Route::get('/{user}', 'UserApiController@show', function($user){
    return $user;
  });

  Route::delete('/{user}', 'UserApiController@destroy', function(User $user){
    return $user;
  });

});

Route::group(array('prefix' => 'posts'), function()
{
  Route::get('/', 'PostApiController@index');
  Route::get('/{post}', 'PostApiController@show', function($post){
    return $post;
  });

  Route::put('/', 'PostApiController@store');
  Route::put('/{post}', 'PostApiController@update', function($post){
    return $post;
  });

  Route::delete('/{post}', 'PostApiController@destroy');

});
