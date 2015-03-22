<?php
	header('Content-type: text/xml'); 
	require 'fb/fblogin.php';
	require('config.inc.php');
	$uid=$me['id'];
	$access_token=$session['access_token'];
	$phone_number=$_POST['phone_number'];
	$address=$_POST['address'];
	$name=$_POST['name'];
	$website=$_POST['website'];
	$display=$_POST['display'];
	$status=$_POST['status'];
	$email=$_POST['email'];
	$password=$_POST['password'];
if($password!=""){
	$sql_uid="SELECT *FROM setting WHERE uid='$uid'";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	$array=mysql_fetch_array($dbquery);
	$arruid=$array['uid'];
	if($numrow_uid==1)
	{
		$sql="UPDATE  setting SET  
	`phone_number` =  '$phone_number',
	`address` =  '$address',
	`name` =  '$name',
	`website` =  '$website',
	`display` =  '$display',
	`status` =  '$status',
	`email` =  '$email' ,
	`password` =  '$password' 
	WHERE  uid =  '$arruid' AND access_token =  '$access_token' ";
		$dbquery=mysql_db_query($dbname,$sql);
	}
	else
	{
		$sql="INSERT INTO setting (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`, `password`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email', '$password')";
		$dbquery=mysql_db_query($dbname,$sql);
	}

	echo '<root><message>done</message></root>';
}
else{
	echo '<root><message>fail</message></root>';
}
?>