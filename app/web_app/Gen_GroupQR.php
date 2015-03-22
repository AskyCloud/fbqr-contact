<?
	header('Content-type: text/xml'); 
	require 'fb/fblogin.php';
	require 'genqrid.php';
	$author_uid=$me['id'];
	$array_gid=explode(";",$_REQUEST['gid']);//[0]=gid  // [1]=pic
	$gid=$array_gid[0];
	$gpic=$array_gid[1];
	$access_token=$array_gid[2];
?>


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
<?

if($gid==""){
echo '<root><stat>none</stat></root>';
exit;
}
	$data2qr.="MECARD:N:FbQRContact;URL:http://apps.facebook.com/fbqrcontact;TYPE:group_qr;GN:$gname;GID:$gid;";



	$size=NULL;
	switch($_POST['size']){
		case 'M':{
			$size=230;
			break;
		}
		case 'L':{
			$size=350;
			break;
		}
		case 'XL':{
			$size=480;
			break;
		}
		default: $size=350;
	}
				//$data=$me['email'];
				//$QR='http://chart.apis.google.com/chart?cht=qr&chs=500x500&choe=UTF-8&chld=H&chl='.$data;
				//echo "<img src=\"".$QR."\">"	
				$ch = curl_init();    
				curl_setopt($ch, CURLOPT_URL,"http://fbqr.tkroputa.in.th/qrcode/createqr.php?");  
				curl_setopt($ch, CURLOPT_POST, TRUE); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, 'data='.$data2qr.'&size='.$size.'&uid='.$author_uid.'&gid='.$gid.'&type=group'.'&gpic='.$gpic.'&access_token='.$access_token);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$result=curl_exec ($ch);     
				curl_close ($ch); 
				$base64=base64_encode($result);
				/*echo "<img src=\"data:image/png;base64,".$base64."\">";
				
				echo "gname $gname <br>$data2qr<br>";*/
				//echo "<root><stat>$data2qr</stat><img></img><uid>'.$author_uid.'</uid></root>";
				echo '<root><stat>done</stat><img>'.$base64.'</img><uid>'.$author_uid.'</uid></root>';
				exit;
?>