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
    return view('welcome');
});

Route::post('login', 'Auth\AuthenticateController@authenticate');
Route::get('user-info', 'Auth\AuthenticateController@index')->middleware('jwt.auth');
Route::get('register', 'RegisterController@create');

Route::get('category/list', 'CategoryController@list');
Route::get('category/all', 'CategoryController@index');
Route::get('category/getone/{cate_id}', 'CategoryController@getOneCate');

Route::post('book/list', 'BookController@index');
Route::get('book/all', 'BookController@getAll');
Route::post('book/find', 'BookController@findById');
Route::post('book/save', 'BookController@save');

Route::post('post/list', 'PostController@index');
Route::get('post/all/{limit?}', 'PostController@getAll');
Route::get('post/find/{id}', 'PostController@findById');
Route::post('post/save', 'PostController@save');

Route::get('post_category/{cate_id}/{limit?}', 'PostController@getPostCate');
Route::get('post/hot/{limit?}', 'PostController@getHotPost');
Route::get('post/same_cate/{post_id?}', 'PostController@getPostSameCate');

Route::get('search/{keyword?}', 'PostController@search');

Route::get('crawl', 'Controller@crawl');


