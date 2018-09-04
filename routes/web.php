<?php

// Fetch routes.
Route::resource('fetch', 'FetchController');

// Auth routes.
Auth::routes();

// Front end routes.
Route::resource('/', 'DisplayController');
Route::resource('manage', 'ManageController');

