<?
	require 'fb/fblogin.php';
	require 'protect.php';
	$uid=$me['id'];
	$access_token=$session['access_token'];
	
	$uidFr=$_REQUEST['fr'];
	//$key="who_are_you?";
	$key="myfbql";
	
	$arefriend=CheckFriend($uidFr,$access_token);
	$bypass=bypassprotect($uidFr,$key,$arefriend[0]);
	$displayProfile=DisplayProfile($uidFr,$bypass);
	/*
	echo "<pre>";
	print_r($displayProfile);
	echo "</pre>";*/
?>
<html>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="facebook.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
body,td,th {
	font-family: tahoma;
	font-size: 12px;
	color: #000;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	padding:0px 0px;
}
a:link {
	font-size: 12px;
	color:#666;
	text-decoration: none;
}
a:visited {
	font-size: 12px;
	color:#666;
	text-decoration: none;
}
a:hover {
	font-size: 12px;
	color:#666;
	text-decoration: underline;
}
a:active {
	font-size: 12px;
	color:#666;
	text-decoration: none;
}
#block {display:block;padding: 10px 10px; width:400px;margin:0px auto;}
</style>
<body>
<div id=block class=fbgreybox>
<H2>Profile</H2>
<?php


require ('config.inc.php');

$sql_uid="SELECT *FROM profiles WHERE uid='$uidFr'";
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
	//echo $phone_number.$address.$name.$website.$display.$status.$email;
}
else{
	echo "No Data";
	die();
}

	$param  =   array(
		'method'  => 'users.getinfo',
		'uids'    => $uidFr,
		'fields'  => 'name,website,status,pic',
		'callback'=> ''
	);
	$frProfiles   =   $facebook->api($param);
	echo "<a href=\"http://www.facebook.com/profile.php?id=".$uidFr."\" target=\"_blank\">";
	echo "<img src=\"https://graph.facebook.com/".$uidFr."/picture\" border=0> ";
	echo $frProfiles[0]['name']."</a>";
	echo "<br>";
	
     echo "
	
              <table width=400 border=0 align=center cellpadding=0 cellspacing=0>";
	if($displayProfile['phone_number']==1){
			echo "
                <tr>
                  <td width=125 align=left valign=top>Phonenumber</td>
                  <td width=325 align=left valign=top>$phone_number
                  </td>
                </tr>
			";
	}
	if($displayProfile['address']==1){
			echo "
                <tr>
                  <td width=125 align=left valign=top>Address</td>
                  <td width=325 align=left valign=top>$address
				  </td>
                </tr>
			";
	}
	if($displayProfile['name']==1){
			echo "             <tr>
                  <td width=125 align=left valign=top>Name</td>
                  <td width=325 align=left valign=top>";
				  echo ($array['sync']%10==1)?$frProfiles[0]['name']:$name;
				  echo "
				  </td>
                </tr>
			";
	}
	if($displayProfile['website']==1){
			echo "
                <tr>
                  <td width=125 align=left valign=top>Website</td>
                  <td width=325 align=left valign=top>"; echo ($array['sync']%100>=10)?$frProfiles[0]['website']:$website; echo "
				  </td>
                </tr>
			";
	}
	if($displayProfile['display']==1){
			echo "
                <tr>
                  <td width=125 align=left valign=top>Display(url only)</td>
                  <td width=325 align=left valign=top>";
				  echo ($array['sync']%1000>=100)?"https://graph.facebook.com/".$uidFr."/picture":$display; 
				echo"  </td>
                </tr>
			";
	}
	if($displayProfile['status']==1){
			echo "
                <tr>
                  <td width=125 align=left valign=top>Status</td>
                  <td width=325 align=left valign=top>"; echo ($array['sync']>=1000)?$frProfiles[0]['status']['message']:$status; echo"
				  </td>
                </tr>
			";
	}
	if($displayProfile['email']==1){
			echo "
                <tr>
                  <td width=125 align=left valign=top>Email</td>
                  <td width=325 align=left valign=top>$email
				  </td>
				  </tr>
			";
	}
	echo "
              </table>";
?>
</div>
</body>
</html>