<?php

namespace App\Permissions;

use App\Facades\BlueGroups;

trait HasPermissionsTrait {

    public function checkBlueGroup($group)
    {
        $userMail = $this->getAuthIdentifier();
        $auth = BlueGroups::groupAuth($userMail, $group);
        return $auth;
    }

    public function hasUserRole()
    {
        // For now, everyone who is authorized is a standard user
        // $group = app()->config['app']['userBg'];
        // return $this->checkBlueGroup($group);
        return true;
    }

    public function hasAdminRole()
    {
        $group = app()->config['app']['adminBg'];
        return $this->checkBlueGroup($group);
    }

}
