<?php

// Fetch routes.
Route::resource('fetch', 'FetchController');

// Front end routes.
Route::resource('/', 'DisplayController');

//Admin routes.
Route::resource('manage', 'ManageController');
Route::resource('options', 'OptionController');
Route::post('optionBatchUpdate', 'OptionController@batchUpdate');
Route::resource('pages', 'PageController');
Route::post('pageBatchUpdate', 'PageController@batchUpdate');
Route::resource('users', 'UserController');
Route::resource('logs', 'FetchLogController');

// Auth routes.
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
