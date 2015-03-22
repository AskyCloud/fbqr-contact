<?php
	require('../fb/facebook.php');
	require('config.inc.php');
	$access_token=$_REQUEST['access_token'];
	$facebook = new Facebook(array(
		 'appId'  => $fbconfig['appid'],
		 'secret' => $fbconfig['secret'],
	));
	$token =  array('access_token' => $access_token,);
	$userdata = $facebook->api('/me', 'GET', $token);
	$uid=$userdata['id'];
	
?>
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
<!--Ajax-->
 <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
 <script type="text/javascript" src="js/jquery.form.js"></script>

  <script type="text/javascript">
		$(document).ready(function() {
			$("#sync_name_facebook").click( function(){
				
			   if( $(this).is(':checked') )
					$("#name").attr("value", "<? echo $profile[0]['name'];?>");
			  else	$("#name").attr("value", "");
			 });
			$("#sync_website_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#website").attr("value", "<? echo $profile[0]['website'];?>");
			   else	$("#website").attr("value", "");
			 });
			 $("#sync_display_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#display").attr("value", "<? echo "https://graph.facebook.com/".$profile[0]['uid']."/picture";?>");
			   else	$("#display").attr("value", "");
			 });
			$("#sync_status_facebook").click( function(){
			   if( $(this).is(':checked') ) 
					$("#status").attr("value", "<? echo str_replace("\n", " ", $profile[0]['status']['message']);?>");
			   else	$("#status").attr("value", "");
			 });
			$("#sync_email_facebook").click( function(){
			   if( $(this).is(':checked') )
					$("#email").attr("value", "<? echo $profile[0]['email'];?>");
			   else	$("#email").attr("value", "");
			 });
		});
	</script>
<!--End Ajax-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="./style.css" rel="stylesheet" type="text/css" />

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


<body>

<?php echo "<center><img src=\"https://graph.facebook.com/".$uid."/picture\" border=0px><br>".$userdata['name']."</center>"; ?>
Step 1 fill personal data.
<?		
     echo"<form id=\"form1\" action=updateprofile.php?from=step1 method=post>
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
				  <input type=checkbox name=sync_name_facebook id=sync_name_facebook >
                    <label for=sync_facebook></label>
                  Sync fb.</td>
				</tr>
				
				
				            
                <tr>
                  <td width=310 align=left valign=top>Website</td>
				</tr>
                <tr>
				  <td width=310 align=left valign=top><label for=website></label>
                  <input name=website type=text id=website size=25 value=\"$website\">
				  <input type=checkbox name=sync_website_facebook id=sync_website_facebook >
                    <label for=sync_facebook></label>
                  Sync fb.</td>
				</tr>
				
				
				
                <tr id=s>
                  <td width=310 align=left valign=top>Display(url only)</td>
				</tr>
				<tr id=s>
                  <td width=310 align=left valign=top><label for=display></label>
                  <input name=display type=text id=display size=25 value=\"$display\">
				  <input type=checkbox name=sync_display_facebook id=sync_display_facebook >
                    <label for=sync_facebook></label>
                  Sync fb.</td>
				</tr>
				
				
				
                <tr>
                  <td width=310 align=left valign=top>Status</td>
				</tr>
				<tr>
                  <td width=310 align=left valign=top><label for=status></label>
                  <textarea name=status id=status cols=25 rows=5></textarea>
				  <input type=checkbox name=sync_status_facebook id=sync_status_facebook >
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
<?php
require '../dev_m.html';
?>
</body>
</html>