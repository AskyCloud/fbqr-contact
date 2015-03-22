<?php
	require 'fb/fblogin.php';
	require('config.inc.php');
	require('group.func.php');
	header('Content-type: text/xml'); 
	$uid=$me['id'];
	$access_token=$session['access_token'];
	$max=$_REQUEST['max'];
	for($k = 1;$k <= $max;$k++){
		$index_name="name".$k;
		$index_phone_number="phone_number".$k;
		$index_address="address".$k;
		$index_website="website".$k;
		$index_display="display".$k;
		$index_status="status".$k;
		$index_email="email".$k;
		$index_password="password".$k;
		$index_gid="gid".$k;
		$gid=$_POST[$index_gid];
		
		$privacy="";
		$c=0;
				if($_POST[$index_name]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
				if($_POST[$index_phone_number]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
				if($_POST[$index_address]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
				if($_POST[$index_website]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
				if($_POST[$index_display]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
				if($_POST[$index_status]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
				if($_POST[$index_email]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
				if($_POST[$index_password]=="T"){$privacy=$privacy."T"; $c++;}
				else $privacy=$privacy."F";
			
			if($c != 0){				
				group_input($gid,$uid,$privacy);
			}
			if($privacy=="FFFFFFFF"){
				del_group($gid,$uid);
			}

	}
echo '<root><message>done</message></root>';
?>