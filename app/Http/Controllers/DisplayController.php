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
        // Return public home page.
        return view('index', [
            'pageTitle' => 'Siteshow',
            'pageData' => $this->pageData,
            'globalOptions' => $this->globalOptions
        ]);
    }  
}