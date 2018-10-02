<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPermission;
use Hash;
use Validator;

class UserController extends ManagePagesController
{
    private $bounceReason = 'Sorry, you require admin access to manage users.';

    public function __construct()
    {
        // Initialise parent constructor.
        parent::__construct('user');
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

        // Get all users.
        $allUsers = User::all()->sortBy('user_permissions_fk');

        // Get user permission list.
        $allPermissions = UserPermission::all();

        // Global Config home page.
        return view('manage.user', [
            'pageTitle' => 'Manage users',
            'introText' => 'Add or update users here.',
            'user' => $allUsers,
            'userPermissions' => $allPermissions,
            'pageCount' => $allUsers->where('status', 1)->count(),
            'option' => $this->globalOptions,
            'showAddButton' => true,
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
    public function store(Request $request, User $user)
    {
        // Check user is authorised.
        if ($user->cant('create', $user)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Validate then insert if successful.
        $request->validate($this->insertValidationOptions);

        // Insert the record.
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_permissions_fk = $request->user_permission_level;
        $user->password = Hash::make($request->password);
        $user->save();

        // Return to index with success message.
        return redirect()->route('users.index')->with('success', 'Success! New User <strong>' . $request->name . '</strong> has been added.');
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
    public function batchUpdate(Request $request, User $user)
    {
        return 'test';
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
