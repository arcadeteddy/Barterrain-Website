<?php
ob_start();
session_start();
include "../config.php";
$message="";

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

$ids = $_SESSION['ids'];
$id = $_SESSION['id'];
$thisWipit=$_POST['thisWipit'];
$file_location=$_SESSION['file_location'];
if ($file_location == "planet") {$header_location = "../planet/planet.php";}
else {$header_location = "../inside/inside.php";}

// Joining
if ($_POST["request"] == "JoinCreate")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";header("location: ".$header_location."?id=".$item_id);exit();}

	/*if($item_type=="groups")
		{	$mysql = mysql_query("SELECT * FROM members WHERE id=$request_id");
	while($row = mysql_fetch_array($mysql))
		{$request_id = $row['id'];}
	if ((!$user_id)OR(!$request_id))
		{$message = "<br/><font style='color:#dd4a4a';>Error: Missing Data!</font><br/><br/>";}
	else if ($user_id == $request_id)
		{$message = "<br/><font style='color:#dd4a4a';>Error: You Can't Friend Yourself!</font><br/><br/>";}
	else 
		{// Check to see if this user hasn't already sent a friend request.
		$mysql1 = mysql_query("SELECT id FROM friend_requests WHERE user_id='$user_id' AND request_id='$request_id' LIMIT 1");
		$numRows1 = mysql_num_rows($mysql1);
		// Check to see if the user already has a friend request from this person.		
		$mysql2 = mysql_query("SELECT id FROM friend_requests WHERE user_id='$request_id' AND request_id='$user_id' LIMIT 1");
		$numRows2 = mysql_num_rows($mysql2);
		if ($numRows1 > 0)
			{$message = "<br/><font style='color:#4773C4';>A friend request has already been sent. Please wait for him/her to accept the friend request.</font><br/><br/>";}
		else if ($numRows2 > 0)
			{$message = "<br/><font style='color:#4773C4';>Him/her has already sent you a friend request. Please use the friend tab to accept it.</font><br/><br/>";}
		// Sends the request.
		else 
			{$mysql3 = mysql_query("INSERT INTO friend_requests (user_id, request_id, request_date) VALUES ('$user_id', '$request_id', UTC_TIMESTAMP())");
			$message = "<br/><font style='color:#4773C4';>A successful friend request has <br/>been sent to him/her.</font><br/><br/>";}
		}}*/
		
	else if ($item_type=="planets")
		{$mysql_join_array1 = mysql_query("SELECT member_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
		$mysql_join_array2 = mysql_query("SELECT ".$item_type."_array AS item_array FROM members WHERE id='$ids' LIMIT 1");
		while ($row=mysql_fetch_array($mysql_join_array1))
			{$member_array = $row['member_array'];
			$memberArray = explode(",",$member_array);}
		while ($row=mysql_fetch_array($mysql_join_array2))
			{$item_array = $row['item_array'];
			$itemArray = explode(",",$item_array);}
		if ((in_array($ids,$memberArray))AND(in_array($item_id,$itemArray)))
			{header("location: ".$header_location."?id=".$item_id);exit();}
		if ($member_array != "")
			{$member_array = "$member_array,$ids";}
		else {$member_array = "$ids";}
		if ($item_array != "")
			{$item_array = "$item_array,$item_id";}
		else {$item_array = "$item_id";}
	
		$UpdateArray1 = mysql_query("UPDATE ".$item_type." SET member_array='$member_array' WHERE id='$item_id'") or die (mysql_error());
		$UpdateArray2 = mysql_query("UPDATE members SET ".$item_type."_array='$item_array' WHERE id='$ids'") or die (mysql_error());
		}
		
	$mysql_block_array = mysql_query("SELECT block_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_block_array))
		{$block_array = $row['block_array'];}
	$blockArray = explode(",", $block_array);
	foreach ($blockArray as $key => $value)
		{if ($value == $ids)
			{unset($blockArray[$key]);}} 
	$new_string = implode(",",$blockArray);
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET block_array='$new_string' WHERE id='$item_id'");
	header("location: ".$header_location."?id=".$item_id);exit();
	}
	
// Leave Create
if ($_POST['request'] == "LeaveCreate")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_join_array1 = mysql_query("SELECT member_array,admin_array,creator_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	$mysql_join_array2 = mysql_query("SELECT ".$item_type."_array AS item_array FROM members WHERE id='$ids' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_join_array1))
		{$member_array = $row['member_array'];
		$memberArray = explode(",",$member_array);
		$admin_array = $row['admin_array'];
		$adminArray = explode(",",$admin_array);
		$creator_array = $row['creator_array'];
		$creatorArray = explode(",",$creator_array);}
	while ($row=mysql_fetch_array($mysql_join_array2))
		{$item_array = $row['item_array'];
		$itemArray = explode(",",$item_array);}
		
	if ((!in_array($ids,$memberArray))AND(!in_array($item_id,$itemArray)))
		{$message = "<br/><font class='success_message_12px'>You are already not a member of this circle.</font><br/><br/>";}
	foreach ($memberArray as $key => $value)
		{if ($value == $ids)
			{unset($memberArray[$key]);}} 
	foreach ($adminArray as $key => $value)
		{if ($value == $ids)
			{unset($adminArray[$key]);}} 
	foreach ($creatorArray as $key => $value)
		{if ($value == $ids)
			{unset($creatorArray[$key]);}} 
	foreach ($itemArray as $key => $value)
		{if ($value == $item_id)
			{unset($itemArray[$key]);}} 
			
	$new_string1 = implode(",",$memberArray);
	$new_string2 = implode(",",$adminArray);
	$new_string3 = implode(",",$itemArray);
	$new_string4 = implode(",",$creatorArray);
	$UpdateArray1 = mysql_query("UPDATE ".$item_type." SET member_array='$new_string1' WHERE id='$item_id'");
	$UpdateArray2 = mysql_query("UPDATE ".$item_type." SET admin_array='$new_string2' WHERE id='$item_id'");
	$UpdateArray3 = mysql_query("UPDATE members SET ".$item_type."_array='$new_string3' WHERE id='$ids'");
	$UpdateArray2 = mysql_query("UPDATE ".$item_type." SET creator_array='$new_string4' WHERE id='$item_id'");
	$delete_pending_requests = mysql_query("DELETE FROM admin_requests WHERE user_id='$ids' LIMIT 1");
	$delete_pending_requests = mysql_query("DELETE FROM creator_requests WHERE user_id='$ids' LIMIT 1");
	
	header("location: ".$header_location."?id=".$item_id);exit();
	}
	
// Leave Create
if ($_POST['request'] == "LeaveCreate2")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$member_id=preg_replace('#[^0-9]#i','',$_POST['member_id']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if (!$member_id||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_join_array1 = mysql_query("SELECT member_array,admin_array,creator_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	$mysql_join_array2 = mysql_query("SELECT ".$item_type."_array AS item_array FROM members WHERE id='$member_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_join_array1))
		{$member_array = $row['member_array'];
		$memberArray = explode(",",$member_array);
		$admin_array = $row['admin_array'];
		$adminArray = explode(",",$admin_array);
		$creator_array = $row['creator_array'];
		$creatorArray = explode(",",$creator_array);}
	while ($row=mysql_fetch_array($mysql_join_array2))
		{$item_array = $row['item_array'];
		$itemArray = explode(",",$item_array);}
		
	if ((!in_array($member_id,$memberArray))AND(!in_array($item_id,$itemArray)))
		{$message = "<br/><font class='success_message_12px'>You are already not a member of this circle.</font><br/><br/>";}
	foreach ($memberArray as $key => $value)
		{if ($value == $member_id)
			{unset($memberArray[$key]);}} 
	foreach ($adminArray as $key => $value)
		{if ($value == $member_id)
			{unset($adminArray[$key]);}} 
	foreach ($creatorArray as $key => $value)
		{if ($value == $member_id)
			{unset($creatorArray[$key]);}} 
	foreach ($itemArray as $key => $value)
		{if ($value == $item_id)
			{unset($itemArray[$key]);}} 
			
	$new_string1 = implode(",",$memberArray);
	$new_string2 = implode(",",$adminArray);
	$new_string3 = implode(",",$itemArray);
	$new_string4 = implode(",",$creatorArray);
	$UpdateArray1 = mysql_query("UPDATE ".$item_type." SET member_array='$new_string1' WHERE id='$item_id'");
	$UpdateArray2 = mysql_query("UPDATE ".$item_type." SET admin_array='$new_string2' WHERE id='$item_id'");
	$UpdateArray3 = mysql_query("UPDATE members SET ".$item_type."_array='$new_string3' WHERE id='$member_id'");
	$UpdateArray2 = mysql_query("UPDATE ".$item_type." SET creator_array='$new_string4' WHERE id='$item_id'");
	$delete_pending_requests = mysql_query("DELETE FROM admin_requests WHERE user_id='$member_id' LIMIT 1");
	$delete_pending_requests = mysql_query("DELETE FROM creator_requests WHERE user_id='$member_id' LIMIT 1");
	
	include_once "../".$item_type_s."/".$item_type_s."_members_list.php";exit();
	}
	
// Delete Create
if ($_POST['request'] == "DeleteCreate")
	{$ids=$_POST['ids'];
	$id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$id||!$ids||!$item_id||!$item_type)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}
	$mysql_delete_array = mysql_query("SELECT planets_array,member_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_delete_array))
		{$linked_planets_array = $row['planets_array'];
		$linked_planetsArray = explode(",",$linked_planets_array);
		$linked_planetsArray_count = count($linked_planetsArray);
		$member_array = $row['member_array'];
		$memberArray = explode(",",$member_array);
		$memberArray_count = count($memberArray);}
	if ($member_array==$ids) 
		{$mysql_delete = mysql_query("SELECT planets_array FROM members WHERE id='$ids' LIMIT 1");
		while ($row=mysql_fetch_array($mysql_delete))
			{$planets_array = $row['planets_array'];
			$planetsArray = explode(",",$planets_array);}
			
		foreach ($planetsArray as $key => $value)
			{if ($value == $id)
				{unset($planetsArray[$key]);}} 
		$new_string = implode(",",$planetsArray);
		
		if (!empty($linked_planetsArray))
			{foreach ($linked_planetsArray as $key => $value) 
				{$mysql_linked_array = mysql_query("SELECT planets_array FROM ".$item_type." WHERE id='$value' LIMIT 1");
				while ($row=mysql_fetch_array($mysql_linked_array))
					{$remove_linked_planets_array = $row['planets_array'];
					$remove_linked_planetsArray = explode(",",$remove_linked_planets_array);}
				
				if (!empty($remove_linked_planetsArray))
					{foreach ($remove_linked_planetsArray as $key2 => $value2)
						{if ($value2 == $id)
							{unset($remove_linked_planetsArray[$key2]);}}
					$remove_linked_planets_array = implode(",",$remove_linked_planetsArray);
					mysql_query("UPDATE ".$item_type." SET planets_array='$remove_linked_planets_array' WHERE id='$value' LIMIT 1");}
				}
			}
			
		mysql_query("UPDATE members SET planets_array='$new_string' WHERE id='$ids'");
		mysql_query("UPDATE planets SET delete_item='0' WHERE id='$id' AND user_id='$ids'");
		if (file_exists("../planet_files/planet$id/")){rename("../planet_files/planet$id/","../planet_files/delete_planet$id/");}
		mysql_query("UPDATE planets SET delete_item='0' WHERE planet_id='$id'");
		
		mysql_query("UPDATE planets_albums SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_albums_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_albums_posts SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_albums_posts_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_games SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_games_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_games_posts SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_games_posts_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_images SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_images_posts SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_images_posts_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_images_walls SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_images_walls_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_videos SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_videos_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_videos_posts SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_videos_posts_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE link_creates SET delete_item='0' WHERE user_page_id='$id' OR planet_id='$id'");
		mysql_query("UPDATE link_creates_comments SET delete_comment='0' WHERE user_page_id='$id' OR planet_id='$id'");
		
		mysql_query("UPDATE planets_posts SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_posts_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_members_posts SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_members_posts_comments SET delete_comment='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_notes SET delete_item='0' WHERE user_page_id='$id'");
		mysql_query("UPDATE planets_notes_comments SET delete_comment='0' WHERE user_page_id='$id'");
		
		echo '<script type="text/javascript">planet_page_refresh()</script>';exit();}
	else if ($memberArray_count>1)
		{$message = "<br/><font class='error_message_12px'>Can't Destroy Planet With Members In It</font><br/><br/>";header("location: ".$header_location."?id=".$item_id."&error_options=".$message);exit();}
	}
	
// Block
if ($_POST["request"] == "BlockCreate")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_block_array = mysql_query("SELECT block_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_block_array))
		{$block_array = $row['block_array'];
	$blockArray = explode(",",$block_array);}
	if(in_array($ids, $blockArray))
		{$message = "<br/><font class='success_message_12px'>This is already blocked from you.</font><br/><br/>";}
	if ($block_array != "")
		{$block_array = "$block_array,$ids";}
	else {$block_array = "$ids";}
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET block_array='$block_array' WHERE id='$item_id'") or die (mysql_error());
	}

// Unblock
if ($_POST['request'] == "UnblockCreate")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_block_array = mysql_query("SELECT block_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_block_array))
		{$block_array = $row['block_array'];}
	$blockArray = explode(",", $block_array);
	if (!in_array($ids,$blockArray))
		{$message = "<br/><font class='success_message_12px'>This is already unblocked from you.</font><br/><br/>";}
	foreach ($blockArray as $key => $value)
		{if ($value == $ids)
			{unset($blockArray[$key]);}} 
			
	$new_string = implode(",",$blockArray);
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET block_array='$new_string' WHERE id='$item_id'");
	}

// Report
if ($_POST["request"] == "ReportCreate")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_report_array = mysql_query("SELECT member_array,report_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_report_array))
		{$member_array = $row['member_array'];
		$memberArray = explode(",",$member_array);
		$report_array = $row['report_array'];
		$reportArray = explode(",",$report_array);}
	if(!in_array($ids,$memberArray))
		{$message = "<br/><font class='error_message_12px'>Can't report! You are not a member.</font><br/><br/>";}
	if(in_array($ids, $reportArray))
		{$message = "<br/><font class='success_message_12px'>Reported To Inappropriate</font><br/><br/>";}
	if ($report_array != "")
		{$report_array = "$report_array,$ids";}
	else {$report_array = "$ids";}
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET report_array='$report_array' WHERE id='$item_id'") or die (mysql_error());
	$message = "<font class='success_message_12px'>Reported To Inappropriate!</font><br/><br/>";
	}
	
// Unreport
if ($_POST["request"] == "UnreportCreate")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_report_array = mysql_query("SELECT report_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_report_array))
		{$report_array = $row['report_array'];}
	$reportArray = explode(",", $report_array);
	if (!in_array($ids,$reportArray))
		{$message = "<br/><font class='success_message_12px'>Unreported To Appropriate</font><br/><br/>";}
	foreach ($reportArray as $key => $value)
		{if ($value == $ids)
			{unset($reportArray[$key]);}} 
	
	$new_string = implode(",",$reportArray);
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET report_array='$new_string' WHERE id='$item_id'");
	$message = "<font class='success_message_12px'>Unreported To Appropriate!</font><br/><br/>";
	}
	
// Sending Creator Request
if ($_POST["request"] == "RequestCreator")
	{$user_id=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	$mysql = mysql_query("SELECT user_id,planet_name,creator_array,admin_array,member_array FROM ".$item_type." WHERE id=$item_id");
	while($row = mysql_fetch_array($mysql))
		{$creator_id = $row['user_id'];
		$planet_name = $row['planet_name'];
		$creator_array = $row['creator_array'];
		$creatorArray = explode(",",$creator_array);
		$admin_array = $row['admin_array'];
		$adminArray = explode(",",$admin_array);
		$member_array = $row['member_array'];
		$memberArray = explode(",",$member_array);}
	if(!in_array($user_id,$memberArray))
		{$message = "<br/><font class='error_message_12px'>Error: You Are Not A Member!</font><br/><br/>";}
	if ((!$user_id)OR(!$item_id))
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}
	else if ($creator_id == $ids)
		{$message = "<br/><font class='success_message_12px'>Already Creator!</font><br/><br/>";}
	else if(in_array($ids, $creatorArray))
		{$message = "<br/><font class='success_message_12px'>Already Creator!</font><br/><br/>";}
	else if(in_array($ids, $adminArray))
		{$message = "<br/><font class='success_message_12px'>Already Admin!</font><br/><br/>";}
	else 
		{$mysql = mysql_query("SELECT id, email FROM members WHERE id=$creator_id");
		while($row = mysql_fetch_array($mysql))
			{$request_id = $row['id'];
			$email = $row['email'];}
		$mysql2 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id=$user_id");
		while($row = mysql_fetch_array($mysql2))
			{$user_id = $row['id'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		
			$message="New Creator Request From ".$firstname." ".$lastname."\n\nPlanet: ".$planet_name;
			$subject = "New Creator Request From ".$firstname." ".$lastname;
			$headers = 'From: Barterrain <request@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <request@barterrain.com>' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
			mail($email,$subject,$message,$headers,'-frequest@barterrain.com');
			
		$mysql1 = mysql_query("SELECT id FROM creator_requests WHERE user_id='$user_id' AND create_id='$item_id' AND request_status='0'");
		$numRows1 = mysql_num_rows($mysql1);
		if ($numRows1 > 0)
			{$message = "<br/><font class='success_message_12px'>Request Sent!<br/></font><br/><br/>";}
		// Sends the request.
		else 
			{$mysql3 = mysql_query("INSERT INTO creator_requests (user_id, create_id, request_date, create_type) VALUES ('$user_id', '$item_id', UTC_TIMESTAMP(), '$item_type')");
			$mysql4 = mysql_query("DELETE FROM admin_requests WHERE user_id='$user_id' AND create_id='$item_id' AND request_status='0'");
			$message = "<br/><font class='success_message_12px'>Request Sent!<br/></font><br/><br/>";}
		}
	}
	
// Accepting Creator Requests
if ($_POST["request"] == "acceptcreator")
	{$requestID = preg_replace('#[^0-9]#i', '', $_POST['requestID']);
	$typex=$_POST['typex'];
	$mysql = mysql_query("SELECT * FROM creator_requests WHERE id='$requestID' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{$message = "<font class='error_message_11px'>Creator Request Accepted</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_id=$row['user_id'];
		$item_id=$row['create_id'];}
		
	$mysql_creator_array = mysql_query("SELECT creator_array FROM ".$typex." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_creator_array))
		{$creator_array = $row['creator_array'];}
	$creatorArray = explode(",",$creator_array);
	
	if(in_array($user_id, $creatorArray))
		{$message = "<font class='success_message_11px'>Already Creator</font>";exit();}
	if ($creator_array !== "")
		{$creator_array = "$creator_array,$user_id";}
	else {$creator_array = "$user_id";}
	
	$UpdateArray1 = mysql_query("UPDATE ".$typex." SET creator_array = '$creator_array' WHERE id='$item_id'") or die (mysql_error());
	$delete_pending_request = mysql_query("UPDATE creator_requests SET request_status='1', request_status_date=UTC_TIMESTAMP() WHERE id='$requestID' LIMIT 1");
	echo "<font class='success_message_11px'>Creator Request Accepted</font>";exit();
	}
	
// Rejecting Creatorship
if ($_POST["request"] == "rejectcreator")
	{$requestID = preg_replace('#[^0-9]#i', '', $_POST['requestID']);
	$delete_pending_request = mysql_query("DELETE FROM creator_requests WHERE id='$requestID' LIMIT 1"); 
    echo "<font class='error_message_11px'>Creator Request Rejected</font>";exit();
	}
	
// Sending Admin Request
if ($_POST["request"] == "RequestAdmin")
	{$user_id=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	$mysql = mysql_query("SELECT user_id,planet_name,creator_array,admin_array,member_array FROM ".$item_type." WHERE id=$item_id");
	while($row = mysql_fetch_array($mysql))
		{$creator_id = $row['user_id'];
		$planet_name = $row['planet_name'];
		$creator_array = $row['creator_array'];
		$creatorArray = explode(",",$creator_array);
		$admin_array = $row['admin_array'];
		$adminArray = explode(",",$admin_array);
		$member_array = $row['member_array'];
		$memberArray = explode(",",$member_array);}
	if(!in_array($user_id,$memberArray))
		{$message = "<br/><font class='error_message_12px'>Error: You Are Not A Member!</font><br/><br/>";}
	if ((!$user_id)OR(!$item_id))
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}
	else if ($creator_id == $ids)
		{$message = "<br/><font class='success_message_12px'>Already Creator!</font><br/><br/>";}
	else if(in_array($ids, $creatorArray))
		{$message = "<br/><font class='success_message_12px'>Already Creator!</font><br/><br/>";}
	else if(in_array($ids, $adminArray))
		{$message = "<br/><font class='success_message_12px'>Already Admin!</font><br/><br/>";}
	else 
		{$mysql = mysql_query("SELECT id, email FROM members WHERE id=$creator_id");
		while($row = mysql_fetch_array($mysql))
			{$request_id = $row['id'];
			$email = $row['email'];}
		$mysql2 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id=$user_id");
		while($row = mysql_fetch_array($mysql2))
			{$user_id = $row['id'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		
			$message="New Admin Request From ".$firstname." ".$lastname."\n\nPlanet: ".$planet_name;
			$subject = "New Admin Request From ".$firstname." ".$lastname;
			$headers = 'From: Barterrain <request@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <request@barterrain.com>' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
			mail($email,$subject,$message,$headers,'-frequest@barterrain.com');
			
		$mysql1 = mysql_query("SELECT id FROM admin_requests WHERE user_id='$user_id' AND create_id='$item_id' AND request_status='0'");
		$numRows1 = mysql_num_rows($mysql1);
		if ($numRows1 > 0)
			{$message = "<br/><font class='success_message_12px'>Request Sent!<br/></font><br/><br/>";}
		// Sends the request.
		else 
			{$mysql3 = mysql_query("INSERT INTO admin_requests (user_id, create_id, request_date, create_type) VALUES ('$user_id', '$item_id', UTC_TIMESTAMP(), '$item_type')");
			$mysql4 = mysql_query("DELETE FROM creator_requests WHERE user_id='$user_id' AND create_id='$item_id' AND request_status='0'");
			$message = "<br/><font class='success_message_12px'>Request Sent!<br/></font><br/><br/>";}
		}
	}
	
// Accepting Admin Requests
if ($_POST["request"] == "acceptadmin")
	{$requestID = preg_replace('#[^0-9]#i', '', $_POST['requestID']);
	$typex=$_POST['typex'];
	$mysql = mysql_query("SELECT * FROM admin_requests WHERE id='$requestID' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{$message = "<font class='error_message_11px'>Admin Request Accepted</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_id=$row['user_id'];
		$item_id=$row['create_id'];}
		
	$mysql_admin_array = mysql_query("SELECT admin_array FROM ".$typex." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_admin_array))
		{$admin_array = $row['admin_array'];}
	$adminArray = explode(",",$admin_array);
	
	if(in_array($user_id, $adminArray))
		{$message = "<font class='success_message_11px'>Already Admin</font>";exit();}
	if ($admin_array !== "")
		{$admin_array = "$admin_array,$user_id";}
	else {$admin_array = "$user_id";}
	
	$UpdateArray1 = mysql_query("UPDATE ".$typex." SET admin_array = '$admin_array' WHERE id='$item_id'") or die (mysql_error());
	$delete_pending_request = mysql_query("UPDATE admin_requests SET request_status='1', request_status_date=UTC_TIMESTAMP() WHERE id='$requestID' LIMIT 1");
	echo "<font class='success_message_11px'>Admin Request Accepted</font>";exit();
	}
	
// Rejecting Adminship
if ($_POST["request"] == "rejectadmin")
	{$requestID = preg_replace('#[^0-9]#i', '', $_POST['requestID']);
	$delete_pending_request = mysql_query("DELETE FROM admin_requests WHERE id='$requestID' LIMIT 1"); 
    echo "<font class='error_message_11px'>Admin Request Rejected</font>";exit();
	}
	
// Leave Adminship
if ($_POST["request"] == "LeaveAdmin")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_admin_array = mysql_query("SELECT admin_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_admin_array))
		{$admin_array = $row['admin_array'];}
	$adminArray = explode(",", $admin_array);
	if (!in_array($ids,$adminArray))
		{$message = "";}
	foreach ($adminArray as $key => $value)
		{if ($value == $ids)
			{unset($adminArray[$key]);}} 
	
	$new_string = implode(",",$adminArray);
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET admin_array='$new_string' WHERE id='$item_id'");
	header("location: ".$header_location."?id=".$item_id);exit();
	}
	
// Leave Creatorship
if ($_POST["request"] == "LeaveCreator")
	{$ids=preg_replace('#[^0-9]#i','',$_POST['ids']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	if (!$ids||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_creator_array = mysql_query("SELECT creator_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_creator_array))
		{$creator_array = $row['creator_array'];}
	$creatorArray = explode(",", $creator_array);
	if (!in_array($ids,$creatorArray))
		{$message = "";}
	foreach ($creatorArray as $key => $value)
		{if ($value == $ids)
			{unset($creatorArray[$key]);}} 
	
	$new_string = implode(",",$creatorArray);
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET creator_array='$new_string' WHERE id='$item_id'");
	header("location: ".$header_location."?id=".$item_id);exit();
	}
	
// Leave Adminship
if ($_POST["request"] == "LeaveAdmin2")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$member_id=preg_replace('#[^0-9]#i','',$_POST['member_id']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if (!$member_id||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_admin_array = mysql_query("SELECT admin_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_admin_array))
		{$admin_array = $row['admin_array'];}
	$adminArray = explode(",", $admin_array);
	if (!in_array($member_id,$adminArray))
		{$message = "";}
	foreach ($adminArray as $key => $value)
		{if ($value == $member_id)
			{unset($adminArray[$key]);}} 
	
	$new_string = implode(",",$adminArray);
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET admin_array='$new_string' WHERE id='$item_id'");
	include_once "../".$item_type_s."/".$item_type_s."_admins_list.php";exit();
	}
	
// Leave Creatorship
if ($_POST["request"] == "LeaveCreator2")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$member_id=preg_replace('#[^0-9]#i','',$_POST['member_id']);
	$item_id=preg_replace('#[^0-9]#i','',$_POST['item_id']);
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if (!$member_id||!$item_id||!$item_type||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_creator_array = mysql_query("SELECT creator_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_creator_array))
		{$creator_array = $row['creator_array'];}
	$creatorArray = explode(",", $creator_array);
	if (!in_array($member_id,$creatorArray))
		{$message = "";}
	foreach ($creatorArray as $key => $value)
		{if ($value == $member_id)
			{unset($creatorArray[$key]);}} 
	
	$new_string = implode(",",$creatorArray);
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET creator_array='$new_string' WHERE id='$item_id'");
	include_once "../".$item_type_s."/".$item_type_s."_creators_list.php";exit();
	}
	
$mysql1 = mysql_query("SELECT * FROM ".$item_type." WHERE id=$item_id LIMIT 1");
while($row = mysql_fetch_array($mysql1))
	{$id = $row['id'];
	$user_id = $row['user_id'];
	$admin_array = $row['admin_array'];
	$creator_array = $row['creator_array'];
	$member_array = $row['member_array'];
	$block_array = $row['block_array'];
	$report_array = $row['report_array'];}
	$creatorArray = explode(',',$creator_array);
	$adminArray = explode(',',$admin_array);
	$memberArray = explode(',',$member_array);
	$blockArray = explode(',',$block_array);
	$reportArray = explode(',',$report_array);

	$type=$item_type;
	$type=json_encode($type);

// Top Right Menu
if (in_array($ids,$reportArray)) {$report1="<a href='#' onclick='return false' onmousedown='javascript:UnreportCreate(".$ids.",".$id.",".$type.");'>Unreport To Appropriate</a>";}
else {$report1="<a href='#' onclick='return false' onmousedown='javascript:ReportCreate(".$ids.",".$id.",".$type.");'>Report To Inappropriate</a>";}
if(in_array($ids,$blockArray)){$block1="<a href='#' onclick='return false' onmousedown='javascript:UnblockCreate(".$ids.",".$id.",".$type.");' class='right_top' id='inline'><img src='blank.gif' name='unblock' class='right_outside3'/></a>";}
else {$block1="<a href='#'  onclick='return false' onmousedown='javascript:BlockCreate(".$ids.",".$id.",".$type.");' class='right_top' id='inline'><img src='blank.gif' name='block' class='right_outside2'/></a>";}
if ($ids==$user_id)
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' name='creator' class='right_inside1'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
							<a href='#' onclick='return false' onmousedown='javascript:DeleteCreate(".$ids.",".$id.",".$type.");'>Destroy Planet</a>
						</div></fieldset></div></div>";}
else if (in_array($ids,$creatorArray))
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' name='creator' class='right_inside1'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div class=''><fieldset id='right_inside_menu'><div class='right_inside_open'>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreator(".$ids.",".$id.",".$type.");'>Leave Creatorship</a>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreate(".$ids.",".$id.",".$type.");'>Leave This Page</a>
						</div></fieldset></div></div>";}
else if (in_array($ids,$adminArray))
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' name='admin' class='right_inside4'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div class=''><fieldset id='right_inside_menu'><div class='right_inside_open'>
							".$report1."
							<a href='#' onclick='return false' onmousedown='javascript:LeaveAdmin(".$ids.",".$id.",".$type.");'>Leave Adminship</a>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreate(".$ids.",".$id.",".$type.");'>Leave This Page</a>
						</div></fieldset></div></div>";}
else if (in_array($ids,$memberArray))
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' name='member' class='right_inside3'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div class=''><fieldset id='right_inside_menu'><div class='right_inside_open'>
							".$report1."
							<a href='#' onclick='return false' onmousedown='javascript:RequestCreator(".$ids.",".$id.",".$type.");'>Request Creatorship</a>
							<a href='#' onclick='return false' onmousedown='javascript:RequestAdmin(".$ids.",".$id.",".$type.");'>Request Adminship</a>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreate(".$ids.",".$id.",".$type.");'>Leave This Page</a>
						</div></fieldset></div></div>";}
else
	{$right_top_box = "<div class='right_top_box' id='right_top_box'>
						<a href='#' class='right_top' onclick='return false' onmousedown='javascript:JoinCreate(".$ids.",".$id.",".$type.");'>
							<img src='blank.gif' name='join_page' class='right_outside1'/></a>
						".$block1."</div>";}	

echo $right_top_box; echo $message;	
ob_flush();	
?>
<script type="text/javascript">
// Top Right Options Menu
//$(document).ready(function() 
//	{$(".right_inside2_button").click(function(e) 
//		{e.preventDefault();
//      $("fieldset#right_inside2_menu").toggle();
//		$(".right_inside2_button").toggleClass("right_inside2_open");});
//		$("fieldset#right_inside2_menu").mouseup(function() 
//			{return false});
//      $(document).mouseup(function(e)
//			{if($(e.target).parent("a.right_inside2_button").length==0)
//				{$(".right_inside2_button").removeClass("right_inside2_open");
//				$("fieldset#right_inside2_menu").hide();}
//          });            
//	});
	
$(document).ready(function() 
	{$(".right_inside_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#right_inside_menu").toggle();
		$(".right_inside_button").toggleClass("right_inside_open");});
		$("fieldset#right_inside_menu").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.right_inside_button").length==0)
				{$(".right_inside_button").removeClass("right_inside_open");
				$("fieldset#right_inside_menu").hide();}
            });            
	});
</script>