<?php

namespace App\Services;

use App\Services\Contracts\BlueGroupsServiceInterface;

class BlueGroupsService implements BlueGroupsServiceInterface
{
    /**
     * @var Ldap record
     */
    protected $ldap;

    protected static $ldapAttr = array(
        'uid',
        'mail',
        'ismanager',
        'dept',
        'div',
        'employeetype',
        'ibmserialnumber',
        'manager',
        'cn',
        'workloc'
    );

    function __construct($ldap)
    {
        // setup ldaps resource
        $this->ldap = $ldap;

        //clear any error values
        // self::$IIP_LDAP_ERRNO = 0;
        // self::$IIP_AUTH_ERRNO = 0;
    }

    // make an OR filter from an array of values
    function makeFilter($value, $attr)
    {
        $filter = "";
        foreach ($value as $v) {
            $filter .= "($attr=$v)";
        }
        if (sizeof($value) > 1) {
            $filter = "(|$filter)";
        }
        return $filter;
    }

    // array result = user_auth(userid, password)
    // Verify the userid and password given are valid in Bluepages
    // returns an array of user information on success or FALSE on
    // failure.
//     function user_auth($user, $pass)
//     {
//         $user = trim($user);
//         $pass = trim($pass);

//         // $filter = "(&(mail=" . $user . ")(objectclass=ibmPerson))";

//         // empty user id
//         if ($user == "") {
//             self::$IIP_LDAP_ERRNO = 0;
//             self::$IIP_AUTH_ERRNO = 4;
//             return FALSE;
//         }

//         // empty password
//         if ($pass == "") {
//             self::$IIP_LDAP_ERRNO = 0;
//             self::$IIP_AUTH_ERRNO = 6;
//             return FALSE;
//         }

//         // new search
//         $search = $this->ldap->search();

//         // new query
// //         $query = $this->ldap->search()->newQuery();

//         // setup ldaps resource
//         // connect, bind, and search for $user
//         // moved do ldap object

// //         $results = $search->select(self::$ldapAttr)
//         $results = $search->select()
//             ->where('mail', '=', $user)
//             ->where('objectclass', '=', 'person')
//             ->where('objectclass', '=', 'ibmPerson')
//             ->first();

//         // retrive the first entry (if any)
//         if (! $entry = @ldap_first_entry($ds, $sr)) {
//             self::$IIP_LDAP_ERRNO = 0;
//             self::$IIP_AUTH_ERRNO = 4;
//             return FALSE;
//         }

//         // authenticated bind using $userDn and $pass
//         $userDn = @ldap_get_dn($ds, $entry);
//         if (! @ldap_bind($ds, $userDn, $pass)) {
//             self::$IIP_LDAP_ERRNO = ldap_errno($ds);
//             self::$IIP_AUTH_ERRNO = 6;
//             return FALSE;
//         }

//         // while we have it, return an array of info
//         $user = array(
//             'dn' => $userDn
//         );
//         foreach (self::$ldapAttr as $a) {
//             $val = @ldap_get_values($ds, $entry, $a);
//             $user[$a] = ($val) ? $val[0] : null;
//         }

//         // close and return
//         return $user;
//     }

    // bool result = groupAuth (string user_dn, mixed group, [string depth])
    // given a DN, check all $groups and return TRUE or FALSE
    // $group can be either an array of groups names or string of the group to check
    // set $depth to 0 to check only the top level group
    // function groupAuth($userDn, $group, $depth = 2)
    function groupAuth($employee, $group, $depth = 2)
    {
        if (strpos($employee, "@") == TRUE) {
            # lookup the DN from an email address
            if (! $record = $this->bluepagesSearch("(mail=$employee)") ) { return FALSE; }
            $userDn = $record[0]['dn'];
        } elseif (strpos($employee, "=") == TRUE) {
            # use the DN given
            $userDn = $employee;
        } else {
            # passed something we don't know how to handle
            return FALSE;
        }

        // setup ldap connection resource
        if (! is_array($group)) {
            $group = array(
                $group
            );
        }
        $basedn = "ou=memberlist,ou=ibmgroups,o=ibm.com";

        // check this $group and all subgroups for $dn
        $result = FALSE;
        while ($depth >= 0) {
            // filter to look for $dn in $group list
            $filter = $this->makeFilter($group, 'cn');
            $filter = "(&(objectclass=groupofuniquenames)(uniquemember=$userDn)$filter)";

            $sr = $this->ldap
                ->query()
                ->setDn($basedn)
                ->select(array('cn'))
                ->rawFilter($filter)
                ->get();

            if (!empty($sr)) {
                $result = TRUE;
                break;
            }
            $depth --;
        }
        return $result;
    }

    # return an array of groups $employee is in.  $employee can be a DN or
    # an email address.
    function employeeBluegroups($employee)
    {
        if (strpos($employee, "@") == TRUE) {
            # lookup the DN from an email address
            if (! $record = $this->bluepagesSearch("(mail=$employee)") ) { return FALSE; }
            $userDn = $record[0]['dn'];
        } elseif (strpos($employee, "=") == TRUE) {
            # use the DN given
            $userDn = $employee;
        } else {
            # passed something we don't know how to handle
            return FALSE;
        }

        # setup ldap connection
        $filter = "(uniquemember=" . $userDn . ")";
        $basedn = "ou=ibmgroups,o=ibm.com";

        $sr = $this->ldap
            ->query()
            ->setDn($basedn)
            ->select(array('cn'))
            ->rawFilter($filter)
            ->get();

        # build an array of groups found
        $groups = array();
        foreach($sr as $entry) {
            $val = $entry['cn'];
            array_push($groups, $val[0]);
        }
        return $groups;
    }

    # search bluepages using an ldap filter
    # array bluepagesSearch ( mixed filter, array attr)
    # $filter can be a string or an array of strings to search on
    # $attr is an array of ldap attributes to return for each record
    # returns FALSE or an array of results keyed by DN
    # WARNING: only the first value of an attribute is returned
    function bluepagesSearch($filter, $attr = null, $keyAttr = 'dn')
    {
        # setup filter array, attr list, and base dn
        if ( ! is_array($filter) ) $filter = array($filter);
        $attr = ($attr) ? $attr : array('cn', 'mail', 'uid');
        # make sure $key is in attr array or we cannot use it
        if ( $keyAttr != 'dn' && ! in_array($keyAttr, $attr) ) $attr[] = $keyAttr;

        $result = $this->ldap
            ->query()
            ->select($attr)
            ->rawFilter($filter)
            ->get();
        return $result;
    }
}
