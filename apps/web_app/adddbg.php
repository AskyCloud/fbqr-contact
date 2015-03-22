<?
require 'fb/fblogin.php';
require('config.inc.php');

$uid=$me['id'];
$name=$me['first_name'];

$data=$_POST['data'];
$datetime=$_POST['datetime'];
$date=date("Y-m-d H:i:s");
	$sql="INSERT INTO  `tkroputa_db`.`debug` (`uid` ,`data` ,`datetime`)VALUES ('$uid','$data','$date')";
	$dbquery=mysql_db_query($dbname,$sql);
?>
<META HTTP-EQUIV=Refresh CONTENT=0;URL=debug.php>