<?
	require 'fb/fblogin.php';
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
	color:#666;
	text-decoration: none;
}
a:visited {
	font-size: 10px;
	color:#666;
	text-decoration: none;
}
a:hover {
	font-size: 10px;
	color:#666;
	text-decoration: underline;
}
a:active {
	font-size: 10px;
	color:#666;
	text-decoration: none;
}

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
	echo "<a href=friend.php>See friends.</a>";
	
	echo "You Friend that use FBQR<br>";
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

/////////////////////////1_MODIFIED/////////////////////////////////////
echo "<form id=form1 name=form1 method=post action=seefriend.php>";
		echo "<table cellspacing=0 border=0>";
		$c=0;
	foreach ($frProfiles as $i){
	$c++;
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";target=\"_self\"
		echo "<tr>";
		echo "<td><input type=checkbox name=uid$c id=uid$c  value=$i[uid]></td>";
		echo "<td align=left valign=middle><a href=\"friendinfo.php?fr=".$i['uid']."\">";
		echo "<img src=\"https://graph.facebook.com/".$i[uid]."/picture\" border=0>";
		echo $i['first_name'];
		echo "</a></td></tr>";
	}
	echo "<tr><td><input type=submit name=submit id=submit value=Submit /> <input type=reset name=reset id=reset value=Reset /></td></tr>";
	echo "</table>";
echo "</form>";
///////////////////////////////////////////////////////////////

?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->