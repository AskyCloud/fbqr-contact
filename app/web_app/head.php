<style type="text/css">
#page{
	width:760px;
}
#head li{
	background-color:#3b5998;
	padding: 0px 0px 0px 0px;
	display:inline;
	float:left;
	text-align: right ;
	vertical-align: text-top;
	margin: 0px 0px;
}
#head{
font-size:11px;
font-family: tahoma;
	display:block;
	background-color:#3b5998;
	width:760px;
	height:154px;
}
#head z{
	display:inline;
	float:right;
}
#head a{
	font-size:11px;
	font-family: tahoma;
	color:#ffffff;
	text-decoration: none;
}
#head a:hover{
font-size:11px;
font-family: tahoma;
text-decoration: none;
}
#head li c{
	padding: 104px 0px 0px 0px;
	background-color:#3b5998;
	display:inline;
	float:left;
	text-align: right ;
	vertical-align: text-top;
	margin: 0px 0px;
}
.frame{
	padding:20px 0px 0px 0px;
	width:100px;
	right:0px;
	vertical-align: text-top;
}

</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="facebook.css" rel="stylesheet" type="text/css" />
<div id=page>
	<div id=head>
	<li><c><?php echo "<img src=\"https://graph.facebook.com/".$me['id']."/picture\" border=0px>"; ?></c></li>
	<li><img src="img/head_02.png" border="0px"></li>
	<li><iframe class="frame"  src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></li>
	<z>
	<a href="main.php" class="fbmenu" style="border-left: 1px solid #26468a;">Home</a>
	<a href="2profile.php" class="fbmenu">Profile</a>
	<a href="2setting.php" class="fbmenu">Setting</a>
	<a href="2MyQR.php" class="fbmenu">QR Generator</a>
	<a href="2Follower.php" class="fbmenu">Follower</a>
	<a href="2Manual.php" class="fbmenu">Manual</a>
	<a href="2license.php" class="fbmenu">License Agreement</a>
	<a href="2thanks.php" class="fbmenu">Thanks</a>
	</z>
	</div>

</div>