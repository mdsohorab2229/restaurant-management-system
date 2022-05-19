<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @mixin \Eloquent
 */
class Permission extends Model
{
    /**
     * Many to many relation between permissions and roles
     * 
     * @return roles that belongs to this permission
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'permission_role', 'permission_id', 'role_id');
    }
}
