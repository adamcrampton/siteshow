<?php

// Fetch routes.
Route::resource('fetch', 'FetchController');

// Front end routes.
Route::resource('/', 'DisplayController');

//Admin routes.
Route::resource('manage', 'ManageController');
Route::resource('options', 'OptionController');
Route::patch('optionBatchUpdate', 'OptionController@batchUpdate');
Route::resource('pages', 'PageController');
Route::patch('pageBatchUpdate', 'PageController@batchUpdate');
Route::resource('users', 'UserController');
Route::patch('userBatchUpdate', 'UserController@batchUpdate');
Route::resource('logs', 'FetchLogController');

// Auth routes.
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
