<?php

namespace App\Http\Controllers;

use App\Models\Fetch;
use App\Models\Page;
use App\Models\Config;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    private $fetchedPages;
    private $fetchedUrls;

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

        // Create an array of URLs to hand off to Browsershot.
        $this->fetchedUrls = $page->getPageUrls($this->fetchedPages);

        // Get Browsershot to crawl the URLs and save the images.
        $browserShotResponse = $fetch->processUrls($this->fetchedUrls);

        dd($browserShotResponse);
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
