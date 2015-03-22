<?php
	$uid=$me['id'];
	$access_token=$session['access_token'];
?>
<h2>MY QR</h2>
<?php
require('config.inc.php');
$sql_uid="SELECT *FROM profiles WHERE uid='$uid'";
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
	
function CheckSharing($it){
	if($it=='A')
	return 'Everyone';
	else if($it=='B')
	return 'Password';
	else if($it=='C')
	return 'Friend';
	else if($it=='D')
	return 'Mutual Friends';
	else if($it=='N')
	return 'None';
}
$sql="SELECT *FROM setting WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql);
$numrow_uid=mysql_num_rows($dbquery);
	$array_s=mysql_fetch_array($dbquery);
	$phone_number_s=CheckSharing($array_s['phone_number']);
	$address_s=CheckSharing($array_s['address']);
	$name_s=CheckSharing($array_s['name']);
	$website_s=CheckSharing($array_s['website']);
	$display_s=CheckSharing($array_s['display']);
	$status_s=CheckSharing($array_s['status']);
	$email_s=CheckSharing($array_s['email']);
?>

<!--//Ajax?-->
 <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>

<script type="text/javascript">
		$(document).ready(function() { 
			// bind form using ajaxForm 
			$('#form2').ajaxForm({ 
				// target identifies the element(s) to update with the server response 
				dataType:  'xml', 
				// success identifies the function to invoke when the server response 
				// has been received; here we apply a fade-in effect to the new content 
				beforeSubmit:function() { 
					$('div#displayqr2').fadeIn('slow'); 
					$('div#displayqr2').html('<div style="padding:5px"  class="fbinfobox"><center>Loading</center></div>') ;
				},
				success: function(responseXML) {
					var stat = $(responseXML).find('stat').text();
					if(stat=="none"){
						$('div#displayqr2').fadeIn('slow');  
						$('div#displayqr2').html('<div style="padding:5px"  class="fberrorbox"><center>Choose data</center></div>') ;
					}
					else if(stat=="fail"){
						$('div#displayqr2').fadeIn('slow');  
						$('div#displayqr2').html('<div style="padding:5px"  class="fberrorbox"><center>Fail</center></div>') ;
					}
					else if(stat=="done"){
						var imgdata = $(responseXML).find('img').text();
						var stat = $(responseXML).find('stat').text();
						var uid = $(responseXML).find('uid').text();
						$('div#displayqr2').fadeIn('slow');  
						$('div#displayqr2').html('<center><a href=\"share.php?uid='+uid+'\" target="_self"><img src=\"/img/facebookShareButton.jpg\" alt=\"share\"></a><br><img src=\'data:image/png;base64,'+imgdata+'\'></center>	');
							
					}
				}
			}); 
			$("#SelectAll2").click( function(){
			   if( $(this).is(':checked') ){
					$("#name_bool2").attr("checked", "checked");
					$("#Phone_number_bool2").attr("checked", "checked");
					$("#Address_bool2").attr("checked", "checked");
					$("#Website_bool2").attr("checked", "checked");
					$("#Status_bool2").attr("checked", "checked");
					$("#Email_bool2").attr("checked", "checked");
				}
				else{
					$("#name_bool2").removeAttr("checked");
					$("#Phone_number_bool2").removeAttr("checked");
					$("#Address_bool2").removeAttr("checked");
					$("#Website_bool2").removeAttr("checked");
					$("#Status_bool2").removeAttr("checked");
					$("#Email_bool2").removeAttr("checked");
				}
			 });
		});
</script>
<!--//End Ajax-->
<center>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center" valign="top" >
		<form id="form2" name="form1" method="post" action="xmlqr.php">
		  <label for="text"></label>
		  <table border="0" align="center" cellpadding="3" cellspacing="0" id=show_table>
		  <tr bgcolor=#333>
			  <td><input type="checkbox" name="SelectAll" id="SelectAll2"  value="TRUE"></td>
			  <td colspan=3 align=left><font color=#fff><b>Select All<b></font></td>
			</tr>
			<tr id=s>
			  <td><input type="checkbox" name="name_bool" id="name_bool2" value="TRUE" />
			  <label for="name"></label></td>
			  <td>Name</td>
			  <?php
				echo "<input type=hidden name=uid id=uid value=\"".$uid."\">";
				echo "<input type=hidden name=access_token id=access_token value=\"".$access_token."\">";
			  ?>
			  <?php
			  echo "<td>$name</td>";
			  echo "<td>$name_s</td>";
			  ?>

			</tr>

			<tr>
			  <td><input type="checkbox" name="phone_number_bool" id="Phone_number_bool2"  value="TRUE"></td>
			  <td>Phone number</td>
			  <?php
			  echo "<td>$phone_number</td>";
			  echo "<td>$phone_number_s</td>";
			  ?>

			</tr>
			<tr id=s>
			  <td><input type="checkbox" name="address_bool" id="Address_bool2"  value="TRUE" /></td>
			  <td>Address</td>
			  <?php
				$address=nl2br($address);
			  echo "<td>$address</td>";
			  echo "<td>$address_s</td>";
			  ?>

			</tr>
			<tr>
			  <td><input type="checkbox" name="website_bool" id="Website_bool2" value="TRUE"  /></td>
			  <td>Website</td>
			  <?php
			  echo "<td>$website</td>";
			  echo "<td>$website_s</td>";
			  ?>
			</tr>
			<!--<tr id=s>
			  <td><input type="checkbox" name="display_bool" id="Display_bool"  value="TRUE" /></td>
			  <td>Display</td>
			  <?php
					//echo "<td>$display</td>";
			  ?>			  
			</tr> -->
			<tr id=s>
			  <td><input type="checkbox" name="status_bool" id="Status_bool2" value="TRUE" /></td>
			  <td>Status</td>
			  <?php
				$status=nl2br($status);
			  echo "<td>$status</td>";
			  echo "<td>$status_s</td>";
			  ?>			  
			</tr>
			<tr>
			  <td><input type="checkbox" name="email_bool" id="Email_bool2" value="TRUE" /></td>			
			  <td>Email</td>
			  <?php
			  echo "<td>$email</td>";
			  echo "<td>$email_s</td>";
			  ?>
			</tr>
			<tr id=s>
			  <td>Size</td>
			  <td colspan="3">
					<label for="size"></label>
					  <select name="size" id="size2">
						<option value="M">Medium</option>
						<option value="L" selected="selected">Large</option>
						<option value="XL">Extra large</option>
					  </select>
			   </td>
			</tr>
		  </table>
			<input type="submit" name="Submit" id="submit2" value="Submit" />
			<input type="reset" name="Reset" id="button2" value="Reset" />
		</form>
	</td>
</tr>
<tr>
<td  align="center" valign="top" ><div id="displayqr2"></div>
</td>
</tr>
</table>
</center>