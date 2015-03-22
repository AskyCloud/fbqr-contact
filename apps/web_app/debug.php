<?php
require 'fb/fblogin.php';
require('config.inc.php');

$uid=$me['id'];
$name=$me['first_name'];
if($uid != 100000925243158 && $uid != 1363051741 && $uid != 100001036241534){
	echo "for admin only";
	die;
}
$sql_uid="SELECT *FROM debug ORDER BY datetime ASC ";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow=mysql_num_rows($dbquery);
if($numrow>=1){
$i=0;
	echo "<form name=form1 id=form1 action=deldbg.php method=post>
	
	
	<table width=650>";
	//echo "<tr><td >by</td><td width=400>data</td><td>time</td><td>choose to del</td></tr>";
	while($i < $numrow){
	
		$array=mysql_fetch_array($dbquery);
		$data=$array['data'];
		$id=$array['uid'];
		$debugby=$array['debugby'];
		$debugstat=$array['status'];
		$datetime=$array['datetime'];
		echo "<tr>";
		echo "<td><input type=radio name=\"date_del\" id=\"date_del$i\" value=\"$datetime\" ></td>";
		echo "<td><img src=\"https://graph.facebook.com/$id/picture\" border=0></td>";
		echo "<td width=300>$data</td>";
		echo "<td>$datetime</td>";
		if($debugstat!=NULL) echo "<td>$debugstat</td>";
		else echo "<td>waiting</td>";
		if($debugby!=NULL) echo "<td><img src=\"https://graph.facebook.com/$id/picture\" border=0></td>";
		else echo "<td></td>";
		
		echo "</tr>";
		$i++;
	}
	echo "</table><input type=submit name=Submit id=submit value=Done />";
	echo "</form>";
}
else{
	echo "<center>No data.</center>";
}
	echo "<form name=form2 id=form2 action=adddbg.php method=post valign=top>";
	echo "<textarea name=data id=data cols=25 rows=5 >Enter data</textarea>";
	echo "<input type=submit name=Submit id=submit value=Summit />";
	echo "</form>";
	
	
?>
</body>
</html>