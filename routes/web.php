<?php

// Fetch routes.
Route::resource('fetch', 'FetchController');

// Front end routes.
Route::resource('/', 'DisplayController');
Route::resource('manage', 'ManageController');

// Auth routes.
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
