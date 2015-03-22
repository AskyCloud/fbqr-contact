<?
require('config.inc.php');
$uid=$_REQUEST['uid'];
$sql="DELETE `tkroputa_db`.`profiles`,`tkroputa_db`.`setting` FROM `tkroputa_db`.`profiles` LEFT JOIN `tkroputa_db`.`setting` ON `profiles`.uid=`setting`.uid WHERE `profiles`.uid =$uid;";
$dbquery=mysql_db_query($dbname,$sql);
$sql="SELECT `profiles`.`uid`, `setting`.`uid` FROM `tkroputa_db`.`profiles`, `tkroputa_db`.`setting` WHERE `profiles`.`uid` ='$uid' AND `setting`.`uid`='$uid';";
$dbquery=mysql_db_query($dbname,$sql);
$numrow_uid=mysql_num_rows($dbquery);
if($numrow_uid==0)
	echo "done!";
else
	echo "FAIL";
?>