<?php
	require('config.inc.php');
	$uid=$me['id'];
?>
<link type="text/css" rel="Stylesheet" href="jquery.validity.css" />
<script type="text/javascript" src="jquery-1.4.3.min.js"> </script>
<script type="text/javascript" src="jquery.validity.js"> </script>
 <!--       <script type="text/javascript">
            $(function() { 
                $("form1").validity(function() {
                    $("#phone_number")
                        .require()
                        .match("phone");
                    
                    $("#email")
                        .require()
                        .match("email");
						
					$("#display")
                        .require()
                        .match("url");
						
					$("#display")
                        .require()
                        .match("url");
                });
            });
        </script>
-->
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
</style>
			<?
				try{
					$param  =   array(
						'method'  => 'users.getinfo',
						'uids'    => $uid,
						'fields'  => 'uid,name,website,status,email',
						'callback'=> ''
					);
					$profile   =   $facebook->api($param);
					//$profile[0]['status']['message']=trim( preg_replace( '/\s+/', ' ', addslashes($profile[0]['status']['message'])));
				}
				catch(Exception $o) {
					echo "<pre>";
					//print_r($o);
					echo "Please try again.";
					echo "</pre>";
				}
			?>
<?php
require('config.inc.php');
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
						$('#done').hide(); 
						$('#loading').hide(); 
						$('#fail').show(); 

					}
				} 
			}); 
		
		
			$("#sync_name_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#name").attr("value", "<? echo $profile[0]['name'];?>");
			   else	$("#name").attr("value", "<? echo $name;?>");
			 });
			$("#sync_website_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#website").attr("value", "<? echo $profile[0]['website'];?>");
			   else	$("#website").attr("value", "<? echo $website;?>");
			 });
			 $("#sync_display_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#display").attr("value", "<? echo "https://graph.facebook.com/".$profile[0]['uid']."/picture";?>");
			   else	$("#display").attr("value", "<? echo $display;?>");
			 });
			$("#sync_status_facebook").click( function(){
			   if( $(this).is(':checked') ) 
					$("#status").attr("value", "<?
					echo str_replace("&", "\&", str_replace("\"", "\\\"", str_replace("\n", " ", $profile[0]['status']['message'])));					
					?>");
			   else	$("#status").attr("value", "<? echo addslashes(str_replace("
", "\n", $status));?>");
			 });
			$("#sync_email_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#email").attr("value", "<? echo $profile[0]['email'];?>");
			   else	$("#email").attr("value", "<? echo $email;?>");
			 });
		 });
	</script>
<!--End Ajax-->
<body>
<H2>Profile</H2>
<?
     echo"<form id=\"form1\" action=updateprofile.php method=post>
              <table width=550 border=0 align=center cellpadding=4px cellspacing=0 id=setting>
                <tr id=s>
                  <td width=125 align=left valign=top><font color=#FF0000>*</font>Phonenumber</td>
                  <td width=240 align=left valign=top><label for=phone_number></label>
                  <input name=phone_number type=text id=phone_number size=25 maxlength=10 value=\"$phone_number\">
                  </td>
				  <td width=185 align=left valign=top></td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Address</td>
                  <td width=240 align=left valign=top><label for=address></label>
                  <textarea name=address id=address cols=25 rows=5>$address</textarea></td>
				  <td width=185 align=left valign=top></td>
                </tr>
                <tr id=s>
                  <td width=125 align=left valign=top>Name</td>
                  <td width=240 align=left valign=top><label for=name></label>
                  <input name=name type=text id=name size=25 value=\"$name\"></td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_name_facebook id=sync_name_facebook ";if($sync%10)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  use this from facebook.</td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Website</td>
                  <td width=240 align=left valign=top><label for=website></label>
                  <input name=website type=text id=website size=25 value=\"$website\"></td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_website_facebook id=sync_website_facebook ";if($sync%100>=10)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  use this from facebook.
				  </td>
                </tr>
                <tr id=s>
                  <td width=125 align=left valign=top>Display(url only)</td>
                  <td width=240 align=left valign=top><label for=display></label>
                  <input name=display type=text id=display size=25 value=\"$display\"></td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_display_facebook id=sync_display_facebook ";if($sync%1000>=100)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  use this from facebook.
				  </td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Status</td>
                  <td width=240 align=left valign=top><label for=status></label>
                  <textarea name=status id=status cols=25 rows=5>";echo $status;/*echo htmlentities($status);*/echo "</textarea>";
				  /*<input name=status type=text id=status size=25 value=\"";echo htmlentities($status);echo "\">*/
				  echo "
				  </td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_status_facebook id=sync_status_facebook ";if($sync>=1000)echo"checked"; echo" >
                    <label for=sync_facebook></label>
                  use this from facebook.
				  </td>
                </tr>
                <tr id=s>
                  <td width=125 align=left valign=top>Email</td>
                  <td colspan=2 align=left valign=top><label for=email></label>
                  <input name=email type=text id=email size=25 value=\"$email\"></td>
                </tr>
              </table>
			  <br>
				<center>
					<input type=submit name=submit id=submit value=Submit />
					<input type=reset name=reset id=reset value=Reset />
				</center>
            </form>";
?>
	<div id=loading style="display:none; padding:5px;" class="fbinfobox"><center>Loading</center></div>
	<div id=done style="display:none; padding:5px;" class="fbbluebox"><center>Done</center></div>
	<div id=fail style="display:none; padding:5px;" class="fberrorbox"><center>Enter phone number</center></div>
</body>
</html>