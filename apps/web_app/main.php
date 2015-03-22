<?php
require 'fb/fblogin.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="ajaxify.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
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
<? require 'home.php'; ?>
<? require 'dev.html'; ?>
</body>
</html>
