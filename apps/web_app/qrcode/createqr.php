<?
//error_reporting(E_ERROR | E_PARSE);
require '../fb/facebook.php';
require '../config.inc.php';

$size = ($_REQUEST['size'])?$_REQUEST['size']:230;
$fontsize = ($_REQUEST['fontsize'])?$_REQUEST['fontsize']:15;
$access_token = $_REQUEST['access_token'];
$type = ($_REQUEST['type'])?$_REQUEST['type']:"single";
//single
$data = $_REQUEST['data'];
$uid = $_REQUEST['uid'];
//group
$gid = $_REQUEST['gid'];
$gpic = $_REQUEST['gpic'];
$gname = $_REQUEST['gname'];


//query from db//
$sql_uid="SELECT *FROM profiles WHERE uid='$uid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
	

$facebook = new Facebook(array(
 'appId'  => $fbconfig['appid'],
 'secret' => $fbconfig['secret'],
 'cookie' => true,
 'fileUpload' => true,
  ));
  
//Gen with Google Chart API
$ch = curl_init();    
curl_setopt($ch, CURLOPT_URL,"http://chart.apis.google.com/chart?");  
curl_setopt($ch, CURLOPT_POST, TRUE); 
curl_setopt($ch, CURLOPT_POSTFIELDS, 'cht=qr&chs='.$size.'x'.$size.'&choe=UTF-8&chld=H|1&chl='.$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$im=curl_exec ($ch);     
curl_close ($ch); 
$im = imagecreatefromstring($im);
if(!$im){
	echo "error";
	die();
}

//Insert Logo
$src = imagecreatefromgif('qrlogo.gif');


$new_width=$size/2;
$new_height=$size/2;

$resized = imagecreatetruecolor($new_width, $new_height);
$trans_colour = imagecolorallocatealpha($resized, 0, 0, 0, 127);
imagefill($resized, 0, 0, $trans_colour);
imagecopyresized($resized,$src,0,0,0,0,$new_width,$new_height,imagesx($src),imagesy($src));

$x=imagesx($im)/2-$new_width/2;
$y=imagesy($im)/2-$new_height/2;

//insert Logo
imagecopy($im,$resized,$x,$y,0,0,$new_width,$new_height);

//Create imdisplay for write name & display
$imdisplay = imagecreatetruecolor($size, $size+70);
$background = imagecolorallocate($imdisplay, 255,255,255);
imagefill($imdisplay, 0, 0, $background);

if($type=="single"){
	//write display
	$new_width=50;
	$new_height=50;	
	$display =  imagecreatetruecolor($new_width, $new_height);
	$background = imagecolorallocate($display , 255,255,255);
	imagefill($display, 0, 0, $background);
		
	if($array['sync']%1000>=100){

	$displayPath = "http://graph.facebook.com/$uid/picture";
	}
	else $displayPath = $array['display'];
	if($displayPath){
		$src = imagecreatefromjpeg($displayPath);

		//resize src to display
		imagecopyresized($display,$src,0,0,0,0,$new_width,$new_height,imagesx($src),imagesy($src));
	}
		
	$displaySize = array(imagesx($display),imagesy($display));
	$profile=$facebook->api("/$uid?fields=first_name,name");
	if($size<250){
		$xDisplay=10;
		
		if($array['sync']%10==1)
			$name=$profile['first_name'];			
		else $name=$array['name'];
	}
	else {	
		if($size>350) $xDisplay=70;
		else  $xDisplay=15;
		
		if($array['sync']%10==1)
			$name=$profile['name'];			
		else $name=$array['name'];
	}
}
else{
	//Group
	//write display
	$new_width=50;
	$new_height=50;
	
	
	$display =  imagecreatetruecolor($new_width, $new_height);
	$background = imagecolorallocate($display , 255,255,255);
	imagefill($display, 0, 0, $background);
		
	if($gpic){
		$displayPath = $gpic;
		$src = imagecreatefromjpeg($displayPath);

		//resize src to display
		imagecopyresized($display,$src,0,0,0,0,$new_width,$new_height,imagesx($src),imagesy($src));
	}
	$displaySize = array(imagesx($display),imagesy($display));
	
	$name= $gname;
	if($type=="group"){
			$group=$facebook->api("$gid?fields=name",array('access_token'=>$access_token));
			$name=$group['name'];
			if($size<250){
			$xDisplay=10;
			}
			else {	
				if($size>350) $xDisplay=70;
				else  $xDisplay=40;
			}	
	}
	else $xDisplay=120;
}

imagecopy($imdisplay,$im,0,0,0,0,$size,$size);
imagecopy($imdisplay,$display,$xDisplay,$size,0,0,$displaySize[0],$displaySize[1]);

//Write name
$text_color = imagecolorallocate($imdisplay,0, 0, 0);
$font = 'Lucida Grande Bold.ttf';
imagettftext($imdisplay, $fontsize,0,$xDisplay+$displaySize[0]+10, $size+30, $text_color, $font, $name);


//display
header("Content-type: image/png" );
$file_location='tmp/'.$uid.'.png';
imagepng($imdisplay,$file_location,0,null);
imagepng($imdisplay,null,0,null);

/*
header("Content-type: image/gif");
imagegif($im);*/


imagedestroy($im);
imagedestroy($src);
imagedestroy($imdisplay);
imagedestroy($resized);
?>