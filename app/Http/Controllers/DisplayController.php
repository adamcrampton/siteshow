<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Display;
use App\Models\Option;
use App\Models\Page;

class DisplayController extends Controller
{
    public $globalOptions;
    public $pageData;

    public function __construct(Page $page, Option $option)
    {
        // Get default options and active page data.
        $this->globalOptions = $option->getGlobalConfig();
        $this->pageData = $page->getPages($this->globalOptions['global_page_list_limit'], 'rank');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageJSON = $this->preparePageJSON();

        // Return public home page.
        return view('index', [
            'pageTitle' => 'Public Front End',
            'pageJSON' => $pageJSON
        ]);
    }

    /**
     * Prepare JSON for front end slideshow to consume.
     *
     * @return \Illuminate\Http\Response
     */
    private function preparePageJSON()
    {
        // Fetch all required page info and create a JSON object suitable for front end rendering.
        $this->pageData->each(function($page) {
            // We may need some logic in here to make the JSON useable.
        });

        return $this->pageData->toJson();
    }    
}