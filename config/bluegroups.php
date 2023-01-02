<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default LDAP Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the LDAP connections below you wish
    | to use as your default connection for all LDAP operations. Of
    | course you may add as many connections you'd like below.
    |
    */

    'username' => env('BLUEGROUP_USERID'),
    'password' => env('BLUEGROUP_PASSWORD'),

    'url' => 'https://bluepages.ibm.com/tools/groups/groupsxml.wss',
    'protectedUrl' => 'https://bluepages.ibm.com/tools/groups/protect/groups.wss',

];
