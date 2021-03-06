<?php

namespace App\Policies;

use App\Models\User;
Use App\Models\Option;
use App\Traits\UserPermissionsTrait;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class OptionPolicy
{
    use HandlesAuthorization;
    use UserPermissionsTrait;

    /**
     * Determine whether the user can view the index page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function index(User $user)
    {
        return $this->isAdministrator();
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
        return $this->isAdministrator();
    }
}
