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
                $("form").validity(function() {
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
#edit{list-style-type:none;float:right; display:block;padding: 10px;width:150px; text-align:right;text-decoration: none;}
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
<a href="2EditMultiQR.php"><div class=fbmenu2 id=edit >Edit Multi QR in Database</div></a>
<div id=blank ></div>
<center>
<div class="fbinfobox" align=center style="width:450px;">
<b><h2>สถานะการแบ่งปัน</h2><br>
<font color=red>All = online and offline เลือกได้ ไม่เกิน 5 คน<br>
Online = online only เลือกได้ไม่จำกัด<br>
แนะนำ : 20 รายชื่อ (ถ้าหลายรายชื่ออาจจะเกิดความล่าช้าได้<br>
เพราะความเร็วขึ้นอยู่กับอินเตอร์เน็ตอาจทำให้การดาวน์โหลดข้อมูลล่าช้าได้)</font>
</b>
</div>
</center>
<?
echo "<form id=form1 name=form1 method=post action=Gen_MultiQR.php target=\"_blank\">" ;
		echo "<table cellspacing=0 border=0 cellpadding=3 align=center>";
		echo "<tr  id=\"s\"><td width=35px align=center  valign=top><b>All</b></td>
		<td width=35px align=center  valign=top><b>Online</b></td>
		<td align=center  valign=top><b>Friend</b></td></tr>";
		
		///my form//////////
		echo "<tr >";
		echo "<td align=center  valign=top width=35px  id=\"bb\" ><input type=radio name=all1 id=uncheck1 onClick=\"return false\" onMouseDown=\"rC(this)\" value=true></td>";
		echo "<td align=center  valign=top width=35px  id=\"bb\" ><input type=radio name=all1 id=uncheck_1 onClick=\"return false\" onMouseDown=\"rC(this)\" value=false></td>";
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
		echo "<td align=center  valign=top width=35px  id=\"bb\" ><input type=radio name=all$c id=uncheck$c onClick=\"return false\" onMouseDown=\"rC(this)\" value=true></td>";
		echo "<td align=center  valign=top width=35px  id=\"bb\" ><input type=radio name=all$c id=uncheck_$c onClick=\"return false\" onMouseDown=\"rC(this)\" value=false></td>";
		echo "<td  align=left  valign=bottom  id=\"bb\" ><a href=\"friendinfo.php?fr=".$i['uid']."\" id=various$c>";
		echo "<img src=\"https://graph.facebook.com/".$i['uid']."/picture\" border=0 height=30px width=30px>";
		echo "<div id=line><b>".$i['name']."</b></div>";
		echo "</a></td></tr>";
	}
	}
	echo "<tr><td colspan=3>Group name<input name=group_name type=text id=group_name size=15 value=\"\"></td></tr>";
	echo "<tr><td colspan=3>Group picture<input name=group_picture type=text id=group_picture size=15 value=\"\"></td></tr>";	
	echo "<tr><td colspan=3>Password :: <input name=password type=password id=password size=25>
	<input type=hidden name=request id=request  value=\"false\">
	<input type=checkbox name=request id=request  value=\"true\">	
	Request Password</td></tr>";
	echo "<tr><td colspan=3 align=\"center\"><input type=submit name=submit id=submit value=Submit /> <input type=reset name=reset id=reset value=Reset /></td></tr>";
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

?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->