<?php

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PostComment;

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
  Route::put('/{user}', 'UserApiController@update', function(User $user){
    return $user;
  });

  Route::get('/', 'UserApiController@index');
  Route::get('/{user}', 'UserApiController@show', function(User $user){
    return $user;
  });

  Route::delete('/{user}', 'UserApiController@destroy', function(User $user){
    return $user;
  });

});

Route::group(array('prefix' => 'posts'), function()
{
  Route::get('/', 'PostApiController@index');
  Route::get('/{post}', 'PostApiController@show', function(User $post){
    return $post;
  });

  Route::put('/', 'PostApiController@store');
  Route::put('/{post}', 'PostApiController@update', function(User $post){
    return $post;
  });

  Route::delete('/{post}', 'PostApiController@destroy');

});

Route::group([], function()
{
    Route::get('comments/', 'PostCommentApiController@index');
    Route::get(
      '/posts/{post_id}/comments',
      'PostCommentApiController@postComments',
      function(integer $post_id): integer {
        return $post_id;
      }
    );

    Route::get(
        'comments/{comment}',
        'PostCommentApiController@show',
        function(PostComment $comment): PostComment {
            return $comment;
        }
    );

    Route::put('comments/', 'PostCommentApiController@store');
    Route::put(
        'comments/{comment}',
        'PostCommentApiController@update',
        function(PostComment $comment): PostComment {
            return $comment;
        }
    );

    Route::delete('comments/{comment}', 'PostCommentApiController@destroy');

});
