<?php
	$access_token=$_REQUEST['access_token'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>
<?php echo "<center><img src=\"https://graph.facebook.com/".$uid."/picture\" border=0px><br>".$userdata['name']."</center>"; ?>
Step 2 fill sharing data.
<?php
	echo "<form id=\"form1\"  action=updatesetting.php?from=step2 method=post>
	  <table width=300 border=0 align=center cellpadding=3px cellspacing=0 id=setting>
	  <input name=access_token type=hidden id=access_token size=15 maxlength=10 value=\"$access_token\">
		<tr>
		  <td width=150 align=center valign=middle bgcolor =#CCC ><strong>Data</strong></td>
		  <td width=150 align=center valign=middle bgcolor =#CCC ><strong>Type to share</strong></td>
		  </tr>
		<tr>
		  <td width=150 align=left valign=top>Name
		  </td>	
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
	  </table>
	  <br />
	  <center>
	  <input type=submit name=submit2 id=submit2 value=Submit />
	  <input type=reset name=reset2 id=reset2 value=Reset />
	  </center>
	</form>";
?>
<?php
require '../dev_m.html';
?>