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
					$('div#displayqr').html('<div style="background-color:#ffa; padding:5px"><center>Loading</center></div>') ;
				},
				success: function(responseXML) {
					var stat = $(responseXML).find('stat').text();
					if(stat=="none"){
						$('div#displayqr').fadeIn('slow');  
						$('div#displayqr').html('<div style="background-color:#ffa; padding:5px"><center>Choose data</center></div>') ;
					}
					else if(stat=="fail"){
						$('div#displayqr').fadeIn('slow');  
						$('div#displayqr').html('<div style="background-color:#ffa; padding:5px"><center>Fail</center></div>') ;
					}
					else if(stat=="done"){
						var imgdata = $(responseXML).find('img').text();
						var stat = $(responseXML).find('stat').text();
						$('div#displayqr').fadeIn('slow');  
						$('div#displayqr').html('<img src=\'data:image/png;base64,'+imgdata+'\'>');
					}
				}
			}); 
			$("#SelectAll").click( function(){
			   if( $(this).is(':checked') ){
					$("#name_bool").attr("checked", "checked");
					$("#Phone_number_bool").attr("checked", "checked");
					$("#Address_bool").attr("checked", "checked");
					$("#Website_bool").attr("checked", "checked");
					$("#Status_bool").attr("checked", "checked");
					$("#Email_bool").attr("checked", "checked");
				}
				else{
					$("#name_bool").removeAttr("checked");
					$("#Phone_number_bool").removeAttr("checked");
					$("#Address_bool").removeAttr("checked");
					$("#Website_bool").removeAttr("checked");
					$("#Status_bool").removeAttr("checked");
					$("#Email_bool").removeAttr("checked");
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
echo "<form id=form1 name=form1 method=post action=xmlqr.php>";
		echo "<table cellspacing=0 border=0 cellpadding=3 align=center width=450px >";
		echo "<tr id=\"s\"><td align=left  valign=middle colspan=2 height=25px><b>Choose your Friend</b></td></tr>";
		

	$it_uid=$i['uid'];
	$sql_uid="SELECT *FROM profiles ";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	$j=0;
	while(++$j<=$numrow_uid){
		$array=mysql_fetch_array($dbquery);
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";target=\"_self\"
		echo "<tr>";
		echo "<td align=center  valign=top width=35px id=\"bb\" width=15px><input type=radio name=uid id=uncheck$j  onClick=\"return false\" onMouseDown=\"rC(this)\"  value=\"".$array['uid']."\"></td>";
		echo "<td  align=left  valign=bottom id=\"bb\" ><a href=\"friendinfo.php?fr=".$array['uid']."\" id=various$j>";
		echo "<img src=\"https://graph.facebook.com/".$array['uid']."/picture\" border=0 height=30px width=30px>";
		echo "<div id=line><b>".$array['name']."</b></div>";
		echo "</a></td></tr>";
	}

	?>	
				<tr><td colspan=2></td></tr>			
				<tr><td align=left  valign=middle colspan=2 height=25px bgcolor=#333 ><font color=#fff><b>Share data</b></font></td></tr>
			<tr  bgcolor="#AAA" >
			  <td style="  border-left:1px solid #333; border-bottom:1px solid #333;" ><input type="checkbox" name="SelectAll" id="SelectAll"  value="TRUE"></td>
			  <td align=left  style="border-bottom:1px solid #333; border-right:1px solid #333;" ><font color=#fff><b>Select All</b></font></td>
			</tr>
			  <tr>
			  <td bgcolor=#EEEEEE>
				  <input type="checkbox" name="name_bool" id="name_bool" value="TRUE" />
				  <label for="name"></label>
			  </td>
			  <td bgcolor=#EEEEEE>Name</td>
			</tr>
			<tr>
			  <td bgcolor=#EEEEEE><input type="checkbox" name="phone_number_bool" id="Phone_number_bool"  value="TRUE" /></td>
			  <td bgcolor=#EEEEEE>Phone number</td>
			</tr>
			  <td bgcolor=#EEEEEE><input type="checkbox" name="address_bool" id="Address_bool"  value="TRUE" /></td>
			  <td bgcolor=#EEEEEE>Address</td>
			</tr>
			<tr>
			  <td bgcolor=#EEEEEE><input type="checkbox" name="website_bool" id="Website_bool" value="TRUE"  /></td>
			  <td bgcolor=#EEEEEE>Website</td>
			</tr>
			<tr>
			  <td bgcolor=#EEEEEE><input type="checkbox" name="status_bool" id="Status_bool" value="TRUE" /></td>
			  <td bgcolor=#EEEEEE>Status</td>
			</tr>
			<tr>
			  <td bgcolor=#EEEEEE><input type="checkbox" name="email_bool" id="Email_bool" value="TRUE" /></td>			
			  <td bgcolor=#EEEEEE>Email</td>
			</tr>
			<tr>
			  <td bgcolor=#EEEEEE>Size</td>
			  <td bgcolor=#EEEEEE>
					<label for="size"></label>
					  <select name="size" id="size">
						<option value="M">Medium</option>
						<option value="L" selected="selected">Large</option>
						<option value="XL">Extra large</option>
					  </select>
			   </td>
			</tr>
	<?php
	//echo "<tr><td colspan=2>
	//<input type=hidden name=request id=request  value=\"false\">
	//<input type=checkbox name=request id=request  value=\"true\">	
	//Request Password</td></tr>";
	//echo "<tr><td colspan=2>Password :: <input name=password type=password id=password size=25></td></tr>";
	echo "<tr><td colspan=2><input type=submit name=submit id=submit value=Submit /> <input type=reset name=reset id=reset value=Reset /></td></tr>";
	echo "<tr><td colspan=2  align=center valign=top><div id=displayqr ></div></td></tr>";
	echo "</table>";
echo "</form>";

	$max=$j;
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
	
	echo "<script type=\"text/javascript\">";
	$max=$j;
	for($i=1;$i<=$max;$i++){
echo"	$(\"#uncheck$c\").click( function(){";
echo"		if( $(this).is(':checked') )
				$(this).removeAttr(\"checked\");
			else	$(this).attr(\"checked\", \"checked\");
	});";
	}

echo "</script>";
///////////////////////////////////////////////////////////////

?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->