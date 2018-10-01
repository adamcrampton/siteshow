<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_permissons_fk', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Get all user details.
    public function getUsers($sortOption = null)
    {
        $users = User::where('status', 1);

        if ($sortOption) {
            $users->orderBy($sortOption);
        }

        return $users->get();
    }

    public function getDeletedUsers()
    {
        return User::where('user_status', 0)->get();
    }

    // Users have a single permission level.
    public function permission()
    {
        return $this->hasOne('App\Models\UserPermission', 'id', 'user_permissions_fk');
    }
}
