<?
function group_input($gid,$uid,$privacy){
require('config.inc.php');
$sql_uid="SELECT * FROM `group` WHERE gid='$gid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_gid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
$array_uid=$array['uid'];
$array_privacy=$array['privacy'];
$datetime=date("Y-m-d H:i:s");
/////check DB////////////////
$tmp=explode(";",$array_uid);
$max=count($tmp);
$A=0;
for($k = 0;$k < $max-1;$k++){
	if($tmp[$k] == $uid){
		$A=1;
		break;
	}
}
////////////////////////////
	if($numrow_gid != 0 ){	
	if($A==0){
		$array_uid.=$uid.";";
		$array_privacy.=$privacy.";";
	}
	else{
			$tmp=explode(";",$array_uid);
			$tmp2=explode(";",$array_privacy);
			$array_privacy="";
			$max=count($tmp);
			for($k = 0;$k < $max-1;$k++){
				if($tmp[$k] == $uid){
					$tmp2[$k]=$privacy;
				}
				$array_privacy.=$tmp2[$k].";";
			}		
	}
	
			$sql="UPDATE  `tkroputa_db`.`group` SET
					`uid` =  '$array_uid',
					`privacy` =  '$array_privacy',
					`last_update` =  '$datetime'
					WHERE  gid =  '$gid' ";

	}
	else{
	$array_uid=$uid.";";
	$array_privacy=$privacy.";";
		$sql="INSERT INTO `tkroputa_db`.`group`  (`gid` ,`uid` ,`privacy` ,`last_update`)
		VALUES ('$gid', '$array_uid', '$array_privacy', '$datetime')";
	}
	
	$dbquery=mysql_db_query($dbname,$sql);
	
//////////////setting//////////////////////////
	$sql_uid="SELECT *FROM setting WHERE uid='$uid'";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$array=mysql_fetch_array($dbquery);
			$array_gid=$array['gid'];
			$array_privacy=$array['privacy'];
		
/////check DB////////////////
$tmp=explode(";",$array_gid);
$max=count($tmp);
$A=0;
for($k = 0;$k < $max-1;$k++){
	if($tmp[$k] == $gid){
		$A=1;
		break;
	}
}
////////////////////////////		

		if($A==1){
				$tmp=explode(";",$array_gid);
				$tmp2=explode(";",$array_privacy);
				$array_privacy="";
				$max=count($tmp);
				for($k = 0;$k < $max-1;$k++){
					if($tmp[$k]==$gid)
						$array_privacy.=$privacy.";";
					else{
						$array_privacy.=$tmp2[$k].";";
					}
				}
		}
		else{
			$array_gid.=$gid.";";
			$array_privacy.=$privacy.";";
		}
		
	$sql="UPDATE  setting SET
					`gid` =  '$array_gid',
					`privacy` =  '$array_privacy'
					WHERE  uid =  '$uid' ";
	$dbquery=mysql_db_query($dbname,$sql);
}



function del_group($gid,$uid){
require('config.inc.php');
$sql_uid="SELECT * FROM `group` WHERE gid='$gid'";
$dbquery=mysql_db_query($dbname,$sql_uid);
$numrow_gid=mysql_num_rows($dbquery);
$array=mysql_fetch_array($dbquery);
$array_uid=$array['uid'];
$array_privacy=$array['privacy'];
$datetime=date("Y-m-d H:i:s");

			$tmp=explode(";",$array_uid);
			$tmp2=explode(";",$array_privacy);
			$array_privacy="";
			$array_uid="";
			$max=count($tmp);
			for($k = 0;$k < $max-1;$k++){
				if($tmp[$k] != $uid){
					$array_uid.=$tmp[$k].";";
					$array_privacy.=$tmp2[$k].";";
				}
			}
			if($array_privacy == "" || $array_uid == ""){			
					$sql="DELETE FROM `group` WHERE gid='$gid'";
			}
			else{
					$sql="UPDATE  `tkroputa_db`.`group` SET
					`uid` =  '$array_uid',
					`privacy` =  '$array_privacy',
					`last_update` =  '$datetime'
					WHERE  gid =  '$gid' ";
			}
		
			$dbquery=mysql_db_query($dbname,$sql);	
//////////////setting//////////////////////////
	$sql_uid="SELECT *FROM setting WHERE uid='$uid'";
	$dbquery=mysql_db_query($dbname,$sql_uid);
	$array=mysql_fetch_array($dbquery);
			$array_gid=$array['gid'];
			$array_privacy=$array['privacy'];
		

				$tmp=explode(";",$array_gid);
				$tmp2=explode(";",$array_privacy);
				$array_privacy="";
				$array_gid="";
				$max=count($tmp);
				for($k = 0;$k < $max-1;$k++){
					if($tmp[$k]!=$gid){
						$array_gid.=$tmp[$k].";";	
						$array_privacy.=$tmp2[$k].";";
					}
				}
	$sql="UPDATE  setting SET
					`gid` =  '$array_gid',
					`privacy` =  '$array_privacy'
					WHERE  uid =  '$uid' ";
	$dbquery=mysql_db_query($dbname,$sql);
}
?>