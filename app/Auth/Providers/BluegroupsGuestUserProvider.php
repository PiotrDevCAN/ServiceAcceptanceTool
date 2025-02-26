<?php

namespace App\Auth\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;

class BluegroupsGuestUserProvider implements UserProvider
{
    private $model;

    public function __construct(\App\Ldap\User $userModel)
    {
        $this->model = $userModel;
    }

    public function retrieveById($identifier)
    {
        return $this->model->getUser($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        // We will not implement this as we are not dealing with password remember feature
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // We will not implement this as we are not dealing with password remember feature
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->model->getUser($credentials['username']);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (strcmp($credentials['username'], $user->getAuthIdentifier()) === 0) {
            if (Hash::check($credentials['password'], $user->getAuthPassword())) {
                return true;
            }
        }

        return false;
    }
}
