<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;
use Exception;

class Fetch extends Model
{
	public $defaultSavePath;
	private $startTime;
	private $endTime;

	public function __construct()
    {
        //
    }

    public function processUrls($urlCollection, $globalConfig)
    {
    	// Set up array of data to pass into the collection function.
    	$loopFunctionVariables = [
    		'defaultSavePath' => $globalConfig['default_save_path'], 
            'userAgent' => $globalConfig['user_agent'],
    		'overwriteFiles' => $globalConfig['global_overwrite_files'],
            'windowWidth' => $globalConfig['global_fetch_window_width'],
            'windowLength' => $globalConfig['global_fetch_window_height'],
            'fetchDelay' => $globalConfig['global_fetch_delay'],
            'fetchTimeout' => $globalConfig['global_fetch_timeout'],
            'dismissDialogues' => $globalConfig['dismiss_dialogues'],
            'waitUntilNetworkIdle' => $globalConfig['wait_until_network_idle'],
            'error' => [],
    		'savedFiles' => []
    	];

    	$this->startTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());

    	$urlCollection->each(function($page, $key) use(&$loopFunctionVariables) {
    		// Initalise index value for this iteration.
            $loopFunctionVariables['savedFiles'][$page['id']] = [];

            // Check if a image_path is set for this record. If not - it's a new record and we need to indicate this in our response.
            $newRecord = $page['image_path'] === null;

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
            // Create object instance and set URL.
    		$browserShot = Browsershot::url($page['url']);

            // Set image options.
            $browserShot->setScreenshotType('jpeg', 100)
                        ->windowSize($loopFunctionVariables['windowWidth'], $loopFunctionVariables['windowLength']);

            // Set user agent.
            $browserShot->userAgent($loopFunctionVariables['userAgent']);
            
            // Set timeout.
            $browserShot->timeout($loopFunctionVariables['fetchTimeout']);

            // Certain options only set if enabled.
            if ($loopFunctionVariables['dismissDialogues']) {
                $browserShot->dismissDialogs();
            }

            if ($loopFunctionVariables['waitUntilNetworkIdle']) {
                $browserShot->waitUntilNetworkIdle();
            }
    		
            // Save the image, save the exception details if it failed.
            try {
                $browserShot->save($loopFunctionVariables['defaultSavePath'] . $imageFileName);
            } catch (Exception $e) {
                $loopFunctionVariables['savedFiles'][$page['id']]['error'] = $e->getMessage();
            }
            

    		// Add file to saved files array - this works because of the pass by reference in the use statement.
            // Note: Don't bother saving this info if an exception has been thrown.
            if (! array_key_exists('error', $loopFunctionVariables['savedFiles'][$page['id']])) {
                $loopFunctionVariables['savedFiles'][$page['id']]['original'] = $originalFileName;
                $loopFunctionVariables['savedFiles'][$page['id']]['saved'] = $imageFileName;
                $loopFunctionVariables['savedFiles'][$page['id']]['new'] = $newRecord;    
            }
    	});

    	// End timer and determine duration.
    	$this->endTime = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());

    	// Set times and duration to return with file info.
    	$loopFunctionVariables['savedFiles']['duration'] = $this->startTime->diffInSeconds($this->endTime);
    	$loopFunctionVariables['savedFiles']['startTime'] = (string) $this->startTime;
    	$loopFunctionVariables['savedFiles']['endTime'] = (string) $this->endTime;

    	return $loopFunctionVariables['savedFiles'];
    }
}
