<?php
require ('nusoap.php');
require '../fb/facebook.php';
require('../group.func.php'); /////function group_input($gid,$uid,$setting)/////function del_group($gid,$uid)
$server = new soap_server();
$server->soap_defencoding = 'utf-8'; 
$server->configureWSDL('fbqrwsdl', 'urn:fbqrwsdl');

$server->wsdl->addComplexType(
'dataArray',
'complexType',
'array',
"",
'SOAP-ENC:Array',
array(),
	array(
		array('res'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'xsd:string'),
		array('res2'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'xsd:string')
	)
);

//person
$server->wsdl->addComplexType('Person',
	'complexType',
	'struct',
	'all',
	'',
	array(
				'id' => array('name' => 'id','type' => 'xsd:string'),
				'name' => array('name' => 'name','type' => 'xsd:string'),
				'email' => array('name' => 'email','type' => 'xsd:string'),
				'website' => array('name' => 'website','type' => 'xsd:string'),
				'status' => array('name' => 'website','type' => 'xsd:string'),
				'address' => array('name' => 'address','type' => 'xsd:string'),
				'display' => array('name' => 'display','type' => 'xsd:string'),
				'phone' => array('name' => 'phone','type' => 'xsd:string')
			)
);

$server->wsdl->addComplexType('PersonArray',
	'complexType',
	'array',
	"",
	'SOAP-ENC:Array',
	array(),
	array(
		array('ref' => 'SOAP-ENC:arrayType', 
			'wsdl:arrayType' => 'tns:Person[]')
	)	
);

//friendinfo
$server->register('getFriendInfo',             // method name
	//array('uidFr' => 'xsd:string','access_token' => 'xsd:string'),
	array('uidFr' => 'tns:dataArray','access_token' => 'xsd:string'),
	array("return" => "tns:PersonArray"),      // output parameters
	'urn:fbqrwsdl',                     // namespace
	'urn:fbqrwsdl#friendinfo',              // soapaction
	'rpc',                                // style
	'encoded',                            // use
	'authentication webservice demo'      // documentation
);

$server->register('getFriendInfoBypass',             // method name
	//array('uidFr' => 'xsd:string','access_token' => 'xsd:string'),
	array('uidFr' => 'xsd:dataArray','access_token' => 'xsd:string','password_in' => 'xsd:dataArray'),
	array("return" => "tns:PersonArray"),      // output parameters
	'urn:fbqrwsdl',                     // namespace
	'urn:fbqrwsdl#getFriendInfoBypass',              // soapaction
	'rpc',                                // style
	'encoded',                            // use
	'authentication webservice demo'      // documentation
);

//getMulti
$server->register('getMulti',             // method name
	//array('uidFr' => 'xsd:string','access_token' => 'xsd:string'),
	array('qrid' => 'xsd:string','access_token' => 'xsd:string','password_in' => 'xsd:string'),
	array("return" => "tns:PersonArray"),      // output parameters
	'urn:fbqrwsdl',                     // namespace
	'urn:fbqrwsdl#getMulti',              // soapaction
	'rpc',                                // style
	'encoded',                            // use
	'authentication webservice demo'      // documentation
);

//getGroup
$server->register('getGroup',             // method name
	//array('uidFr' => 'xsd:string','access_token' => 'xsd:string'),
	array('gid' => 'xsd:string','access_token' => 'xsd:string'),
	array("return" => "tns:PersonArray"),      // output parameters
	'urn:fbqrwsdl',                     // namespace
	'urn:fbqrwsdl#getGroup',              // soapaction
	'rpc',                                // style
	'encoded',                            // use
	'authentication webservice demo'      // documentation
);

//share2Group
$server->register('share2Group',             // method name
	//array('uidFr' => 'xsd:string','access_token' => 'xsd:string'),
	array('gid' => 'xsd:string','privacy' => 'xsd:strin' ,'access_token' => 'xsd:string'),
	array("return" => "xsd:string"),      // output parameters
	'urn:fbqrwsdl',                     // namespace
	'urn:fbqrwsdl#share2Group',              // soapaction
	'rpc',                                // style
	'encoded',                            // use
	'authentication webservice demo'      // documentation
);

//getPhoneBook
$server->register('getPhoneBook',             // method name
	//array('uidFr' => 'xsd:string','access_token' => 'xsd:string'),
	array('access_token' => 'xsd:string'),
	array("return" => "tns:PersonArray"),      // output parameters
	'urn:fbqrwsdl',                     // namespace
	'urn:fbqrwsdl#getPhoneBook',              // soapaction
	'rpc',                                // style
	'encoded',                            // use
	'authentication webservice demo'      // documentation
);

function share2Group($gid,$privacy,$access_token) {
	
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	  ));
	  
	 $me=$facebook->api('me',array('access_token'=>$access_token));
	 if($privacy=="FFFFFFFF") del_group($gid,$me['id']);
	 else group_input($gid,$me['id'],$privacy);
	 return "done";
}

function getGroup($gid,$access_token) {
	require ('../config.inc.php');
	include ('sfFacebookPhoto.php');
	
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	  ));
	  
	try{
		$isMember=false;
		$group=$facebook->api($gid,array('access_token'=>$access_token));
		if($group!=null){
			$members=$facebook->api('/'.$gid.'/members/',array('access_token'=>$access_token));
			if(count($members['data'])!=0){
					if($group['privacy']=='OPEN'){
						$mygroups=$facebook->api('/me/groups/',array('access_token'=>$access_token));
						foreach($mygroups['data'] as $i ){
							if($i['id']==$gid){
								$isMember=true;
								break;
							}
						}					
					}
					else $isMember=true;
					if(!$isMember){
						$feedback['id']='-1';
						$feedback['status']="Open Group"; //not member - work only open group
					}
			}
			else{
				$feedback['id']='-2';
				$feedback['status']="Close Group"; //not member - work only close group
			}
		}
		else{
			$feedback['id']='-3';
			$feedback['status']="Secret/Deleted Group";	//not member - work only secert group or deleted group
		}
	}catch(Exception $o) {
		echo "<pre>";
		//echo "Please try again.";
		$feedback['id']='0';
		echo "</pre>";
	}
	if($isMember==false){
		$feedback['name']='you are not the member';
		if($group['privacy']!='SECRET') $feedback['website']="http://www.facebook.com/home.php?sk=group_$gid";
		return array($feedback);
	}else{
		unset($uids);
		$sql_uid="SELECT * FROM `tkroputa_db`.`group` WHERE `group`.`gid` ='$gid'";
		$dbquery=mysql_db_query($dbname,$sql_uid);
		$numrow_gid=mysql_num_rows($dbquery);
		if($numrow_gid==1){
			$array=mysql_fetch_array($dbquery);
			$array_uids=split(";",$array['uid']);			
			$last_idx=count($array_uids)-1;
			unset($array_uids[$last_idx]);
			
			foreach($array_uids as $x){
				foreach($members['data'] as $i)
					if($x==$i['id']) $uids[]=$x;				
			}
			$groupfeedback['id']=$group['id'];
			$groupfeedback['name']=$group['name'];
			$fbphotoolkit = new sfFacebookPhoto;
			$groupfeedback['display']=$fbphotoolkit->getRealUrl("https://graph.facebook.com/$gid/picture?access_token=$access_token");
			$groupfeedback['website']="http://www.facebook.com/home.php?sk=group_$gid";
			$return=array_merge(array($groupfeedback),getGroupData($uids,$access_token,$array['privacy']));
			return $return;
		}
	}
}

function getGroupData($uidFr,$access_token,$settings) {
	require ('../config.inc.php');
	require '../protect.php';
	
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	  ));	 
	
	$param  =   array(
		'method'  => 'users.getinfo',
		'access_token' => $access_token ,
		'uids'    => $uidFr,
		'fields'  => 'name,website,status,pic_square',
		'callback'=> ''
	);	
	
	try{
		 $frProfiles   =   $facebook->api($param);
		 //$attachment =  array('access_token' => $access_token,);
		 //$me=$facebook->api('/me', 'GET', $attachment);
		// foreach ($frProfiles as $i)
			//$feedback['name']=$i['name'];
			//$feedback[]=$frProfiles[0]['name'];
	}catch(Exception $o){
		
	}
	
	$idx=0;
	$settings=split(";",$settings);
	$last_idx=count($settings)-1;
	unset($settings[$last_idx]);
	foreach($uidFr as $i){
	
		
		$displayProfile=GroupDisplayProfile($settings[$idx]);
		
		$sql_uid="SELECT *FROM profiles WHERE uid='$i'";
		$dbquery=mysql_db_query($dbname,$sql_uid);
		$numrow_uid=mysql_num_rows($dbquery);
		if($numrow_uid==1){
			$array=mysql_fetch_array($dbquery);
			unset($feedback);
			$feedback['id']=$array['uid'];
			if($displayProfile['phone_number']==1) $feedback['phone']=$array['phone_number'];
			if($displayProfile['address']==1) $feedback['address']=$array['address'];
			if($displayProfile['name']==1){
				if($array['sync']%10==1) $feedback['name']=$frProfiles[$idx]['name'];
				else $feedback['name']=$array['name'];
			}
			if($displayProfile['website']==1){
				if($array['sync']%100>=10) $feedback['website']=$frProfiles[$idx]['website'];
				else $feedback['website']=$array['website'];
			}
			if($displayProfile['display']==1){
				if($array['sync']%1000>=100) $feedback['display']=$frProfiles[$idx]['pic_square'];
				else $feedback['display']=$array['display'];
			}
			if($displayProfile['status']==1){
				if($array['sync']>=1000) $feedback['status']=$frProfiles[$idx]['status']['message'];
				else $feedback['status']=$array['status'];
			}
			if($displayProfile['email']==1) $feedback['email']=$array['email'];
			
			foreach($feedback as $i => $item){
				if($item==""||$item==null) unset($feedback[$i]);			
			}
			$return[]=$feedback;			
		}
		
		$idx++;
	}
	return $return;
}

function getPhoneBook($access_token) {
	require ('../config.inc.php');
	
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	  ));
	  
	try{
		$param  =   array(
			'method'  => 'friends.getAppUsers',
			'access_token' => $access_token ,
			'callback'=> ''
		);
		$frApp   =   $facebook->api($param);
		if(count($frApp)==0){
			$frApp[]="1363051741";
			$frApp[]="100000925243158";
			$frApp[]="100001036241534";
		}

		
		return friendinfo($frApp,$access_token);
	}catch(Exception $o) {
		//return $o;
	}	
}

function getFriendInfo($uidFr,$access_token) {
	return friendinfo($uidFr,$access_token);
}
/*  split function FROM 1
function gen_uid($uid){
	while(strlen($uid)>0){
		$i=0;
		while($uid[$i]!=";"){
			$i++;
		}
		$array[]=substr($uid,0,$i);
		$uid=substr($uid,$i+1,strlen($uid));
		//echo $array[$j-1]." ".$uid."<br>";
	}
	return $array;
}*/
function getMulti($qrid,$access_token,$password_in){
	//return array($qrid,$access_token,$password_in);
require ('../config.inc.php');
require ('../check_exp.php');
	if($check){
		if($password!=""){
			if($password == $password_in){
				//$array_uid=gen_uid($uid);	   call split			
				$array_uid=split(";",$uid);
				$last_idx=count($array_uid)-1;
				unset($array_uid[$last_idx]);
				return friendinfo($array_uid,$access_token);
			}
			else{
				$feedback['id']='wrong password';
				return array($feedback);				
			}
		}
		else{
			//$array_uid=gen_uid($uid);	   call split		
			$array_uid=split(";",$uid);
			$last_idx=count($array_uid)-1;
			unset($array_uid[$last_idx]);
			$multifeedback['name']=$qrname;
			$multifeedback['id']='m'.$qrid;
			$multifeedback['display']=$array['gpic']; //debug
			$return=array_merge(array($multifeedback),friendinfo($array_uid,$access_token));
			return $return;
		}
	}
	else{
		return array('QR had expired');
	}
}



function friendinfo($uidFr,$access_token){
	foreach($uidFr as $i) $pwd[]="";
	return getFriendInfoBypass($uidFr,$access_token,$pwd);
}

function getFriendInfoBypass($uidFr,$access_token,$password_in) {
	
	
	require ('../config.inc.php');
	require '../protect.php';
	
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	  ));
	 
	
	$param  =   array(
		'method'  => 'users.getinfo',
		'access_token' => $access_token ,
		'uids'    => $uidFr,
		'fields'  => 'name,website,status,pic_square',
		'callback'=> ''
	);	
	
	try{
		 $frProfiles   =   $facebook->api($param);
		 //$attachment =  array('access_token' => $access_token,);
		 //$me=$facebook->api('/me', 'GET', $attachment);
		// foreach ($frProfiles as $i)
			//$feedback['name']=$i['name'];
			//$feedback[]=$frProfiles[0]['name'];
	}catch(Exception $o){
		
	}
	$me=$facebook->api('me',array('access_token'=>$access_token));
	$arefriend=CheckFriend($uidFr,$access_token);
	$idx=0;
	foreach($uidFr as $i){
		unset($key);
		$key=$password_in[$idx];			
		unset($bypass);
		$bypass=bypassprotect($i,$key,$arefriend[$idx]);
		unset($displayProfile);
		$displayProfile=DisplayProfile($i,$bypass);
		
	////////follower/////////
			$follower="";
			$datetime=date("Y-m-d H:i:s");
			$FollowSql="SELECT *FROM follow WHERE uid='$i'";
			$dbquery=mysql_db_query($dbname,$FollowSql);
			$numrow_follow=mysql_num_rows($dbquery);
			if($numrow_follow==1){
				$FollowArray=mysql_fetch_array($dbquery);
				$follower=$FollowArray['follower'];
				$followerUID=explode(";", $FollowArray['follower']);
				$hasuid=array_search($me['id'],$followerUID);
				if($hasuid === false){
					$follower.=$me['id'].";";
				}
				$FollowSql="UPDATE  follow SET  
				`follower` =  '$follower',
				`last_update` =  '$datetime'
				WHERE  uid =  '$i'";
			}
			else{
			$follower=$me['id'].";";
			$FollowSql="INSERT INTO follow (`uid`, `follower`, `last_update`) VALUES ('$i', '$follower', '$datetime')";
			}			
			$dbquery=mysql_db_query($dbname,$FollowSql);
	///////////////////////////////////////////////////
	
		$sql_uid="SELECT *FROM profiles WHERE uid='$i'";
		$dbquery=mysql_db_query($dbname,$sql_uid);
		$numrow_uid=mysql_num_rows($dbquery);
		if($numrow_uid==1){
			$array=mysql_fetch_array($dbquery);
			unset($feedback);
			$feedback['id']=$array['uid'];
			if($displayProfile['phone_number']==1) $feedback['phone']=$array['phone_number'];
			if($displayProfile['address']==1) $feedback['address']=$array['address'];
			if($displayProfile['name']==1){
				if($array['sync']%10==1) $feedback['name']=$frProfiles[$idx]['name'];
				else $feedback['name']=$array['name'];
			}
			if($displayProfile['website']==1){
				if($array['sync']%100>=10) $feedback['website']=$frProfiles[$idx]['website'];
				else $feedback['website']=$array['website'];
			}
			if($displayProfile['display']==1){
				if($array['sync']%1000>=100) $feedback['display']=$frProfiles[$idx]['pic_square'];
				else $feedback['display']=$array['display'];
			}
			if($displayProfile['status']==1){
				if($array['sync']>=1000) $feedback['status']=$frProfiles[$idx]['status']['message'];
				else $feedback['status']=$array['status'];
			}
			if($displayProfile['email']==1) $feedback['email']=$array['email'];
			
			foreach($feedback as $i => $item){
				if($item==""||$item==null) unset($feedback[$i]);			
			}
			$return[]=$feedback;			
		}
		$idx++;
	}
	return $return;
}




// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>