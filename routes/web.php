<?php

// Fetch routes.
Route::get('/fetch', 'FetchController@index');
Route::get('/fetch/{siteList}/{fetchLimit}', 'FetchController@fetch');

