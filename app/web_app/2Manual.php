<?php
require 'fb/fblogin.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="ajaxify.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<style type="text/css">
body{
	background: #f2f2f2;
}
</style>
<body>

<? //fb autoresize ?>
<div id="fb-root"></div> 
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.Canvas.setAutoResize(true,100);
	};
</script>
<? //end fb autoresize ?>
<? require 'head.php'; ?>
<center>
<iframe width=100% height=580px frameborder=0 src="manual" scrolling=no></iframe>
</center>
<? require 'dev.html'; ?>
</body>
</html>
