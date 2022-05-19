<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Support\Facades\DB;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Many to many relation between users and roles
     *
     * @return object|array - roles that belongs to current user
     */
    public function roles()
    {
        return $this->belongsToMany('\App\Role', 'role_user', 'user_id', 'role_id');
    }

    /**
     * Get single role to verify permission, as it has a many to many relationship
     *
     * @return object|array - roles that belongs to current user
     */
    public function role()
    {
        return $this->roles()->first();
        // return \App\Role::find(DB::table('role_user')->where('user_id', $this->id)->first()->role_id);
    }

    /**
     * Checks if user has a specific permission or a group of permissions
     *
     * @param mixed $permission - Permission name, or a list of permission
     * @param bool $requireAll - if required all from the list
     * @return bool
     */
    public function canDo($permission, $requireAll = false)
    {
        return $this->role()->hasPermission($permission, $requireAll);
    }

    /**
     * Checks if user belongs to a specific user role
     *
     * @param mixed $role
     * @return bool
     */
    public function isA($role)
    {
        return $this->hasRole($role);
    }

    /**
     * Authorize User Role
     *
     * @param string|object|array $role
     * @return bool or abort
     */
    public function authorizeRole($roles)
    {
        if ($this->hasRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }

    /**
     * Authorize User Permission
     *
     * @param mixed $permission - Permission name, or a list of permission
     * @param bool $requireAll - if required all from the list
     * @return bool or abort
     */
    public function authorizePermissions($perms, $requireAll = false)
    {
        if ($this->role()->hasPermission($perms, $requireAll)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }

    /**
     * Check if current user has specific roles
     *
     * @param string|object|array $role
     * @return bool
     */
    public function hasRole($role, $requireAll = false)
    {
        if (is_object($role)) {
            $role = $role->name;
        }
        if (is_array($role)) {
            if(!isset($role['name'])) {
                return $this->hasRoles($role, $requireAll);
            }

            $role = $role['name'];
        }

        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Check if current user has multiple roles.
     *
     * @param mixed $roles
     * @param bool $requireAll (optional) - if all roles are required
     * @return bool
     */
    public function hasRoles($roles, $requireAll = false)
    {
        foreach ($roles as $role) {
            $hasRol = $this->hasRole($role);

            if ($hasRol && !$requireAll) {
                return true;
            } elseif (!$hasRol && $requireAll) {
                return false;
            }
        }

        return $requireAll;
    }

    /**
     * Attach role to current user.
     *
     * @param object|array $role
     * @return void
     */
    public function attachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }
        if (is_array($role)) {
            if(!isset($role['id'])) {
                return $this->attachRoles($role);
            }

            $role = $role['id'];
        }
        $this->roles()->attach($role);
    }


    /**
     * Attach multiple roles to current user.
     *
     * @param mixed $roles
     * @return void
     */
    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    /**
     * Detach role from current user.
     *
     * @param object|array $role
     * @return void
     */
    public function detachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }
        if (is_array($role)) {
            if(!isset($role['id'])) {
                return $this->detachRoles($role);
            }

            $role = $role['id'];
        }
        $this->roles()->detach($role);
    }

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     */
    public function detachRoles($roles=null)
    {
        if (!$roles) $roles = $this->roles()->get();
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }

}
