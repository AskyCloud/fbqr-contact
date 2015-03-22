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
	$datetime=date("Y-m-d H:i:s");
	$from=$_REQUEST['from'];
	$sync=0;
	if($_POST['sync_name_facebook']=="on")
		$sync+=1;
	if($_POST['sync_website_facebook']=="on")
		$sync+=10;
	if($_POST['sync_display_facebook']=="on")
		$sync+=100;
	if($_POST['sync_status_facebook']=="on")
		$sync+=1000;
$sql_uid="SELECT *FROM profiles WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
$arruid=$array['uid'];
/*
function addData($numrow_uid,$access_token,$phone_number,$address,$name,$website,$display,$status,$email,$datetime,$sync,$arruid){
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
		`email` =  '$email' ,
		`last_update` = '$datetime' ,
		`sync` = '$sync'
		WHERE  uid =  '$arruid' ";
		$dbquery=mysql_db_query($dbname,$sql);
	}
	else
	{
		$sql="INSERT INTO `tkroputa_db`.`profiles` (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`, `last_update`, `sync`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email', '$datetime', '$sync')";
		$dbquery=mysql_db_query($dbname,$sql);
	}
}
*/
if($from=="step1"){
	echo "<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\" />";
	if($phone_number=="")
		echo "<center><h1>Please fill your phone number.</h1><br>
			<div id=back><a href=javascript:history.back(1)>BACK</a></div></center>";
	else{
				if($numrow_uid==1)
				{
					$sql="UPDATE  `tkroputa_db`.`profiles` SET
					`phone_number` =  '$phone_number',
					`address` =  '$address',
					`name` =  '$name',
					`website` =  '$website',
					`display` =  '$display',
					`status` =  '$status',
					`email` =  '$email' ,
					`last_update` = '$datetime' ,
					`sync` = '$sync'
					WHERE  uid =  '$arruid' ";
					$dbquery=mysql_db_query($dbname,$sql);
				}
				else
				{
					$sql="INSERT INTO `tkroputa_db`.`profiles` (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`, `last_update`, `sync`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email', '$datetime', '$sync')";
					$dbquery=mysql_db_query($dbname,$sql);
				}

		echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL=\"step2.php\">";
	}
}
else{
	header('Content-type: text/xml'); 
	if($phone_number!=""){
			if($numrow_uid==1)
			{
				$sql="UPDATE  `tkroputa_db`.`profiles` SET  
				`phone_number` =  '$phone_number',
				`address` =  '$address',
				`name` =  '$name',
				`website` =  '$website',
				`display` =  '$display',
				`status` =  '$status',
				`email` =  '$email' ,
				`last_update` = '$datetime' ,
				`sync` = '$sync'
				WHERE  uid =  '$arruid' ";
				$dbquery=mysql_db_query($dbname,$sql);
			}
			else
			{
				$sql="INSERT INTO `tkroputa_db`.`profiles` (`uid`, `access_token`, `phone_number`, `address`, `name`, `website`, `display`, `status`, `email`, `last_update`, `sync`) VALUES ('$uid', '$access_token', '$phone_number', '$address', '$name', '$website', '$display', '$status', '$email', '$datetime', '$sync')";
				$dbquery=mysql_db_query($dbname,$sql);
			}
	echo '<root><message>done</message></root>';
	}
	else{
	echo '<root><message>fail</message></root>';
	}
}
?>