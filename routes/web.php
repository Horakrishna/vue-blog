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
Route::get('/new','TestController@TestMethod');
Route::any('{slug}',function(){
    return view('welcome');
});

Route::post('app/create_tag','AdminController@addTag');
Route::post('app/edit_tag','AdminController@editTag');
Route::get('app/get_tags','AdminController@getTag');
Route::post('app/detete_tag','AdminController@deleteTag');
Route::post('app/upload','AdminController@upload');
Route::post('app/delete_image','AdminController@deleteImage');
Route::post('app/create_category','AdminController@addCategory');
Route::get('app/get_category','AdminController@getCategory');
Route::post('app/edit_category','AdminController@editCategory');
Route::post('app/detete_category','AdminController@deleteCategory');



Route::post('app/create_user','AdminController@createUser');
Route::get('app/get_users','AdminController@getUser');
Route::post('app/edit_user','AdminController@editUser');


Route::post('app/admin-login','AdminController@adminLogin');



