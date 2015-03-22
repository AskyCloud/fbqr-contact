<?
 	require 'fb/fblogin.php';	
	include_once('config.inc.php');
	include_once ('webservice/sfFacebookPhoto.php');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="facebook.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body{
	margin:0px 0px;
	padding:0px 0px;
	font-family:tahoma;
	font-size:12px;
	color: #000;
}
#block {display:block;padding:25px; width:316px;margin:25px auto; }
a{text-decoration: none;}
#link{color:#000; font-weight:bold; font-size:12px;width:300px;}
</style>
<?
				$gid=$_REQUEST['gid'];
				$access_token=$_REQUEST['access_token'];
				$mygroups=$facebook->api($gid);
				$sql_gid="SELECT *FROM `group` WHERE gid='$gid'";
				$dbquery=mysql_db_query($dbname,$sql_gid);
				$numrow_gid=mysql_num_rows($dbquery);
				$array=mysql_fetch_array($dbquery);
				$array_uid=explode(";",$array['uid']);
				$max=count($array_uid)-1;
				$fbphotoolkit = new sfFacebookPhoto;
				$picLink=$fbphotoolkit->getRealUrl("https://graph.facebook.com/".$gid."/picture?access_token=$access_token");
				echo "<div id=block class=fbgreybox >";				
				echo "<a href=\"http://www.facebook.com/home.php?sk=group_$gid&ap=1\" target=\"_blank\"><div id=link><img src=$picLink > ".$mygroups['name']."</div></a><br>";
				echo "Member($max) who share in group.<br>";
				for($k=0;$k < $max; $k++){				
				echo "<a href=\"http://www.facebook.com/profile.php?id=".$array_uid[$k]."\" target=\"_blank\"><img src=\"https://graph.facebook.com/".$array_uid[$k]."/picture\" style=\"padding:1px\"></a>";
				}				
				echo "</div>";
?>