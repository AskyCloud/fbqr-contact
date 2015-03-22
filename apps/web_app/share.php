<?php
require 'fb/fblogin.php';
require 'config.inc.php';

$uid=$_REQUEST['uid'];
$postId=$_REQUEST['postId'];
$target=$_REQUEST['target'];

if(!$uid) die();
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

function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $application_secret) != $args['sig']) {
    return null;
  }
  return $args;
}

$cookie = get_facebook_cookie($fbconfig['appid'], $fbconfig['secret']);

$user = json_decode(file_get_contents(
    'https://graph.facebook.com/me?access_token=' .
    $cookie['access_token']));

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="ajaxify.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="jquery.facebook.multifriend.select.js"></script>
<link rel="stylesheet" href="jquery.facebook.multifriend.select.css" />
<body>
<? //fb autoresize ?>

<div id="fb-root"></div> 
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.Canvas.setAutoResize(true,100);
		FB.init({appId: '<?= $fbconfig['appid'] ?>', status: true,
               cookie: true, xfbml: true});
		FB.getLoginStatus(function(response) {
				if (response.session) {
				  init();
				} else {
				  // no user session available, someone you dont know
				  alert('not login');
				}
		});
	}
	(function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		'//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	}());
		

		function init() {
					  FB.api('/me', function(response) {
							$("#jfmfs-container").jfmfs({ max_selected: 15, max_selected_message: "{0} of {1} selected"});
						});
		}  
		
		function uiFeed(){
				var friendSelector = $("#jfmfs-container").data('jfmfs');
				var friendIds = friendSelector.getSelectedIds();
				var publish = {
					method: 'feed',
					message : 'Using this with FbQR Contact to add my phone number',
					to: '\''+friendIds[0]+'\'',
					name : 'FbQR Contact',
					caption : 'FbQR Contact',
					description : 'more detial see at http://apps.facebook.com/fbqrcontact/',
					picture : '<?= $photoUrl ?>',
					link : '<?= $photoUrl ?>',
				};
						
				 FB.ui(publish,function(response){
					if (response && response.post_id) {
						if(friendIds.length>1)
							getMsg(response.post_id);
						else 
							alert('Successful');
					 } else {
							alert("Fail");
					}
				});
		}	
		function apiFeed(msg,target){
			var name = 'FbQR Contact';
			var des = 'more detial see at http://apps.facebook.com/fbqrcontact/';
			var pic = '<?= $photoUrl ?>';
			FB.api('/'+target+'/feed', 'post', 
					{ 
						message: msg,
						name: name,
						caption: name,
						description: des,
						link: pic,
						picture	: pic, 
					}
					, function(response) {
						  if (!response || response.error) {
							alert('Error occured');
							return false;
						  } else {
							return true;
							//alert('Post ID: ' + response.id);
						  }
					}
			);
		}
		function getMsg(postId){
			FB.api(('/'+postId+'?fields=message'),function(response) {
							if (!response || response.error) {
								alert('Error occured');
							}else {
								var res;
								var friendSelector = $("#jfmfs-container").data('jfmfs');
								var friendIds = friendSelector.getSelectedIds();
								for (var i=1, l=friendIds.length; i<l; i++){ 
									res=apiFeed(response['message'],friendIds[i]);
									if(res==false){
										break;
									}
									else alert('Successful');
								}
							}
						});
		}
		
</script>
<? //end fb autoresize ?>
<? require 'head.php'; ?>
    <br>
	<h2>Select Friends to Share</h2>
	<div>
		<div id="jfmfs-container";></div> 
		<div style="margin-left:25px;"><input type="button" value="POST"  style="width: 100px"   onclick="uiFeed()" /><div>
	<div>

<? require 'dev.html'; ?>
</body>
</html>
