<?php

namespace App\Policies;

use App\Models\User;
Use App\Models\Option;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class OptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the index page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function index(User $user)
    {
        return Auth::user()->permission->permission_name === 'admin';
    }

    /**
     * Determine whether the user can update the options.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Option $option
     * @return mixed
     */
    public function update(User $user, Option $option)
    {
        return Auth::user()->permission->permission_name === 'admin';
    }
}
