<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;

class FetchController extends Controller
{
    // Assume all defaults and return data.
    public function index() 
    {
    	// Grab default config.
    	$defaultConfig = Config::where('config_name', 'global')->get();

    	return $defaultConfig;
    }


    public function fetch($siteList = [], $fetchLimit = 50)
    {
    	return 'route test';
    }

}
