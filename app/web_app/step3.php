<?php
	require 'fb/fblogin.php';
	$uid=$me['id'];
	$access_token=$session['access_token'];
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
.bd{
	border:2px solid #10ee23;
	width:550px;
	margin:auto;
	padding:20px;
}

</style>
<?php
require('config.inc.php');
$sql_uid="SELECT *FROM profiles WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
	$array=mysql_fetch_array($dbquery);
	$phone_number=$array['phone_number'];
	$address=nl2br($array['address']);
	$name=$array['name'];
	$website=$array['website'];
	$display=$array['display'];
	$status=nl2br($array['status']);
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
			$('#form1').ajaxForm({ 
				// target identifies the element(s) to update with the server response 
				dataType:  'xml', 
				// success identifies the function to invoke when the server response 
				// has been received; here we apply a fade-in effect to the new content 
				beforeSubmit:function() { 
					$('div#displayqr').fadeIn('slow'); 
					$('div#displayqr').html('<div style="background-color:#ffa; padding:5px"><center>Loading</center></div>') ;
				},
				success: function(responseXML) { 
					var imgdata = $(responseXML).find('img').text();
					var stat = $(responseXML).find('stat').text();
					if(stat=="done") 
						$('div#displayqr').fadeIn('slow');  
						$('div#displayqr').html('<img src=\'data:image/png;base64,'+imgdata+'\'>');
					 
				} 
			}); 
		});
</script>
<!--//End Ajax-->
<body>
<div align=center><img src="img/step3.png"></div>
<center class="bd">
<h1>Successful!!</h1>

<table border="0" align="center" cellpadding="2" cellspacing="0" id=show_table>
<?php
echo "
<tr id=s><td id=bold>Name</td><td>$name</td><td>$name_s</td></tr>
<tr><td id=bold>Phone number</td><td>$phone_number</td><td>$phone_number_s</td></tr>
<tr id=s><td id=bold>Address</td><td>$address</td><td>$address_s</td></tr>
<tr><td id=bold>Website</td><td>$website</td><td>$website_s</td></tr>
<tr id=s><td id=bold>Status</td><td>$status</td><td>$status_s</td></tr>
<tr><td id=bold>Email</td><td>$email</td><td>$email_s</td></tr>
<tr id=s><td id=bold colspan=3 align=center >Password : ".$array_s['password']."</td></tr>
";
 ?>
</table>
<br>
<div id=lets_go><a href="index.php">Let's use FbQr</a></div><br>
</center>
<?php
require 'dev.html';
?>
</body>