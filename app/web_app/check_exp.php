<?php
$sql_uid="SELECT *FROM `multi2qr` WHERE qrid='$qrid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_uid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
$qrname=$array['qrname'];
$password=$array['password'];
$uid=$array['uid'];
$author_uid=$array['author_uid'];
$expire=$array['expire'];
$inexpire=date("Y-m-d H:i:s");
//echo "$inqrid $arrqrid $password $uid $expire***$inexpire";
if($inexpire <= $expire){
	$check=true;
}
else{
	$check=false;
	$sql="DELETE FROM `tkroputa_db`.`multi2qr` WHERE `multi2qr`.`qrid` = '$qrid' AND `multi2qr`.`qrname` = '$qrname' AND `multi2qr`.`uid` = '$uid' AND `multi2qr`.`expire` = '$expire'";
	$dbquery=mysql_db_query($dbname,$sql);
}
?>