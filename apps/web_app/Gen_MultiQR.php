<?
	require 'fb/fblogin.php';
	if($_REQUEST['qrid'])
		$qrid=$_REQUEST['qrid'];
	else 
		require 'genqrid.php';
	$author_uid=$me['id'];
?>

<script src="jquery-1.4.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<link rel="stylesheet" href="style_2.css" />
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
	font-size: 14px;
	color:#666;
	text-decoration: none;
}
a:visited {
	font-size: 14px;
	color:#666;
	text-decoration: none;
}
a:hover {
	font-size: 14px;
	color:#666;
	text-decoration: underline;
}
a:active {
	font-size: 14px;
	color:#666;
	text-decoration: none;
}

</style>

<?
	//get Frined that use this app
	try{
		$param  =   array(
			'method'  => 'friends.getAppUsers',
			'callback'=> ''
		);
		$frApp   =   $facebook->api($param);
	}catch(Exception $o) {
		echo "<pre>";
		//print_r($o);
					echo "Please try again.";
		echo "</pre>";
	}
	try{
		$param  =   array(
			'method'  => 'users.getinfo',
			'uids'    => $frApp,
			'fields'  => 'uid,first_name',
			'callback'=> ''
		);
		$frProfiles   =   $facebook->api($param);
	}catch(Exception $o) {
		echo "<pre>";
		//print_r($o);
					echo "Please try again.";
		echo "</pre>";
	}
/*////////////////////////ORIGINAL/////////////////////////////////////	
	foreach ($frProfiles as $i){
		//echo "<a href=\"http://www.facebook.com/profile.php?id=".$i['uid']."&v=info\" target=\"_blank\">";
		echo "<a href=\"friendinfo.php?fr=".$i['uid']."\" target=\"_self\">";
		echo "<img src=\"https://graph.facebook.com/".$i[uid]."/picture\" border=0>";
		echo $i['name'];
		echo "</a>";
		echo "<br>";
	}
/////////////////////////////////////////////////////////////*/
?>
<center>
<?	
	
	$check_none=0;
	if ($_POST['group_picture'] != "" && (substr($_POST['group_picture'],strlen($_POST['group_picture'])-4,4) != ".jpg")	)
		echo "<center><h1>Please fill picture url (only jpg)</h1></center>";
	else if($_POST['request']=="true" && $_POST['password']==""){
		echo "<center><h1>Please fill password</h1></center>";
	}
	else{
	$data2qr.="MECARD:N:FbQRContact;URL:http://apps.facebook.com/fbqrcontact;TYPE:multiqr_";
	if($_POST['password']!=""&&$_POST['request']!="false"){
		$data2qr.="p;";
	}
	else{
		$data2qr.="n;";
	}
	$group_name=$_POST['group_name'];
	$group_pic=$_POST['group_picture'];
	$data2qr.="GN:$group_name;QRID:$qrid;";
	$count=0;
	$c=1;
	if($_POST['all1']=="true"){
					$count++;
					$insert_uid.=$author_uid.";";
					$ituid=$author_uid;
						//QUERY/////////////////////////////////////////////
						$sql_uid="SELECT *FROM profiles WHERE uid='$ituid'";
						$dbquery=mysql_db_query($dbname,$sql_uid);
						$numrow_uid=mysql_num_rows($dbquery);
						$array=mysql_fetch_array($dbquery);
						$phone_number=$array['phone_number'];
						$name=$array['name'];
						//echo "$ituid $name $phone_number";
						//QUERY/////////////////////////////////////////////
					$data2qr.="P:$name,$phone_number;";
	}
	if($_POST['all1']=="false"){
					$insert_uid.=$author_uid.";";
				
	}

		foreach ($frProfiles as $i){
	$it_uid=$i['uid'];
	$sql_uid="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$it_uid' AND `setting`.`uid`='$it_uid' ";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$numrow_uid=mysql_num_rows($dbquery);
	if($numrow_uid==1){$c++;
		$all="all".$c;
				if($_POST[$all]=="true"){
					$count++;
					$insert_uid.=$i['uid'].";";
					$ituid=$i['uid'];
						//QUERY/////////////////////////////////////////////
						$sql_uid="SELECT *FROM profiles WHERE uid='$ituid'";
						$dbquery=mysql_db_query($dbname,$sql_uid);
						$numrow_uid=mysql_num_rows($dbquery);
						$array=mysql_fetch_array($dbquery);
						$phone_number=$array['phone_number'];
						$name=$array['name'];
						//echo "$ituid $name $phone_number";
						//QUERY/////////////////////////////////////////////
					$data2qr.="P:$name,$phone_number;";
					if($count>5){
						echo "<center><h1>You choose All type over than 5</h1><br><a href=\"JavaScript:window.close()\">close</a></center>";
						die;
					}
				}
				if($_POST[$all]=="false"){
					$insert_uid.=$i['uid'].";";
				
				}
			$check_none++;
			}
			
		}		if($_POST['request']!="false" )
					$password=$_POST['password'];
				//$datetime=date("Y-m-d H:i:s");		
				$exp.=date("Y-");
				if(date("m")==12){
					$tmp=date("Y")+1;
					$exp=$tmp."-1";
				}
				else{
					$exp.=(date("m")+1);
				}
				$exp.=date("-d H:i:s");
				//echo $datetime." ".$exp;
				if($_REQUEST['qrid'])
					$mysql="UPDATE  `tkroputa_db`.`multi2qr` SET  `qrname` =  '$group_name' , `gpic` =  '$group_pic' , `password` =  '$password' , `uid` =  '$insert_uid' , `author_uid` =  '$author_uid' , `expire` =  '$exp'   WHERE  `qrid` = $qrid;";
				else
					$mysql="INSERT INTO  `tkroputa_db`.`multi2qr` (`qrid` ,`qrname` ,`gpic` ,`password` ,`uid` ,`author_uid` ,`expire`)VALUES ('$qrid',  '$group_name',  '$group_pic',  '$password',  '$insert_uid', '$author_uid',  '$exp');";
				$dbquery=mysql_db_query($dbname,$mysql);
				/*$sql="SELECT *FROM  `multi2qr` WHERE `qrid`='$qrid'";
				$dbquery=mysql_db_query($dbname,$sql);
				$array=mysql_fetch_array($dbquery);
				echo $array['uid'];*/
			
			$size=480;
			//echo $data2qr;
			
			if($_POST['group_picture']) $gpic=$_POST['group_picture']; 
			if($_POST['group_name'])	$gname=$_POST['group_name'];
			
			if($check_none!=0){		
				//$data=$me['email'];
				//$QR='http://chart.apis.google.com/chart?cht=qr&chs=500x500&choe=UTF-8&chld=H&chl='.$data;
				//echo "<img src=\"".$QR."\">"	
				$ch = curl_init();    
				curl_setopt($ch, CURLOPT_URL,"http://fbqr.tkroputa.in.th/qrcode/createqr.php?");  
				curl_setopt($ch, CURLOPT_POST, TRUE); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, 'data='.$data2qr.'&size='.$size.'&uid='.$author_uid.'&type=multi'.'&gname='.$gname.'&gpic='.$gpic);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$result=curl_exec ($ch);     
				curl_close ($ch); 
				$base64=base64_encode($result);
				echo "<center>";
				
				echo "<img src=\"data:image/png;base64,".$base64."\">";
				echo "<br><a href=\"share.php?uid=".$author_uid."\" target=\"_self\"><img src=\"/img/facebookShareButton.jpg\" alt=\"share\"></a>";
				echo "</center>";
			}
			else{
				echo "<h1>Choose your friend.</h1>";
			}			
	}
?>
<br>
<a href="JavaScript:window.close()">close</a>
</center>