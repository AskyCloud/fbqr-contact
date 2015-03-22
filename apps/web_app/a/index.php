<?php
require('../fb/facebook.php');
require 'config.inc.php';

	$access_token=$_REQUEST['access_token'];
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	));
	$token =  array('access_token' => $access_token,);
	$userdata = $facebook->api('/me', 'GET', $token);
	$uid=$userdata['id'];
$sql_uid="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$uid' AND `setting`.`uid`='$uid';";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
	if($numrow_uid ==0){
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=step1.php?access_token=$access_token\">";
		//header("Location: $STEPURL");
	}
	else{
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php?access_token=$access_token\">";
		//header("Location: $NORMALURL");
	}
?>