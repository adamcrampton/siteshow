<?php

namespace App\Traits;

use App\Models\User;
use Auth;

trait UserPermissionsTrait
{
    private $permissionLevels;

    public function __construct()
    {
    	// Set the required permission membership for each level.
        $this->permissionLevels['administrator'] = ['administrator'];
        $this->permissionLevels['editor'] = ['administrator', 'editor'];
        $this->permissionLevels['viewer'] = ['viewer', 'editor', 'viewer'];
    }

    public function isAdministrator()
    {
    	return in_array(Auth::user()->permission->permission, $this->permissionLevels['administrator']);
    }

    public function isEditor()
    {
    	return in_array(Auth::user()->permission->permission, $this->permissionLevels['editor']);
    }

    public function isViewer()
    {
    	return in_array(Auth::user()->permission->permission, $this->permissionLevels['viewer']);
    }
}