<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use App\Models\Permission;
use App\Models\Role;

trait RolePermission
{
    public function givePermissionTo(...$permission)
    {
        $permission = $this->getPermissions(Arr::flatten($permission));
        if ($permission === null) {
            return $this;
        }

        $this->permissions()->saveMany($permission);
        return $this;
    }

    public function revokePermission(...$permission)
    {
        $permission = $this->getPermissions(Arr::flatten($permission));
        $this->permissions()->detach($permission);

        return $this;
    }

    public function refreshPermission(...$permission)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permission);
    }

    protected function getPermissions(array $permission)
    {
        return Permission::whereIn('name', $permission)->get();
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }

        return false;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }
}
