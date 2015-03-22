<?php
require_once('nusoap.php');
$wsdl="http://tkroputa.in.th/fbqr/webservice/t2_server.php";
$server->soap_defencoding = 'utf-8'; 
$client = new nusoap_client($wsdl);

$uid1=array("100001036241534","100000925243158");
//$password=array("1234","1234");
$access_token="146472442045328|c01bd0d9a3083974f876ba9e-100000925243158|ZBeUd36wcM3naVv5N0j8dQmp0_A";
$qrid="17";
$password="";


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
		array('gid'=>"175483529136581",'access_token'=>$access_token),
		'uri:t2',
		'uri:t2/getGroup');
		
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