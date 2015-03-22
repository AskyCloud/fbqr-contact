<?php
	require 'fb/fblogin.php';
	require('config.inc.php');
	$uid=$me['id'];
	
	$res=$facebook->api('/me/photos'
			,'post',
			array('access_token' => $facebook->access_token
				,'source'=>'@'.'qrcode/tmp/'.$uid.'.png'
				,'message'=>'http://apps.facebook.com/fbqrcontact/'
				)
		);	
		
	$photoid=explode('.', sprintf('%f', $res['id']));
	$redirectUrl='http://www.facebook.com/photo.php?fbid='.$photoid[0];
	echo '<script type=\'text/javascript\'>top.location.href =\''.$redirectUrl.'\';</script>';
	die();
?>
<?
require 'fb/fblogin.php';
require('config.inc.php');
$uid=$_REQUEST['uid'];
$target=$_REQUEST['target'];

$filename ='qrcode/tmp/'.$uid.'.png';
$handle = fopen($filename, "r");
$data = fread($handle, filesize($filename));

// $data is file data
$pvars   = array('image' => base64_encode($data), 'key' => '3d6c85d8b6c6bec7673c0a842d115c14');
$timeout = 30;
$curl    = curl_init();

curl_setopt($curl, CURLOPT_URL, 'http://api.imgur.com/2/upload.json');
curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);

$xml = curl_exec($curl);
curl_close ($curl);
$res= json_decode($xml , true);
/*echo "<pre>";
print_r($res);
echo "</pre>";*/
$photoUrl = $res['upload']['links']['original'];
//echo $photoUrl;
$resPost=$facebook->api("/$target/feed/"
		,'post',
		array('access_token' => $facebook->access_token
			,'picture'=> $photoUrl
			,'link' => $photoUrl
			,'caption' =>'FbQR Contact'
			,'description'=>'more detial see at http://apps.facebook.com/fbqrcontact/'
			,'name'=>'FbQR Contact'
			,'message'=>'use this with FbQR Contact to add my phone number'
			)
	);	
$redirectUrl='http://www.facebook.com/profile.php?id='.$target;
echo '<script type=\'text/javascript\'>top.location.href =\''.$redirectUrl.'\';</script>';

?>