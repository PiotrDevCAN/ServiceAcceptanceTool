<?php

namespace App\Ldap;

use App\Permissions\HasPermissionsTrait;
use LdapRecord\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use InvalidArgumentException;
use LdapRecord\Models\Concerns\CanAuthenticate;

class User extends Model implements Authenticatable
{
    use CanAuthenticate, HasPermissionsTrait;

    /**
     * The attribute key that contains the models object GUID.
     *
     * @var string
     */
    protected $guidKey = 'mail';
    // protected $guidKey = 'uid';

    /**
     * The object classes of the LDAP model.
     *
     * @var array
     */
    public static $objectClasses = [
        'person',
        'organizationalPerson',
        'ibmPerson',
        'ePerson',
        'top'
    ];

    // protected $rememberTokenName = 'uid';
    protected $rememberTokenName = 'mail';

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return (string) $this->{$this->getRememberTokenName()}[0];
        }
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

        /**
     * Get the model's string GUID.
     *
     * @param string|null $guid
     *
     * @return string|null
     */
    public function getConvertedGuid($guid = null)
    {
        try {
            return $guid ?? $this->getObjectGuid();
        } catch (InvalidArgumentException $e) {
            return;
        }
    }

}
