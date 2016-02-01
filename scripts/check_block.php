<?php
ob_start();
if(!isset($_SESSION['id']))
	{$_SESSION['id']=$_SESSION['ids'];}
$id = $_SESSION['id'];
$ids = $_SESSION['ids'];

$mysql_friend_family = mysql_query("SELECT friend_array, family_array, block_array, delete_member FROM members WHERE id='$id' LIMIT 1");
while($row = mysql_fetch_array($mysql_friend_family))
	{$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$block_array = $row['block_array'];
	$delete_member = $row['delete_member'];
	
	$friendArray = explode(",",$friend_array);
	$familyArray = explode(",",$family_array);
	$blockArray = explode(",",$block_array);}
	
$check_id=mysql_num_rows($mysql_friend_family);
if ($check_id<1)
	{header("Location: ../profile/profile.php");exit();}
	
if ((!in_array($ids,$friendArray))AND(!in_array($ids,$familyArray)))
	{include_once "../profile/profile_block.php";exit();}
else if (in_array($ids,$blockArray))
	{include_once "../profile/profile_delete.php";exit();}
else if ($delete_member=="0")
	{include_once "../profile/profile_delete.php";exit();}

ob_flush();
?>