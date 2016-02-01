<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include "../config.php";

$_SESSION['file_location'] = "planet";
$file_location = "planet";
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

$ids = $_SESSION['ids'];
if (isset($_GET['id'])) 
	{$id = $_GET['id'];
	$idp = $_GET['id'];
	$_SESSION['idp'] = $idp;}
else {header("Location: ../index.php");exit();}

include_once "../scripts/check_login.php";
include_once "../scripts/check_existence.php";
ob_flush();

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = rand(999999999,9999999999999);   
$_SESSION['cacheBuster'] = $cacheBuster;

$force_album="";
$numRows_force_album="";
if (isset($_GET['force_album'])) 
	{$force_album=$_GET['force_album'];
	$mysql_force_album = mysql_query("SELECT id FROM planets_albums WHERE user_page_id='$id' AND id='$force_album' AND delete_item='1' LIMIT 1");
	$numRows_force_album = mysql_num_rows($mysql_force_album);}
	
$force_game="";
$numRows_force_game="";
if (isset($_GET['force_game'])) 
	{$force_game=$_GET['force_game'];
	$mysql_force_game = mysql_query("SELECT id FROM planets_games WHERE user_page_id='$id' AND id='$force_game' AND delete_item='1' LIMIT 1");
	$numRows_force_game = mysql_num_rows($mysql_force_game);}

$force_video="";
$numRows_force_video="";
if (isset($_GET['force_video'])) 
	{$force_video=$_GET['force_video'];
	$mysql_force_video = mysql_query("SELECT id FROM planets_videos WHERE user_page_id='$id' AND id='$force_video' AND delete_item='1' LIMIT 1");
	$numRows_force_video = mysql_num_rows($mysql_force_video);}

$error_options="";
if (isset($_GET['error_options'])) 
	{$error_options = $_GET['error_options'];}

$error_message="";
$success_message="";
$right_top_box="<br/>";
$mysql1 = mysql_query("SELECT * FROM planets WHERE id='$id'");
while($row = mysql_fetch_array($mysql1))
	{$create_id = $row['id'];
	$user_id = $row['user_id'];
	$planet_name = $row['planet_name'];
	$planet_description = $row['planet_description'];
	$categories = $row['categories'];
	$like_array = $row['like_array'];
	$love_array = $row['love_array'];
	$like_array_create = $row['like_array'];
	$love_array_create = $row['love_array'];
	$likeArray_create = explode(",",$like_array_create);
	$loveArray_create = explode(",",$love_array_create);
	$like_array_count_create = count($likeArray_create);
	$love_array_count_create = count($loveArray_create);
	$admin_array = $row['admin_array'];
	$adminArray = explode(",",$admin_array);
	$admin_count = count($adminArray);
	$creator_array = $row['creator_array'];
	$creatorArray = explode(",",$creator_array);
	$creator_count = count($creatorArray);
	$member_array = $row['member_array'];
	$memberArray = explode(",",$member_array);
	$member_count = count($memberArray);
	$planets_array = $row['planets_array'];
	$events_array = $row['events_array'];
	$shops_array = $row['shops_array'];
	$pages_array = $row['pages_array'];
	$groups_array = $row['groups_array'];
	$admin_array = $row['admin_array'];
	$member_array = $row['member_array'];
	$block_array = $row['block_array'];
	$report_array = $row['report_array'];
	$adminArray = explode(',',$admin_array);
	$memberArray = explode(',',$member_array);
	$blockArray = explode(',',$block_array);
	$reportArray = explode(',',$report_array);
	$check_pic="../planet_files/planet$id/planet_picture.jpg";
	$check_pic_png="../planet_files/planet$id/planet_picture.png";
	$check_pic_gif="../planet_files/planet$id/planet_picture.gif";
	$default_pic="../planet_files/planet0/planet_picture.png";
	if (file_exists($check_pic)){$user_pic="<img class='planet_image thumb_background' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else if (file_exists($check_pic_png)){$user_pic="<img class='planet_image thumb_background' src='$check_pic_png#$cacheBuster' width='260px' height='auto'/>";}
	else if (file_exists($check_pic_gif)){$user_pic="<img class='planet_image thumb_background' src='$check_pic_gif#$cacheBuster' width='260px' height='auto'/>";}
	else{$user_pic="<img class='planet_image thumb_background' src='$default_pic' width='260px' height='auto'/>";}
	$check_pic2="../planet_files/planet$id/cover_pic.jpg";
	if (file_exists($check_pic2)){$cover_pic="<img class='cover_image' src='$check_pic2#$cacheBuster' width='1120px' height='auto'/>";}
	else{$cover_pic="";}
	}
	
if (($numRows_force_album>0)OR($numRows_force_game>0)OR($numRows_force_video>0))
	{$selected_window_wall="";
	$addClass_white_background_full2="hide_div";
	$addClass_planet_page_middle_right="hide_div";
	$addClass_planet_page_middle_left="expand";
	$selected_window_media="selected_window";}
else
	{$selected_window_wall="selected_window";
	$addClass_white_background_full2="";
	$addClass_planet_page_middle_right="";
	$addClass_planet_page_middle_left="";
	$selected_window_media="";}
	
$Member_posts_side="";
$mysql_check_empty=mysql_query("(SELECT id FROM planets_member_posts WHERE user_page_id='$id' AND delete_item='1' LIMIT 1)");
$numRows=mysql_num_rows($mysql_check_empty);
if ($numRows>0)
	{$Member_posts_side='<a href="#" onclick="return false" onmousedown="javascript:window_8('.$ids.','.$id.');" class="side_button"><div class="side_button planet_window_8"><img src="blank.gif" width="1px" height="1px" class="planet_member_posts"/><span class="span_side">Member Posts</span></div></a>';}
if(in_array($ids,$creatorArray)AND($admin_array!=="")) {$title_admin_member="Creators & Admins & Members";}
else if(in_array($ids,$creatorArray)) {$title_admin_member="Creators & Members";}
else if($admin_array!=="") {$title_admin_member="Admins & Members";}
else {$title_admin_member="Members";}
$Media_side="";
$mysql_check_empty=mysql_query("(SELECT id FROM planets_albums WHERE user_page_id='$id' AND delete_item='1' LIMIT 1) UNION ALL (SELECT id FROM planets_games WHERE user_page_id='$id' AND delete_item='1' LIMIT 1) UNION ALL (SELECT id FROM planets_videos WHERE user_page_id='$id' AND delete_item='1' LIMIT 1)");
$numRows=mysql_num_rows($mysql_check_empty);
if ($numRows>0)
	{$Media_side='<a href="#" onclick="return false" onmousedown="javascript:window_3('.$ids.','.$id.');" class="side_button"><div class="side_button '.$selected_window_media.' planet_window_3"><img src="blank.gif" width="1px" height="1px" class="planet_media"/><span class="span_side">Media</span></div></a>';}
$Notes_side="";
$mysql_check_empty=mysql_query("SELECT id FROM planets_notes WHERE user_page_id=$id AND delete_item='1' LIMIT 1");
$numRows=mysql_num_rows($mysql_check_empty);
if ($numRows>0)
	{$Notes_side='<a href="#" onclick="return false" onmousedown="javascript:window_4('.$ids.','.$id.');" class="side_button"><div class="side_button planet_window_4"><img src="blank.gif" width="1px" height="1px" class="planet_notes"/><span class="span_side">Notes</span></div></a>';}
$Planets_side="";
if ($planets_array!=="")
	{$Planets_side='<a href="#" onclick="return false" onmousedown="javascript:window_7('.$ids.','.$id.');" class="side_button"><div class="side_button planet_window_7"><img src="blank.gif" width="1px" height="1px" class="planet_planets"/><span class="span_side">Planets</span></div></a>';}
$MB_side="";
$mysql_check_empty=mysql_query("(SELECT id FROM planets_posts WHERE ((user_page_id='$id')AND((memory_type='b')OR(memory_type='d'))) OR ((user_post_id='$id')AND((memory_type='c')OR(memory_type='d'))) AND delete_item='1') 
					UNION ALL(SELECT id FROM planets_notes WHERE user_page_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_albums WHERE user_page_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_images_walls WHERE user_page_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_videos WHERE user_page_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_games WHERE user_page_id='$id' AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_albums_posts WHERE  (user_post_id='$user_id' OR user_post_id='$ids') AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_images_posts WHERE  (user_post_id='$user_id' OR user_post_id='$ids') AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_games_posts WHERE  (user_post_id='$user_id' OR user_post_id='$ids') AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM planets_videos_posts WHERE  (user_post_id='$user_id' OR user_post_id='$ids') AND delete_item='1' AND memory_type='b')
					UNION ALL(SELECT id FROM link_creates WHERE (user_page_id='$id' OR planet_id='$id') AND delete_item='1' AND memory_type='b') LIMIT 1");
$numRows=mysql_num_rows($mysql_check_empty);
if ($numRows>0)
	{$MB_side='<a href="#" onclick="return false" onmousedown="javascript:window_6('.$ids.','.$id.');" class="side_button"><div class="side_button planet_window_6"><img src="blank.gif" width="1px" height="1px" class="planet_memory_box"/><span class="span_side">Memory Box</span></div></a>';}

	$type_o="planets";
	$type=json_encode($type_o);
	
	if (in_array($ids,$likeArray_create))
		{$like_love_create_page = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_create(".$user_id.",".$ids.",".$create_id.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_create))
		{$like_love_create_page = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_create(".$user_id.",".$ids.",".$create_id.");'>Unlove</a>";}
	else 
		{$like_love_create_page = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_create(".$user_id.",".$ids.",".$create_id.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_create(".$user_id.",".$ids.",".$create_id.");'>Love</a>";}
	if (($like_array_create !="")AND($love_array_create !=""))
		{$like_love2_create_page = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$like_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$love_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_create !="")
		{$like_love2_create_page = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$like_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_create !="")
		{$like_love2_create_page = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$create_id.",".$type.");'>".$love_array_count_create."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_create_page = "";}

// Top Right Menu
if (in_array($ids,$reportArray)) {$report1="<a href='#' onclick='return false' onmousedown='javascript:UnreportCreate(".$ids.",".$id.",".$type.");'>Unreport To Appropriate</a>";}
else {$report1="<a href='#' onclick='return false' onmousedown='javascript:ReportCreate(".$ids.",".$id.",".$type.");'>Report To Inappropriate</a>";}
if(in_array($ids,$blockArray)){$block1="<a href='#' onclick='return false' onmousedown='javascript:UnblockCreate(".$ids.",".$id.",".$type.");' class='right_top' id='inline'><img src='blank.gif' width='1px' height='1px' name='unblock' class='right_outside3'/></a>";}
else {$block1="<a href='#'  onclick='return false' onmousedown='javascript:BlockCreate(".$ids.",".$id.",".$type.");' class='right_top' id='inline'><img src='blank.gif' width='1px' height='1px' name='block' class='right_outside2'/></a>";}
if ($ids==$user_id)
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='creator' class='right_inside1'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
							<a href='#' onclick='return false' onmousedown='javascript:DeleteCreate(".$ids.",".$id.",".$type.");'>Destroy Planet</a>
						</div></fieldset></div></div>";}
else if (in_array($ids,$creatorArray))
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='creator' class='right_inside1'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div class=''><fieldset id='right_inside_menu'><div class='right_inside_open'>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreator(".$ids.",".$id.",".$type.");'>Leave Creatorship</a>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreate(".$ids.",".$id.",".$type.");'>Leave This Planet</a>
						</div></fieldset></div></div>";}
else if (in_array($ids,$adminArray))
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='admin' class='right_inside4'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div class=''><fieldset id='right_inside_menu'><div class='right_inside_open'>
							".$report1."
							<a href='#' onclick='return false' onmousedown='javascript:LeaveAdmin(".$ids.",".$id.",".$type.");'>Leave Adminship</a>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreate(".$ids.",".$id.",".$type.");'>Leave This Planet</a>
						</div></fieldset></div></div>";}
else if (in_array($ids,$memberArray))
	{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='member' class='right_inside3'/>
						<a href='#' class='right_top right_inside2_button' title='Invite' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<a href='#' class='right_top right_inside_button' title='Options' onclick='return false' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside2_menu'><div class='right_inside2_open'>
							<a href='#' onclick='return false' onmousedown='javascript:InviteAll($ids);'>Invite All</a>
						</div></fieldset></div>
						<div class=''><fieldset id='right_inside_menu'><div class='right_inside_open'>
							".$report1."
							<a href='#' onclick='return false' onmousedown='javascript:RequestCreator(".$ids.",".$id.",".$type.");'>Request Creatorship</a>
							<a href='#' onclick='return false' onmousedown='javascript:RequestAdmin(".$ids.",".$id.",".$type.");'>Request Adminship</a>
							<a href='#' onclick='return false' onmousedown='javascript:LeaveCreate(".$ids.",".$id.",".$type.");'>Leave This Planet</a>
						</div></fieldset></div></div>";}
else
	{$right_top_box = "<div class='right_top_box' id='right_top_box'>
						<a href='#' class='right_top' onclick='return false' onmousedown='javascript:JoinCreate(".$ids.",".$id.",".$type.");'>
							<img src='blank.gif' width='1px' height='1px' name='join_planet' class='right_outside1'/></a>
						".$block1."</div>";}						
						
// Display Admins
$admin_list = "";
if ($admin_array != "")
	{$adminArray = explode(",",$admin_array);
	shuffle($adminArray);
	$adminArray8 = array_slice($adminArray,0,4);
	$admin_count = count($adminArray);
	$admin_list .= "<div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='family_lists'/><span class='heading_list'>Admins (".$admin_count.")</span></div>
					<div class='float_right'><a href='#' onclick='return false' onmousedown='javascript:window_5(".$ids.",".$id.");' class='bold'>See All</a></div>
					</div>";
	$i = 0;
	$admin_list .="<div class='under_side_bars'>";
	foreach ($adminArray8 as $key => $value)
		{$i++;
		$mysql_name=mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$value' LIMIT 1");
		$row=mysql_fetch_assoc($mysql_name);
			{$alias=$row['alias'];
			$alias_activation=$row['alias_activation'];}
		$mysql_name=mysql_query("SELECT id,firstname, lastname, location FROM members WHERE id=$value LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$admin_id = $row['id'];
			$admin_firstname = $row['firstname'];
			$admin_lastname = $row['lastname'];
			$admin_location = $row['location'];
		$check_pic_admin_bar="../user_files/user$admin_id/profile_thumb.jpg";
		$default_pic_admin_bar="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic_admin_bar)){$user_pic_admin_bar="<img src='$check_pic_admin_bar#$cacheBuster' height='55px' class='thumb_background' width='55px'/>";}
		else{$user_pic_admin_bar="<img src='$default_pic_admin_bar' height='55px' class='thumb_background' width='55px'/>";}
			
		if ($alias_activation=="1") 
			{$user_pic_member_bar="<a href='#' onclick='return false'>".$user_pic_admin_bar."</a>";
			$profile_link_admin_bar="<a class='alias_link' href='#' onclick='return false'><b>".$alias."</b></a>";}
		else if ($alias_activation=="0") 
			{$user_pic_member_bar="<a href='../profile/profile.php?id=".$admin_id."'>".$user_pic_admin_bar."</a>";
			$profile_link_admin_bar="<a class='profile_link' href='../profile/profile.php?id=".$admin_id."'><b>".$admin_firstname." ".$admin_lastname."</b></a>";}
			
		$admin_list .="<div class='list_wrap'>
						<div class='list_wrap_1'>".$user_pic_admin_bar."</div>
						<div class='list_wrap_2'><div class='profile_link'>".$profile_link_admin_bar."</div>
							<span class='places'>".$admin_location."</span>
							</div>
						</div>";
			}
		}
	$admin_list .="</div><br/><br/>";
	}						
							
// Display Members
$member_list = "";
if ($member_array != "")
	{$memberArray = explode(",",$member_array);
	shuffle($memberArray);
	$memberArray8 = array_slice($memberArray,0,8);
	$member_count = count($memberArray);
	$member_list .= "<div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='friends_lists'/><span class='heading_list'>Members (".$member_count.")</span></div>
					<div class='float_right'><a href='#' onclick='return false' onmousedown='javascript:window_5(".$ids.",".$id.");' class='bold'>See All</a></div>
					</div>";
	$i = 0;
	$member_list .="<div class='under_side_bars'>";
	foreach ($memberArray8 as $key => $value)
		{$i++;
		$mysql_name=mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$value' LIMIT 1");
		$row=mysql_fetch_assoc($mysql_name);
			{$alias=$row['alias'];
			$alias_activation=$row['alias_activation'];}
		$mysql_name=mysql_query("SELECT id,firstname, lastname, location FROM members WHERE id=$value LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$member_id = $row['id'];
			$member_firstname = $row['firstname'];
			$member_lastname = $row['lastname'];
			$member_location = $row['location'];
		$check_pic_member_bar="../user_files/user$member_id/profile_thumb.jpg";
		$default_pic_member_bar="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic_member_bar)){$user_pic_member_bar="<img src='$check_pic_member_bar#$cacheBuster' width='55px' height='55px' class='thumb_background'/>";}
		else{$user_pic_member_bar="<img src='$default_pic_member_bar' width='55px' height='55px' class='thumb_background'/>";}
			
		if ($alias_activation=="1") 
			{$user_pic_member_bar="<a href='#' onclick='return false'>".$user_pic_member_bar."</a>";
			$profile_link_member_bar="<a class='alias_link' href='#' onclick='return false'><b>".$alias."</b></a>";}
		else if ($alias_activation=="0") 
			{$user_pic_member_bar="<a href='../profile/profile.php?id=".$member_id."'>".$user_pic_member_bar."</a>";
			$profile_link_member_bar="<a class='profile_link' href='../profile/profile.php?id=".$member_id."'><b>".$member_firstname." ".$member_lastname."</b></a>";}
			
		$member_list .="<div class='list_wrap'>
						<div class='list_wrap_1'>".$user_pic_member_bar."</div>
						<div class='list_wrap_2'><div class='profile_link'>".$profile_link_member_bar."</div>
							<span class='places'>".$member_location."</span></div>
						</div>";
			}
		}
	$member_list .="</div><br/><br/>";
	}

// Planets List
$planets_list = "";
if ($planets_array != "")
	{$planetsArray = explode(",",$planets_array);
	shuffle($planetsArray);
	$planetsArray4 = array_slice($planetsArray,0,4);
	$planets_count = count($planetsArray);
	$planets_list .= "<div class='right_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='planets_linked_lists'/><span class='heading_list'>Linked Planets (".$planets_count.")</span></div>
					<div class='float_right'><a href='#' onclick='return false' onmousedown='javascript:window_7(".$ids.",".$id.");' class='bold'>See All</a></div>
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
			$planet_name_side = $row['planet_name'];
			$categories = $row['categories'];
			$likes = $row['likes'];$loves = $row['loves'];
			$categories = $row['categories'];
			if ($categories=="Currently Not Set")
				{$categories="Category Currently Not Set";}
			if ((strlen($categories))>30)
				{$categories = substr($categories,0,30);
				$categories=$categories."...";}
			$check_pic_planet_bar="../planet_files/planet$value/planet_thumb.jpg";
			$default_pic_planet_bar="../planet_files/planet0/planet_thumb.png";
			if (file_exists($check_pic_planet_bar))
				{$user_pic_planet_bar="<a href='planet.php?id=$value'><img src='$check_pic_planet_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic_planet_bar="<a href='planet.php?id=$value'><img src='$default_pic_planet_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			
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

		$planets_list .="<div class='list_wrap'>
						<div class='list_wrap_1'><a href='http://www.barterrain.com/planet/planet.php?id=".$planet_id."'>".$user_pic_planet_bar."</a></div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/planet/planet.php?id=".$planet_id."'><b>".$planet_name_side."</b></a></div>
							<span class='places'>".$categories."</span>
							<div id='create_ll_".$create_id."'>
								".$like_love_create." ".$like_love2_create."
							</div>
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
<title>Planet - <?php echo "$planet_name"; ?></title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_planet.php" media="screen">  
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
<script type="text/javascript" async>
// Top Box
var id = "<?php echo $idp; ?>";
var ids = "<?php echo $ids; ?>";
var type = "<?php echo $type_o; ?>";
var color = "<?php echo $color; ?>";
var file_location = "<?php echo $file_location; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var force_album = "<?php echo $force_album; ?>";
var force_game = "<?php echo $force_game; ?>";
var force_video = "<?php echo $force_video; ?>";
var numRows_force_album = "<?php echo $numRows_force_album; ?>";
var numRows_force_game = "<?php echo $numRows_force_game; ?>";
var numRows_force_video = "<?php echo $numRows_force_video; ?>";
var like_loveURL = "../scripts/like_love.php";
var PageChangerURL = "../scripts/page_changer.php";
</script>
<script src="planet_javascript.js" type="text/javascript" async></script> 
<script src="planet.js" type="text/javascript" async></script>
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color; ?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="../barterrain_main_images/loader_full_<?php echo $color; ?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="../barterrain_main_images/loader_full_<?php echo $color; ?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow:auto;overflow-y:scroll;" onload="upload_stuff()" class="inside">
<font>
<div class="side_colors_left"></div>

<div class="body"></div>
<div class="planet_page_body_cover">
<div class="planet_page_body">

<div class="cover_image"><div class="margin"></div><?php echo $cover_pic;?></div>

<div class="cover_margin_1"></div>
<div class="planet_page_left" id="planet_page_left">
	<div class="margin"></div>
    <div class="white_background">
    <?php echo $user_pic."<br/><br/>";?>
    <font class="side_header"><img src="blank.gif" width="1px" height="1px" class="planet_header"/><?php echo $planet_name;?></font>
    <div id='create_ll_<?php echo $id;?>'>
		<?php echo $like_love_create_page; echo $like_love2_create_page; ?>
	</div><br/>
	<a href="#" onclick="return false" onmousedown="javascript:window_1(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button planet_window_1"><img src="blank.gif" width="1px" height="1px" class="planet_info"/><span class="span_side">Info</span></div></a>
    <a href="#" onclick="return false" onmousedown="javascript:window_2(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button <?php echo $selected_window_wall;?> planet_window_2"><img src="blank.gif" width="1px" height="1px" class="planet_wall"/><span class="span_side">Wall</span></div></a>
    <?php echo $Member_posts_side; echo $Notes_side; echo $Media_side; echo $Planets_side;?>
    <a href="#" onclick="return false" onmousedown="javascript:window_5(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button planet_window_5"><img src="blank.gif" width="1px" height="1px" class="admins_members_lists"/><span class="span_side"><?php echo $title_admin_member; ?></span></div></a>
   	<?php echo $MB_side; ?>
    </div>
	<div class="side_bottom"></div>
</div>

<div class="planet_page_body_left"></div>
<div class="planet_page_right" id="planet_page_right">
<div class="cover_margin_2"></div><div class="margin"></div>
<div class="planet_page_middle_left <?php echo $addClass_planet_page_middle_left;?>" id="planet_page_middle_left">
<?php
if (($numRows_force_album>0)OR($numRows_force_game>0)OR($numRows_force_video>0))
	{echo "";}
else {include_once "planet_wall.php";}
?>
</div>

<div class="planet_page_middle_right <?php echo $addClass_planet_page_middle_right;?>" id="planet_page_middle_right">
	<div class="interact_message" id="top_result_div">
		<?php echo $right_top_box; echo $error_options; ?>
    </div>
	<div class="white_background">
		<?php echo $admin_list; echo $member_list; ?>
	</div>
    <div id="planet_page_right_covers">
    	<?php echo $planets_list; ?>
    </div>
</div>
</div>

<div class="white_background_full"></div>
<div class="white_background_full2 <?php echo $addClass_white_background_full2;?>"></div>
<!--<div class="white_background_full3"></div>-->


</div>
<div class="planet_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>
</html>