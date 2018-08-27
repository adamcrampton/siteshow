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

    public function processUrls($urlCollection, $defaultSavePath, $overwriteFiles)
    {
    	// Set up array of data to pass into the collection function.
    	$loopFunctionVariables = [
    		'defaultSavePath' => $defaultSavePath, 
    		'overwriteFiles' => $overwriteFiles,
    		'savedFiles' => []
    	];

    	$urlCollection->each(function($page, $key) use(&$loopFunctionVariables) {
    		// Convert URL to usable string so we can have a meaningful filename, and overwrite on each cron job execution (if option is set).
    		$parsedUrl = parse_url($page['url']);

    		// Get the host and replace dots with dashes.
	   		$imageFileName = str_replace('.', '-', $parsedUrl['host']);

	   		// If there is a path available, replace slashes with dashes.
    		$imageFileName .= (! empty($parsedUrl['path'])) ? str_replace('/', '-', $parsedUrl['path']) : '';

    		// Save original filename in case overwriting is switched off.
    		$originalFileName = $imageFileName . '.jpg';

    		// If overwriting is switched off, append a date string to the end of the filename.
    		$imageFileName .= (! $loopFunctionVariables['overwriteFiles']) ? '-' . time() : '';

    		// Append JPG extension.
    		$imageFileName .= '.jpg';

    		// Grab the screenshot and save the image.
    		Browsershot::url($page['url'])
    		->setScreenshotType('jpeg', 100)
    		->save($loopFunctionVariables['defaultSavePath'] . $imageFileName);

    		// Add file to saved files array - this works because of the pass by reference in the use statement.
    		$loopFunctionVariables['savedFiles'][$page['id']]['original'] = $originalFileName;
    		$loopFunctionVariables['savedFiles'][$page['id']]['saved'] = $imageFileName;
    	});

    	return $loopFunctionVariables['savedFiles'];
    }
}
