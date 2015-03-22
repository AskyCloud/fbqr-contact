<?php
	require('config.inc.php');
	require 'fb/fblogin.php';
	$uid=$me['id'];
?>
<?php
$sql_uid="SELECT *FROM profiles WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
if($numrow_uid==1){
	$array=mysql_fetch_array($dbquery);
	$phone_number=$array['phone_number'];
	$address=$array['address'];
	$name=$array['name'];
	$website=$array['website'];
	$display=$array['display'];
	$status=$array['status'];
	$email=$array['email'];
	$sync=$array['sync'];
	//echo $phone_number.$address.$name.$website.$display.$status.$email;
}
else{
	$phone_number="";
	$address="";
	$name="";
	$website="";
	$display="";
	$status="";
	$email="";
	$sync="";
}
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
		
			
			$("#sync_name_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#name").attr("value", "<? echo $userdata['name'];?>");
			   else	$("#name").attr("value", "<? echo $name;?>");
			 });
			$("#sync_website_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#website").attr("value", "<? echo $userdata['website'];?>");
			   else	$("#website").attr("value", "<? echo $website;?>");
			 });
			 $("#sync_display_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#display").attr("value", "<? echo "https://graph.facebook.com/".$userdata['id']."/picture";?>");
			   else	$("#display").attr("value", "<? echo $display;?>");
			 });
			$("#sync_status_facebook").click( function(){
			   if( $(this).is(':checked') ) 
						$("#status").attr("value", "<? echo
						echo str_replace("&", "\&", str_replace("\"", "\\\"", str_replace("\n", " ", $profile[0]['status']['message'])));					
						?>");
			   else	$("#status").attr("value", "<? echo addslashes($status);?>");
			 });
			$("#sync_email_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#email").attr("value", "<? echo $userdata['email'];?>");
			   else	$("#email").attr("value", "<? echo $email;?>");
			 });
		 });
	</script>
<!--End Ajax-->

<body>
<div style="height:15px"></div>
<?

     echo"<form id=\"form1\" action=updateprofiles.php method=post>
				<input name=access_token type=hidden id=access_token size=25 maxlength=10 value=\"$access_token\">
              <table width=310 border=0 align=center cellpadding=1px cellspacing=0>
                
				
				<tr id=s>
                  <td width=310 align=left valign=top><font color=#FF0000>*</font>Phonenumber</td>
				</tr>
				<tr id=s>
                  <td width=310 align=left valign=top><label for=phone_number></label>
                  <input name=phone_number type=text id=phone_number size=25 maxlength=10 value=\"$phone_number\">
                  </td>
				</tr>
				
				
				<tr>
                  <td width=310 align=left valign=top>Email</td>
				</tr>
				<tr>
                  <td width=310 align=left valign=top><label for=email></label>
                  <input name=email type=text id=email size=25 value=\"$email\"></td>
				</tr>	


				
				<tr id=s>
                  <td width=310 align=left valign=top>Name</td>
				</tr>
				<tr id=s>
                  <td width=310 align=left valign=top><label for=name></label>
                  <input name=name type=text id=name size=25 value=\"$name\">
				  <input type=checkbox name=sync_name_facebook id=sync_name_facebook ";if($sync%10)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  Sync fb.</td>
				</tr>
				
				
				            
                <tr>
                  <td width=310 align=left valign=top>Website</td>
				</tr>
                <tr>
				  <td width=310 align=left valign=top><label for=website></label>
                  <input name=website type=text id=website size=25 value=\"$website\">
				  <input type=checkbox name=sync_website_facebook id=sync_website_facebook ";if($sync%100>=10)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  Sync fb.</td>
				</tr>
				
				
				
                <tr id=s>
                  <td width=310 align=left valign=top>Display(url only)</td>
				</tr>
				<tr id=s>
                  <td width=310 align=left valign=top><label for=display></label>
                  <input name=display type=text id=display size=25 value=\"$display\">
				  <input type=checkbox name=sync_display_facebook id=sync_display_facebook ";if($sync%1000>=100)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  Sync fb.</td>
				</tr>
				
				
				
                <tr>
                  <td width=310 align=left valign=top>Status</td>
				</tr>
				<tr>
                  <td width=310 align=left valign=top><label for=status></label>
                  <textarea name=status id=status cols=25 rows=5>";echo $status;/*echo htmlentities($status);*/echo "</textarea>";
				  /*<input name=status type=text id=status size=25 value=\"";echo htmlentities($status);echo "\">*/
				  echo "
				  <input type=checkbox name=sync_status_facebook id=sync_status_facebook ";if($sync>=1000)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  Sync fb.</td>
				</tr>
				

				<tr id=s>
                  <td width=310 align=left valign=top>Address</td>
				</tr>
				<tr id=s>
                  <td width=310 align=left valign=top><label for=address></label>
                  <textarea name=address id=address cols=25 rows=5>$address</textarea></td>
				</tr>
				
                <tr>
                  <td align=center ><input type=submit name=submit id=submit value=Submit />
                  <input type=reset name=reset id=reset value=Reset /></td>
                </tr>
              </table>
            
            </form>";
	
?>
	<div id=loading style="display:none"><div style="background-color:#ffa; padding:5px"><center>Loading</center></div></div>
	<div id=done style="display:none"><div style="background-color:#ffa; padding:5px"><center>Done</center></div></div>
	<div id=fail style="display:none"><div style="background-color:#ffa; padding:5px"><center>Enter Phone number</center></div></div>
</body>
</html>