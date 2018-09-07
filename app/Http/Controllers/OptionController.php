<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\User;

class OptionController extends Controller
{
    private $globalOptions = [];
    private $bounceReason = 'Sorry, you require admin access to manage the options.';

    public function __construct()
    {
        // Set up global options object.
        $optionCollection = Option::all();

        $optionCollection->each(function($item, $key) {
            $this->globalOptions[$item->option_name] = $item->option_value;
        });
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

        // Global Config home page.
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
        if ($user->cant('update', $user)) {
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
    public function batchUpdate(Request $request, User $user)
    {
        // Check user is authorised.
        if ($user->cant('update', $user)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
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
