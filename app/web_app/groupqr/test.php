<?php
require '../fb/facebook.php';
require '../config.inc.php';


$facebook = new Facebook(array(
 'appId'  => $fbconfig['appid'],
 'secret' => $fbconfig['secret'],
 'cookie' => true,
 'fileUpload' => true,
  ));
  
  
$uid=$me['id'];
$gid=$_REQUEST['gid'];

$group=$facebook->api(gid);
$members=$facebook->api(gid.'/members');

echo "<pre>";
print_r($group);
print_r($members);
echo "</pre>";

?>