<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class Fetch extends Model
{
	public $defaultSavePath;

	public function __construct()
    {

    }

    public function processUrls($urlCollection, $defaultSavePath)
    {
    	$results = [];

    	$urlCollection->each(function($url) use($defaultSavePath) {
    		// Convert URL to usable string so we can have a meaningful filename, and overwrite on each cron job execution (if option is set).
    		$parsedUrl = parse_url($url);
	   		$imageFileName = str_replace('.', '-', $parsedUrl['host']);
    		$imageFileName .= (! empty($parsedUrl['path'])) ? str_replace('/', '-', $parsedUrl['path']) . '.jpg' : '.jpg';		

    		// Grab the screenshot and save the image.
    		$result[] = Browsershot::url($url)
    		->setScreenshotType('jpeg', 100)
    		->save($defaultSavePath . $imageFileName);
    	});

    	dd($results);
    }
}
