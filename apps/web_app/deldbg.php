<?
require('config.inc.php');
require 'fb/fblogin.php';
$sql_uid="SELECT *FROM debug";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow=mysql_num_rows($dbquery);
$status="done";
$uid=$me['id'];
$date_del=$_POST['date_del'];
	if($date_del!=""){
	$sql ="UPDATE  `tkroputa_db`.`debug` SET `status` =  '$status',`debugby` =  '$uid' WHERE datetime='$date_del' ";
	$dbquery=mysql_db_query($dbname,$sql);
	}
echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL=debug.php>";
?>
