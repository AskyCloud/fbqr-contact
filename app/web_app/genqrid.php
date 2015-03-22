<?php
/*for($i=0;$i<10;$i++){
$a1=rand(65,90);
$str.=chr($a1);
}
echo $str;*/
include('config.inc.php');
$sql="SELECT * FROM  `multi2qr` ORDER BY  `multi2qr`.`qrid` DESC ";
$dbquery=mysql_db_query($dbname,$sql);
$numrow=mysql_num_rows($dbquery);
$itarray=mysql_fetch_array($dbquery);
if($numrow==0){
	$qrid=1;
}
else{
	$qrid=$itarray['qrid']+1;
}
?>