<?php

namespace App\Http\Controllers;

use App\Models\Fetch;
use App\Models\Page;
use App\Models\Config;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    private $globalConfig;
    private $fetchedPages;
    private $fetchedPageData;
    private $savedFiles;
    private $updatedPages;

    public function __construct(Config $config)
    {
        // Grab global config.
        $this->globalConfig = Config::where('config_name', 'global')->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Page $page, Fetch $fetch)
    {
        // Get all records from pages table for processing.
        // Limit is set to the global default if not specified.
        $this->fetchedPages = $page->getPages($this->globalConfig->fetch_limit);

        // Create an array of URLs and Ids to hand off to the processing method.
        $this->fetchedPageData = $page->getPageData($this->fetchedPages);

        // Get Browsershot to crawl the URLs and save the images.
        $this->savedFiles = $fetch->processUrls($this->fetchedPageData, $this->globalConfig->default_save_path, $this->globalConfig->overwrite_files);

        // Now we have an array of paired filenames - original and saved, for each id in the pages table.
        // If overwriting is switched on, values will be the same.
        // Next, we update the pages table if we need to.
        $this->updatedPages = $page->processUpdates($this->savedFiles);

        dd($this->updatedPages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fetch  $fetch
     * @return \Illuminate\Http\Response
     */
    public function show(Fetch $fetch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fetch  $fetch
     * @return \Illuminate\Http\Response
     */
    public function edit(Fetch $fetch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fetch  $fetch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fetch $fetch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fetch  $fetch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fetch $fetch)
    {
        //
    }
}
