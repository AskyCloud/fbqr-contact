<?php
	$access_token=$_REQUEST['access_token'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>FBQR On Mobile</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
<script type="text/javascript" src="./js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui-1.8.4.custom.min.js"></script>
<!--
<script type="text/javascript">
			$(function(){
				// Accordion
				$("#accordion").accordion({ header: "h3" });
				// Tabs
				$('#tabs').tabs();
			});
		</script>
-->

<script type="text/javascript" src="./js/ajaxify.js"></script>
<script type="text/javascript">
  $(document).ready(function() {  
   $('.ajaxify').ajaxify({
	     loading_image: './loading/loading.gif'
   }
   );
  }); 
</script>
</head>

<body>
<div id="menu" align="left">
<li><a href="home.php<?php echo "?access_token=".$access_token; ?>"  class="ajaxify" target="#example-container">Home</a></li>
<li><a href="profiles.php<?php echo "?access_token=".$access_token; ?>"  class="ajaxify" target="#example-container">Profile</a></li>
<li><a href="setting.php<?php echo "?access_token=".$access_token; ?>"  class="ajaxify" target="#example-container">Setting</a></li>
<li><a href="getqr.php<?php echo "?access_token=".$access_token; ?>"  class="ajaxify" target="#example-container">Generate</a></li>
</div>
<div id="example-container">
<?
require 'home.php';
?>
</div>
<br>
<!--
<div id="tabs" >
<ul>
    <li><a href="#tabs-1">test</a></li>
    <li><a href="#tabs-2">test13254679</a></li>
    <li><a href="#tabs-3">testasdasdasdasdasdasdasdas</a></li>
</ul>

<div id="tabs-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>

			<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>

			<div id="tabs-3">Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
</div>-->
<?php
require '../dev_m.html';
?>
</body>
</html>
