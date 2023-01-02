<?php

namespace App\Services;

use App\Facades\BlueGroups;
use App\Services\Contracts\BlueGroupsManageServiceInterface;

/*
 *  Handles Blue Groups.
 */
class BlueGroupsManageExtService implements BlueGroupsManageServiceInterface
{
	/*
	*	-------------------------------------------------------------------------------------------------------------------------
	* 	BlueGroups XML API
	*	-------------------------------------------------------------------------------------------------------------------------
	*/
    private $username;
    private $password;

    private $bluegroupsUrl;
    private $bluegroupsProtectedUrl;

    public function __construct($config)
    {
        $this->username = $config['username'];
        $this->password = $config['password'];

        $this->bluegroupsUrl = $config['url'];
        $this->bluegroupsProtectedUrl = $config['protectedUrl'];
    }

	public function createCurl($agent='ITDQ'){
		// create a new cURL resource
		$ch = curl_init();
//		curl_setopt($ch, CURLOPT_HEADER,         1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//		curl_setopt($ch, CURLOPT_TIMEOUT,        240);
//		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240);
//		curl_setopt($ch, CURLOPT_USERAGENT,      $agent);
//		curl_setopt($ch, CURLOPT_CAINFO,        '/cecert/cacert.pem');
//		curl_setopt($ch, CURLOPT_CAINFO,        '/usr/local/zendsvr6/share/curl/cacert.pem');
//		curl_setopt($ch, CURLOPT_HTTPAUTH,        CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_HEADER,        FALSE);
// 		$userpwd = $_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW'];
// 		$ret = curl_setopt($ch, CURLOPT_USERPWD,        $userpwd);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username.":".$this->password);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		return $ch;
	}

    private function getBgResponseXML($url){
	    $ch = $this->createCurl();

	    curl_setopt($ch, CURLOPT_URL, $url);

        $ret = curl_exec($ch);
        if (empty($ret)) {
            // some kind of an error happened
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
                    echo "<H3>Error processing Bluegroup URL </H3>";
                    echo "<H2>Please take a screen print of this page and send to the ITDQ Team ASAP.</H2>";
                    echo "<BR>URL<BR>";
                    print_r($url);
                    echo "<BR>Info<BR>";
                    print_r($info);
                    echo "<BR>";
                    exit ("<B>Unsuccessful RC: $ret</B>");
                } else {
                    return $ret;
                }
	        }
	    }
	}

	private function validateBgXMLResponseXML($xml){
		$request = $xml->request;
		$returnCode = $xml->rc;
		$message = $xml->msg;
		switch($returnCode) {
			case "0":
				return true;
				break;
			case "1":
			case "2":
			case "3":
			case "4":
			case "5":
			case "6":
			case "7":
			case "8":
			case "9":
				throw new \Exception('An error during BlueGroups Update API (XML API) lookup has occured ' . $message . '[' . $request . ', ' . $returnCode . ']');
				return false;
				break;
			default:
				return false;
				break;
		}
	}

	public function inAGroup($groupName, $ssoEmail, $depth=1){
		$url = $this->bluegroupsUrl."?task=inAGroup&email=" . urlencode($ssoEmail) . "&group=" . urlencode($groupName) . "&depth=" . urlencode($depth);
		$myXMLData =  $this->getBgResponseXML($url);
		$xml=simplexml_load_string($myXMLData);
		if ($this->validateBgXMLResponseXML($xml) === true) {
			return get_object_vars($xml)['msg']=='Success';
        }
        return false;
	}

	public function inAllGroups($groupName, $ssoEmail, $depth=1){
		$url = $this->bluegroupsUrl."?task=inAllGroups&email=" . urlencode($ssoEmail) . "&group=" . urlencode($groupName) . "&depth=" . urlencode($depth);
		$myXMLData =  $this->getBgResponseXML($url);
		$xml=simplexml_load_string($myXMLData);
		if ($this->validateBgXMLResponseXML($xml) === true) {
			return get_object_vars($xml)['msg']=='Success';
        }
        return false;
	}

	public function inAnyGroup($groupName, $ssoEmail, $depth=1){
		$url = $this->bluegroupsUrl."?task=inAnyGroup&email=" . urlencode($ssoEmail) . "&group=" . urlencode($groupName) . "&depth=" . urlencode($depth);
		$myXMLData =  $this->getBgResponseXML($url);
		$xml=simplexml_load_string($myXMLData);
		if ($this->validateBgXMLResponseXML($xml) === true) {
			return get_object_vars($xml)['msg']=='Success';
        }
        return false;
	}

	public function listMembers($groupName, $depth=1){
		$url = $this->bluegroupsUrl."?task=listMembers&group=" . urlencode($groupName) . "&depth=" . urlencode($depth);
		$myXMLData =  $this->getBgResponseXML($url);
		$xml=simplexml_load_string($myXMLData);
		if ($this->validateBgXMLResponseXML($xml) === true) {
			return get_object_vars($xml)['member'];
		}
        return array();
	}

	/*
	*	-------------------------------------------------------------------------------------------------------------------------
	* 	BlueGroups Update API (HTTPS API)
	*	-------------------------------------------------------------------------------------------------------------------------
	*/
    public function getUID($email){
		$record = array();
		$attr = array();
		$attr[]='uid';
		$search="(mail=$email)";
		if (! $record = BlueGroups::bluepagesSearch($search, $attr) ) {
			exit("This should be impossible - but we've not found $email in Bluepages, so have to fail");
		} else {
            $user_dn = current($record);
			$ownerUID=$user_dn['uid'][0];
            if(!isset($ownerUID)){
				print_r($user_dn);
				exit("<BR>Email address provided has no UID in Bluepages.");
			}
		}

   	 	return $ownerUID;
	}

	private function validateBgHTTPSResponse($response){

		$returnCode  = substr($response,0,1);
		$returnMessage = substr($response,2);

		switch($returnCode) {
			case "0":
				// Success
				return true;
				break;
			case "1":
				$message = 'Not authorized';
				throw new \Exception('An error during BlueGroups Update API (HTTPS API) lookup has occured ' . $message . ' [' . $returnMessage . ',' . $returnCode . ']');
				break;
			case "2":
				$message = 'No record found';
				throw new \Exception('An error during BlueGroups Update API (HTTPS API) lookup has occured ' . $message . ' [' . $returnMessage . ',' . $returnCode . ']');
				break;
			case "3":
				$message = 'No member were specified for add/delete';
				throw new \Exception('An error during BlueGroups Update API (HTTPS API) lookup has occured ' . $message . ' [' . $returnMessage . ',' . $returnCode . ']');
				break;
			case "4":
				$message = 'Error occurred while performing function';
				throw new \Exception('An error during BlueGroups Update API (HTTPS API) lookup has occured ' . $message . ' [' . $returnMessage . ',' . $returnCode . ']');
				break;
			case "5":
				$message = 'An unexpected error occurred';
				throw new \Exception('An error during BlueGroups Update API (HTTPS API) lookup has occured ' . $message . ' [' . $returnMessage . ',' . $returnCode . ']');
				break;
			default:
				return false;
				break;
		}
    }

    public function processURL($url, $trace = false){
		$ch = $this->createCurl();
		foreach($url as $function => $BGurl){
            if ($trace) {
                echo "<BR>Processing $function.";
			    echo "URL:" . $BGurl;
            }
			$ret = curl_setopt($ch, CURLOPT_URL, $BGurl);
			$ret = curl_exec($ch);
			if (empty($ret)) {
				// some kind of an error happened
   		 		die(curl_error($ch));
   		 		curl_close($ch); // close cURL handler
			} else {
   				$info = curl_getinfo($ch);
   			 	if (empty($info['http_code'])) {
   		     	    die("No HTTP code was returned");
   		 		} else {
   		 			// So Bluegroups has processed our URL - What was the result.
					try {
						if ($this->validateBgHTTPSResponse($ret) === true) {
							sleep(1); // Give BG a chance to process the request.
							return true;
						} else {
							// Bluegroups has NOT returned a ZERO - so there was a problem
                            if ($trace) {
                                echo "<H3>Error processing Bluegroup URL </H3>";
                                echo "<H2>Please take a screen print of this page and send to the ITDQ Team ASAP.</H2>";
                                echo "<BR>URL<BR>";
                                print_r($url);
                                echo "<BR>Info<BR>";
                                print_r($info);
                                echo "<BR>";
                            }
							exit ("<B>Unsuccessful RC: $ret</B>");
						}

					} catch (\Exception $e) {
						echo 'Caught exception: ',  $e->getMessage(), "\n";
						return false;
					}
   		 		}
			}
		}
	}

	public function defineGroup($groupName ,$description, $life=1){
		$nextyear = time() + ((365*24*60*60) * $life);
		$yyyy = date("Y",$nextyear);
		$mm   = date("m",$nextyear);
		$dd   = date("d",$nextyear);
		$url = array();
		$url['Define_Group'] = $this->bluegroupsProtectedUrl."?task=GoNew&selectOn=" . urlencode($groupName) . "&gDesc=" . urlencode($description) . "&mode=members&vAcc=Owner/Admins&Y=$yyyy&M=$mm&D=$dd&API=1";
		$this->processURL($url);
	}

	public function deleteGroup($groupName){
		$url = array();
		$url['Delete_Group'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=GoDel&API=1";
		$this->processURL($url);
	}

	public function addMember($groupName, $memberEmail){
		$memberUID = $this->getUID($memberEmail);
		$url = array();
		$url['Add_Member'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=Members&mebox=" . urlencode($memberUID) . "&Select=Add+Members&API=1";
		$this->processURL($url);
	}

	public function deleteMember($groupName, $memberEmail){
		$memberUID = $this->getUID($memberEmail);
        $url = array();
		$url['Delete_Member'] = $this->bluegroupsProtectedUrl."?Delete=Delete+Checked&gName=" . urlencode($groupName) . "&task=DelMem&mebox=" . urlencode($memberUID) . "&API=1";
		$this->processURL($url);
	}

	public function addAdministrator($groupName, $memberEmail){
		$memberUID = $this->getUID($memberEmail);
		$url = array();
		$url['Add_Administrator'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=Administrators&mebox=" . urlencode($memberUID) . "&Submit=Add+Administrators&API=1";
		$this->processURL($url);
	}

	public function deleteAdministrator($groupName, $memberEmail){
		$memberUID = $this->getUID($memberEmail);
		$url = array();
		$url['Delete_Administrator'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=DelAdm&mebox=" . urlencode($memberUID) . "&API=1";
		$this->processURL($url);
	}

	public function addSubgroup($groupName, $subGroupName){
		$url = array();
		$url['Add_Subgroup'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=Members&mgbox=" . urlencode($subGroupName) . "&Select=Add+Members&API=1";
		$this->processURL($url);
	}

	public function deleteSubgroup($groupName, $subGroupName){
		$url = array();
		$url['Delete_Subgroup'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=DelMem&mgbox=" . urlencode($subGroupName) . "&Delete=Delete+Checked&API=1";
		$this->processURL($url);
	}

	public function changeOwner($groupName, $memberEmail){
		$memberUID = $this->getUID($memberEmail);
		$url = array();
		$url['Change Owner'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=GoCO&mebox=" . urlencode($memberUID) . "&API=1";
		$this->processURL($url);
	}

	public function changeFilter($groupName, $ldapFilter){
		$url = array();
		$url['Change Filter'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=GoCf&ldapfilter=" . urlencode($ldapFilter) . "&Save=ldapfilter&API=1";
		$this->processURL($url);
	}

	public function changeCharacteristics($groupName, $newGroupName = null, $newGroupDescription = null, $viewAccess = null, $newExpYear = null, $newExpMonth = null, $newExpDay = null){
		$params = '';
		if (!is_null($newGroupName)){
			$params .= "&selectOn=" . urlencode($newGroupName);
		}
		if (!is_null($newGroupDescription)){
			$params .= "&gDesc=" . urlencode($newGroupDescription);
		}
		if (!is_null($viewAccess)){
			// Everyone, Owner/Admins
			$params .= "&vAcc=" . urlencode($viewAccess);
		}
		if (!is_null($newExpYear) && !is_null($newExpMonth) && !is_null($newExpDay)){
			$params .= "&Y=" . urlencode($newExpYear);
			$params .= "&M=" . urlencode($newExpMonth);
			$params .= "&D=" . urlencode($newExpDay);
		}
		$url = array();
		$url['Change Characteristics'] = $this->bluegroupsProtectedUrl."?gName=" . urlencode($groupName) . "&task=GoCc" . $params . "&API=1";
		$this->processURL($url);
	}
}
?>
