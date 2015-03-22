<?php

require 'fb/fblogin.php';
$uid=$me['id'];
$access_token=$session['access_token'];

require('config.inc.php');

$sql_uid="DELETE profile, setting FROM profile INNER JOIN setting WHERE profile.id=setting.id;";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
$arruid=$array['uid'];

if($numrow_uid==1)
{
	$sql="UPDATE  `tkroputa_db`.`profiles` SET  
	`access_token` = '$access_token',
	`phone_number` =  '$phone_number',
	`address` =  '$address',
	`name` =  '$name',
	`website` =  '$website',
	`display` =  '$display',
	`status` =  '$status',
	`email` =  '$email' 
	WHERE  uid =  '$arruid' ";
	$dbquery=mysql_db_query($dbname,$sql);
}
else
{
	$sql="INSERT INTO `tkroputa_db`.`profiles` (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email')";
	$dbquery=mysql_db_query($dbname,$sql);
}
header('Content-type: text/xml'); 
echo '<root><message>done</message></root>';
?>