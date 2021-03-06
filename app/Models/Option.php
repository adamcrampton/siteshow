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

    private $optionData;
    private $updateArray = [];

    public function getGlobalConfig()
    {
    	// Set up array of global config and return.
    	$allConfig = Option::all();

    	$allConfig->each(function($item, $key) {
    		$this->optionData[$item->option_name] = $item->option_value;
    	});

    	return $this->optionData;
    }

    public function processUpdates($originalValues, $request)
    {
        // Compare the original values against the request, and set up an update array.
        foreach ($originalValues as $option => $value) {
            if ($originalValues[$option] !== $request->$option) {
                $this->updateArray[$option] = $request->$option;
            }
        }

        // Update database.
        foreach ($this->updateArray as $option => $value) {
            Option::where('option_name', $option)
                ->update(['option_value' => $value]);
        }

        // Return updated values so we can inform the front end.
        return $this->updateArray;
    }
}
