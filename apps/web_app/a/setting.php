<?php
	require('config.inc.php');
	require('../fb/facebook.php');
	$access_token=$_REQUEST['access_token'];
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	  ));
	$token =  array('access_token' => $access_token,);
	$userdata = $facebook->api('/me', 'GET', $token);
	$uid=$userdata['id'];
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
<div style="height:15px"></div>
<?php
	echo "<form id=\"form1\"  action=updatesetting.php method=post>
	  <table width=300 border=0 align=center cellpadding=3px cellspacing=0 id=setting>
	  <input name=access_token type=hidden id=access_token size=15 maxlength=10 value=\"$access_token\">
		<tr>
		  <td width=150 align=center valign=middle bgcolor =#CCC ><strong>Data</strong></td>
		  <td width=150 align=center valign=middle bgcolor =#CCC ><strong>Type to share</strong></td>
		  </tr>
		<tr>
		  <td width=150 align=left valign=top>Name
		  </td>";

include('config.inc.php');
$sql_uid="SELECT *FROM setting WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
if($numrow_uid==1){
	echo"
		  <td width=150 align=center valign=top>
		  	<select name=name id=name title=name >
				  <option value=N ";if($array['name']=='N')echo " selected=selected";echo " >None</option>
				  <option value=A ";if($array['name']=='A')echo " selected=selected";echo " >Every one</option>
				  <option value=B ";if($array['name']=='B')echo " selected=selected";echo " >Password</option>
				  <option value=C ";if($array['name']=='C')echo " selected=selected";echo " >Friend</option>
				  <option value=D ";if($array['name']=='D')echo " selected=selected";echo " >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Phone number</td>
		  <td width=150 align=center valign=top>
		  	<select name=phone_number id=phone_number title=phone number >
				  <option value=N ";if($array['phone_number']=='N')echo " selected=selected";echo " >None</option>
				  <option value=A ";if($array['phone_number']=='A')echo " selected=selected";echo " >Every one</option>
				  <option value=B ";if($array['phone_number']=='B')echo " selected=selected";echo " >Password</option>
				  <option value=C ";if($array['phone_number']=='C')echo " selected=selected";echo " >Friend</option>
				  <option value=D ";if($array['phone_number']=='D')echo " selected=selected";echo " >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Address</td>
		  <td width=150 align=center valign=top>
		  	<select name=address id=address title=address >
				  <option value=N ";if($array['address']=='N')echo " selected=selected";echo " >None</option>
				  <option value=A ";if($array['address']=='A')echo " selected=selected";echo " >Every one</option>
				  <option value=B ";if($array['address']=='B')echo " selected=selected";echo " >Password</option>
				  <option value=C ";if($array['address']=='C')echo " selected=selected";echo " >Friend</option>
				  <option value=D ";if($array['address']=='D')echo " selected=selected";echo " >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Website</td>
		  <td width=150 align=center valign=top>
			<select name=website id=website title=website >
				  <option value=N ";if($array['website']=='N')echo " selected=selected";echo " >None</option>
				  <option value=A ";if($array['website']=='A')echo " selected=selected";echo " >Every one</option>
				  <option value=B ";if($array['website']=='B')echo " selected=selected";echo " >Password</option>
				  <option value=C ";if($array['website']=='C')echo " selected=selected";echo " >Friend</option>
				  <option value=D ";if($array['website']=='D')echo " selected=selected";echo " >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Display</td>
		  <td width=150 align=center valign=top>
			<select name=display id=display title=display >
				  <option value=N ";if($array['display']=='N')echo " selected=selected";echo " >None</option>
				  <option value=A ";if($array['display']=='A')echo " selected=selected";echo " >Every one</option>
				  <option value=B ";if($array['display']=='B')echo " selected=selected";echo " >Password</option>
				  <option value=C ";if($array['display']=='C')echo " selected=selected";echo " >Friend</option>
				  <option value=D ";if($array['display']=='D')echo " selected=selected";echo " >Mutual Friends</option>
			</select>
		 </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Status</td>
		  <td width=150 align=center valign=top>
			<select name=status id=status title=status >
				  <option value=N ";if($array['status']=='N')echo " selected=selected";echo " >None</option>
				  <option value=A ";if($array['status']=='A')echo " selected=selected";echo " >Every one</option>
				  <option value=B ";if($array['status']=='B')echo " selected=selected";echo " >Password</option>
				  <option value=C ";if($array['status']=='C')echo " selected=selected";echo " >Friend</option>
				  <option value=D ";if($array['status']=='D')echo " selected=selected";echo " >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Email</td>
		  <td width=150 align=center valign=top>
			<select name=email id=email title=email >
				  <option value=N ";if($array['email']=='N')echo " selected=selected";echo " >None</option>
				  <option value=A ";if($array['email']=='A')echo " selected=selected";echo " >Every one</option>
				  <option value=B ";if($array['email']=='B')echo " selected=selected";echo " >Password</option>
				  <option value=C ";if($array['email']=='C')echo " selected=selected";echo " >Friend</option>
				  <option value=D ";if($array['email']=='D')echo " selected=selected";echo " >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		<td colspan=6  align=center valign=top>
			<font color=red>*</font>password :: <input name=password type=password id=password size=25 value=\"";echo $array['password'];echo "\">
		</td>
		</tr>
	  ";
}
else{
	echo"
		  <td width=150 align=center valign=top>
			<select name=name id=name title=name >
				<option value=N >None</option>
				<option value=A >Every one</option>
				<option value=B >Password</option>
				<option value=C selected=selected >Friend</option>
				<option value=D >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Phone number</td>
		  <td width=150 align=center valign=top>
		  <select name=phone_number id=phone_number title=phone number >
				<option value=N >None</option>
				<option value=A >Every one</option>
				<option value=B >Password</option>
				<option value=C selected=selected >Friend</option>
				<option value=D >Mutual Friends</option>
			</select>
			</td>
		 </tr>
		<tr>
		  <td width=150 align=left valign=top>Address</td>
		  <td width=150 align=center valign=top>
		  	<select name=address id=address title=address >
				<option value=N >None</option>
				<option value=A >Every one</option>
				<option value=B >Password</option>
				<option value=C selected=selected >Friend</option>
				<option value=D >Mutual Friends</option>
			</select>
			</td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Website</td>
		  <td width=150 align=center valign=top>
		  	<select name=website id=website title=website >
				<option value=N >None</option>
				<option value=A >Every one</option>
				<option value=B >Password</option>
				<option value=C selected=selected >Friend</option>
				<option value=D >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Display</td>
		  <td width=150 align=center valign=top>
		  	<select name=display id=display title=display >
				<option value=N >None</option>
				<option value=A >Every one</option>
				<option value=B >Password</option>
				<option value=C selected=selected >Friend</option>
				<option value=D >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Status</td>
		  <td width=150 align=center valign=top>
		  	<select name=status id=status title=status >
				<option value=N >None</option>
				<option value=A >Every one</option>
				<option value=B >Password</option>
				<option value=C selected=selected >Friend</option>
				<option value=D >Mutual Friends</option>
			</select>
			</td>
		</tr>
		<tr>
		  <td width=150 align=left valign=top>Email</td>
		  <td width=150 align=center valign=top>
		  	<select name=email id=email title=email >
				<option value=N >None</option>
				<option value=A >Every one</option>
				<option value=B >Password</option>
				<option value=C selected=selected >Friend</option>
				<option value=D >Mutual Friends</option>
			</select>
		  </td>
		</tr>
		<tr>
		<td colspan=6  align=center valign=top>
			<font color=red>*</font>password :: <input name=password type=password id=password size=25>
		</td>
		</tr>
	  ";
}
echo "
	  </table>
	  <br />
	  <center>
	  <input type=submit name=submit2 id=submit2 value=Submit />
	  <input type=reset name=reset2 id=reset2 value=Reset />
	  </center>
	</form>";
?>
	<div id=loading style="display:none"><div style="background-color:#ffa; padding:5px"><center>Loading</center></div></div>
	<div id=done style="display:none"><div style="background-color:#ffa; padding:5px"><center>Done</center></div></div>
	<div id=fail style="display:none"><div style="background-color:#ffa; padding:5px"><center>Enter password</center></div></div>
</body>