<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_name',
        'option_value'
    ];

    private $configData;

    public function getGlobalConfig()
    {
    	// Set up array of global config and return.
    	$allConfig = Option::all();

    	$allConfig->each(function($item, $key) {
    		$this->configData[$item->option_name] = $item->option_value;
    	});

    	return $this->configData;
    }
}
