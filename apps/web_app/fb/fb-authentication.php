<?
	function RequestforPermission($next_url) { 
		global $facebook;
		$loginUrl=$facebook->getLoginUrl(array(
			'canvas'=>1,
			'fbconnect'=>0,
			'display'=>'page',
			'next'=>$next_url,
			'cancel_url'=>'http://www.facebook.com/',
			'req_perms'=>'offline_access,email,user_status,user_website,user_birthday,user_location,user_hometown,publish_stream,read_stream,
						friends_birthday,friends_status,friends_hometown,friends_location,friends_website,user_photos,friends_photos,user_groups',
			));
		return '<script type=\'text/javascript\'>top.location.href =\''.$loginUrl.'\';</script>';
	  } // end redirect function
?>
