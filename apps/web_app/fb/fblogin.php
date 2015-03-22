<?php

require 'facebook.php';
require './config.inc.php';
require 'fb-authentication.php';

header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

$facebook = new Facebook(array(
 'appId'  => $fbconfig['appid'],
 'secret' => $fbconfig['secret'],
 'cookie' => true,
 'fileUpload' => true,
  ));
  
  
$session = $facebook->getSession();

if (!$session) {
	echo RequestforPermission($fbconfig['canvas_url']);
}
else {	//got session
	//$session['id']!=
	$loginUrl=$facebook->getLoginStatusUrl();  
	//echo '<script type=\'text/javascript\'>top.location.href =\''.$loginUrl.'\';</script>';
	try {
		$me = $facebook->api('/me');
		/*
		echo "<img src=\"https://graph.facebook.com/".$me['id']."/picture\">";
		echo $me['name'];
		echo "<br>";*/
	}
	catch (FacebookApiException $e) {
		error_log($e);
	}
}
?>