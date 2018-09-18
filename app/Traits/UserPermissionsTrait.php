<?php

namespace App\Traits;

use App\Models\User;
use Auth;

trait UserPermissionsTrait
{
    private $permissionLevels;
    private $currentUserPermissionLevel;

    public function __construct()
    {
    	// Set the required permission membership for each level.
        $this->permissionLevels['administrator'] = ['administrator'];
        $this->permissionLevels['editor'] = ['administrator', 'editor'];
        $this->permissionLevels['viewer'] = ['viewer', 'editor', 'viewer'];

        // Get current user permission level.
        $this->currentUserPermissionLevel = Auth::user()->permission->permission;
    }

    public function isAdministrator()
    {
    	return in_array($this->currentUserPermissionLevel, $this->permissionLevels['administrator']);
    }

    public function isEditor()
    {
    	return in_array($this->currentUserPermissionLevel, $this->permissionLevels['editor']);
    }

    public function isViewer()
    {
    	return in_array($this->currentUserPermissionLevel, $this->permissionLevels['viewer']);
    }
}