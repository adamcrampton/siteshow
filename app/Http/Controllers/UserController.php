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
    private $allUsers;
    private $activeUsers;
    private $inactiveUsers;
    private $activeUserCount;
    private $inActiveUserCount;

    public function __construct(User $user)
    {
        // Initialise parent constructor.
        parent::__construct('user');

        // Set up properties required for front end.
        $this->allUsers = User::all()->values();
        $this->activeUsers = $user->where('status', 1)->paginate(2);
        $this->inactiveUsers = $user->where('status', 0)->get();
        $this->activeUserCount = $this->allUsers->where('status', 1)->count();
        $this->inactiveUserCount = $this->allUsers->where('status', 0)->count();
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

        // Get user permission list.
        $allPermissions = UserPermission::all();

        // Global Config home page.
        return view('manage.user', [
            'modelName' => 'User',
            'pageTitle' => 'Manage users',
            'introText' => 'Add or update users here.',
            'allUsers' => $this->allUsers,
            'activeUsers' => $this->activeUsers,
            'inactiveUsers' => $this->inactiveUsers,
            'activeUserCount' => $this->activeUserCount,
            'inactiveUserCount' => $this->inactiveUserCount,
            'userPermissions' => $allPermissions,
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
        // Check user is authorised.
        if ($user->cant('update', $user)) {
            return redirect()->route('manage.index')->with('warning', $this->bounceReason);
        }

        // Validate each row then insert if successful.
        // Boot the user to the manage page with errors if validation fails.
        $batchValidationResult = $this->processBatchValidation('user', $request);

        // If validation doesn't pass, the validator object will be returned from the method.
        if ($batchValidationResult !== 'passed') {
            return redirect()
                ->route('users.index')
                ->withErrors($batchValidationResult); 
        }

        // Set array for request rows.
        $batchRequest = $request->all();

        // Check if any items in request have been updated. This method will return with warning if not.
        // Otherwise, the update array is populated.
        $updateArray = $this->checkRequestForUpdates($batchRequest, 'user');

        if (! $updateArray) {
            return redirect()
                ->route('users.index')
                ->with('warning', 'No updates were submitted.');
        } else {
            // Process any updates.
            $this->processBatchUpdates(User::class, $updateArray);
        }

        // Set status per update array - if any status changes were detected.
        if ($this->recordStatusChanged) {
            $this->toggleStatus(User::class, $updateArray);
        }

        // Build and return success message for returning to front end.
        $successMessage = $this->buildUpdateSuccessMessage(User::class, $updateArray);

        return redirect()->route('users.index')->with('success', $successMessage);
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
