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

Route::middleware('auth')->group(function() {
    Route::get('/', 'TimelineController@index')->name('timeline');
    Route::get('/notifications', 'NotificationsController@index')->name('notifications');
    Route::get('/notifications/read/{id}', 'NotificationsController@read')->name('notifications.read');
    
    Route::post('/posts', 'PostsController@store')->name('posts.store');
    Route::post('/likes', 'LikesController@store')->name('likes.store');

    Route::post('/follow/{user_id}', 'TimelineController@follow')->name('follow');

    Route::get('/u/{username}/followers', 'TimelineController@followers')->name('followers');
    Route::get('/u/{username}/following', 'TimelineController@following')->name('following');
});

Route::get('/u/{username}', 'TimelineController@profile')->name('profile');

Route::get('user/avatar/{image}', 'AvatarController@image')->name('avatar');


/*Route::group([
    'middleware' => ['isAdmin'],
    'prefix' => 'admin',
    'namespace' => 'Posts',
], function() {
    Route::get('/posts/index', 'PostsController@index')->name('posts');
    Route::get('/posts/{id}', 'PostsController@edit')->name('posts.edit');
    Route::get('/posts/create', 'PostsController@create')->name('posts.create');
    Route::post('/posts', 'PostsController@store')->name('posts.store');
    Route::put('/posts/{id}', 'PostsController@update')->name('posts.update');
    Route::delete('/posts/{id}', 'PostsController@destory')->name('posts.destroy');
});*/

Auth::routes([
    //'register' => false,
    'verify' => true,
]);

//Route::get('admin/login')

Route::get('/home', 'HomeController@index')->name('home');
