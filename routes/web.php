<?php

// Fetch routes.
Route::resource('fetch', 'FetchController');

// Front end routes.
Route::resource('/', 'DisplayController');

//Admin routes.
Route::resource('manage', 'ManageController');
Route::resource('options', 'OptionController');
Route::resource('pages', 'PageController');
Route::resource('users', 'UserController');

// Auth routes.
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
