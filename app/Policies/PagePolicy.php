<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class PagePolicy
{
    use HandlesAuthorization;

    private $defaultPermissionLevels = ['administrator', 'editor'];

    /**
     * Determine whether the user can view the index page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function index(User $user)
    {
        return in_array(Auth::user()->permission->permission, $this->defaultPermissionLevels);
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Page $page
     * @return mixed
     */
    public function update(User $user, Page $page)
    {
        return in_array(Auth::user()->permission->permission, $this->defaultPermissionLevels);
    }
}
