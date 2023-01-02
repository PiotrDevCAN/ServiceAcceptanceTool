<?php

namespace App\Services\Contracts;

interface BlueGroupsManageServiceInterface
{
    public function defineGroup($groupName, $description, $life=1);

    public function deleteMember($groupName, $memberEmail);

    public function addMember($groupName, $memberEmail);

    public function addAdministrator($groupName, $memberEmail);

    public function getUID($email);

    public function createCurl($agent='SOIWAPI');

    public function processURL($url);
}
