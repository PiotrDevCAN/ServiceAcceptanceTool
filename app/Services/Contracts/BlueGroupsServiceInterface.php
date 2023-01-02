<?php

namespace App\Services\Contracts;

interface BlueGroupsServiceInterface
{
    // array result = userAuth(userid, password)
    // Verify the userid and password given are valid in Bluepages
    // returns an array of user information on success or FALSE on
    // failure.
    // function userAuth($user, $pass);

    // bool result = groupAuth (string employee, mixed group, [string depth])
    // given a DN, check all $groups and return TRUE or FALSE
    // $group can be either an array of groups names or string of the group to check
    // set $depth to 0 to check only the top level group
    function groupAuth($employee, $group, $depth = 2);

    // do bluegroups check, if needed
    // function checkBluegroup($userDn, $group=null);

    # return an array of groups $employee is in.  $employee can be a DN or
    # an email address.
    function employeeBluegroups($employee);

    # search bluepages using an ldap filter
    # array bluepagesSearch ( mixed filter, array attr)
    # $filter can be a string or an array of strings to search on
    # $attr is an array of ldap attributes to return for each record
    # returns FALSE or an array of results keyed by DN
    # WARNING: only the first value of an attribute is returned
    function bluepagesSearch($filter, $attr = null, $keyAttr = 'dn');
}
