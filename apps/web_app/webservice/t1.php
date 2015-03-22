<?php
require_once('nusoap.php');
$wsdl="http://tkroputa.in.th/fbqr/webservice/t2_server.php";
$server->soap_defencoding = 'utf-8'; 
$client = new nusoap_client($wsdl);

$uid1=array("100001036241534","100000925243158");
//$password=array("1234","1234");
//$access_token="146472442045328|c01bd0d9a3083974f876ba9e-100000925243158|ZBeUd36wcM3naVv5N0j8dQmp0_A"; //Teerasak
$access_token="146472442045328|9b40c5171d942e9fb90245e2-1363051741|VCdTye9vg8ujFuH9mfhPHGCl3D0"; //um
//$access_token="146472442045328|5fea5c79c96038bb9bc31565-100001233200691|KyH2DgYs9Fz0KJ9Zpc1pTs2EkLY"; //บอท เทสเตอร์

//$access_token="146472442045328|9a1539a6f439129dd1bfcefc-100001036241534|Kt0yqXSqT_AhSpLD65uyVjTR2tw"; //patompong
$qrid="17";
$password="";
$gid="177648985606389";


/*$res=$client->call(
	'show2',
	array('uid'=>$uid1),
	'uri:t2',
	'uri:t2/show2');
	print_r($res);
	echo "<br>";
	for($i=0;$i<count($res);$i++){
		echo $res[$i]."<br>";
	}*/
		  //FriendInfo
	/*$res=$client->call(
		'getFriendInfoBypass',
		array('uidFr'=>$uid1,'access_token'=>$access_token,'password_in'=>$password),
		'uri:t2',
		'uri:t2/getFriendInfoBypass');*/

		
	
	/*$res=$client->call(
		'getPhoneBook',
		array('access_token'=>$access_token),
		'uri:t2',
		'uri:t2/getPhoneBook');*/
		
	//getMulti
	/*$res=$client->call(
	'getMulti',
	array('qrid'=>$qrid,'access_token'=>$access_token,'password_in'=>$password),
	'uri:t2',
	'uri:t2/getMulti');*/
	
	
	$res=$client->call(
	'getGroup',
	array('gid'=>$gid,'access_token'=>$access_token),
	'uri:t2',
	'uri:t2/getGroup');
	
	/*$res=$client->call(
	'share2Group',
	array('gid'=>$gid,'privacy' => "TTFFFFFF",'access_token'=>$access_token),
	'uri:t2',
	'uri:t2/share2Group');*/
		
	echo "<pre>";
	print_r($res);
	echo "</pre>";	
	
	
// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
// Display the debug messages
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>