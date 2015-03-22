<?php
	$uid=$me['id'];
	$access_token=$session['access_token'];

	$mygroups=$facebook->api('/me/groups');
?>
<!--Ajax-->
 <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
 <script type="text/javascript" src="js/jquery.form.js"></script>

  <script type="text/javascript">

		// prepare the form when the DOM is ready 
		$(document).ready(function() { 
			// bind form using ajaxForm 
			$('#form1').ajaxForm({ 
				// target identifies the element(s) to update with the server response 
				dataType:  'xml', 
				beforeSubmit:function() { 
					$('#done').hide(); 
					$('#fail').hide(); 
					$('#loading').fadeIn('slow');  
				},
				// success identifies the function to invoke when the server response 
				// has been received; here we apply a fade-in effect to the new content 
				success: function(responseXML) { 
					var message = $('message', responseXML).text(); 
					if(message=="done"){
						$('#loading').hide(); 
						$('#fail').hide(); 
						$('#done').show(); 
					}
					else{
						$('#loading').hide(); 
						$('#done').hide(); 
						$('#fail').show(); 
					}
				} 
			}); 
		});
		
	</script>
<!--End Ajax-->
<body>
<h2>Group privacy setting</h2>
<?php
	echo "<form id=\"form1\"  action=update_group_setting.php method=post>
	  <table width=700px border=0 align=center cellpadding=3px cellspacing=0 id=setting>
		<tr id=s >
		  <td width=100 align=center valign=middle height=25px><b>Group</b></td>
		  <td  align=center valign=middle><b>name</b></td>
		  <td  align=center valign=middle><b>phone</b></td>
		  <td  align=center valign=middle><b>address</b></td>
		  <td  align=center valign=middle><b>website</b></td>
		  <td  align=center valign=middle><b>display</b></td>
		  <td  align=center valign=middle><b>status</b></td>
		  <td  align=center valign=middle><b>email</b></td>
		  <td  align=center valign=middle width=30px style=\"background-color: #FFF; border-bottom:1px solid #FFF;\"></td>
			";/*
		  <td  align=center valign=middle style=\"background-color: #CCC; border-bottom:1px solid #FFF;\"><b>password</b></td>
		</tr>";*/

include('config.inc.php');
$sql_uid="SELECT *FROM `setting` WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
//echo $array['name'].$array['phone_number'].$array['address'].$array['website'].$array['display'].$array['status'].$array['email'];
$c=0;
	foreach($mygroups['data'] as $i ){
	$c++;
		echo "<tr><td>".$i['name']."</td>";
		$array_gid = explode(";",$array['gid']);
		$array_privacy = explode(";",$array['privacy']);
		$max=count($array_gid);
		$A=0;
		for($k = 0;$k < $max;$k++){
			if($array_gid[$k] == $i['id']){		
				$A=1;
				break;
			}
		}
		if($A==1){
			echo "
			<td  align=center valign=top><input type=checkbox name=name$c id=name value=T ";if($array_privacy[$k][0]=='T')echo "checked";echo " /></td>
			<td  align=center valign=top><input type=checkbox name=phone_number$c id=phone_number value=T ";if($array_privacy[$k][1]=='T')echo "checked";echo " /></td>
			<td  align=center valign=top><input type=checkbox name=address$c id=address value=T ";if($array_privacy[$k][2]=='T')echo "checked";echo " /></td>
			<td  align=center valign=top><input type=checkbox name=website$c id=website value=T ";if($array_privacy[$k][3]=='T')echo "checked";echo " /></td>		
			<td  align=center valign=top><input type=checkbox name=display$c id=display value=T ";if($array_privacy[$k][4]=='T')echo "checked";echo " /></td>
			<td  align=center valign=top><input type=checkbox name=status$c id=status value=T ";if($array_privacy[$k][5]=='T')echo "checked";echo " /></td>
			<td  align=center valign=top><input type=checkbox name=email$c id=email value=T ";if($array_privacy[$k][6]=='T')echo "checked";echo " /></td>
			<td  align=center valign=top style=\"background-color: #FFF; border-bottom:1px solid #FFF;\"><input type=hidden name=gid$c id=gid value=".$array_gid[$k]." /></td>

		";/*
			<td  align=center valign=top style=\"background-color: #FFF;\"><input type=checkbox name=password$c id=password value=T ";if($array_privacy[$k][7]=='T')echo "checked";echo " /></td>
			";*/
		}
		else{
			echo "
			<td  align=center valign=top><input type=checkbox name=name$c id=name value=T /></td>
			<td  align=center valign=top><input type=checkbox name=phone_number$c id=phone_number value=T /></td>
			<td  align=center valign=top><input type=checkbox name=address$c id=address value=T /></td>
			<td  align=center valign=top><input type=checkbox name=website$c id=website value=T /></td>		
			<td  align=center valign=top><input type=checkbox name=display$c id=display value=T /></td>
			<td  align=center valign=top><input type=checkbox name=status$c id=status value=T /></td>
			<td  align=center valign=top><input type=checkbox name=email$c id=email value=T /></td>
			<td  align=center valign=top style=\"background-color: #FFF; border-bottom:1px solid #FFF;\"><input type=hidden name=gid$c id=gid value=".$i['id']." /></td>

		";/*
			<td  align=center valign=top style=\"background-color: #FFF; border-bottom:1px solid #FFF;\"><input type=checkbox name=password$c id=password value=T /></td>
			";*/
		}		
	}

echo "
	  </table>
	  <center>
	  <br>
	  <input type=hidden name=max id=max value=$c />
	  <input type=submit name=submit2 id=submit2 value=Submit />
	  <input type=reset name=reset2 id=reset2 value=Reset />
	  </center>
	</form>";
?>
	<div id=loading style="display:none;padding:5px;" class="fbinfobox"><center>Loading</center></div>
	<div id=done style="display:none;padding:5px;" class="fbbluebox"><center>Done</center></div>
	<div id=fail style="display:none;padding:5px;"  class="fberrorbox"><center>Enter password</center></div>
</body>