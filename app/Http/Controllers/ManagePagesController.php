<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FetchLog;
use App\Models\Option;
use App\Models\Page;
use App\Models\User;
use Validator;

class ManagePagesController extends Controller
{
    protected $controllerType;
    protected $globalOptions = [];
    protected $optionNames = [];
    protected $insertValidationOptions;
    protected $updateValidationOptions;
    protected $nameColumn;
    protected $fieldsToCompare;
    protected $loopLimit;
    protected $recordStatusChanged = false;

    public function __construct($controllerType)
    {
        // Require authentication.
        $this->middleware('auth');
        
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

        // Set loop limit.
        $this->loopLimit = $this->setLoopLimit($this->controllerType);

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
                    'rank' => 'required|integer'
                ];
                $this->updateValidationOptions = [
                    'name' => 'required',
                    'url' => 'required|url',
                    'rank' => 'required|integer',
                    'status' => 'required|boolean'
                ];
                break;

            case 'user':
                $this->insertValidationOptions = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'name' => 'required',
                    'email' => 'required|email',
                    'user_permission_level' => 'required|integer',
                    'password' => 'required'
                ];
                $this->updateValidationOptions = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'name' => 'required',
                    'email' => 'required|email',
                    'user_permission_level' => 'required|integer',
                    'status' => 'required|boolean'
                ];
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

            case 'fetchlog':
                return null;
                break;

            default:
                return 'name';
                break;
        }
    }

    // For pages with "Load more" pagination instead of links, set how many records to show on page for each batch.
    protected function setLoopLimit($controllerType) {
        switch ($controllerType) {
            case 'page':
                return 5;
                break;
            
            default:
                return 5;
                break;
        }
    }

    // Depending on the controller type, return original and new fields to compare against.
    protected function fieldsToCompare($controllerType) {
        switch ($controllerType) {
            case 'page':
                return [
                    'name', 'url', 'rank', 'status'
                ];
                break;
            case 'user':
                return [
                    'first_name', 'last_name', 'name', 'email', 'user_permission_level', 'status'
                ];
                break;
            
            default:
                // Empty array to check against in case it falls through.
                $this->fieldsToCompare = [];
        }
    }

    // Check request to see if any items were updated.
    protected function checkRequestForUpdates($batchRequest, $controllerType)
    {
        // Set update array.
        $updateArray = [];

        // Loops through each page and check if any changes were made.
        foreach ($batchRequest[$controllerType] as $page => $itemId) {
            foreach ($this->fieldsToCompare as $fieldValue => $fieldName) {
                if ($itemId[$fieldName] !== $itemId['original_value_'.$fieldName]) {
                    $updateArray[$itemId['id']][$fieldName] = $itemId[$fieldName];

                    // Additional check if record status was changed - set flag if so.
                    if ($fieldName === 'status') {
                        $this->recordStatusChanged = true;
                    }
                }
            }
        }

        // Return values or false if nothing to update.
        return (empty($updateArray)) ? false : $updateArray;
    }

    // Process batch validation from child controller.
    protected function processBatchValidation($modelName, $batchRequest)
    {
        // Flatten request array for validation.
        $validationArray = $batchRequest->all()[$modelName];

        // Validate each row then insert if successful.
        foreach ($validationArray as $item => $itemValues) {
            // Create Request object required for validator.
            $requestRow = new Request($validationArray[$item]);

            // Make a validator for each row.
            $validator = Validator::make($requestRow->all(), $this->updateValidationOptions);

            // Boot immediately with error if failed.
            if ($validator->fails()) {
                return $validator;
            }
        }
        return 'passed';
    }

    // Process batch updates from child controller.
    protected function processBatchUpdates($model, $updateArray)
    {
        // Check if any items should be excluded from batch updating, and unset.
        $exclusionArray = $this->checkUpdateArrayForExclusions($model);

        foreach ($updateArray as $id => $values) {
            foreach ($values as $valueName => $updateValue) {
                // Skip if in exclusion list.
                if (in_array($valueName, $exclusionArray)) {
                    continue;
                }

                $model::where('id', $id)
                    ->update([$valueName => $updateValue]);
            }
        }
    }

    // Prepare success HTML when one or more records are updated.
    protected function buildUpdateSuccessMessage($model, $updateArray)
    {
        // Set nameColumn to regular variable for use with Eloquent.
        $nameColumn = $this->nameColumn;

        // Add human readable name to updateArray.
        foreach ($updateArray as $id => $updateValues) {
            $updateArray[$id]['display_name'] = $model::where('id', $id)->first()->$nameColumn;
        }

        // Now make that the key name of the array, as we no longer need the id.
        $updateArray = collect($updateArray)->keyBy(function($item) {
            return $item['display_name'];
        });

        // Loop through each item and generate the success message.
        $successMessage = '<p>Success! The following updates were made:</p>';   
        $successMessage .= '<ul>';

        foreach ($updateArray as $displayName => $itemValues) {
            // Show row display name.
            $successMessage .= '<li><strong>'.$displayName.'</strong> was updated with the following values:';
            $successMessage .= '<ul>';
            // Add each updated item for this row to the success message.
            foreach ($itemValues as $itemName => $itemValue) {
                // Skip if it's display_name. Unsetting it earlier would be better but it's a pain in the butt.
                if ($itemName === 'display_name') {
                    continue;
                }

                $successMessage .= '<li><strong>'.ucfirst($itemName).'</strong> was updated to '.$itemValue;
            }

            $successMessage .= '</ul>';
        }

        $successMessage .= '</ul>';

        return $successMessage;
    }

    // Return an array of any fields that need to be excluded when batch updating.
    private function checkUpdateArrayForExclusions($model)
    {
        switch ($model) {
            // Status exclusions for models that have batch updating.
            case 'App\Models\Page':
            case 'App\Models\Users':
                return ['status'];
                break;
            
            default:
                return [];
                break;
        }
    }

    protected function toggleStatus($model, $updateArray)
    {
        foreach ($updateArray as $id => $values) {
            // We are receiving the whole update array - so skip if this iteration has no status key.
            if (isset($values['status'])) {
                $model::where('id', $id)
                ->update(['status' => $values['status']]);
            }   
        }
    }
}