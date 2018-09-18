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
    protected $nameColumn;
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

        // Set column name for the model used by the controller.
        $this->nameColumn = $this->setNameColumn($this->controllerType);
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

    // Depending on the controller type, specify the human-readable "name" column for the model. This helps with status messages etc.
    private function setNameColumn($controllerType)
    {
        switch ($controllerType) {
            case 'page':
            case 'user':
                return 'name';
                break;

            default:
                return 'name';
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

    // Check request to see if any items were updated.
    protected function checkRequestForUpdates($batchRequest)
    {
        // Set update array.
        $updateArray = [];

        // Loops through each page and check if any changes were made.
        foreach ($batchRequest['page'] as $page => $values) {
            foreach ($this->fieldsToCompare as $fieldName) {
                if ($values[$fieldName] !== $values['original_value_'.$fieldName]) {
                    $updateArray[$values['id']][$fieldName] = $values[$fieldName];
                }
            }
        }

        // Return values or false if nothing to update.
        return (empty($updateArray)) ? false : $updateArray;
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

    // Prepare success HTML when one or more records are updated.
    protected function buildUpdateSuccessMessage($model, $batchRequest, $updateArray)
    {
        // Set nameColumn to regular variable for use with Eloquent.

        $nameColumn = $this->nameColumn;

        // Convert batchRequest to Collection.
        $batchRequest = collect($batchRequest['page']);

        // Add original values and human readable name to updateArray.
        foreach ($updateArray as $id => $updateValues) {
            $updateArray[$id]['display_name'] = $model::where('id', $id)->first()->$nameColumn;

            // Find and add original values to updateArray.
            // foreach ($updateValues as $valueName => $value) {
            //     $updateArray[$id]['original_value_'.$valueName] = $batchRequest->where('id', $id)->first()['original_value_'.$valueName];

            // }
        }

        dd($updateArray);
        

        // Loop through each item and generate the success message.

        $successMessage = '<p>Success! The following updates were made:</p>';
        $successMessage .= '<ul><li>';

        foreach ($updateArray as $id => $itemValues) {

        }

        $successMessage .= '</li></ul>';

        return $successMessage;
    }

    // Prepare success HTML when one or more records are disabled.
    protected function buildDisabledSuccessMessage($disableArray)
    {

    }
}
