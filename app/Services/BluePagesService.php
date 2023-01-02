<?php

namespace App\Services;

use App\Services\Contracts\BluePagesServiceInterface;

class BluePagesService implements BluePagesServiceInterface
{
    private $bluepagesUrl;

    public function __construct($config)
    {
        $this->bluepagesUrl = $config['url'];
    }

    public function cleanupNotesid($notesId = ''){
		$sp = strpos(strtolower($notesId),'ocean');
		if($sp === FALSE){
			return self::cleanupIBMNotesid($notesId);
		} else {
			return self::cleanupOceanNotesid($notesId);
		}
	}

    public function cleanupIBMNotesid($notesid = ''){
		$stepOne =  str_ireplace('CN=','',str_replace('OU=','',str_replace('O=','',$notesid)));
		$location = strpos($stepOne,'@IBM');
		$cleanId = substr($stepOne,0,$location);
		// return $cleanId;
        return $notesid;
	}

	public function cleanupOceanNotesid($notesid = ''){
		$stepOne =  str_ireplace('CN=','',str_replace('OU=','',str_replace('O=','',$notesid)));
		$location = strpos($stepOne,'@Ocean');
		$cleanId = substr($stepOne,0,$location);
		// return $cleanId;
        return $notesid;
	}

    public function getDetailsFromIntranetId($intranetId = '')
    {
        if(empty($intranetId)){
            return FALSE;
        }
        set_time_limit(120);
        $url = $this->bluepagesUrl."?byInternetAddr=INTRANET_ID_HERE";
        $ch = curl_init ( str_replace('INTRANET_ID_HERE',urlencode($intranetId),$url) );
        return $this->processDetails($ch);
    }

    public function getDetailsFromNotesId($notesId = '')
    {
        if(empty($notesId)){
            return FALSE;
        }
        set_time_limit(120);
        $url = $this->bluepagesUrl."?allByNotesIDLite=NOTES_ID_HERE%25";

        $sp = strpos($notesId,'/O=IBM');

        if($sp != FALSE){
            $amendIbm2 = urlencode(trim($notesId));
        } else {
            $amendIbm = str_replace("/IBM","xxxxx",$notesId);
            $amendCC  = str_replace("/","/OU=",$amendIbm);
            $amendIbm2 = str_replace("xxxxx","/O=IBM",$amendCC);
            $amendIbm2 = "CN%3D" . urlencode($amendIbm2);
        }
        $ch = curl_init ( str_replace('NOTES_ID_HERE',$amendIbm2,$url) );
        return $this->processDetails($ch);
    }

    public function getNotesidFromIntranetId($intranetId = '')
    {
        $notesId = '';
        if(empty($intranetId)){
            return FALSE;
        }
        set_time_limit(120);
        $url = $this->bluepagesUrl."?byInternetAddr=INTRANET_ID_HERE";
        $ch = curl_init ( str_replace('INTRANET_ID_HERE',urlencode($intranetId),$url) );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $ret = curl_exec ( $ch );
        if (empty($ret)) {
            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            if (empty($info['http_code'])) {
                die("No HTTP code was returned");
            } else {
                // So Bluepages has processed our URL - What was the result.
                $bgapiRC  = substr($ret,0,1);
                if($bgapiRC!=0){
                    // Bluepages has NOT returned a ZERO - so there was a problem
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

        $pattern = "/# rc/";
        $results = preg_split ( $pattern, $ret );

        $pattern = "/[=,]/";
        $resultValues = preg_split ( $pattern, $results [1] );
        $size = $resultValues [3];
        $found = false;
        if ($resultValues [3] > 0) {
            $found = true;
            $pattern = "/[\n:]/";
            $matches = preg_split ( $pattern, $results [0] );
            for($cellOffset = 0; $cellOffset < count ( $matches ); $cellOffset ++) {
                $next = $cellOffset+1;
                switch ($matches [$cellOffset]) {
                    case 'CNUM' :
                    case 'INTERNET' :
                    case 'WORKLOC' :
                    case 'NAME' :
                    case 'HRACTIVE':
                    case 'HREMPLOYEETYPE':
                    case 'EMPTYPE':
                    case 'DEPT':
                    case 'HRFAMILYNAME':
                    case 'JOBRESPONSIB' :
                    case 'EMPNUM':
                    case 'EMPCC' :
                    case 'MGRNUM':
                    case 'MGRCC':
                        break;
                    case 'NOTESID':
                        $notesId = trim ( $matches [$cellOffset+1]);
                    default :
                        ;
                        break;
                }
            }
        } else {
            $found = FALSE;
        }

        if($found){
            return $this->cleanupNotesid($notesId);
        } else {
            return FALSE;
        }
    }

    public function validateNotesId($notesId = ''): bool
    {
        if(empty($notesId)){
            return FALSE;
        }
        set_time_limit(120);
        $url = $this->bluepagesUrl."?allByNotesIDLite=NOTES_ID_HERE%25";

        $sp = strpos($notesId,'/O=IBM');

        if($sp != FALSE){
            $amendIbm2 = urlencode(trim($notesId));
        } else {
            $amendIbm = str_replace("/IBM","xxxxx",$notesId);
            $amendCC  = str_replace("/","/OU=",$amendIbm);
            $amendIbm2 = str_replace("xxxxx","/O=IBM",$amendCC);
            $amendIbm2 = "CN%3D" . urlencode($amendIbm2);
        }
        $ch = curl_init ( str_replace('NOTES_ID_HERE',$amendIbm2,$url) );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $ret = curl_exec ( $ch );
        if (empty($ret)) {
            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            if (empty($info['http_code'])) {
                die("No HTTP code was returned");
            } else {
                // So Bluepages has processed our URL - What was the result.
                $bgapiRC  = substr($ret,0,1);
                if($bgapiRC!=0){
                    // Bluepages has NOT returned a ZERO - so there was a problem
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

        $pattern = "/# rc/";
        $results = preg_split ( $pattern, $ret );

        $pattern = "/[=,]/";
        $resultValues = preg_split ( $pattern, $results [1] );
        $size = $resultValues [3];
        $found = false;
        if ($resultValues [3] > 0) {
            $found = true;
            $pattern = "/[\n:]/";
            $matches = preg_split ( $pattern, $results [0] );
            for($cellOffset = 0; $cellOffset < count ( $matches ); $cellOffset ++) {
                switch ($matches [$cellOffset]) {
                    case 'CNUM' :
                    case 'INTERNET' :
                    case 'WORKLOC' :
                    case 'NAME' :
                    case 'HRACTIVE':
                    case 'HREMPLOYEETYPE':
                    case 'EMPTYPE':
                    case 'DEPT':
                    case 'HRFAMILYNAME':
                    case 'JOBRESPONSIB' :
                    case 'EMPNUM':
                    case 'EMPCC' :
                    case 'MGRNUM':
                    case 'MGRCC':
                    case 'NOTESID':
                    default :
                        ;
                        break;
                }
            }

        } else {
            $found = FALSE;
        }
        return $found;
    }

    public function getIntranetIdFromNotesId($notesId = '')
    {
        $notesId = strtoupper(trim($notesId));
        if(empty($notesId)){
            return FALSE;
        }
        set_time_limit(120);
        $url = $this->bluepagesUrl."?allByNotesIDLite=NOTES_ID_HERE%25";

        $sp = strpos($notesId,'/O=IBM');

        if($sp != FALSE){
            $amendIbm2 = urlencode(trim($notesId));
        } else {
            $amendIbm = str_replace("/IBM","xxxxx",$notesId);
            $amendCC  = str_replace("/","/OU=",$amendIbm);
            $amendIbm2 = str_replace("xxxxx","/O=IBM",$amendCC);
            $amendIbm2 = "CN%3D" . urlencode($amendIbm2);
        }
        $ch = curl_init ( str_replace('NOTES_ID_HERE',$amendIbm2,$url) );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $ret = curl_exec ( $ch );
        if (empty($ret)) {
            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            if (empty($info['http_code'])) {
                die("No HTTP code was returned");
            } else {
                // So Bluepages has processed our URL - What was the result.
                $bgapiRC  = substr($ret,0,1);
                if($bgapiRC!=0){
                    // Bluepages has NOT returned a ZERO - so there was a problem
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

        $pattern = "/# rc/";
        $results = preg_split ( $pattern, $ret );

        $pattern = "/[=,]/";
        $resultValues = preg_split ( $pattern, $results [1] );
        $size = $resultValues [3];
        $found = false;
        if ($resultValues [3] > 0) {
            $found = true;
            $pattern = "/[\n:]/";
            $matches = preg_split ( $pattern, $results [0] );
            for($cellOffset = 0; $cellOffset < count ( $matches ); $cellOffset ++) {
                switch ($matches [$cellOffset]) {
                    case 'CNUM' :
                    case 'WORKLOC' :
                    case 'NAME' :
                    case 'HRACTIVE':
                    case 'HREMPLOYEETYPE':
                    case 'EMPTYPE':
                    case 'DEPT':
                    case 'HRFAMILYNAME':
                    case 'JOBRESPONSIB' :
                    case 'EMPNUM':
                    case 'EMPCC' :
                    case 'MGRNUM':
                    case 'MGRCC':
                    case 'NOTESID':
                        break;
                    case 'INTERNET' :
                        $internetId = trim ( $matches [$cellOffset+1]);
                    default :
                        ;
                        break;
                }
            }

        } else {
            $found = FALSE;
        }
        if($found){
            return $internetId;
        } else {
            return FALSE;
        }
    }

    public function validateIntranetId($intranetId = ''): bool
    {
        if(empty($intranetId)){
            return FALSE;
        }
        set_time_limit(120);
        $url = $this->bluepagesUrl."?byInternetAddr=INTRANET_ID_HERE";
        $ch = curl_init ( str_replace('INTRANET_ID_HERE',urlencode($intranetId),$url) );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $ret = curl_exec ( $ch );
        if (empty($ret)) {
            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            if (empty($info['http_code'])) {
                die("No HTTP code was returned");
            } else {
                // So Bluepages has processed our URL - What was the result.
                $bgapiRC  = substr($ret,0,1);
                if($bgapiRC!=0){
                    // Bluepages has NOT returned a ZERO - so there was a problem
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

        $pattern = "/# rc/";
        $results = preg_split ( $pattern, $ret );

        $pattern = "/[=,]/";
        $resultValues = preg_split ( $pattern, $results [1] );
        $size = $resultValues [3];
        $found = false;
        if ($resultValues [3] > 0) {
            $found = true;
            $pattern = "/[\n:]/";
            $matches = preg_split ( $pattern, $results [0] );
            for($cellOffset = 0; $cellOffset < count ( $matches ); $cellOffset ++) {
                switch ($matches [$cellOffset]) {
                    case 'CNUM' :
                    case 'INTERNET' :
                    case 'WORKLOC' :
                    case 'NAME' :
                    case 'HRACTIVE':
                    case 'HREMPLOYEETYPE':
                    case 'EMPTYPE':
                    case 'DEPT':
                    case 'HRFAMILYNAME':
                    case 'JOBRESPONSIB' :
                    case 'EMPNUM':
                    case 'EMPCC' :
                    case 'MGRNUM':
                    case 'MGRCC':
                    case 'NOTESID':
                    default :
                        ;
                        break;
                }
            }

        } else {
            $found = FALSE;
        }
        return $found;
    }

    public function processDetails($ch)
    {
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $ret = curl_exec ( $ch );
        if (empty($ret)) {
            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            if (empty($info['http_code'])) {
                die("No HTTP code was returned");
            } else {
                // So Bluepages has processed our URL - What was the result.
                $bgapiRC  = substr($ret,0,1);
                if($bgapiRC!=0){
                    // Bluepages has NOT returned a ZERO - so there was a problem
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

        $pattern = "/# rc/";
        $results = preg_split ( $pattern, $ret );
        $pattern = "/[=,]/";
        $resultValues = preg_split ( $pattern, $results [1] );

        $size = $resultValues [3];
        $found = false;
        if ($resultValues [3] > 0) {
            $found = true;
            $pattern = "/[\n]/";
            $matches = preg_split ( $pattern, $results [0] );
            foreach($matches as $field){
                $subFields = explode(":", $field,2);
                if(isset($subFields[1])){
                    $details[$subFields[0]] = $subFields[1];
                }
            }
        } else {
            $found = FALSE;
        }

        if($found){
            return $details;
        } else {
            return FALSE;
        }
    }
}
