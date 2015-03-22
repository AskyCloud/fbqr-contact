<?
	include_once('config.inc.php');
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
#line {list-style-type:none;float:inherit; display:inherit;padding: 20px 15px;height:50px;}
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
			'fields'  => 'uid,name',
			'callback'=> ''
		);
		$frProfiles   =   $facebook->api($param);
	}catch(Exception $o) {
		echo "<pre>";
		//print_r($o);
					echo "Please try again.";
		echo "</pre>";
	}
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
echo "<br>";
		echo "<table cellspacing=0 cellpadding=3 align=center width=450px >";
		echo "<tr id=\"s\"><td align=left valign=middle height=25><b>Your friends who using FBQR Contact.</b></td></tr>";
		
		$c=0;
	foreach ($frProfiles as $i){

	$it_uid=$i['uid'];
	$sql_uid="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$it_uid' AND `setting`.`uid`='$it_uid' ";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	if($numrow_uid==1){$c++;
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";target=\"_self\"
		echo "<tr>";
		echo "<td  align=left  valign=bottom id=\"bb\" ><a href=\"friendinfo.php?fr=".$i['uid']."\" id=various$c>";
		echo "<img src=\"https://graph.facebook.com/".$i['uid']."/picture\" border=0 height=50px width=50px>";
		echo "<div id=line><b>".$i['name']."</b></div>";
		echo "</a></td></tr>";
	}
	}
	echo "</table>";

	$max=$c;
	echo "<script type=\"text/javascript\">
		$(document).ready(function() {";
	for($i=1;$i<=$max;$i++){
		echo "\$(\" #various$i \").fancybox({
					'width'				: '75%',
					'height'			: '90%',
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe'
				});";
		}
		echo"	});
	</script>";
///////////////////////////////////////////////////////////////

?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->