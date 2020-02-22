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

/* Rutas generales */
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

/* Rutas para usuarios */
Route::get('/configuration', 'UserController@config')->name('config');
Route::get('/user/profilepic/{filename}', 'UserController@getImage')->name('user.image');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/profile/{id}','UserController@profile')->name('user.profile');
Route::get('/users/{search?}', 'UserController@index')->name('user.index');

/* Rutas para Comentarios */
Route::post('/comment/save','CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

/* Rutas para Likes */
Route::get('/like/{post_id}','LikeController@like')->name('like.save');
Route::get('/dislike/{post_id}','LikeController@dislike')->name('like.delete');
Route::get('/likes', 'LikeController@index')->name('likes.index');

/* Rutas para Podcasts */
Route::get('/upload-podcast','PodcastController@create')->name('podcast.create');
Route::post('/podcast/save','PodcastController@save')->name('podcast.save');
Route::get('/podcast/file/{filename}', 'PodcastController@getPost')->name('podcast.file');
Route::get('/podcast/{id}', 'PodcastController@detail')->name('podcast.detail');
Route::get('/podcast/delete/{id}', 'PodcastController@delete')->name('podcast.delete');
Route::get('/podcast/edit/{id}', 'PodcastController@edit')->name('podcast.edit');
Route::post('/podcast/edit','PodcastController@update')->name('podcast.update');
Route::get('/broadcast','PodcastController@broadcast')->name('podcast.broadcast');

