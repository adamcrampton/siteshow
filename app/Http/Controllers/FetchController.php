<?php

namespace App\Http\Controllers;

use App\Models\Fetch;
use App\Models\FetchLog;
use App\Models\Page;
use App\Models\Option;
use App\Mail\FetchNotification;
use Illuminate\Http\Request;
use Mail;

class FetchController extends Controller
{
    private $globalConfig;
    private $fetchedPages;
    private $fetchedPageData;
    private $savedFiles;
    private $processedPageData;

    public function __construct(Option $option)
    {
        // Grab global config.
        $this->globalConfig = $option->getGlobalConfig();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Page $page, Fetch $fetch, FetchLog $fetchLog, FetchNotification $fetchNotification)
    {
        // Generate and output results object.
        $jsonData = [];

        // Get all records from pages table for processing.
        // Limit is set to the global default if not specified.
        $this->fetchedPages = $page->getPages($this->globalConfig['global_fetch_limit']);

        // Create an array of URLs and Ids to hand off to the processing method.
        $this->fetchedPageData = $page->getPageData($this->fetchedPages);   

        // Get Browsershot to crawl the URLs and save the images.
        $this->savedFiles = $fetch->processUrls($this->fetchedPageData, $this->globalConfig);

        // Set datetime variables for output array.
        $jsonData['startTime'] = $this->savedFiles['startTime'];
        $jsonData['endTime'] = $this->savedFiles['endTime'];
        $jsonData['duration'] = $this->savedFiles['duration'];

        // Set up fill values for log table insertion.
        $fillValues = [
            'started' => $this->savedFiles['startTime'],
            'finished' => $this->savedFiles['endTime'],
            'duration' => $this->savedFiles['duration']
        ];

        // Unset datetime variables from savedFiles so they don't interfere with the next few items.
        unset($this->savedFiles['startTime'], $this->savedFiles['endTime'], $this->savedFiles['duration']);

        // Add user currently set user agent.
        $fillValues['user_agent_used'] = $this->globalConfig['user_agent'];

        // Add image info for log table insertion.
        $fillValues['output'] = json_encode($this->savedFiles);

        // Add collected data to fetch log.
        $fetchLog->fill($fillValues);
        $fetchLog->save();

        // Process files, returning a ray of updated rows and new files added (if overwriting is switched off).
        $this->processedPageData = $page->processUpdates($this->savedFiles);

        // Populate remaining data for output.
        $jsonData['filesUpdated'] = $this->savedFiles;
        $jsonData['totalUpdates'] = $this->processedPageData;

        // If email notifications are switched on, create an email and send it to the email address in the config.
        if ($this->globalConfig['global_email_results']) {

            $fetchNotification->buildConfig($jsonData);
            $fetchNotification->build();

            // Now send the completed email to the specified provider.
            Mail::to($this->globalConfig['global_email'])->send($fetchNotification);
        }

        return $jsonData;
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
