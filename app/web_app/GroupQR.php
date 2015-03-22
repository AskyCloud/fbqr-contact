<?
	include_once ('webservice/sfFacebookPhoto.php');
	include_once('config.inc.php');
	$uid=$me['id'];
	$access_token=$session['access_token'];
	$myName=$me['name'];
	$mygroups=$facebook->api('/me/groups');
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
	text-decoration: underline;
}
a:active {
	font-size: 11px;
	color:#666;
	text-decoration: none;
}
#line {list-style-type:none;float:inherit; display:inherit;padding: 10px 15px;height:30px;}
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

<!--//Ajax?-->
 <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>

<script type="text/javascript">
		$(document).ready(function() { 
			// bind form using ajaxForm 
			$('#form1').ajaxForm({ 
				// target identifies the element(s) to update with the server response 
				dataType:  'xml', 
				// success identifies the function to invoke when the server response 
				// has been received; here we apply a fade-in effect to the new content 
				beforeSubmit:function() { 
					$('div#displayqr').fadeIn('slow'); 
					$('div#displayqr').html('<div style="padding:5px"  class="fbinfobox"><center>Loading</center></div>') ;
				},
				success: function(responseXML) {
					var stat = $(responseXML).find('stat').text();
					if(stat=="none"){
						$('div#displayqr').fadeIn('slow');  
						$('div#displayqr').html('<div style="padding:5px"  class="fberrorbox"><center>Choose group</center></div>') ;
					}
					else if(stat=="done"){
						var imgdata = $(responseXML).find('img').text();
						var stat = $(responseXML).find('stat').text();
						var uid = $(responseXML).find('uid').text();
						$('div#displayqr').fadeIn('slow');  
						$('div#displayqr').html('<center><a href=\"share.php?uid='+uid+'\" target="_self"><img src=\"/img/facebookShareButton.jpg\" alt=\"share\"></a><br><img src=\'data:image/png;base64,'+imgdata+'\'></center>	');
							
					}
				}
			});
		});
</script>
<!--//End Ajax-->
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
<h2>Group QR</h2>
<?
echo "<br>";
$sql_uid="SELECT *FROM `setting` WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
if($array['gid']==""){
echo "<center><h1>No group sharing data.</h1></center>";
}
else{
		echo "<form id=form1 name=form1 method=post action=Gen_GroupQR.php target=\"_blank\">" ;
		$c=0;
		$count_various=0;
		echo "<table cellspacing=0 border=0 cellpadding=3 align=center>";
		echo "<tr><td colspan=4 align=\"center\" id=\"s\">Choose group</td></tr>";
			foreach($mygroups['data'] as $i ){
			$c++;		
				$array_gid = explode(";",$array['gid']);
				//$array_privacy = explode(";",$array['privacy']);
				$max=count($array_gid);
				$A=0;
				for($k = 0;$k < $max;$k++){
					if($array_gid[$k] == $i['id']){
						$A=1;
						break;
					}
				}
				if($A==1){$count_various++;
				$fbphotoolkit = new sfFacebookPhoto;
				$picLink=$fbphotoolkit->getRealUrl("https://graph.facebook.com/".$i['id']."/picture?access_token=$access_token");
				echo "<tr height=40px>				
				<td  id=\"bb\" ><input type=radio name=gid id=gid  onClick=\"return false\" onMouseDown=\"rC(this)\"  value=".$i['id'].";$picLink;$access_token; ></td>
				<td  id=\"bb\" ><img src=\"$picLink\" style=\"padding:1px\"></td>
				<td  id=\"bb\" ><a href=group_info.php?gid=".$i['id']."&access_token=$access_token id=\"various$count_various\" target=blank >".$i['name']."</a></td>
				<td  id=\"bb\">";
				$gid=$i['id'];
				$sql_gid="SELECT *FROM `group` WHERE gid='$gid'";
				$dbquery=mysql_db_query($dbname,$sql_gid);
				$numrow_gid=mysql_num_rows($dbquery);
				$array2=mysql_fetch_array($dbquery);
				$array_uid=explode(";",$array2['uid']);
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
				echo "</td>
				</tr>";
				}
				else{
				}		
			}/*
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
			Request Password</td></tr>";*/
			?>
			<tr id=s>
			  <td>Size</td>
			  <td colspan="3">
					<label for="size"></label>
					  <select name="size" id="size">
						<option value="M">Medium</option>
						<option value="L" selected="selected">Large</option>
						<option value="XL">Extra large</option>
					  </select>
			   </td>
			</tr>
			<?
			echo "<tr><td colspan=4 align=\"center\"><input type=submit name=submit id=submit value=Submit /> <input type=reset name=reset id=reset value=Reset /></td></tr>";
			echo "</table>";
		echo "</form>";
		
	}
?>

<div id="displayqr" style="align:center;"></div>
<?

	$max=$count_various;
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
?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->