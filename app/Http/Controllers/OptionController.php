<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\User;

class OptionController extends ManagePagesController
{
    private $bounceReason = 'Sorry, you require admin access to manage the options.';

    public function __construct()
    {
        // Initialise parent constructor, passing in controller type value.
        parent::__construct('option');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Option $option, User $user)
    {
        // Check user is authorised.
        if ($user->cant('index', $option)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Global Options home page.
        return view('manage.option', [
            'pageTitle' => 'Set Options',
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
    public function update(Request $request, $id, User $user)
    {
        // Check user is authorised.
        if ($user->cant('update', $option)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }
    }

    /**
     * Update the multiple resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchUpdate(Request $request, User $user, Option $option)
    {
          // Check user is authorised.
        if ($user->cant('update', $option)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Validate request.
        $request->validate($this->updateValidationOptions);

        // Validation has passed, process update.
        $updateResult = $option->processUpdates($this->globalOptions, $request);

        // Return update result to front end.
        if (empty($updateResult)) {
            return redirect()
                ->route('options.index')
                ->with('warning', 'No options were updated');
        } else {
            $returnHTML = '<ul>';

            foreach ($updateResult as $option => $value) {
                $returnHTML .= '<li>'.$option.' was updated to '.$value.'</li>';
            }

            $returnHTML .= '</ul>';

            return redirect()
                ->route('options.index')
                ->with('success', $returnHTML); 
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
