<?php

namespace App\Services;

use App\Facades\BlueGroups;
use App\Services\Contracts\BlueGroupsManageServiceInterface;

class BlueGroupsManageService implements BlueGroupsManageServiceInterface
{
    private $bluegroupsUrl;

    public function __construct($config)
    {
        $this->bluegroupsUrl = $config['url'];
    }

    public function defineGroup($groupName, $description, $life=1){
        $nextyear = time() + ((350*24*60*60) * $life);
        $yyyy = date("Y",$nextyear);
        $mm   = date("m",$nextyear);
        $dd   = date("d",$nextyear);
        $url = array();
        $url['Define_Group'] = $this->bluegroupsUrl."?task=GoNew&selectOn=" . urlencode($groupName) . "&gDesc=" . urlencode($description) . "&mode=members&vAcc=Owner/Admins&Y=$yyyy&M=$mm&D=$dd&API=1";
        $this->processURL($url);
    }

    public function deleteMember($groupName, $memberEmail){
        $memberUID = $this->getUID($memberEmail);
        $url['Delete_Member'] = $this->bluegroupsUrl."?Delete=Delete+Checked&gName=" . urlencode($groupName) . "&task=DelMem&mebox=" . urlencode($memberUID) . "&API=1";
        $this->processURL($url);
    }

    public function addMember($groupName, $memberEmail){
        $memberUID = $this->getUID($memberEmail);

        $url['Add_Member'] = $this->bluegroupsUrl."?gName=" . urlencode($groupName) . "&task=Members&mebox=" . urlencode($memberUID) . "&Select=Add+Members&API=1";
        $this->processURL($url);
    }

    public function addAdministrator($groupName, $memberEmail){
        $memberUID = $this->getUID($memberEmail);
        $url['Add_Administrator'] = $this->bluegroupsUrl."?gName=" . urlencode($groupName) . "&task=Administrators&mebox=" . urlencode($memberUID) . "&Submit=Add+Administrators&API=1 ";
        $this->processURL($url);
    }

    public function getUID($email){
        $record = array();
        $attr = array();
        $groups = array();
        $attr[]='uid';
        $search="(mail=$email)";
        if (! $record = BlueGroups::bluepagesSearch($search, $attr) ) {
            exit("This should be impossible - but we've not found $email in Bluepages, so have to fail");
        } else {
            $user_dn = current($record);
            $OwnerUID=$user_dn['uid'];
            if(!isset($OwnerUID)){
                exit("<BR>Email address provided has no UID in Bluepages.");
            }
        }

        return $OwnerUID;
    }

    public function createCurl($agent='SOIWAPI'){
        // create a new cURL resource
        $ch = curl_init();
        $ret = curl_setopt($ch, CURLOPT_HEADER,         1);
        $ret = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_setopt($ch, CURLOPT_TIMEOUT,        240);
        $ret = curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240);
        $ret = curl_setopt($ch, CURLOPT_USERAGENT,      $agent);
        $ret = curl_setopt($ch, CURLOPT_CAINFO,        '/usr/local/zendsvr6/share/curl/cacert.pem');
        $ret = curl_setopt($ch, CURLOPT_HTTPAUTH,        CURLAUTH_BASIC);
        $ret = curl_setopt($ch, CURLOPT_HEADER,        FALSE);
        $userpwd = $_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW'];
        $ret = curl_setopt($ch, CURLOPT_USERPWD,        $userpwd);
        return $ch;
    }

    public function processURL($url){
        $ch = $this->createCurl();
        foreach($url as $function => $BGurl){
            $ret = curl_setopt($ch, CURLOPT_URL, $BGurl);
            $ret = curl_exec($ch);
            if (empty($ret)) {
                //     some kind of an error happened
                die(curl_error($ch));
                curl_close($ch); // close cURL handler
            } else {
                $info = curl_getinfo($ch);
                if (empty($info['http_code'])) {
                    die("No HTTP code was returned");
                } else {
                    // So Bluegroups has processed our URL - What was the result.
                    $bgapiRC  = substr($ret,0,1);
                    if($bgapiRC!=0){
                        // Bluegroups has NOT returned a ZERO - so there was a problem
                        // echo "<H3>Error processing Bluegroup URL </H3>";
                        // echo "<H2>Please take a screen print of this page and send to the ITDQ Team ASAP.</H2>";
                        // echo "<BR>URL<BR>";
                        // print_r($url);
                        // echo "<BR>Info<BR>";
                        // print_r($info);
                        // echo "<BR>";
                        exit ("<B>Unsuccessful RC: $ret</B>");
                    } else {
                        // echo " Successful RC: $ret";
                        sleep(1); // Give BG a chance to process the request.
                    }
                }
            }
        }
    }
}
