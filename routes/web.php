<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login');

Route::middleware('auth')->group(function () {

    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::get('/', 'MainController@index')->name('home');

    Route::match(['get', 'post'], 'change_password', 'UserController@change_password')->name('change_password');

    Route::middleware('permission')->group(function () {
        Route::resource('log', 'LogController');
        Route::resource('user', 'UserController');
        Route::resource('ticket', 'TicketController');
        Route::resource('department', 'DepartmentController');
    });

});
