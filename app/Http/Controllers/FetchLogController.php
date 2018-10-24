<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FetchLog;
use App\Models\User;

class FetchLogController extends ManagePagesController
{
    private $bounceReason = 'Sorry, you require viewer access or higher to view logs.';

    public function __construct()
    {
        // Initialise parent constructor.
        parent::__construct('fetchlog');

        // Require authentication.
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $user)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Fetch all logs.
        $allLogs = FetchLog::all();

        // Generate readable log format for the front end, then insert into collection.
        $allLogs->each(function($item) {
            // Decode log details for this item.
            $logDetails = json_decode($item->output);

            // Reset $item->output.
            $item->output = '<ul class="list-group">';

            // Insert updated values.
            foreach ($logDetails as $id => $details) {
                // Easier to declare this here.
                $newFileCreated = $details->new ? 'Yes' : 'No';

                $outputHTML = '<li class="list-group-item"><ul class="list-group">';
                $outputHTML .= '<li class="list-group-item">Item # '. $id .'</li>';
                $outputHTML .= '<li class="list-group-item">Original Filename: '. $details->original .'</li>';
                $outputHTML .= '<li class="list-group-item">Saved Filename: '. $details->saved .'</li>';
                $outputHTML .= '<li class="list-group-item">New file created? '. $newFileCreated . '</li>';
                $outputHTML .= '</ul></li>';

                $item->output .= $outputHTML;
            }
            // Close off list.
            $item->output .= '</ul>';
        });

        // Log view.
        return view('manage.log', [
            'modelName' => 'FetchLog',
            'pageTitle' => 'View Logs',
            'introText' => 'View logs from fetch requests',
            'log' => $allLogs,
            'option' => $this->globalOptions,
            'showAddButton' => false
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
    public function store(Request $request)
    {
        //
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
