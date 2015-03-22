<?php
//include_once 'fb/fblogin.php';
include_once 'config.inc.php';
include_once('includes/config.inc.php');
include_once('includes/functions.inc.php');

if(!$_REQUEST['session']){
	$loginUrl=$facebook->getLoginUrl(array(
			'canvas'=>1,
			'fbconnect'=>0,
			'display'=>'page',
			'next'=>$fbconfig['canvas_url'],
			'cancel_url'=>'http://www.facebook.com/',
			'req_perms'=>'offline_access,email,user_status,user_website,user_birthday,user_location,read_stream,user_hometown,publish_stream,friends_birthday,friends_status,friends_hometown,friends_location,friends_website,user_photos,friends_photos,user_groups',
			));
		echo '<script type=\'text/javascript\'>top.location.href =\''.$loginUrl.'\';</script>';
} 
try {
	$me = $facebook->api('/me');
}
catch (FacebookApiException $e) {
	error_log($e);
}
$uid=$me['id'];
$access_token=$session['access_token'];
$sql_uid="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$uid' AND `setting`.`uid`='$uid';";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
//function///////////////////////////////////////////////////////////////////////////////////
 function ismobile() {
    $is_mobile = '0'; 

    if(preg_match('/(android|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $is_mobile=1;
    }

    if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $is_mobile=1;
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));    $mobile_agents = array('w3c ','acs-','alav','alca','amoi','andr','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');

    if(in_array($mobile_ua,$mobile_agents)) {
        $is_mobile=1;
    }

    if (isset($_SERVER['ALL_HTTP'])) {
        if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
            $is_mobile=1;
        }
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
        $is_mobile=0;
    }

    return $is_mobile;
}

function isiphone($useragent) {
    $iphone=0;
    if (preg_match('/iphone/',strtolower($useragent))) {
        $iphone=1;
    }
    return $iphone;
}

function isipad($useragent) {
    $ipad=0;
    if (preg_match('/ipad/',strtolower($useragent))) {
        $ipad=1;
    }
    return $ipad;
}
//function///////////////////////////////////////////////////////////////////////////////////

$useragent=$_SERVER['HTTP_USER_AGENT'];
if (ismobile($useragent)) {
    if (isipad($_SERVER['HTTP_USER_AGENT'])) {
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$IPADURL\">";  
        //header("Location: $IPADURL");
    } else {
        if (isiphone($_SERVER['HTTP_USER_AGENT'])) {
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$IPHONEURL\">";            
			//header("Location: $IPHONEURL");
        } else {
			echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$MOBILEURL\">";            
			//header("Location: $MOBILEURL");
        }
    }
} else {
	if($numrow_uid ==0){
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$STEPURL\">";

		//header("Location: $STEPURL");
	}
	else{
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$NORMALURL\">";

		//header("Location: $NORMALURL");
	}
}

?>