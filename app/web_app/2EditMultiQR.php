<?php
require 'fb/fblogin.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="ajaxify.js"></script>

<script src="http://connect.facebook.net/en_US/all.js"></script>
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

<? //fb autoresize ?>
<div id="fb-root"></div> 
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.Canvas.setAutoResize(true,100);
	};
</script>
<? //end fb autoresize ?>
<? require 'head.php'; ?>
<div id="menu" align="center">
<li style="cursor: hand;"><a href="2MyQR.php" class="fbmenu2">My QR</a></li>
<li style="cursor: hand;"><a href="2FriendQR.php" class="fbmenu2">Friend QR</a></li>
<li style="cursor: hand;"><a href="2GroupQR.php" class="fbmenu2">Group QR</a></li>
<li style="cursor: hand;"><a class="fbmenu2">Multi QR</a></li>
</div>
<? require 'EditMultiQR.php'; ?>
<? require 'dev.html'; ?>
</body>
</html>
