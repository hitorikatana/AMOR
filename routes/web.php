<?php

use Illuminate\Support\Facades\Route;

//Login, logout, forgot password
Route::get('/', 'LoginController@index');
Route::get('/login', ['as' => 'login', 'uses' => 'Logincontroller@index']);
Route::get('/logout', 'LoginController@logout');
Route::get('/home', ['as' => 'home', 'uses' => 'LoginController@home']);
Route::get('/password', 'LoginController@password');
Route::post('/auth', 'LoginController@auth');
Route::get('/department/department', 'DepartmentController@view');
Route::get('/forgot', function(){
    return view('forgot');
});
Route::get('/users/users', 'Users@view');

Route::group(['middleware' => 'checkSession'], function () {

    //Users

    Route::get('/users/usersNew', 'Users@new');
    Route::get('/users/usersDetail/{id}', 'Users@detail');
    Route::post('/users/add', 'Users@add');
    Route::post('/users/edit', 'Users@edit'); 
    Route::get('/users/search', 'Users@search'); 
});