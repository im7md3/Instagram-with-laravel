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

Route::get('/', function () {
    if(Auth::check()){
        return redirect('/home');
    }else{
        return view('Auth.login');
    }
});

Route::group(['middleware' => ['auth']], function () {
    route::get('user/profile','UserController@edit')->name('edit.user');
    route::PATCH('user/profile','UserController@update')->name('update.user');
    Route::get('users','UserController@index');

    // post url
    Route::resource('post', 'PostController');
    Route::get('user/posts', 'PostController@userPosts')->name('user.post');
    
    //like url
    Route::resource('like', 'LikeController');
    Route::resource('comment', 'CommentController');

    Route::resource('follow','FollowController');
    Route::get('user/followers','FollowController@index');

Route::get('/home', 'PostController@index')->name('home');

});

Auth::routes();

