<?php
require 'fb/fblogin.php';
require 'config.inc.php';

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
  <body>
    <?php if ($cookie) { ?>
      Welcome <?= $user->name ?>
    <?php } else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>
    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="jquery.facebook.multifriend.select.js"></script>
	<link rel="stylesheet" href="jquery.facebook.multifriend.select.css" />
	<script>
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
		
		function init() {
                  FB.api('/me', function(response) {
						$("#jfmfs-container").jfmfs({ max_selected: 15, max_selected_message: "{0} of {1} selected"});
						var friendSelector = $("#jfmfs-container").data('jfmfs');
						var friendIds = friendSelector.getSelectedIds();
					});
         }  		
	</script>
	<div id="jfmfs-container"></div> 
 </body>
</html>
