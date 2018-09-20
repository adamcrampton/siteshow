<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FetchLog;
use App\Traits\UserPermissionsTrait;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class FetchLogPolicy
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
        return $this->isViewer();
    }
}
