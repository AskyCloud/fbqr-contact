<?php
	$fbconfig['appid']  = "146472442045328";
	$fbconfig['secret']  = "a8590a401b869e64ab1e40da202dd9b4";
	$fbconfig['canvas_url']  = "http://apps.facebook.com/fbqrcontact/";

	$host="localhost";
	$user="tkroputa_db";
	$passwd="r3d_penguin";
	$dbname="tkroputa_db";
	mysql_connect($host,$user,$passwd)or die("Conecting failed");
	mysql_query("SET NAMES UTF8");
	mysql_select_db($dbname)or die("Selecting database failed");
?>