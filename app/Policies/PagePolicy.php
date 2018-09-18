<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Page;
use App\Traits\UserPermissionsTrait;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class PagePolicy
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
        return $this->isEditor();
    }

    /**
     * Determine whether the user can create a page.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Page $page
     * @return mixed
     */
    public function create(User $user, Page $page)
    {
        return $this->isEditor();
    }

    /**
     * Determine whether the user can update the pages.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Page $page
     * @return mixed
     */
    public function update(User $user, Page $page)
    {
        return $this->isEditor();
    }
}
