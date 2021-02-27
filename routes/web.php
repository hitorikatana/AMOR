<?php

use Illuminate\Support\Facades\Route;

//Login, logout, forgot password
Route::get('/', 'LoginController@index');
Route::get('/login', ['as' => 'login', 'uses' => 'Logincontroller@index']);
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/home', ['as' => 'home', 'uses' => 'LoginController@home']);
Route::get('/password', 'LoginController@password');
Route::post('/auth', 'LoginController@auth');
Route::get('/forgot', function(){
    return view('forgot');
});
Route::get('/contact/list', 'UsersController@view')->name('contact/list');
Route::get('/schedule/list', 'UsersController@view')->name('schedule/list');
Route::get('/schedule/activityType', 'UsersController@view')->name('schedule/activityType');
Route::get('/profile/list', 'UsersController@view')->name('profile/list');
Route::get('/product/list', 'UsersController@view')->name('product/list');
Route::get('/product/productCategory', 'UsersController@view')->name('product/productCategory');



Route::group(['middleware' => 'checkSession'], function () {

    //UsersController
    Route::get('/users/list', 'UsersController@view')->name('users/list');
    Route::get('/users/usersNew', 'UsersController@new');
    Route::get('/users/usersDetail/{id}', 'UsersController@detail');
    Route::post('/users/add', 'UsersController@add');
    Route::post('/users/edit', 'UsersController@edit');
    Route::get('/users/search', 'UsersController@search');

    //department
    Route::get('/department/list', 'DepartmentController@view')->name('department/list');
    Route::post('/department/edit', 'DepartmentController@edit')->name('department/edit');
    Route::get('/department/departmentDetail/{id}', 'DepartmentController@detail')->name('department/detail');

    //region
    Route::get('/region/list', 'RegionController@view')->name('region/list');
    Route::get('/region/edit', 'RegionController@edit')->name('region/edit');
    Route::get('/region/regionDetail/{$id}', 'RegionController@detail')->name('region/detail');
});
