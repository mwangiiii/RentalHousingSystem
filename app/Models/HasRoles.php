<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

trait HasRoles
{
    /**
     * Assign a role to the user.
     *
     * @param string $roleName
     * @return void
     */
    public function assignRole(string $roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->roles()->syncWithoutDetaching([$role->id]);
    }

    /**
     * Revoke a role from the user.
     *
     * @param string $roleName
     * @return void
     */
    public function revokeRole(string $roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->roles()->detach([$role->id]);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Relationship: User belongs to many roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
