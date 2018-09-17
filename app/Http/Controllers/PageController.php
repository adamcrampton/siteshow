<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\User;

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
            'pageTitle' => 'Manage Pages',
            'page' => $allPages,
            'pageCount' => $allPages->where('status', 1)->count(),
            'option' => $this->globalOptions
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
        $rowsUpdated = $page->updatePageRanks($page->id, $request->rank);

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

        // Set array for request rows.
        $batchRequest = $request->all();

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
        
        // Process any updates.
        if (empty($updateArray)) {
            return redirect()
                ->route('pages.index')
                ->with('warning', 'No options were updated');
        } else {
            return $this->processBatchUpdates(Page::class, $updateArray);
        }
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
