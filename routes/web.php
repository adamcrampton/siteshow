<?php

// Fetch routes.
Route::resource('fetch', 'FetchController');

// Auth routes.
Auth::routes();

// Admin routes.
Route::get('/home', 'HomeController@index')->name('home');
