<style type="text/css">
	#block{display:table;padding: 10px 0px;margin:auto;}
	#blank{display:table-row;height:15px;}
	#avatar img{border-color:#FFFFFF;}
	#update {padding-left:10px;height:25px;background:url(images/menu_bg.png);}
	#update li {float:left;list-style-type:none;}	
	#update li b {display:block;padding: 0px 5px;color:#d4dae8;font-size:20px;}
	#update li c {display:block;padding: 4px 9px 5px 9px;background-color:#eceff6;width:250px;border:1px solid #d4dae8}
	#update li img {display:block;padding: 0px 0px 0px 0px;}	

</style>

<?
	echo "<div id=block>";
	echo "<div id=update>";
	echo "<li><b>Update</b></li>";
	echo "</div>";
	echo "<div id=update>";
	echo "<li><c>";require '../update_text.php';
	$str=nl2br($str);
	echo "$str</c></li></div>";
?>

<!--
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D146472442045328&amp;width=600&amp;colorscheme=light&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:600px; height:587px;" allowTransparency="true"></iframe>
-->