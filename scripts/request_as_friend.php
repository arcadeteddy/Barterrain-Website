<?php
ob_start();
session_start();
include "../config.php";
$ids = $_SESSION['ids'];
$id = $_SESSION['id'];
$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);
$message="";

// Sending Friend Request
if ($_POST["request"] == "requestFriendship")
	{$id = preg_replace('#[^0-9]#i', '', $_POST['request_id']); 
	$user_id = preg_replace('#[^0-9]#i', '', $_POST['user_id']); 
    $request_id = preg_replace('#[^0-9]#i', '', $_POST['request_id']); 
	$user_id = $_SESSION['ids'];
	$mysql = mysql_query("SELECT id, email FROM members WHERE id=$request_id");
	while($row = mysql_fetch_array($mysql))
		{$request_id = $row['id'];
		$email = $row['email'];}
	$mysql2 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id=$user_id");
	while($row = mysql_fetch_array($mysql2))
		{$user_id = $row['id'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];}
	
		$message="New Friend Request From ".$firstname." ".$lastname."";
		$subject = "New Friend Request From ".$firstname." ".$lastname;
		$headers = 'From: Barterrain <request@barterrain.com>' . "\r\n"  .
					'Reply-To: Barterrain <request@barterrain.com>' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		mail($email,$subject,$message,$headers,'-frequest@barterrain.com');
	
	if ((!$user_id)OR(!$request_id))
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}
	else if ($user_id == $request_id)
		{$message = "<br/><font class='error_message_12px'>Error: You Can't Friend Yourself!</font><br/><br/>";}
	else 
		{// Check to see if this user hasn't already sent a friend request.
		$mysql1 = mysql_query("SELECT id FROM friend_requests WHERE user_id='$user_id' AND request_id='$request_id' AND request_status='0' LIMIT 1");
		$numRows1 = mysql_num_rows($mysql1);
		// Check to see if the user already has a friend request from this person.		
		$mysql2 = mysql_query("SELECT id FROM friend_requests WHERE user_id='$request_id' AND request_id='$user_id' AND request_status='0' LIMIT 1");
		$numRows2 = mysql_num_rows($mysql2);
		if ($numRows1 > 0)
			{$message = "<br/><font class='success_message_12px'>Request Sent!<br/></font><br/><br/>";}
		else if ($numRows2 > 0)
			{$message = "<br/><font class='success_message_12px'>Request Sent!</font><br/><br/>";}
		// Sends the request.
		else 
			{$mysql3 = mysql_query("INSERT INTO friend_requests (user_id, request_id, request_date) VALUES ('$user_id', '$request_id', UTC_TIMESTAMP())");
			$message = "<br/><font class='success_message_12px'>Request Sent!</font><br/><br/>";}
		}
	}

if ($_POST["request"] == "requestFriendship2")
	{$user_id = preg_replace('#[^0-9]#i', '', $_POST['user_id']); 
    $request_id = preg_replace('#[^0-9]#i', '', $_POST['request_id']); 
	$user_id = $_SESSION['ids'];
	$mysql = mysql_query("SELECT id, email FROM members WHERE id=$request_id");
	while($row = mysql_fetch_array($mysql))
		{$request_id = $row['id'];
		$email = $row['email'];}
	$mysql2 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id=$user_id");
	while($row = mysql_fetch_array($mysql2))
		{$user_id = $row['id'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];}
	
		$message="New Friend Request From ".$firstname." ".$lastname."";
		$subject = "New Friend Request From ".$firstname." ".$lastname;                                  
		$headers = 'From: Barterrain <request@barterrain.com>' . "\r\n"  .
					'Reply-To: Barterrain <request@barterrain.com>' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		mail($email,$subject,$message,$headers,'-frequest@barterrain.com');
		
	if ((!$user_id)OR(!$request_id))
		{echo "<font class='error_message_11px'>Error: Missing Data</font>";exit();}
	else if ($user_id == $request_id)
		{echo "<font class='error_message_11px'>Error: Can't Friend Yourself</font>";exit();}
	else 
		{// Check to see if this user hasn't already sent a friend request.
		$mysql1 = mysql_query("SELECT id FROM friend_requests WHERE user_id='$user_id' AND request_id='$request_id' AND request_status='0' LIMIT 1");
		$numRows1 = mysql_num_rows($mysql1);
		// Check to see if the user already has a friend request from this person.		
		$mysql2 = mysql_query("SELECT id FROM friend_requests WHERE user_id='$request_id' AND request_id='$user_id' AND request_status='0' LIMIT 1");
		$numRows2 = mysql_num_rows($mysql2);
		if ($numRows1 > 0)
			{echo "<font class='success_message_11px'>Request Sent</font>";exit();}
		else if ($numRows2 > 0)
			{echo "<font class='success_message_11px'>Request Sent</font>";exit();}
		// Sends the request.
		else 
			{$mysql3 = mysql_query("INSERT INTO friend_requests (user_id, request_id, request_date) VALUES ('$user_id', '$request_id', UTC_TIMESTAMP())");
			echo "<font class='success_message_11px'>Request Sent</font>";exit();}
		}
	}

// Accepting Friendship
if ($_POST["request"] == "acceptFriend")
	{$requestID = preg_replace('#[^0-9]#i', '', $_POST['requestID']);
	$mysql = mysql_query("SELECT * FROM friend_requests WHERE id='$requestID' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font class='error_message_11px'>Friend Request Rejected</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_id=$row['user_id'];
		$request_id=$row['request_id'];}
		
	$mysql_friend_array_1 = mysql_query("SELECT friend_array FROM members WHERE id='$user_id' LIMIT 1");
	$mysql_friend_array_2 = mysql_query("SELECT friend_array FROM members WHERE id='$request_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_friend_array_1))
		{$friend_array_1 = $row['friend_array'];}
	while ($row=mysql_fetch_array($mysql_friend_array_2))
		{$friend_array_2 = $row['friend_array'];}
	$friendArray1 = explode(",",$friend_array_1);
	$friendArray2 = explode(",",$friend_array_2);
	
	if(in_array($request_id, $friendArray1))
		{echo "<font class='success_message_11px'>Friend Request Accepted</font>";exit();}
	if(in_array($user_id, $friendArray2))
		{echo "<font class='success_message_11px'>Friend Request Accepted</font>";exit();}
	if ($friend_array_1 != "")
		{$friend_array_1 = "$friend_array_1,$request_id";}
	else {$friend_array_1 = "$request_id";}
	if ($friend_array_2 != "")
		{$friend_array_2 = "$friend_array_2,$user_id";}
	else {$friend_array_2 = "$user_id";}
	
	$UpdateArray1 = mysql_query("UPDATE members SET friend_array = '$friend_array_1' WHERE id='$user_id'") or die (mysql_error());
	$UpdateArray2 = mysql_query("UPDATE members SET friend_array = '$friend_array_2' WHERE id='$request_id'") or die (mysql_error());
	$delete_pending_request = mysql_query("UPDATE friend_requests SET request_status='1', request_status_date=UTC_TIMESTAMP() WHERE id='$requestID' LIMIT 1");
	echo "<font class='success_message_11px'>Friend Request Accepted</font>";exit();
	}

// Rejecting Friendship
if ($_POST["request"] == "rejectFriend")
	{$requestID = preg_replace('#[^0-9]#i', '', $_POST['requestID']);
	$delete_pending_request = mysql_query("DELETE FROM friend_requests WHERE id='$requestID' LIMIT 1"); 
    echo "<font class='error_message_11px'>Friend Request Rejected</font>";exit();
	
	}
	
// Removing Friendship
if ($_POST['request'] == "removeFriendship")
	{$user_id = preg_replace('#[^0-9]#i','',$_POST['user_id']);
	$request_id = preg_replace('#[^0-9]#i','',$_POST['request_id']);

	if (!$user_id||!$request_id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}
	$mysql_friend_array_1 = mysql_query("SELECT friend_array, family_array, subscriptions_array, subscribers_array FROM members WHERE id='$user_id' LIMIT 1");
	$mysql_friend_array_2 = mysql_query("SELECT friend_array, family_array, subscriptions_array, subscribers_array  FROM members WHERE id='$request_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_friend_array_1))
		{$friend_array_1 = $row['friend_array'];
		$family_array_1 = $row['family_array'];
		$subscription_array_1 = $row['subscriptions_array'];
		$subscriber_array_1 = $row['subscribers_array'];}
	while ($row=mysql_fetch_array($mysql_friend_array_2))
		{$friend_array_2 = $row['friend_array'];
		$family_array_2 = $row['family_array'];
		$subscription_array_2 = $row['subscriptions_array'];
		$subscriber_array_2 = $row['subscribers_array'];}
	$friendArray1 = explode(",", $friend_array_1);
	$familyArray1 = explode(",", $family_array_1);
	$subscriptionArray1 = explode(",", $subscription_array_1);
	$subscriberArray1 = explode(",", $subscriber_array_1);
	$friendArray2 = explode(",", $friend_array_2);
	$familyArray2 = explode(",", $family_array_2);
	$subscriptionArray2 = explode(",", $subscription_array_2);
	$subscriberArray2 = explode(",", $subscriber_array_2);
	if ((!in_array($request_id,$friendArray1))AND(!in_array($request_id,$familyArray1)))
		{$message = "<br/><font class='error_message_12px'>Friend Removed!</font><br/><br/>";}
	if ((!in_array($user_id,$friendArray2))AND(!in_array($user_id,$familyArray2)))
		{$message = "<br/><font class='error_message_12px'>Friend Removed!</font><br/><br/>";}
	
	foreach ($friendArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($friendArray1[$key]);}}
	foreach ($familyArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($familyArray1[$key]);}}
	foreach ($subscriptionArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($subscriptionArray1[$key]);}}
	foreach ($subscriberArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($subscriberArray1[$key]);}}
	foreach ($friendArray2 as $key => $value)
		{if ($value == $user_id)
			{unset($friendArray2[$key]);}} 
	foreach ($familyArray2 as $key => $value) 
		{if ($value == $user_id)
			{unset($familyArray2[$key]);}}
	foreach ($subscriptionArray2 as $key => $value) 
		{if ($value == $user_id)
			{unset($subscriptionArray2[$key]);}}
	foreach ($subscriberArray2 as $key => $value) 
		{if ($value == $user_id)
			{unset($subscriberArray2[$key]);}}
	$new_string_1 = implode(",",$friendArray1);
	$new_string_2 = implode(",",$familyArray1);
	$new_string_3 = implode(",",$subscriptionArray1);
	$new_string_4 = implode(",",$subscriberArray1);
	$new_string_5 = implode(",",$friendArray2);
	$new_string_6 = implode(",",$familyArray2);
	$new_string_7 = implode(",",$subscriptionArray2);
	$new_string_8 = implode(",",$subscriberArray2);
	$mysql = mysql_query("UPDATE members SET friend_array='$new_string_1',family_array='$new_string_2',subscriptions_array='$new_string_3',subscribers_array='$new_string_4' WHERE id='$user_id'");
	$mysql = mysql_query("UPDATE members SET friend_array='$new_string_5',family_array='$new_string_6',subscriptions_array='$new_string_7',subscribers_array='$new_string_8' WHERE id='$request_id'");
	$message = "<br/><font class='success_message_12px'>Friend Removed!</font><br/><br/>";
	header("location: ../profile/profile.php?id=".$request_id);
	}

// Removing Friendship 2
if ($_POST['request'] == "removeFriendship2")
	{$list = $_POST['list'];
	$user_id = preg_replace('#[^0-9]#i','',$_POST['user_id']);
	$request_id = preg_replace('#[^0-9]#i','',$_POST['request_id']);

	if (!$user_id||!$request_id||!$thisWipit)
		{$message = "";}
	$mysql_friend_array_1 = mysql_query("SELECT friend_array, family_array, subscriptions_array, subscribers_array FROM members WHERE id='$user_id' LIMIT 1");
	$mysql_friend_array_2 = mysql_query("SELECT friend_array, family_array, subscriptions_array, subscribers_array  FROM members WHERE id='$request_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_friend_array_1))
		{$friend_array_1 = $row['friend_array'];
		$family_array_1 = $row['family_array'];
		$subscription_array_1 = $row['subscriptions_array'];
		$subscriber_array_1 = $row['subscribers_array'];}
	while ($row=mysql_fetch_array($mysql_friend_array_2))
		{$friend_array_2 = $row['friend_array'];
		$family_array_2 = $row['family_array'];
		$subscription_array_2 = $row['subscriptions_array'];
		$subscriber_array_2 = $row['subscribers_array'];}
	$friendArray1 = explode(",", $friend_array_1);
	$familyArray1 = explode(",", $family_array_1);
	$subscriptionArray1 = explode(",", $subscription_array_1);
	$subscriberArray1 = explode(",", $subscriber_array_1);
	$friendArray2 = explode(",", $friend_array_2);
	$familyArray2 = explode(",", $family_array_2);
	$subscriptionArray2 = explode(",", $subscription_array_2);
	$subscriberArray2 = explode(",", $subscriber_array_2);
	if ((!in_array($request_id,$friendArray1))AND(!in_array($request_id,$familyArray1)))
		{$message = "";}
	if ((!in_array($user_id,$friendArray2))AND(!in_array($user_id,$familyArray2)))
		{$message = "";}
	
	foreach ($friendArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($friendArray1[$key]);}}
	foreach ($familyArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($familyArray1[$key]);}}
	foreach ($subscriptionArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($subscriptionArray1[$key]);}}
	foreach ($subscriberArray1 as $key => $value) 
		{if ($value == $request_id)
			{unset($subscriberArray1[$key]);}}
	foreach ($friendArray2 as $key => $value)
		{if ($value == $user_id)
			{unset($friendArray2[$key]);}} 
	foreach ($familyArray2 as $key => $value) 
		{if ($value == $user_id)
			{unset($familyArray2[$key]);}}
	foreach ($subscriptionArray2 as $key => $value) 
		{if ($value == $user_id)
			{unset($subscriptionArray2[$key]);}}
	foreach ($subscriberArray2 as $key => $value) 
		{if ($value == $user_id)
			{unset($subscriberArray2[$key]);}}
	$new_string_1 = implode(",",$friendArray1);
	$new_string_2 = implode(",",$familyArray1);
	$new_string_3 = implode(",",$subscriptionArray1);
	$new_string_4 = implode(",",$subscriberArray1);
	$new_string_5 = implode(",",$friendArray2);
	$new_string_6 = implode(",",$familyArray2);
	$new_string_7 = implode(",",$subscriptionArray2);
	$new_string_8 = implode(",",$subscriberArray2);
	$mysql = mysql_query("UPDATE members SET friend_array='$new_string_1',family_array='$new_string_2',subscriptions_array='$new_string_3',subscribers_array='$new_string_4' WHERE id='$user_id'");
	$mysql = mysql_query("UPDATE members SET friend_array='$new_string_5',family_array='$new_string_6',subscriptions_array='$new_string_7',subscribers_array='$new_string_8' WHERE id='$request_id'");
	include_once "../profile/".$list."_list.php";
	}

// Friends to Family
if ($_POST["request"] == "FriendstoFamily")
	{$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$id = preg_replace('#[^0-9]#i','',$_POST['id']);
	if (!$ids||!$id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}
		
	$mysql_array = mysql_query("SELECT friend_array,family_array FROM members WHERE id='$ids' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_array))
		{$friend_array = $row['friend_array'];
		$family_array = $row['family_array'];}
	$friendArray = explode(",",$friend_array);
	$familyArray = explode(",",$family_array);
	
	if(in_array($id, $familyArray))
		{$message = "<br/><font class='success_message_12px'>Already Family!</font><br/><br/>";}
	if ($family_array != "")
		{$family_array = "$family_array,$id";}
	else {$family_array = "$id";}
	foreach ($friendArray as $key => $value) 
		{if ($value == $id)
			{unset($friendArray[$key]);}}
	$new_string = implode(",",$friendArray);
	
	$UpdateArray1 = mysql_query("UPDATE members SET family_array = '$family_array' WHERE id='$ids'") or die (mysql_error());
	$UpdateArray2 = mysql_query("UPDATE members SET friend_array='$new_string' WHERE id='$ids'");
	}
	
// Family to Friends
if ($_POST["request"] == "FamilytoFriends")
	{$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$id = preg_replace('#[^0-9]#i','',$_POST['id']);
	if (!$ids||!$id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}
		
	$mysql_array = mysql_query("SELECT friend_array,family_array FROM members WHERE id='$ids' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_array))
		{$friend_array = $row['friend_array'];
		$family_array = $row['family_array'];}
	$friendArray = explode(",",$friend_array);
	$familyArray = explode(",",$family_array);
	
	if(in_array($id, $friendArray))
		{$message = "<br/><font class='success_message_12px'>Already Friend!</font><br/><br/>";}
	if ($friend_array != "")
		{$friend_array = "$friend_array,$id";}
	else {$friend_array = "$id";}
	foreach ($familyArray as $key => $value) 
		{if ($value == $id)
			{unset($familyArray[$key]);}}
	$new_string = implode(",",$familyArray);
	
	$UpdateArray1 = mysql_query("UPDATE members SET friend_array = '$friend_array' WHERE id='$ids'") or die (mysql_error());
	$UpdateArray2 = mysql_query("UPDATE members SET family_array='$new_string' WHERE id='$ids'");
	}
	
// Block
if ($_POST["request"] == "blockUser")
	{$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$id = preg_replace('#[^0-9]#i','',$_POST['id']);
	if (!$ids||!$id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_block_array = mysql_query("SELECT block_array FROM members WHERE id='$ids' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_block_array))
		{$block_array = $row['block_array'];
	$blockArray = explode(",",$block_array);}
	
	if(in_array($id, $blockArray))
		{$message = "<br/><font class='success_message_12px'>Already Blocked!</font><br/><br/>";}
	if ($block_array != "")
		{$block_array = "$block_array,$id";}
	else {$block_array = "$id";}
	
	$UpdateArray = mysql_query("UPDATE members SET block_array = '$block_array' WHERE id='$ids'") or die (mysql_error());
	}

// Unblock
if ($_POST['request'] == "unblockUser")
	{$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$id = preg_replace('#[^0-9]#i','',$_POST['id']);
	if (!$ids||!$id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_block_array = mysql_query("SELECT block_array FROM members WHERE id='$ids' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_block_array))
		{$block_array = $row['block_array'];}
	$blockArray = explode(",", $block_array);
	if (!in_array($id,$blockArray))
		{$message = "<br/><font class='success_message_12px'>Already Unblocked!</font><br/><br/>";}

	foreach ($blockArray as $key => $value)
		{if ($value == $id)
			{unset($blockArray[$key]);}} 
			
	$new_string = implode(",",$blockArray);
	$UpdateArray = mysql_query("UPDATE members SET block_array='$new_string' WHERE id='$ids'");
	}
	
// Subscribe
if ($_POST["request"] == "subscribeUser")
	{$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$id = preg_replace('#[^0-9]#i','',$_POST['id']);
	if (!$ids||!$id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_subscribe_array1 = mysql_query("SELECT subscriptions_array FROM members WHERE id='$ids' LIMIT 1");
	$mysql_subscribe_array2 = mysql_query("SELECT subscribers_array FROM members WHERE id='$id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_subscribe_array1))
		{$subscriptions_array = $row['subscriptions_array'];
	$subscriptionsArray = explode(",",$subscriptions_array);}
	while ($row=mysql_fetch_array($mysql_subscribe_array2))
		{$subscribers_array = $row['subscribers_array'];
	$subscribersArray = explode(",",$subscribers_array);}
	
	if(in_array($id, $subscriptionsArray))
		{$message = "<br/><font class='success_message_12px'>Already Subscribed!</font><br/><br/>";}
	if ($subscriptions_array != "")
		{$subscriptions_array = "$subscriptions_array,$id";}
	else {$subscriptions_array = "$id";}
	if(in_array($ids, $subscribersArray))
		{$message = "<br/><font class='success_message_12px';>Already Subscribed!</font><br/><br/>";}
	if ($subscribers_array != "")
		{$subscribers_array = "$subscribers_array,$ids";}
	else {$subscribers_array = "$ids";}
	
	$UpdateArray1 = mysql_query("UPDATE members SET subscriptions_array = '$subscriptions_array' WHERE id='$ids'") or die (mysql_error());
	$UpdateArray2 = mysql_query("UPDATE members SET subscribers_array = '$subscribers_array' WHERE id='$id'") or die (mysql_error());
	}

// Unsubscribe
if ($_POST['request'] == "unsubscribeUser")
	{$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$id = preg_replace('#[^0-9]#i','',$_POST['id']);
	if (!$ids||!$id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_subscribe_array1 = mysql_query("SELECT subscriptions_array FROM members WHERE id='$ids' LIMIT 1");
	$mysql_subscribe_array2 = mysql_query("SELECT subscribers_array FROM members WHERE id='$id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_subscribe_array1))
		{$subscriptions_array = $row['subscriptions_array'];}
	$subscriptionsArray = explode(",", $subscriptions_array);
	if (!in_array($id,$subscriptionsArray))
		{$message = "<br/><font class='success_message_12px'>Already Unsubscribed!</font><br/><br/>";}
	while ($row=mysql_fetch_array($mysql_subscribe_array2))
		{$subscribers_array = $row['subscribers_array'];}
	$subscribersArray = explode(",", $subscribers_array);
	if (!in_array($ids,$subscribersArray))
		{$message = "<br/><font class='success_message_12px'>Already Unsubscribed!</font><br/><br/>";}
		
	foreach ($subscriptionsArray as $key => $value)
		{if ($value == $id)
			{unset($subscriptionsArray[$key]);}} 
	foreach ($subscribersArray as $key => $value)
		{if ($value == $ids)
			{unset($subscribersArray[$key]);}} 
			
	$new_string1 = implode(",",$subscriptionsArray);
	$new_string2 = implode(",",$subscribersArray);
	$UpdateArray1 = mysql_query("UPDATE members SET subscriptions_array='$new_string1' WHERE id='$ids'");
	$UpdateArray2 = mysql_query("UPDATE members SET subscribers_array='$new_string2' WHERE id='$id'");
	}
	
// Unsubscribe
if ($_POST['request'] == "unsubscribeUser2")
	{$list = $_POST['list'];
	$subscriber_id = preg_replace('#[^0-9]#i','',$_POST['subscriber_id']);
	$user_id = preg_replace('#[^0-9]#i','',$_POST['user_id']);
	if (!$subscriber_id||!$user_id||!$thisWipit)
		{$message = "<br/><font class='error_message_12px'>Error: Missing Data!</font><br/><br/>";}

	$mysql_subscribe_array1 = mysql_query("SELECT subscribers_array, subscriptions_array FROM members WHERE id='$subscriber_id' LIMIT 1");
	$mysql_subscribe_array2 = mysql_query("SELECT subscribers_array, subscriptions_array FROM members WHERE id='$user_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_subscribe_array1))
		{$subscriptions_array = $row['subscriptions_array'];}
	$subscriptionsArray = explode(",", $subscriptions_array);
	if (!in_array($user_id,$subscriptionsArray))
		{$message = "";}
	while ($row=mysql_fetch_array($mysql_subscribe_array2))
		{$subscribers_array = $row['subscribers_array'];}
	$subscribersArray = explode(",", $subscribers_array);
	if (!in_array($subscriber_id,$subscribersArray))
		{$message = "";}
		
	foreach ($subscriptionsArray as $key => $value)
		{if ($value == $user_id)
			{unset($subscriptionsArray[$key]);}} 
	foreach ($subscribersArray as $key => $value)
		{if ($value == $subscriber_id)
			{unset($subscribersArray[$key]);}} 
			
	$new_string1 = implode(",",$subscriptionsArray);
	$new_string2 = implode(",",$subscribersArray);
	$UpdateArray1 = mysql_query("UPDATE members SET subscriptions_array='$new_string1' WHERE id='$subscriber_id'");
	$UpdateArray2 = mysql_query("UPDATE members SET subscribers_array='$new_string2' WHERE id='$user_id'");
	include_once "../profile/".$list."_list.php";
	}
	
// Top Right Menu
if (isset($_SESSION['ids']) && $_SESSION['ids'] != $id)
	{$mysqlArray = mysql_query("SELECT friend_array, family_array, block_array, subscriptions_array FROM members WHERE id='$ids' LIMIT 1");
	while ($row = mysql_fetch_array($mysqlArray))
		{$rt_friend_array = $row['friend_array'];
		$rt_family_array = $row['family_array'];
		$rt_block_array = $row['block_array'];
		$rt_subscribe_array = $row['subscriptions_array'];}
	$rt_friend_array = explode(",",$rt_friend_array);
	$rt_family_array = explode(",",$rt_family_array);
	$rt_block_array = explode(",",$rt_block_array);
	$rt_subscribe_array = explode(",",$rt_subscribe_array);
	if (in_array($id,$rt_subscribe_array)) {$subscribe1="<img src='barterrain_profile_images/blank.gif' name='subscribed' class='right_inside6'/>";
		$subscribe2="<a href='#' onclick='return false' onmousedown='javascript:unsubscribeUser($ids, $id);'>Unsubscribe To This Person</a>";}
	else {$subscribe1="<a href='#' onclick='return false' onmousedown='javascript:subscribeUser($ids, $id);' class='right_top' id='inline'><img src='barterrain_profile_images/blank.gif' name='unsubscribe' class='right_inside2'/></a>";
		$subscribe2="";}
	if ((in_array($id,$rt_block_array))AND((in_array($id,$rt_friend_array))OR(in_array($id,$rt_family_array))))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='barterrain_profile_images/blank.gif' name='blocked' class='right_inside4'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' onclick='return false' onmousedown='javascript:unblockUser($ids, $id);'>Unblock This Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove This Person</a>
						</div></fieldset></div></div>";}
	else if (in_array($id,$rt_friend_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='barterrain_profile_images/blank.gif' name='friend' class='right_inside1'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' class='right_inside_open' onclick='return false' onmousedown='javascript:FriendstoFamily($ids, $id);'>Friends To Family</a>
						<a href='#' onclick='return false' onmousedown='javascript:blockUser($ids, $id);'>Block This Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove This Person</a>
						</div></fieldset></div></div>";}
	else if (in_array($id,$rt_family_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='barterrain_profile_images/blank.gif' name='family' class='right_inside3'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' class='right_inside_open' onclick='return false' onmousedown='javascript:FamilytoFriends($ids, $id);'>Family To Friends</a>
						<a href='#' onclick='return false' onmousedown='javascript:blockUser($ids, $id);'>Block This Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove This Person</a>
						</div></fieldset></div></div>";}

	else if (in_array($id,$rt_block_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><a href='#' class='right_top' onclick='return false' onmousedown='javascript:addAsFriend(".$ids.",".$id.");'>
						<img src='barterrain_profile_images/blank.gif' name='add_friend' class='right_outside1'/></a>
						<a href='#' onmousedown='javascript:unblockUser($ids, $id);' class='right_top' id='inline'>						
						<img src='barterrain_profile_images/blank.gif' name='unblock' class='right_outside3'/></a></div>";}
	else
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><a href='#' class='right_top' onclick='return false' onmousedown='javascript:addAsFriend(".$ids.",".$id.");'>
						<img src='barterrain_profile_images/blank.gif' name='add_friend' class='right_outside1'/></a>
						<a href='#' onmousedown='javascript:blockUser($ids, $id);' class='right_top' id='inline'>						
						<img src='barterrain_profile_images/blank.gif' name='block' class='right_outside2'/></a></div>";}
	}
else if (isset($_SESSION['ids']) && $_SESSION['ids'] == $id)
	{$right_top_box = "";}
	
echo $right_top_box; echo $message;	
ob_flush();
?>

<script type="text/javascript">
// Friends Options Menu
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