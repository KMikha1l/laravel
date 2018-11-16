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

Route::get('/', function (): \Illuminate\View\View {
    return view('welcome', [
        'users' => App\Models\User::get(),
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
  Route::resource('/users', 'UserController', ['middleware' => 'role:moder', 'name' => 'users']);

  Route::resource('/comments', 'PostCommentController', ['name' => 'comments']);

  // Free access for all users
  Route::resource(
    '/posts',
    'PostController',
    [
        'name' => 'posts',
        'only' => [
          'index',
          'show',
          'create',
          'store',
        ],
        'middleware' => 'role:user'
    ]
  );

  // Moderators and admins
  Route::resource(
    '/posts',
    'PostController',
    [
      'name' => 'posts',
      'except' => [
        'destroy',
        'index',
        'create',
        'store'
      ],
      'middleware' => 'role:moder',
    ]
  );

  // Only admins
  Route::resource(
    '/posts',
    'PostController',
    [
      'name' => 'posts',
      'only' => [
        'destroy'
      ],
      'middleware' => 'role:admin',
    ]
  );
});
