<?php

require 'fb/facebook.php';
require 'config.inc.php';

/*if($_REQUEST['session']){
	$Url=$fbconfig['canvas_url'].'main.php';
	echo '<script type=\'text/javascript\'>top.location.href =\''.$Url.'\';</script>';
}else{*/
	header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

	$facebook = new Facebook(array(
	 'appId'  => $fbconfig['appid'],
	 'secret' => $fbconfig['secret'],
	 'cookie' => true,
	 'fileUpload' => true,
	  ));
	  
	  
	$session = $facebook->getSession();
	if (!$session) {
		$Url=$fbconfig['canvas_url'].'manual/index.php';
		echo '<script type=\'text/javascript\'>top.location.href =\''.$Url.'\';</script>';
	}
	else {	
		require 'redirect.php';
		//$Url=$fbconfig['canvas_url'].'redirect.php';
		//echo '<script type=\'text/javascript\'>top.location.href =\''.$Url.'\';</script>';
	}
//}
?>