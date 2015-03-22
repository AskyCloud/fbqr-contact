<?php

header('Content-type: text/xml'); 

$uid=$_POST['uid'];
$access_token=$_POST['access_token'];
if($uid==""){
	echo '<root><stat>no uid</stat></root>';
	die;
}
//echo $uid;

require('config.inc.php');
$sql_uid="SELECT *FROM profiles WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);



if($numrow_uid==1){
	$array=mysql_fetch_array($dbquery);
	$phone_number=$array['phone_number'];
	$address=$array['address'];
	$name=$array['name'];
	$website=$array['website'];
	$display=$array['display'];
	$status=$array['status'];
	$email=$array['email'];
	
	$search= "
";
	$address=str_replace($search,"\n",$address);
	$status=str_replace($search,"\n",$status);
	
	$data=NULL;
	
	//count data
	$i=0;
	if($_POST['name_bool']=="TRUE") $i++;
	if($_POST['phone_number_bool']=="TRUE") $i++;
	if($_POST['address_bool']=="TRUE") $i++;
	if($_POST['website_bool']=="TRUE") $i++;
	if($_POST['display_bool']=="TRUE") $i++;
	if($_POST['status_bool']=="TRUE") $i++;
	if($_POST['email_bool']=="TRUE") $i++;

	if($i>=1){
		//use MECARD format
		$data="MECARD:".$data;
		if($_POST['name_bool']=="TRUE")
			$data.='N:'.$name.';';
		if($_POST['phone_number_bool']=="TRUE")
			$data.='TEL:'.$phone_number.';';
		if($_POST['address_bool']=="TRUE")
			$data.='ADR:'.$address.';';
		if($_POST['website_bool']=="TRUE")
			$data.='URL:'.$website.';';
		/*if($_POST['display_bool']=="TRUE")
			$data.='N:'.$display.';';*/
		if($_POST['status_bool']=="TRUE") 
			$data.='NOTE:'.$status.';';
		if($_POST['email_bool']=="TRUE")
			$data.='EMAIL:'.$email.';';
		$data.='UID:'.$uid.';';
		
	}else{
		/*
		//use single format
		if($_POST['name_bool']=="TRUE")
			$data.=$name;
		else if($_POST['phone_number_bool']=="TRUE")
			$data.='tel:'.$phone_number;
		else if($_POST['address_bool']=="TRUE")
			$data.=$address;
		else if($_POST['website_bool']=="TRUE")
			$data.=$website;
		/*else if($_POST['display_bool']=="TRUE")
			$data.=$display;
		else if($_POST['status_bool']=="TRUE") 
			$data.=$status;
		else if($_POST['email_bool']=="TRUE")
			$data.='mailto:'.$email;
		*/
	}
	
	$size=NULL;
	switch($_POST['size']){
		case 'M':{
			$size=230;
			break;
		}
		case 'L':{
			$size=350;
			break;
		}
		case 'XL':{
			$size=480;
			break;
		}
		default: $size=350;
	}
	
	
	if($data!=NULL){		
		//$data=$me['email'];
		//$QR='http://chart.apis.google.com/chart?cht=qr&chs=500x500&choe=UTF-8&chld=H&chl='.$data;
		//echo "<img src=\"".$QR."\">"	
		$ch = curl_init();    
		curl_setopt($ch, CURLOPT_URL,"http://fbqr.tkroputa.in.th/qrcode/createqr.php?");  
		curl_setopt($ch, CURLOPT_POST, TRUE); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'data='.$data.'&size='.$size.'&uid='.$uid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result=curl_exec ($ch);     
		curl_close ($ch); 
		$base64=base64_encode($result);
		
		echo '<root><stat>done</stat><img>'.$base64.'</img><uid>'.$uid.'</uid></root>';
		exit;
	}
	else{
		echo '<root><stat>none</stat></root>';
		exit;
	}
}
echo '<root><stat>fail</stat></root>';
?>