<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class Fetch extends Model
{
	private $defaultSavePath;

	public function __construct()
    {
        $this->defaultSavePath = 'site_images';
    }

    public function processUrls($urlCollection)
    {
    	$result = $urlCollection->each(function($url, $key) {
    		Browsershot::url($url)->save('test.jpg');
    	});

    	dd($result);
    }
}
