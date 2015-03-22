<?php
	require('../fb/facebook.php');
	require('config.inc.php');
	$from=$_REQUEST['from'];
	$access_token=$_POST['access_token'];
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	));
	$token =  array('access_token' => $access_token,);
	$userdata = $facebook->api('/me', 'GET', $token);
	$uid=$userdata['id'];
	$phone_number=$_POST['phone_number'];
	$address=$_POST['address'];
	$name=$_POST['name'];
	$website=$_POST['website'];
	$display=$_POST['display'];
	$status=$_POST['status'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	
if($from=="step2"){
echo "<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\" />";
	if($password==""){
			echo "<center>
			<h3>Please fill your password protection.</h3><br>
			<META HTTP-EQUIV=Refresh CONTENT=3;URL=\"step2.php?access_token=$access_token\">
			</center>";
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
				$dbquery=mysql_db_query($dbname,$sql);
			}
			else
			{
				$sql="INSERT INTO setting (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`, `password`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email', '$password')";
				$dbquery=mysql_db_query($dbname,$sql);
			}
		echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL=\"step3.php?access_token=$access_token\">";
	}
}
else{
	header('Content-type: text/xml'); 
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
		WHERE  uid =  '$arruid'";
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
}
?>