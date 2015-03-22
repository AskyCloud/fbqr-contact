<?php
	require 'fb/fblogin.php';
	require('config.inc.php');
	$uid=$me['id'];
	$access_token=$session['access_token'];
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
 
       <link type="text/css" rel="Stylesheet" href="jquery.validity.css" />
        <script type="text/javascript" src="jquery.validity.js"> </script>
        <script type="text/javascript">
            $(function() { 
                $("form").validity(function() {
					$("#phone_number")
                        .require()
                        .match("phone");
						
                });
            });
        </script>
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
.bd{
	border:2px solid #00cbff;
	width:550px;
	margin:auto;
	padding:20px;
}
</style>


<body>

<div   align=center><img src="img/step1.png"></div>
<div class="bd">
<h1>Personal data</h1>
<?		
      echo"<form id=\"form1\" action=updateprofile.php?from=step1 method=post>
              <table width=550 border=0 align=center cellpadding=4px cellspacing=0>
                <tr>
                  <td width=125 align=left valign=top><font color=#FF0000>*</font>Phonenumber</td>
                  <td width=25 align=left valign=top colspan=2><label for=phone_number></label>
                  <input name=phone_number type=text id=phone_number size=25 maxlength=10 value=\"$phone_number\">
                  </td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Address</td>
                  <td width=240 align=left valign=top><label for=address></label>
                  <textarea name=address id=address cols=25 rows=5>$address</textarea></td>
				  <td width=185 align=left valign=top></td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Name</td>
                  <td width=240 align=left valign=top><label for=name></label>
                  <input name=name type=text id=name size=25 value=\"$name\"></td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_name_facebook id=sync_name_facebook />
                    <label for=sync_facebook></label>
                  use this from facebook.</td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Website</td>
                  <td width=240 align=left valign=top><label for=website></label>
                  <input name=website type=text id=website size=25 value=\"$website\"></td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_website_facebook id=sync_website_facebook />
                    <label for=sync_facebook></label>
                  use this from facebook.
				  </td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Display(url only)</td>
                  <td width=240 align=left valign=top><label for=display></label>
                  <input name=display type=text id=display size=25 value=\"$display\"></td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_display_facebook id=sync_display_facebook />
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
				  <input type=checkbox name=sync_status_facebook id=sync_status_facebook />
                    <label for=sync_facebook></label>
                  use this from facebook.
				  </td>
                </tr>
                <tr>
                  <td width=125 align=left valign=top>Email</td>
                  <td width=240 align=left valign=top><label for=email></label>
                  <input name=email type=text id=email size=25 value=\"$email\"></td>
				  <td width=185 align=left valign=top>
				  <input type=checkbox name=sync_email_facebook id=sync_email_facebook />
                    <label for=sync_facebook></label>
                  use this from facebook.
				  </td>
                </tr>
                <tr>
                  <td colspan=3 align=center><input type=submit name=submit id=submit value=Submit />
                  <input type=reset name=reset id=reset value=Reset /></td>
                </tr>
              </table>
            
            </form>";
?>
</div>
<?php
require 'dev.html';
?>
</body>
</html>