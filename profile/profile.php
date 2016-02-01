<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include "../config.php";

$_SESSION['file_location'] = "profile";
$file_location = "profile";
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

$id = $_SESSION['id'];
$ids = $_SESSION['ids'];
if (isset($_GET['id'])) 
	{$id = preg_replace('#[^0-9]#i', '', $_GET['id']);}
$_SESSION['id'] = $id;

include_once "../scripts/check_login.php";
if ($id!==$ids)
	{include_once "../scripts/check_block.php";}
ob_flush();

$force_album="";
$numRows_force_album="";
if (isset($_GET['force_album'])) 
	{$force_album=$_GET['force_album'];
	$mysql_force_album = mysql_query("SELECT id FROM albums WHERE user_id='$id' AND id='$force_album' AND delete_item='1' LIMIT 1");
	$numRows_force_album = mysql_num_rows($mysql_force_album);}
	
$force_game="";
$numRows_force_game="";
if (isset($_GET['force_game'])) 
	{$force_game=$_GET['force_game'];
	$mysql_force_game = mysql_query("SELECT id FROM games WHERE user_id='$id' AND id='$force_game' AND delete_item='1' LIMIT 1");
	$numRows_force_game = mysql_num_rows($mysql_force_game);}

$force_video="";
$numRows_force_video="";
if (isset($_GET['force_video'])) 
	{$force_video=$_GET['force_video'];
	$mysql_force_video = mysql_query("SELECT id FROM videos WHERE user_id='$id' AND id='$force_video' AND delete_item='1' LIMIT 1");
	$numRows_force_video = mysql_num_rows($mysql_force_video);}
	
// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
	
$cacheBuster=rand(999999999,9999999999999);   
$_SESSION['cacheBuster'] = $cacheBuster;

$_SESSION['id'] = $id;
$success_message="";
$right_top_box="<br/>";
$margin_top_1="";
$margin_top_2="";
$mysql1 = mysql_query("SELECT * FROM members WHERE id=$id");
$mysql2 = mysql_query("SELECT * FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql1))
	{$id = $row['id'];
	$fullname = $row['fullname'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
	$email = $row['email'];
	$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$subscriptions_array = $row['subscriptions_array'];
	$subscribers_array = $row['subscribers_array'];
	$planets_array = $row['planets_array'];
	$cover_picture_ext = $row['cover_picture_ext'];
	$check_pic="../user_files/user$id/profile_pic.jpg";
	$default_pic="../user_files/user0/default_profile_pic.png";
	if (file_exists($check_pic))
		{$user_pic="<img class='profile_image thumb_background' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else
		{$user_pic="<img class='profile_image thumb_background' src='$default_pic' width='260px' height='auto'/>";}
	$check_pic2="../user_files/user$id/cover_pic.".$cover_picture_ext."";
	if (file_exists($check_pic2))
		{$cover_pic="<img class='cover_image' src='$check_pic2#$cacheBuster' width='1120px' height='auto'/>";}
	else{$cover_pic="";}
	}
	
$mysql_alias = mysql_query("SELECT alias FROM members_planets WHERE id=$id LIMIT 1");
while($row = mysql_fetch_array($mysql_alias))
	{$alias = $row['alias'];}
	
if (($numRows_force_album>0)OR($numRows_force_game>0)OR($numRows_force_video>0))
	{$selected_window_wall="";
	$addClass_white_background_full2="hide_div";
	$addClass_profile_page_middle_right="hide_div";
	$addClass_profile_page_middle_left="expand";
	$selected_window_media="selected_window";}
else
	{$selected_window_wall="selected_window";
	$addClass_white_background_full2="";
	$addClass_profile_page_middle_right="";
	$addClass_profile_page_middle_left="";
	$selected_window_media="";}
	
$Media_side="";
$mysql_check_empty=mysql_query("(SELECT id FROM albums WHERE user_id=$id AND delete_item='1' LIMIT 1) UNION ALL (SELECT id FROM games WHERE user_id=$id AND delete_item='1' LIMIT 1) UNION ALL (SELECT id FROM videos WHERE user_id=$id AND delete_item='1' LIMIT 1)");
$numRows=mysql_num_rows($mysql_check_empty);
if ($numRows>0)
	{$Media_side='<a href="#" onclick="return false" onmousedown="javascript:window_3('.$ids.','.$id.');" class="side_button"><div class="side_button '.$selected_window_media.' profile_window_3"><img src="blank.gif" width="1px" height="1px" class="profile_media"/><span class="span_side">Media</span></div></a>';}
$Notes_side="";
$mysql_check_empty=mysql_query("SELECT id FROM notes WHERE user_id=$id AND delete_item='1' LIMIT 1");
$numRows=mysql_num_rows($mysql_check_empty);
if ($numRows>0)
	{$Notes_side='<a href="#" onclick="return false" onmousedown="javascript:window_4('.$ids.','.$id.');" class="side_button"><div class="side_button profile_window_4"><img src="blank.gif" width="1px" height="1px" class="profile_notes"/><span class="span_side">Notes</span></div></a>';}
$Planets_side="";
if ($planets_array!=="")
	{$Planets_side='<a href="#" onclick="return false" onmousedown="javascript:window_8('.$ids.','.$id.');" class="side_button"><div class="side_button profile_window_8"><img src="blank.gif" width="1px" height="1px" class="profile_planets"/><span class="span_side">Planets</span></div></a>';}
$SS_side="";
if (($subscriptions_array!="")OR($subscribers_array!=""))
	{$SS_side='<a href="#" onclick="return false" onmousedown="javascript:window_5('.$ids.','.$id.');" class="side_button"><div class="side_button profile_window_5"><img src="blank.gif" width="1px" height="1px" class="profile_subscriptions"/><span class="span_side">Subscriptions</span></div></a>';}
$FF_side="";
if (($family_array!=="")AND($friend_array!==""))
	{$FF_side_name="Family & Friends";}
else if (($family_array=="")AND($friend_array!==""))
	{$FF_side_name="Friends";}
else if (($family_array!=="")AND($friend_array==""))
	{$FF_side_name="Family";}
if (($family_array!=="")OR($friend_array!==""))
	{$FF_side='<a href="#" onclick="return false" onmousedown="javascript:window_6('.$ids.','.$id.');" class="side_button"><div class="side_button profile_window_6"><img src="blank.gif" width="1px" height="1px" class="profile_friends"/><span class="span_side">'.$FF_side_name.'</span></div></a>';}
$MB_side="";
$mysql_check_empty=mysql_query("(SELECT id FROM posts WHERE ((user_page_id='$id')AND((memory_type='b')OR(memory_type='d'))) OR ((user_post_id='$id')AND((memory_type='c')OR(memory_type='d'))) AND delete_item='1') 
					UNION ALL(SELECT id FROM notes WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM albums WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM images_walls WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM games WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM videos WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM albums_posts WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM images_posts WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM games_posts WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM videos_posts WHERE user_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets WHERE user_id='$id' AND delete_item='1' AND memory_type='b') ");
$numRows=mysql_num_rows($mysql_check_empty);
if ($numRows>0)
	{$MB_side='<a href="#" onclick="return false" onmousedown="javascript:window_7('.$ids.','.$id.');" class="side_button"><div class="side_button profile_window_7"><img src="blank.gif" width="1px" height="1px" class="profile_memory_box"/><span class="span_side">Memory Box</span></div></a>';}

// Top Right Menu
$php_self = $_SERVER['REQUEST_URI'];
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
	if (in_array($id,$rt_subscribe_array)) {$subscribe1="<img src='blank.gif' width='1px' height='1px' name='subscribed' class='right_inside6'/>";
		$subscribe2="<a href='#' onclick='return false' onmousedown='javascript:unsubscribeUser($ids, $id);'>Unsubscribe To This Person</a>";}
	else {$subscribe1="<a href='#' onclick='return false' onmousedown='javascript:subscribeUser($ids, $id);' class='right_top' id='inline'><img src='blank.gif' width='1px' height='1px' name='unsubscribe' class='right_inside2'/></a>";
		$subscribe2="";}
	if ((in_array($id,$rt_block_array))AND((in_array($id,$rt_friend_array))OR(in_array($id,$rt_family_array))))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='blocked' class='right_inside4'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' onclick='return false' onmousedown='javascript:unblockUser($ids, $id);'>Unblock This Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove This Person</a>
						</div></fieldset></div></div>";}
	else if (in_array($id,$rt_friend_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='friend' class='right_inside1'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' class='right_inside_open' onclick='return false' onmousedown='javascript:FriendstoFamily($ids, $id);'>Friends To Family</a>
						<a href='#' onclick='return false' onmousedown='javascript:blockUser($ids, $id);'>Block This Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove This Person</a>
						</div></fieldset></div></div>";}
	else if (in_array($id,$rt_family_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='family' class='right_inside3'/>
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
						<img src='blank.gif' width='1px' height='1px' name='add_friend' class='right_outside1'/></a>
						<a href='#' onmousedown='javascript:unblockUser($ids, $id);' class='right_top' id='inline'>						
						<img src='blank.gif' width='1px' height='1px' name='unblock' class='right_outside3'/></a></div>";}
	else
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><a href='#' class='right_top' onclick='return false' onmousedown='javascript:addAsFriend(".$ids.",".$id.");'>
						<img src='blank.gif' width='1px' height='1px' name='add_friend' class='right_outside1'/></a>
						<a href='#' onmousedown='javascript:blockUser($ids, $id);' class='right_top' id='inline'>						
						<img src='blank.gif' width='1px' height='1px' name='block' class='right_outside2'/></a></div>";}
	}
else if (isset($_SESSION['ids']) && $_SESSION['ids'] == $id)
	{$right_top_box = "<br/>";}

	
// Display Friends List
$friend_list = "";
if ($friend_array != "")
	{$friendArray = explode(",",$friend_array);
	shuffle($friendArray);
	$friendArray8 = array_slice($friendArray,0,8);
	$friend_count = count($friendArray);
	$friend_list .= "<div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='friends_lists'/><span class='heading_list'>Friends (".$friend_count.")</span></div>
					<div class='float_right'><a href='#' onclick='return false' onmousedown='javascript:window_6(".$ids.",".$id.");' class='bold'>See All</a></div>
					</div>";
	$i = 0;
	$friend_list .="<div class='under_side_bars'>";
	foreach ($friendArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='profile.php?id=$value'><img src='$check_pic_friend_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='profile.php?id=$value'><img src='$default_pic_friend_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id,firstname, lastname, location, friend_array, family_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);}
			
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else {$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}
			
		$friend_list .="<div class='list_wrap'>
						<div class='list_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a></div>
							<span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div>
						</div>";
			
		}
		$friend_list .="</div><br/><br/>";
	}
	
// Display Family List
$family_list = "";
if ($family_array!="")
	{$familyArray = explode(",",$family_array);
	shuffle($familyArray);
	$familyArray8 = array_slice($familyArray,0,4);
	$family_count = count($familyArray);
	$family_list .= "<div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='family_lists'/><span class='heading_list'>Family (".$family_count.")</span></div>
					<div class='float_right'><a href='#' onclick='return false' onmousedown='javascript:window_6(".$ids.",".$id.");' class='bold'>See All</a></div>
					</div>";
	$i = 0;
	$family_list .="<div class='under_side_bars'>";
	foreach ($familyArray8 as $key => $value)
		{$i++;
		$check_pic_family_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_family_bar="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic_family_bar))
			{$user_pic_family_bar="<a href='profile.php?id=$value'><img src='$check_pic_family_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
		else
			{$user_pic_family_bar="<a href='profile.php?id=$value'><img src='$default_pic_family_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id,firstname, lastname, location, friend_array, family_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$family_id = $row['id'];
			$family_firstname = $row['firstname'];
			$family_lastname = $row['lastname'];
			$family_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);}
			
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$family_id))
			{$add_friend = "";}
		else {$add_friend = "<span id='request".$family_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$family_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}
		
		$family_list .="<div class='list_wrap'>
						<div class='list_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$family_id."'>".$user_pic_family_bar."</a></div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$family_id."'><b>".$family_firstname." ".$family_lastname."</b></a></div>
							<span class='places'>".$family_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$family_id."' class='post_link'>Message</a></div>
						</div>";
		}
		$family_list .="</div><br/><br/>";
	}
	
// Planets List
$planets_colonized_list = "";
if ($planets_array != "")
	{$planetsArray = explode(",",$planets_array);
	shuffle($planetsArray);
	$planetsArray4 = array_slice($planetsArray,0,4);
	$planets_count = count($planetsArray);
	$planets_colonized_list .= "<div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='planets_colonized_lists'/><span class='heading_list'>Colonized Planets (".$planets_count.")</span></div>
					<div class='float_right'><a href='#' onclick='return false' onmousedown='javascript:window_8(".$ids.",".$id.");' class='bold'>See All</a></div>
					</div>";
	$i = 0;
	$planets_colonized_list .="<div class='under_side_bars'>";
	foreach ($planetsArray4 as $key => $value)
		{$i++;
		$mysql_planet1=mysql_query("SELECT * FROM planets WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_planet1))
			{$planet_id = $row['id'];
			$create_id = $row['id'];
			$user_id = $row['user_id'];
			$planet_name = $row['planet_name'];
			$categories = $row['categories'];
			if ($categories=="Undefined")
				{$categories="";}
			if ((strlen($categories))>30)
				{$categories = substr($categories,0,30);
				$categories=$categories."...";}
			$creator_array = $row['creator_array'];
			$creatorArray = explode(",",$creator_array);
			$events_array = $row['events_array'];
			$eventsArray = explode(",",$events_array);
			if($events_array!=="")
				{$eventsArray = end($eventsArray);
				$mysql_event=mysql_query("SELECT event_name FROM events WHERE id='$eventsArray' LIMIT 1") or die ("Sorry, we have a system error!");
				while ($row = mysql_fetch_array($mysql_event))
					{$event_name = $row['event_name'];}}
			$member_array = $row['member_array'];
			$memberArray = explode(",",$member_array);
			$member_count = count($memberArray);			
			if($member_count == 1){$member_count_planets = "Member: ".$member_count;}			
			else {$member_count_planets = "Members: ".$member_count;}		
			$check_pic_planet_bar="../planet_files/planet$value/planet_thumb.jpg";
			$default_pic_planet_bar="../planet_files/planet0/planet_thumb.png";
			if (file_exists($check_pic_planet_bar))
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$value'><img src='$check_pic_planet_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$value'><img src='$default_pic_planet_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			if($user_id==$id){$planet_2="Planet Creator";}
			else if (in_array($id,$creatorArray)){$planet_2="Planet Creator";}
			else{$planet_2="Planet Colonizer";}
			
			$like_array = $row['like_array'];
			$love_array = $row['love_array'];
			$like_array_create = $row['like_array'];
			$love_array_create = $row['love_array'];
			$likeArray_create = explode(",",$like_array_create);
			$loveArray_create = explode(",",$love_array_create);
			$like_array_count_create = count($likeArray_create);
			$love_array_count_create = count($loveArray_create);    
			
			$type="planets";
			$type=json_encode($type);
			
	if (in_array($ids,$likeArray_create))
		{$like_love_create = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_create(".$user_id.",".$ids.",".$create_id.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_create))
		{$like_love_create = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_create(".$user_id.",".$ids.",".$create_id.");'>Unlove</a>";}
	else 
		{$like_love_create = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_create(".$user_id.",".$ids.",".$create_id.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_create(".$user_id.",".$ids.",".$create_id.");'>Love</a>";}
	if (($like_array_create !="")AND($love_array_create !=""))
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$like_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$love_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$like_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$love_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_create = "";}

		$planets_colonized_list .="<div class='list_wrap'>
						<div class='list_wrap_1'>".$user_pic_planet_bar."</div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/planet/planet.php?id=".$planet_id."'><b>".$planet_name."</b></a></div>
							<span class='places'>".$categories."</span>
							<div id='create_ll_".$create_id."'>
								".$like_love_create." ".$like_love2_create."
							</div>
						</div>
						</div>";
			}
		}
	$planets_colonized_list .="</div>";
	}
	
// Planets List
$planets_list = "";
$planets_array = "";
unset($planets_array);
$mysql_planet1=mysql_query("SELECT id FROM planets WHERE user_id='$id' AND delete_item='1'") or die ("Sorry, we have a system error!");
$numRows_created_planet=mysql_num_rows($mysql_planet1);
if ($numRows_created_planet>0)
	{$mysql1 = mysql_query("SELECT id FROM planets WHERE user_id='$id' AND delete_item='1'");
	while ($row = mysql_fetch_array($mysql1))
		{$planet_id = $row['id'];
		if ((isset($planets_array))AND($planets_array!=="")) {$planets_array = $planets_array.",".$planet_id;}
		else {$planets_array = $row['id'];}}
	$planetsArray = explode(",",$planets_array);
	shuffle($planetsArray);
	$planetsArray4 = array_slice($planetsArray,0,4);
	$planets_count=mysql_num_rows($mysql_planet1);
	$planets_list .= "<br/><div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='planets_lists'/><span class='heading_list'>Created Planets (".$planets_count.")</span></div>
					<div class='float_right'><a href='#' onclick='return false' onmousedown='javascript:window_8(".$ids.",".$id.");' class='bold'>See All</a></div>
					</div>";
	$i = 0;
	$planets_list .="<div class='under_side_bars'>";
	foreach ($planetsArray4 as $key => $value)
		{$i++;
		$mysql_planet1=mysql_query("SELECT * FROM planets WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_planet1))
			{$planet_id = $row['id'];
			$create_id = $row['id'];
			$user_id = $row['user_id'];
			$planet_name = $row['planet_name'];
			$planet_description = $row['planet_description'];
			$categories = $row['categories'];
			if ((strlen($categories))>30)
				{$categories = substr($categories,0,30);
				$categories=$categories."...";}
			$creator_array = $row['creator_array'];
			$creatorArray = explode(",",$creator_array);
			$events_array = $row['events_array'];
			$eventsArray = explode(",",$events_array);
			if($events_array!=="")
				{$eventsArray = end($eventsArray);
				$mysql_event=mysql_query("SELECT event_name FROM events WHERE id='$eventsArray' LIMIT 1") or die ("Sorry, we have a system error!");
				while ($row = mysql_fetch_array($mysql_event))
					{$event_name = $row['event_name'];}}
			$member_array = $row['member_array'];
			$memberArray = explode(",",$member_array);
			$member_count = count($memberArray);			
			if($member_count == 1){$member_count_planets = "Member: ".$member_count;}			
			else {$member_count_planets = "Members: ".$member_count;}		
			$check_pic_planet_bar="../planet_files/planet$value/planet_thumb.jpg";
			$default_pic_planet_bar="../planet_files/planet0/planet_thumb.png";
			if (file_exists($check_pic_planet_bar))
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$value'><img src='$check_pic_planet_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$value'><img src='$default_pic_planet_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			if($events_array!==""){$planet_1="Newest Event: ".$event_name;}
			else{$planet_1="Category: ".$categories;}
			if($categories=="Undefined"){$categories="";}
			if($user_id==$id){$planet_2="Planet Creator";}
			else if (in_array($id,$creatorArray)){$planet_2="Planet Creator";}
			else{$planet_2=$member_count_planets;}

		$planets_list .="<div class='list_wrap'>
						<div class='list_wrap_1'>".$user_pic_planet_bar."</div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/planet/planet.php?id=".$planet_id."'><b>".$planet_name."</b></a></div>
							<span class='places'>".$categories."</span>
							<span class='places'>".$planet_2."</span>
						</div>
						</div>";
			}
		}
	$planets_list .="</div><br/><br/>";
	}
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Profile - <?php echo "$firstname $lastname"; ?></title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_profile.php" media="screen">  
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
<script type="text/javascript" async>
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var color = "<?php echo $color; ?>";
var file_location = "<?php echo $file_location; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var force_album = "<?php echo $force_album; ?>";
var force_game = "<?php echo $force_game; ?>";
var force_video = "<?php echo $force_video; ?>";
var numRows_force_album = "<?php echo $numRows_force_album; ?>";
var numRows_force_game = "<?php echo $numRows_force_game; ?>";
var numRows_force_video = "<?php echo $numRows_force_video; ?>";
var interactiveURL = "../scripts/interactive_changer.php";
var interactive = "../scripts/interactive_box.php";
var commentURL = "../scripts/comment_box.php";
var url = "../scripts/interactive_box.php";	
var like_loveURL = "../scripts/like_love.php";
var PageChangerURL = "../scripts/page_changer.php";
</script>
<script src="profile_javascript.js" type="text/javascript" async></script> 
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow:auto;overflow-y:scroll;" onload="upload_stuff()" class="inside">
<font>
<div class="side_colors_left"></div>

<div class="body"></div>
<div class="profile_page_body_cover">
<div class="profile_page_body">

<div class="cover_image"><div class="margin"></div><?php echo $cover_pic;?></div>

<div class="cover_margin_1"></div>
<div class="profile_page_left" id="profile_page_left">
	<div class="margin"></div>
    <div class="white_background">
    <?php echo $user_pic;?> 
    <br/><br/><font class="side_header"><img src="blank.gif" width="1px" height="1px" class="profile_header"/><?php echo $fullname;?></font><br/>
    <a href="#" onclick="return false" class="post_link" title="Alias"><?php echo $alias;?></a><br/><br/>
	<a href="#" onclick="return false" onmousedown="javascript:window_1(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button profile_window_1"><img src="blank.gif" width="1px" height="1px" class="profile_info"/><span class="span_side">Info</span></div></a>
    <a href="#" onclick="return false" onmousedown="javascript:window_2(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button <?php echo $selected_window_wall;?> profile_window_2"><img src="blank.gif" width="1px" height="1px" class="profile_wall"/><span class="span_side">Wall</span></div></a>
	<?php 
	echo $Notes_side;
	echo $Media_side;
	echo $Planets_side;
	echo $FF_side;
	echo $SS_side;
	echo $MB_side;?>
    </div>
	<div class="side_bottom"></div>
</div>

<div class="profile_page_body_left"></div>
<div class="profile_page_right" id="profile_page_right">
<div class="cover_margin_2"></div><div class="margin"></div>
<div class="profile_page_middle_left <?php echo $addClass_profile_page_middle_left;?>" id="profile_page_middle_left">
<?php
if (($numRows_force_album>0)OR($numRows_force_game>0)OR($numRows_force_video>0))
	{echo "";}
else {include_once "wall.php";}
?>
</div>

<div class="profile_page_middle_right <?php echo $addClass_profile_page_middle_right;?>" id="profile_page_middle_right">
	<div class="interact_message" id="top_result_div">
		<?php echo $right_top_box;?>
    </div>
	<div class="white_background">
	<?php echo $family_list;
	echo $friend_list;
	echo $planets_colonized_list; ?>
	</div>
    <div id="profile_page_right_covers" style="width:265px;">
    	<?php echo $planets_list; ?>
    </div>
</div>
</div>

<div class="white_background_full"></div>
<div class="white_background_full2 <?php echo $addClass_white_background_full2;?>"></div>
<!--<div class="white_background_full3"></div> -->

</div>
<div class="profile_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>
</html>