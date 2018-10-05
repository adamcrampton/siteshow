<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\User;
use Validator;

class PageController extends ManagePagesController
{
    private $bounceReason = 'Sorry, you require editor access or higher to manage pages.';

    public function __construct()
    {
        // Initialise parent constructor.
        parent::__construct('page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Page $page, User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $page)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Get all pages.
        $allPages = Page::all()->sortBy('rank');

        // Manage Pages front end.
        return view('manage.page', [
            'modelName' => 'Page',
            'pageTitle' => 'Manage Pages',
            'introText' => 'Add or update pages here.',
            'page' => $allPages,
            'pageCount' => $allPages->where('status', 1)->count(),
            'option' => $this->globalOptions,
            'showAddButton' => true
        ]);
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
    public function store(Request $request, User $user, Page $page)
    {
        // Check user is authorised.
        if ($user->cant('create', $page)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Validate then insert if successful.
        $request->validate($this->insertValidationOptions);

        // Before creating, we need to rearrange the other records in the pages table so each item has an individual rank value.
        $rowsUpdated = $page->updatePageRanksAfterInsert($request->rank);

        // Insert the record.
        $page->name = $request->name;
        $page->url = $request->url;
        $page->duration = $request->duration;
        $page->rank = $request->rank;
        $page->save();

        // Return to index with success message.
        return redirect()->route('pages.index')->with('success', 'Success! New Page <strong>' . $request->name . '</strong> has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchUpdate(Request $request, User $user, Page $page)
    {   
        // Check user is authorised.
        if ($user->cant('update', $page)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Validate then insert if successful.
        // First, create a collection based on the batch request, then validate each row.
        $validationArray = collect($request->page)->map(function($item) {
            // For each item, we'll need to create a Request object to pass into the validator.
            $requestRow = new Request($item);

            // If validator fails on any row, immediately return so database isn't touched.
            $validator = Validator::make($requestRow->all(), $this->updateValidationOptions);

            if ($validator->fails()) {
                dd('Validator failed');
            };

        });

        // Set array for request rows.
        $batchRequest = $request->all();

        // Check if any items in request have been updated. This method will return with warning if not.
        // Otherwise, the update array is populated.
        $updateArray = $this->checkRequestForUpdates($batchRequest, 'page');

        if (! $updateArray) {
            return redirect()
                ->route('pages.index')
                ->with('warning', 'No updates were submitted.');
        }

        // Process any updates.
        $this->processBatchUpdates(Page::class, $updateArray);
        
        // If there were any records disabled or enabled, we need to re-sort the ranking, and set the status, the assign a rank at the bottom of the list.
        if ($this->recordStatusChanged) {

            // Set status per update array.
            $this->toggleStatus(Page::class, $updateArray);

            foreach ($updateArray as $pageId => $updateValues) {
                // Set max rank for this iteration.
                $lastRank = $page->getMaxRank() + 1;

                // Set rank to zero if made inactive.
                if (array_key_exists('status', $updateValues) && $updateValues['status'] === '0') {
                    Page::where('id', $pageId)
                        ->update(['rank' => 0]);
                } 

                if (array_key_exists('status', $updateValues) && $updateValues['status'] === '1') {
                    // If made active, bump into last position.
                    Page::where('id', $pageId)
                        ->update(['rank' => $lastRank]);
                }
            }

            // Reset all.
            $page->reindexPageRanks('rank');
        }

        // Build and return success message for returning to front end.
        $successMessage = $this->buildUpdateSuccessMessage(Page::class, $updateArray);

        return redirect()->route('pages.index')->with('success', $successMessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
