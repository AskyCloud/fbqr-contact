<?php
	require('config.inc.php');
	$uid=$me['id'];
?>

<script src="jquery-1.4.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<link rel="stylesheet" href="style_2.css" />
<link href="style.css" rel="stylesheet" type="text/css" />

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
	font-size: 10px;
	color:#FFF;
	text-decoration: none;
}
a:visited {
	font-size: 10px;
	color:#FFF;
	text-decoration: none;
}
a:hover {
	font-size: 10px;
	color:#FFF;
	text-decoration: underline;
}
a:active {
	font-size: 10px;
	color:#FFF;
	text-decoration: none;
}
	#width{width:300px;}
	#block{display:table;padding: 10px 0px;margin:auto;}
	#blank{display:table-row;height:15px;}
	#avatar img{border-color:#FFFFFF;}
	#friend{list-style-type:none;padding-left: 10px;display:table-row;background-color:#00CDFF;width:500px;color:#FFF;}
	#update {padding-left:25px;height:25px;background:url(images/menu_bg.png);}
	#update li {float:left;list-style-type:none;}	
	#update li b {display:block;padding: 0px 5px;color:#d4dae8;font-size:20px;}
	#update li c {display:block;padding: 4px 9px 5px 9px;background-color:#eceff6;width:500px;border:1px solid #d4dae8}
	#update li img {display:block;padding: 0px 0px 0px 0px;}	
	#friend2 {padding-left:25px;width:500px;height:25px;background:url(images/menu_bg.png);}
	#friend2 li {float:left;list-style-type:none;}	
	#friend2 li b {display:block;padding: 0px 0px;color:#FF0089;font-size:20px;}
	#friend2 z a {display:block;padding: 5px 9px 5px 9px;background-color:#FF0089;color:#FFF;width:304px;font-weight:bold;}
	#friend2 li img {display:block;padding: 0px 0px 0px 0px;}
	#friend2 li a {color:#FFF;display:block;background-color:#FF0089;}
	#friend2 li d{display:block;padding:5px 2px 0px 2px;background-color:#FF0089;}
	#friend2 li x{display:block;padding: 0px 10px 0px 0px;}
</style>

<?
	//get Frined that use this app
	try{
		$param  =   array(
			'method'  => 'friends.getAppUsers',
			'callback'=> ''
		);
		$frApp   =   $facebook->api($param);
	}catch(Exception $o) {
		echo "<pre>";
		//print_r($o);
					echo "Please try again.";
		echo "</pre>";
	}
	try{
		$param  =   array(
			'method'  => 'users.getinfo',
			'uids'    => $frApp,
			'fields'  => 'uid,first_name',
			'callback'=> ''
		);
		$frProfiles   =   $facebook->api($param);
	}catch(Exception $o) {
		echo "<pre>";
		//print_r($o);
					echo "Please try again.";
		echo "</pre>";
	}
	echo "<h2>Follower</h2>";
			$FollowSql="SELECT *FROM follow WHERE uid='$uid'";
			$dbquery=mysql_db_query($dbname,$FollowSql);
			$numrow_follow=mysql_num_rows($dbquery);
			if($numrow_follow==1){
				$FollowArray=mysql_fetch_array($dbquery);
				$follower=$FollowArray['follower'];
				$followerUID=explode(";", $FollowArray['follower']);
			}
			else{
				echo "<div class=fbinfobox align=center style=\"width:150px; margin:0px auto;\">Doesn't has follower.</div>";
			}
	echo "<div id=blank></div>";
	echo "<table border=0 cellpadding=0px cellspacing=0px align=center>";
	echo "<tr><td colspan=6 bgcolor=\"#FF0089\" height=20px valign=middle><b style=\"padding:0px 5px\"><a href=2friend.php>See friends.You Friend that use FBQR</a></b></td></tr>";
	echo "<tr>";
	$size=count($frProfiles);
	if($size>=6)
		$ran=rand(0,$size-5);
	else
		$ran=0;
	$stop=6;
	$re=0;
	$count_pic=0;
	for($c = 0;(($ran + $c) < $size) && $c < $stop ;$c++){
		$it_uid=$frProfiles[$ran + $c]['uid'];
		$sql_uid="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$it_uid' AND `setting`.`uid`='$it_uid' ";
		$dbquery=mysql_db_query($dbname,$sql_uid);
		$numrow_uid=mysql_num_rows($dbquery);
		if($numrow_uid==1){
			++$count_pic;
			echo "<td  bgcolor=\"#FF0089\" width=60px><center><a href=\"friendinfo.php?fr=".$frProfiles[$ran + $c]['uid']."\"  id=various$count_pic ><img src=\"https://graph.facebook.com/".$frProfiles[$ran + $c]['uid']."/picture\" border=0><br>".$frProfiles[$ran + $c]['first_name']."</a></center></td>";
		}
		else{
			$stop++;
		}
		if((($ran + $c)+1 >= $size) && $size >=6  && ++$re==1){
			$stop-=$c;
			$ran=0;
			$c=0;
		}
	}
	while($count_pic<6){
	echo "<td bgcolor=\"#FF0089\" width=60px></td>";
	$count_pic++;
	}
	echo "<td width=50px><img src=\"img/corner_2.png\"></td>";
	echo "<td><img src=\"https://graph.facebook.com/".$uid."/picture\" style=\"border: 4px #FF0089 solid;\"></td>";
	echo "</tr></table>";
	echo "<div id=blank></div>";
	echo "<div id=block>";
	echo "<div id=update>";
	echo "<li><b>Update</b></li>";
	echo "<li><c>";require 'update_text.php';
	$str=nl2br($str);
	echo "$str</c></li></div>";
	echo "<div id=blank></div>";
	echo "<center><div class=fbinfobox align=center id=width><img src=img/FBQR-qrcode.jpg><br>Download Moblie Application</div></center>";
/*////////////////////////ORIGINAL/////////////////////////////////////	
	foreach ($frProfiles as $i){
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";
		echo "<a href=\"friendinfo.php?fr=".$i['uid']."\" target=\"_self\">";
		echo "<img src=\"https://graph.facebook.com/".$i[uid]."/picture\" border=0>";
		echo $i['name'];
		echo "</a>";
		echo "<br>";
	}
/////////////////////////////////////////////////////////////*/
/*

	$c=0;
	echo "<script type=\"text/javascript\">
		$(document).ready(function() {";
	foreach ($frProfiles as $i){	
	$c++;
		echo "\$(\" #various$c \").fancybox({
					'width'				: '90%',
					'height'			: '60%',
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe'
				});";
		}
		echo"	});
	</script>";
	echo "<div id=blank></div>";
	echo "<div id=friend>";

		echo "<table cellspacing=0 cellpadding=0 border=0><tr>";
		$c=0;
	foreach ($frProfiles as $i){
	$c++;
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";target=\"_self\"
		echo "<td align=left valign=top><a href=\"friendinfo.php?fr=".$i['uid']."\"  id=various$c>";
		echo "<img src=\"https://graph.facebook.com/".$i[uid]."/picture\" border=0>";
		echo "<br>";
		echo $i['first_name'];
		echo "</a></td>";
	}
	echo "</tr></table>";
	echo "</div>";
	echo "<img src=\"img/corner_v.png\">";
	echo "<div id=avatar><img src=\"https://graph.facebook.com/".$uid."/picture\" border=2></div>";
	echo "</div>";
*/
	$c=0;
	echo "<script type=\"text/javascript\">
		$(document).ready(function() {";
	for($i=1;$i<=6;$i++){
		echo "\$(\" #various$i \").fancybox({
					'padding'			: 5,
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe'
				});";
		}
		echo"	});
	</script>";
/*	
	echo "<div id=blank></div>";
		echo "<div id=friend2>";	
		echo "<z><a href=2friend.php>See friends.You Friend that use FBQR</a></z>";
		$c=0;


	foreach ($frProfiles as $i){
	$c++;
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";target=\"_self\"
		echo "<li>";
		echo "<d><img src=\"https://graph.facebook.com/".$i['uid']."/picture\" border=0>";
		echo "<center><a href=\"friendinfo.php?fr=".$i['uid']."\"  id=various$c>".$i['first_name']."</a></center>";
		echo "</d></li>";
		if($c>=6){
			break;
		}
	}
	echo "<li><x><img src=\"img/corner_2.png\"></x></li>";
	echo "<li><b><img src=\"https://graph.facebook.com/".$uid."/picture\" border=2></b></li>";
	echo "</div>";
	echo "</div>";*/
	
?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->