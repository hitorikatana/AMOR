<?php

use Illuminate\Support\Facades\Route;

//Login, logout, forgot password
Route::get('/', 'Login@index');
Route::get('/login', ['as' => 'login', 'uses' => 'Login@index']);
Route::get('/forgot', function(){
    return view('forgot');
});
Route::get('/logout', 'Login@logout');

Route::get('/home', 'Login@home');
Route::get('/password', 'Login@password');
Route::post('/auth', 'Login@auth');

Route::group(['middleware' => 'checkSession'], function () {

    //Users
    Route::get('/users/users', 'Users@view');
    Route::get('/users/usersNew', 'Users@new');
    Route::get('/users/usersDetail/{id}', 'Users@detail');
    Route::post('/users/add', 'Users@add');
    Route::post('/users/edit', 'Users@edit'); 
    Route::get('/users/search', 'Users@search'); 
});