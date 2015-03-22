<?php
	$uid=$me['id'];
	$access_token=$session['access_token'];
?>
<!--Ajax-->
 <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
 <script type="text/javascript" src="js/jquery.form.js"></script>

  <script type="text/javascript">

		// prepare the form when the DOM is ready 
		$(document).ready(function() { 
			// bind form using ajaxForm 
			$('#form').ajaxForm({ 
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
<h2>Personal privacy setting</h2>
<?php
	echo "<form id=\"form1\"  action=updatesetting.php method=post>
	  <table width=600 border=0 align=center cellpadding=3px cellspacing=0 id=setting>
		<tr id=s >
		  <td width=100 align=center valign=middle height=25px><b>Data</b></td>
		  <td  align=center valign=middle><b>Everyone</b></td>
		  <td  align=center valign=middle><b>Password</b></td>
		  <td  align=center valign=top><b>Friend</b></td>
		  <td  align=center valign=top><b>Mutual Friends</b></td>
		  <td  align=center valign=middle><b>None</b></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Name
		  </td>";

include('config.inc.php');
$sql_uid="SELECT *FROM setting WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
//echo $array['name'].$array['phone_number'].$array['address'].$array['website'].$array['display'].$array['status'].$array['email'];
if($numrow_uid==1){
	echo"
		  <td  align=center valign=top><input type=radio name=name id=name value=A ";if($array['name']=='A')echo "checked";echo " /></td>
		  <td  align=center valign=top><input type=radio name=name id=name2 value=B ";if($array['name']=='B')echo "checked";echo " /></td>
		  <td  align=center valign=top><input type=radio name=name id=name3 value=C ";if($array['name']=='C')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=name id=name4 value=D ";if($array['name']=='D')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=name id=name5 value=N ";if($array['name']=='N')echo "checked";echo "/></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Phone number</td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number value=A ";if($array['phone_number']=='A')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number2 value=B ";if($array['phone_number']=='B')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number3 value=C ";if($array['phone_number']=='C')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number4 value=D ";if($array['phone_number']=='D')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number5 value=N ";if($array['phone_number']=='N')echo "checked";echo "/></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Address</td>
		  <td  align=center valign=top><input type=radio name=address id=address value=A ";if($array['address']=='A')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=address id=address2 value=B ";if($array['address']=='B')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=address id=address3 value=C ";if($array['address']=='C')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=address id=address4 value=D ";if($array['address']=='D')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=address id=address5 value=N ";if($array['address']=='N')echo "checked";echo "/></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Website</td>
		  <td  align=center valign=top><input type=radio name=website id=website value=A ";if($array['website']=='A')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=website id=website2 value=B ";if($array['website']=='B')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=website id=website3 value=C ";if($array['website']=='C')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=website id=website4 value=D ";if($array['website']=='D')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=website id=website5 value=N ";if($array['website']=='N')echo "checked";echo "/></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Display</td>
		  <td  align=center valign=top><input type=radio name=display id=display value=A ";if($array['display']=='A')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=display id=display2 value=B ";if($array['display']=='B')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=display id=display3 value=C ";if($array['display']=='C')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=display id=display4 value=D ";if($array['display']=='D')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=display id=display5 value=N ";if($array['display']=='N')echo "checked";echo "/></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Status</td>
		  <td  align=center valign=top><input type=radio name=status id=status value=A ";if($array['status']=='A')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=status id=status2 value=B ";if($array['status']=='B')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=status id=status3 value=C ";if($array['status']=='C')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=status id=status4 value=D ";if($array['status']=='D')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=status id=status5 value=N ";if($array['status']=='N')echo "checked";echo "/></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Email</td>
		  <td  align=center valign=top><input type=radio name=email id=email value=A ";if($array['email']=='A')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=email id=email2 value=B ";if($array['email']=='B')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=email id=email3 value=C ";if($array['email']=='C')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=email id=email4 value=D ";if($array['email']=='D')echo "checked";echo "/></td>
		  <td  align=center valign=top><input type=radio name=email id=email5 value=N ";if($array['email']=='N')echo "checked";echo "/></td>
		</tr>";
}
else{
	echo"
		  <td width=100 align=center valign=top><input type=radio name=name id=name value=A /></td>
		  <td  align=center valign=top><input type=radio name=name id=name2 value=B /></td>
		  <td  align=center valign=top><input type=radio name=name id=name3 value=C /></td>
		  <td  align=center valign=top><input type=radio name=name id=name4 value=D /></td>
		  <td  align=center valign=top><input type=radio name=name id=name5 checked value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Phone number</td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number value=A /></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number2 value=B /></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number3 value=C /></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number4 value=D /></td>
		  <td  align=center valign=top><input type=radio name=phone_number id=phone_number5 checked value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Address</td>
		  <td  align=center valign=top><input type=radio name=address id=address value=A /></td>
		  <td  align=center valign=top><input type=radio name=address id=address2 value=B /></td>
		  <td  align=center valign=top><input type=radio name=address id=address3 value=C /></td>
		  <td  align=center valign=top><input type=radio name=address id=address4 value=D /></td>
		  <td  align=center valign=top><input type=radio name=address id=address5 checked value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Website</td>
		  <td  align=center valign=top><input type=radio name=website id=website value=A /></td>
		  <td  align=center valign=top><input type=radio name=website id=website2 value=B /></td>
		  <td  align=center valign=top><input type=radio name=website id=website3 value=C /></td>
		  <td  align=center valign=top><input type=radio name=website id=website4 value=D /></td>
		  <td  align=center valign=top><input type=radio name=website id=website5 checked value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Display</td>
		  <td  align=center valign=top><input type=radio name=display id=display value=A /></td>
		  <td  align=center valign=top><input type=radio name=display id=display2 value=B /></td>
		  <td  align=center valign=top><input type=radio name=display id=display3 value=C /></td>
		  <td  align=center valign=top><input type=radio name=display id=display4 value=D /></td>
		  <td  align=center valign=top><input type=radio name=display id=display5 checked value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Status</td>
		  <td  align=center valign=top><input type=radio name=status id=status value=A /></td>
		  <td  align=center valign=top><input type=radio name=status id=status2 value=B /></td>
		  <td  align=center valign=top><input type=radio name=status id=status3 value=C /></td>
		  <td  align=center valign=top><input type=radio name=status id=status4 value=D /></td>
		  <td  align=center valign=top><input type=radio name=status id=status5 checked value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Email</td>
		  <td  align=center valign=top><input type=radio name=email id=email value=A /></td>
		  <td  align=center valign=top><input type=radio name=email id=email2 value=B /></td>
		  <td  align=center valign=top><input type=radio name=email id=email3 value=C /></td>
		  <td  align=center valign=top><input type=radio name=email id=email4 value=D /></td>
		  <td  align=center valign=top><input type=radio name=email id=email5 checked value=N /></td>
		</tr>
	  ";
}
echo "
	  </table>
	  <center>
	  <br>
	  <font color=red>*</font>password :: <input name=password type=password id=password size=25 value=\"";echo $array['password'];echo "\">
	  <br>
	  <input type=submit name=submit2 id=submit2 value=Submit />
	  <input type=reset name=reset2 id=reset2 value=Reset />
	  </center>
	</form>";
?>
	<div id=loading style="display:none;padding:5px;" class="fbinfobox"><center>Loading</center></div>
	<div id=done style="display:none;padding:5px;" class="fbbluebox"><center>Done</center></div>
	<div id=fail style="display:none;padding:5px;"  class="fberrorbox"><center>Enter password</center></div>
</body>