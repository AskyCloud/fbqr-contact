<?



function bypassprotect($uidFr,$key,$isFriend) { 
	return array(
		'password' =>  CheckPassword($uidFr,$key),
		'friend' => $isFriend,
		'mutual' => $isFriend);
}

function CheckFriend($uidFr,$access_token){
	require ('config.inc.php');
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	  ));
	  $token =  array('access_token' => $access_token,);
	  $userdata = $facebook->api('/me', 'GET', $token);
	 
	  if(count($uidFr)>0)
		for($i=0;$i<count($uidFr);$i++)  $uid[]=$userdata['id']; 
	  else  $uid[]=$userdata['id'];
	try {
		$param  =   array(
				'method'  => 'friends.areFriends',
				'uids1'    => $uid,
				'uids2'    => $uidFr,
				'access_token' => $access_token ,
				'callback'=> ''
			);
		$areFr   =   $facebook->api($param);
		foreach($areFr as $i) $res[]=$i['are_friends'];
		return $res;
		//if($areFr[0]['are_friends']) return 1;
	}catch(Exception $o) {
		echo "<pre>";
        //print_r($o);
					echo "Please try again.";
		echo "</pre>";
    }
	return 0;
}

function CheckPassword($uidFr,$key){
	require ('config.inc.php');
	$sql_uid="SELECT password FROM setting WHERE uid='$uidFr'";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	if($numrow_uid==1){
		$array=mysql_fetch_array($dbquery);
		$pwd=$array['password'];
		if($key==$pwd){
			return 1;
		}
	}
	return 0;
}
function DisplayProfile($uidFr,$bypass){
	require ('config.inc.php');
	$sql_uid="SELECT * FROM setting WHERE uid='$uidFr'";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	if($numrow_uid==1){
		$array=mysql_fetch_array($dbquery);
	}
	return array(
		'phone_number' =>  checkDisplay($bypass,$array['phone_number']),
		'address' => checkDisplay($bypass,$array['address']),
		'name' => checkDisplay($bypass,$array['name']),
		'website' =>  checkDisplay($bypass,$array['website']),
		'display' => checkDisplay($bypass,$array['display']),
		'status' => checkDisplay($bypass,$array['status']),
		'email' => checkDisplay($bypass,$array['email'])
	);
}

function checkDisplay($bypass,$type){
	switch($type){
	 case A: return 1;
	 case B: return $bypass['password'];
	 case C: return $bypass['friend'];
	 case D: return $bypass['mutual'];
	 case N: return 0;
	 default : return 0;
	}
	return 0;
}

function GroupDisplayProfile($setting){
	$i=0;
	if(substr($setting,7,1)=='T') 
		return array('name' => 1,
		'phone_number' =>  0,
		'address' => 0,
		'website' =>  0,
		'display' => 0,
		'status' => 0,
		'email' => 0,);
	else 
		return array(
		'name' => (substr($setting,$i++,1)=='T')?1:0,
		'phone_number' =>  (substr($setting,$i++,1)=='T')?1:0,
		'address' => (substr($setting,$i++,1)=='T')?1:0,
		'website' =>  (substr($setting,$i++,1)=='T')?1:0,
		'display' => (substr($setting,$i++,1)=='T')?1:0,
		'status' => (substr($setting,$i++,1)=='T')?1:0,
		'email' => (substr($setting,$i++,1)=='T')?1:0,
	);
}

/*
function getMutualFriends($facebook, $uid1, $uid2){
    try {
        $param  =   array(
                    'method'  => 'friends.getMutualFriends',
                    'source_uid'    => $uid1,
                    'target_uid'  => $uid2,
                    'callback'=> ''
                );
        $mutualFriends   =   $facebook->api($param);
        return $mutualFriends;
    }
    catch(Exception $o) {
        ////print_r($o);
					echo "Please try again.";
    }

    return '';
}
*/
?>