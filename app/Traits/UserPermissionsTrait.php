<?php

namespace App\Traits;

use App\Models\User;

trait UserPermissionsTrait
{
    private $permissionLevels;

    public function __construct()
    {
        $this->permissionLevels = ['administrator', 'editor', 'viewer'];
    }
}