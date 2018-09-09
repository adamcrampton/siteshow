<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FetchLog;
use App\Models\Option;
use App\Models\Page;
use App\Models\User;

class ManagePagesController extends Controller
{
    protected $globalOptions = [];

    public function __construct()
    {
        // Set up global options object.
        $optionCollection = Option::all();

        $optionCollection->each(function($item, $key) {
            $this->globalOptions[$item->option_name] = $item->option_value;
        });

        // Determine fields required for validation and associated rules.
        $this->setValidationRules($this->controllerType);
    }

    private function setValidationRules($controllerType)
    {
        // Depending on the admin page, return the set of required validation rules.
        switch ($controllerType) {
            case 'option':
                $this->insertValidationOptions = [];
                $this->updateValidationOptions = [
                    'global_delay' => 'required', 
                    'global_fetch_limit' => 'required', 
                    'global_fetch_delay' => 'required', 
                    'global_page_list_limit' => 'required', 
                    'user_agent' => 'required', 
                    'default_save_path' => 'required',
                    'global_overwrite_files' => 'required',
                    'dismiss_dialogues' => 'required',
                    'wait_until_network_idle' => 'required',
                    'global_fetch_window_width' => 'required',
                    'global_fetch_window_height' => 'required'
                ];

            default:
                $this->insertValidationOptions = [];
                $this->updateValidationOptions = [];
                break;
        }
    }
}
