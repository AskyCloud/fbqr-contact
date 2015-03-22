<?php
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
	$datetime=date("Y-m-d H:i:s");
	$from=$_REQUEST['from'];

$sql_uid="SELECT *FROM setting WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
$arruid=$array['uid'];

if($from=="step2"){
echo "<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\" />";
	if($password==""){
			echo "<center>
			<h1>Please fill your password protection.</h1><br>
			<div id=back><a href=javascript:history.back(1)>BACK</a></div></center>";
	}
	else{
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
			WHERE  uid =  '$arruid'";	

			}
			else
			{
				$sql="INSERT INTO setting (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`, `password`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email', '$password')";
			}
			$dbquery=mysql_db_query($dbname,$sql);
		echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL=\"step3.php\">";
	}
	
}
else{
	//header('Content-type: text/xml'); 
	if($password!=""){
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
		WHERE  uid =  '$uid'";
		}
		else
		{
			$sql="INSERT INTO setting (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`, `password`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email', '$password')";

		}
		$dbquery=mysql_db_query($dbname,$sql);
		echo '<root><message>done</message></root>';
	}
	else{
		echo '<root><message>fail</message></root>';
	}
}
?>