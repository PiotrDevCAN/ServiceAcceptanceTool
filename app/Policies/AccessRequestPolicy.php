<?php

namespace App\Policies;

use App\Ldap\User;
use App\Models\AccessRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Ldap\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasAdminRole()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Ldap\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\AccessRequest  $accessRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AccessRequest $accessRequest)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Ldap\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\AccessRequest  $accessRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AccessRequest $accessRequest)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\AccessRequest  $accessRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AccessRequest $accessRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\AccessRequest  $accessRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AccessRequest $accessRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Ldap\User  $user
     * @param  \App\Models\AccessRequest  $accessRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AccessRequest $accessRequest)
    {
        //
    }
}
