<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FetchLog;
use App\Models\Option;
use App\Models\Page;
use App\Models\User;

class ManagePagesController extends Controller
{
    protected $controllerType;
    protected $globalOptions = [];
    protected $optionNames = [];
    protected $insertValidationOptions;
    protected $updateValidationOptions;
    protected $fieldsToCompare;

    public function __construct($controllerType)
    {
        // Set controller type being used.
        $this->controllerType = $controllerType;

        // Set up global options object.
        $optionCollection = Option::all();

        $optionCollection->each(function($item, $key) {
            $this->globalOptions[$item->option_name] = $item->option_value;
            $this->optionNames[$item->option_name] = $item->option_nice_name;
        });

        // Determine fields required for validation and associated rules.
        $this->setValidationRules($this->controllerType);

        // Determine fields to compare when updating.
        $this->fieldsToCompare = $this->fieldsToCompare($this->controllerType);
    }

    // Depending on controller type, return the set of required validation rules.
    private function setValidationRules($controllerType)
    {
        switch ($controllerType) {
            case 'option':
                $this->insertValidationOptions = [];
                $this->updateValidationOptions = [
                    'global_delay' => 'required|integer', 
                    'global_fetch_limit' => 'required|integer', 
                    'global_fetch_delay' => 'required|integer', 
                    'global_page_list_limit' => 'required|integer', 
                    'user_agent' => 'required', 
                    'default_save_path' => 'required',
                    'global_overwrite_files' => 'required|boolean',
                    'dismiss_dialogues' => 'required|boolean',
                    'wait_until_network_idle' => 'required|boolean',
                    'global_fetch_window_width' => 'required|integer',
                    'global_fetch_window_height' => 'required|integer'
                ];
                break;

            case 'page':
                $this->insertValidationOptions = [
                    'name' => 'required',
                    'url' => 'required|url',
                    'duration' => 'required|integer',
                    'rank' => 'required|integer'
                ];
                $this->updateValidationOptions = [];
                break;

            default:
                $this->insertValidationOptions = [];
                $this->updateValidationOptions = [];
                break;
        }
    }

    // Depending on the controller type, return original and new fields to compare against.
    protected function fieldsToCompare($controllerType) {
        switch ($controllerType) {
            case 'page':
                return [
                    'name', 'url', 'duration', 'rank'
                ];
                break;
            
            default:
                // Empty array to check against in case it falls through.
                $this->fieldsToCompare = [];
        }
    }

    // Process batch updates from child controller.
    protected function processBatchUpdates($model, $updateArray)
    {
        foreach ($updateArray as $id => $values) {
            foreach ($values as $valueName => $updateValue) {
                $model::where('id', $id)
                    ->update([$valueName => $updateValue]);
            }
        }
    }
}
