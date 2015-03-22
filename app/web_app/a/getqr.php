<?php
	require('../config.inc.php');
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

<?php
$sql_uid="SELECT *FROM profiles WHERE uid='$uid' ";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
	$array=mysql_fetch_array($dbquery);
	$phone_number=$array['phone_number'];
	$address=$array['address'];
	$name=$array['name'];
	$website=$array['website'];
	$display=$array['display'];
	$status=$array['status'];
	$email=$array['email'];
?>
<div style="height:15px"></div>
<?php echo "<center><img src=\"https://graph.facebook.com/".$uid."/picture\" border=0px><br>".$userdata['name']."</center>"; ?>
<div style="height:15px"></div>
<center>
		<form id="form1" name="form1" method="post" action="xmlqr.php" target="_blank">
		<? echo "<input name=access_token type=hidden id=access_token size=15 maxlength=10 value=\"$access_token\">"; ?>
		  <table border="0" align="center" cellpadding="3" cellspacing="0" width="300px" id=show_table>
			<tr id=s>
			  <td><input type="checkbox" name="phone_number_bool" id="Phone_number_bool"  value="TRUE" checked></td>
			  <td>Phone</td>
			  <?php
			  echo "<td>$phone_number</td>";
			  ?>

			</tr>
			<tr>
			  <td><input type="checkbox" name="name_bool" id="name_bool" value="TRUE" />
			  <label for="name"></label></td>
			  <td>Name</td>
			  <?php
				echo "<input type=hidden name=access_token id=access_token value=\"".$access_token."\">";
			  ?>
			  <?php
			  echo "<td>$name</td>";
			  ?>

			</tr>
			<tr id=s>
			  <td><input type="checkbox" name="email_bool" id="Email_bool" value="TRUE" /></td>			
			  <td>Email</td>
			  <?php
			  echo "<td>$email</td>";
			  ?>
			</tr>
			
			<tr>
			  <td><input type="checkbox" name="website_bool" id="Website_bool" value="TRUE"  /></td>
			  <td>Website</td>
			  <?php
			  echo "<td>$website</td>";
			  ?>
			</tr><!--
			<tr id=s>
			  <td><input type="checkbox" name="display_bool" id="Display_bool"  value="TRUE" /></td>
			  <td>Display</td>
			  <?php
						//echo "<td>$display</td>";
			  ?>			  
			</tr> -->
			<tr id=s>
			  <td><input type="checkbox" name="status_bool" id="Status_bool" value="TRUE" /></td>
			  <td>Status</td>
			  <?php
				$status=nl2br($status);
			  echo "<td>$status</td>";
			  ?>			  
			</tr>
			<tr >
			  <td><input type="checkbox" name="address_bool" id="Address_bool"  value="TRUE" /></td>
			  <td>Address</td>
			  <?php
				$address=nl2br($address);
			  echo "<td>$address</td>";
			  ?>

			</tr>
			<tr id=s>
			  <td>Size</td>
			  <td colspan="2">
					<label for="size"></label>
					  <select name="size" id="size">
						<option value="M" selected="selected">Medium</option>
						<option value="L">Large</option>
						<option value="XL">Extra large</option>
					  </select>
			   </td>
			</tr>
		  </table>
		  <div style="height:15px"></div>
			<input type="submit" name="Submit" id="submit" value="Submit" />
			<input type="reset" name="Reset" id="button" value="Reset" />
		</form>
</center>