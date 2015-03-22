<?
	include_once('config.inc.php');
	$uid=$me['id'];
	$myName=$me['name'];
?>

<script src="jquery-1.4.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<link rel="stylesheet" href="style_2.css" />
<link href="style.css" rel="stylesheet" type="text/css" /> 
       <link type="text/css" rel="Stylesheet" href="jquery.validity.css" />
        <script type="text/javascript" src="jquery.validity.js"> </script>
        <script type="text/javascript">
            $(function() { 
                $("#form1").validity(function() {
                    $("#group_picture")
                        .match("url");
					$("#group_name")
                        .require()
                        .match("nonHtml");
						
                });
            });
        </script>

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
	font-size: 11px;
	color:#666;
	text-decoration: none;
}
a:visited {
	font-size: 11px;
	color:#666;
	text-decoration: none;
}
a:hover {
	font-size: 11px;
	color:#666;
	text-decoration: none;
}
a:active {
	font-size: 11px;
	color:#666;
	text-decoration: none;
}
#line {list-style-type:none;float:inherit; display:inherit;padding: 10px 15px;height:30px;}
#edit{list-style-type:none;float:right; display:block;padding: 10px;width:120px; text-align:right;text-decoration: none;}
#blank{display:table-row;height:40px;}
</style>
<script type="text/javascript">
rC = function(radioEl) {
    if(radioEl.checked == true) {
        radioEl.checked = false;
        return false;
    }
    else {
        radioEl.checked = true;
        return true;
    }
}
</script>

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
/*
echo "<script type=\"text/javascript\">";
		$c=0;
	foreach ($frProfiles as $i){

	$it_uid=$i['uid'];
	$sql_uid="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$it_uid' AND `setting`.`uid`='$it_uid' ";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	if($numrow_uid==1){$c++;
echo"	$(\"#uncheck$c\").click( function(){";
echo"		if( $(this).is(':checked') )
				$(this).removeAttr(\"checked\");
			else	$(this).attr(\"checked\", \"checked\");
	});";
echo"	$(\"#uncheck_$c\").click( function(){
			if( $(this).is(':checked') )
				$(this).removeAttr(\"checked\");
			else	$(this).attr(\"checked\", \"checked\");
	});";
	}
}
echo "</script>";*/

/////////////////////////1_MODIFIED/////////////////////////////////////
?>
<h2>Multi QR</h2>
<a href="2MultiQR.php"><div class=fbmenu2 id=edit >Create new Multi QR</div></a>
<div id=blank ></div>

<?
if($_REQUEST['submit2'] == "delete"){
$array_select=explode(";",$_REQUEST['select']);
$sql_uid="DELETE FROM `multi2qr` WHERE `qrid`='".$array_select[0]."'";
$dbquery=mysql_db_query($dbname,$sql_uid);
echo "<div class=fberrorbox style=\"text-align:center; margin:0px auto;margin-bottom:10px; width:100px;\">Deleted</div>";	
}
$sql_uid="SELECT *FROM `multi2qr` WHERE author_uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);


echo "<table border=0 align=center cellpadding=0px cellspacing=0px >";
echo "<form id=form name=form method=post targer=_SELF >";
echo "<tr><td colspan=4 align=center id=s height=25px><b>Select Multi QR to edit.</b></td></tr>";

for($j = 0;$j < $numrow_uid;$j++){
$array=mysql_fetch_array($dbquery);
	echo "<tr>
	<td><input type=radio name=select id=select value=\"".$array['qrid'].";".$array['uid']."\"";
	$array_select=explode(";",$_REQUEST['select']);
	if($array_select[0] == $array['qrid'])echo " checked ";	echo" ></td>";
	if($array['gpic']=="")
		$gpic="http://b.static.ak.fbcdn.net/rsrc.php/y6/r/_xS7LcbxKS4.gif";
	else
		$gpic=$array['gpic'];
	echo "	
	<td><img src=\"".$gpic."\" border=0px height=50px width=50px></td>
	<td>".$array['qrname']."</td>
	<td>";
	
				$array_uid=explode(";",$array['uid']);
				$max=count($array_uid)-1;
					if($max>=6)
						$ran=rand(0,$max-5);
					else
						$ran=0;
				$stop=6;
				$re=0;
				for($k=0;($k+$ran) < $max && $k<$stop;$k++){
					echo "<img src=\"https://graph.facebook.com/".$array_uid[$ran+$k]."/picture\" style=\"padding:1px\">";
					if((($ran + $k)+1 >= $max) && $max >=6  && ++$re==1){
					$stop-=$k;
					$ran=0;
					$k=0;
					}
				}
	echo "</td></tr>";
}
	echo "<tr><td colspan=4 align=center ><input type=submit name=submit1 id=submit1 value=update ><input type=submit name=submit2 id=submit2 value=delete ></form></td></tr>";
	echo "</table>";

if($_REQUEST['select'] != "" && $_REQUEST['submit1'] == "update" ){
		$checked=1;
echo "<div class=fbinfobox style=\"text-align:center; margin:0px auto;margin-bottom:10px; width:100px;\">Selected</div>";	
echo "<form id=form1 name=form1 method=post action=Gen_MultiQR.php target=\"_blank\">" ;
		echo "<table cellspacing=0 border=0 cellpadding=3 align=center>";
		echo "<tr  id=\"s\">
		<td align=center  valign=top colspan=2 ><b>Choose friend</b></td></tr>";
		
		///my form//////////
		echo "<tr >";
		echo "<td align=center  valign=top width=35px  id=\"bb\" ><input type=radio name=all1 id=uncheck_1 onClick=\"return false\" onMouseDown=\"rC(this)\" value=false  ";if($array_select[$checked] == $uid){ echo " checked ";	$checked++;}echo "></td>";
		echo "<td  align=left  valign=bottom  id=\"bb\" ><a href=\"friendinfo.php?fr=".$uid."\" id=various1>";
		echo "<img src=\"https://graph.facebook.com/".$uid."/picture\" border=0 height=30px width=30px>";
		echo "<div id=line><b>".$myName."</b></div>";
		echo "</a></td></tr>";
		
		$c=1;
		
	foreach ($frProfiles as $i){
	
	$it_uid=$i['uid'];
	$sql_uid="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$it_uid' AND `setting`.`uid`='$it_uid' ";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	if($numrow_uid==1){$c++;
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";target=\"_self\"
		echo "<tr >";
		echo "<td align=center  valign=top width=35px  id=\"bb\" ><input type=radio name=all$c id=uncheck_$c onClick=\"return false\" onMouseDown=\"rC(this)\" value=false ";if($array_select[$checked] == $i['uid']){ echo " checked "; $checked++;}	echo "></td>";
		echo "<td  align=left  valign=bottom  id=\"bb\" ><a href=\"friendinfo.php?fr=".$i['uid']."\" id=various$c>";
		echo "<img src=\"https://graph.facebook.com/".$i['uid']."/picture\" border=0 height=30px width=30px>";
		echo "<div id=line><b>".$i['name']."</b></div>";
		echo "</a></td></tr>";
	}
	}
	$sql_uid="SELECT *FROM `multi2qr` WHERE qrid='".$array_select[0]."'";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	$array=mysql_fetch_array($dbquery);
	
	echo "<tr><td colspan=2>Group name<input name=group_name type=text id=group_name size=15 value=\"".$array['qrname']."\"></td></tr>";
	echo "<tr><td colspan=2>Group picture<input name=group_picture type=text id=group_picture size=15 value=\"".$array['gpic']."\"></td></tr>";	
	echo "<tr><td colspan=2>Password :: <input name=password type=password id=password size=25 value=\"".$array['password']."\">
	<input type=hidden name=qrid id=qrid  value=\"".$array_select[0]."\" >
	<input type=hidden name=request id=request  value=\"false\">
	<input type=checkbox name=request id=request  value=\"true\" "; if($array['password']) echo " checked "; echo ">	
	Request Password</td></tr>";
	echo "<tr><td colspan=2 align=\"center\"><input type=submit name=submit id=submit value=Submit /> <input type=reset name=reset id=reset value=Reset /></td></tr>";
	echo "</table>";
echo "</form>";

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
}
?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->