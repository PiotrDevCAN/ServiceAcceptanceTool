<?php

namespace App\Auth\Providers;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\IBMUser;

class BluepagesUserProvider implements UserProvider
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * Create a new ibm user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @return void
     */
    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $user = array(
            'cnum' => 'SAMPLE_CNUM',
            'name' => 'SAMPLE_NAME',
            'email' => 'SAMPLE_EMAIL',
            'password' => Hash::make('SAMPLE_PW')
        );

        return $this->getUser($user);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $user = $this->getUser(
            array(
                'cnum' => 'SAMPLE_CNUM',
                'name' => 'SAMPLE_NAME',
                'email' => 'SAMPLE_EMAIL',
                'password' => Hash::make('SAMPLE_PW')
            )
        );

        return $user && $user->getRememberToken() && hash_equals($user->getRememberToken(), $token)
                    ? $user : null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        $this->conn->table($this->table)
                ->where($user->getAuthIdentifierName(), $user->getAuthIdentifier())
                ->update([$user->getRememberTokenName() => $token]);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
            (count($credentials) === 1 &&
                array_key_exists('password', $credentials))) {
                    return;
                }

                // First we will add each credential element to the query as a where clause.
                // Then we can execute the query and, if we found a user, return it in a
                // generic "user" object that will be utilized by the Guard instances.
//                 $query = $this->conn->table($this->table);

//                 foreach ($credentials as $key => $value) {
//                     if (Str::contains($key, 'password')) {
//                         continue;
//                     }

//                     if (is_array($value) || $value instanceof Arrayable) {
//                         $query->whereIn($key, $value);
//                     } else {
//                         $query->where($key, $value);
//                     }
//                 }

                // Now we are ready to execute the query to see if we have an user matching
                // the given credentials. If not, we will just return nulls and indicate
                // that there are no matching users for these given credential arrays.
                $user = array(
                    'cnum' => 'SAMPLE_CNUM',
                    'name' => 'SAMPLE_NAME',
                    'email' => 'SAMPLE_EMAIL',
                    'password' => Hash::make('SAMPLE_PW')
                );

                return $this->getUser($user);
    }

    /**
     * Get the IBM user.
     *
     * @param  mixed  $user
     * @return \App\Models\IBMUser|null
     */
    protected function getUser($user)
    {
        if (! is_null($user)) {
            return new IBMUser((array) $user);
        }
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $this->hasher->check(
            $credentials['password'], $user->getAuthPassword()
        );
    }
}
