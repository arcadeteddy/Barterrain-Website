<?php
ob_start();
include_once "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
if(!isset($number)){$number="0";}
$DisplayList ="";
$numRows ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";

if(isset($_GET['number']))
	{$number=$_GET['number'];
	$cacheBuster=$_GET['cacheBuster'];
	$id=$_GET['id'];
	$ids=$_GET['ids'];}
if(isset($_GET['search']))
	{$search = $_GET['search'];
	$search = strip_tags($_GET['search']);
	$search = mysql_real_escape_string($search);}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql = mysql_query("SELECT friend_array, family_array, planets_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$FF_array=$friend_array.",".$family_array;
	$FFArray = explode(",",$FF_array);
	$planets_array = $row['planets_array'];
	$planetsArray = explode(",",$planets_array);
	$PLANETS = join(',',$planetsArray);}
	
////////// PLANETS!!! //////////
$mysql_union = mysql_query("(SELECT id, upload_date AS datetime, union_type FROM planets_albums WHERE (delete_item='1')
								AND (album_name LIKE '%$search%' OR album_description LIKE '%$search%'))
							UNION ALL(SELECT id, upload_date AS datetime, union_type FROM planets_images_walls WHERE (delete_item='1')
								AND (album_name LIKE '%$search%'))
							ORDER BY datetime DESC LIMIT ".$number.",20");
$numRows=mysql_num_rows($mysql_union);
if($numRows>0)
{while ($row = mysql_fetch_array ($mysql_union))
	{$item_id = $row['id'];
	$datetime = $row['datetime'];
	$union_type = $row['union_type'];
	
	if ($union_type == "link_creates") {$planet_item_type=$union_type;}
	else if ($union_type == "planets") {$planet_item_type=$union_type;}
	else if (($union_type !== "link_creates")OR($union_type !== "planets")) {$planet_item_type="planets_".$union_type;}
	
	if ($union_type == "planets")
		{$mysql_planet = mysql_query("SELECT id FROM ".$planet_item_type." WHERE id='$item_id' AND delete_item='1'");
		while($row = mysql_fetch_array($mysql_planet))
			{$planet_id = $row['id'];}}
	else 
		{$mysql_planet = mysql_query("SELECT user_page_id FROM ".$planet_item_type." WHERE id='$item_id' AND delete_item='1'");
		while($row = mysql_fetch_array($mysql_planet))
			{$planet_id = $row['user_page_id'];}}
	
	$mysql_planet = mysql_query("SELECT * FROM planets WHERE id=$planet_id");
	while($row = mysql_fetch_array($mysql_planet))
		{$planet_name = $row['planet_name'];
		$creator_display = $row['creator_display'];
		$user_id = $row['user_id'];
		$member_array = $row['member_array'];
		$admin_array = $row['admin_array'];
		$creator_array = $row['creator_array'];
		$block_array = $row['block_array'];
		$planets_array = $row['planets_array'];
	
		$memberArray=explode(",",$member_array);
		$adminArray=explode(",",$admin_array);
		$creatorArray=explode(",",$creator_array);
		$CREATORS=join(',',$creatorArray);}
	
	if (!in_array($ids,$memberArray))
		{$hide_llc_front="";
		$hide_llc_back="";}
	else
		{$hide_llc_front="";
		$hide_llc_back="";}

if ($union_type=="albums")
{$mysql1 = mysql_query("SELECT * FROM planets_albums WHERE id='$item_id' AND upload_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$album_id = $row['id'];
	$user_page_id = $row['user_page_id'];
	$user_post_id = $row['user_post_id'];
	$album_name = $row['album_name'];
	$album_description = $row['album_description'];
	$album_description_length = strlen($album_description);
	$album_description = substr($album_description, 0, 35);
	if ($album_description_length>35){$album_description=$album_description.'...';}
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$album_type =  $row['album_type'];
	$memory_type =  $row['memory_type'];
	$comment_array =  $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM planets_albums_comments WHERE album_id='$album_id' AND delete_comment='1'"));
	$image_array = $row['image_array'];
	$imageArray = explode(",",$image_array);
	$image_count = count($imageArray);
	$imageArray3 = array_slice($imageArray,0,3);
	$like_array_album = $row['like_array'];
	$love_array_album = $row['love_array'];
	$likeArray_album = explode(",",$like_array_album);
	$loveArray_album = explode(",",$love_array_album);
	$like_array_count_album = count($likeArray_album);
	$love_array_count_album = count($loveArray_album);
	$point_array_album = $row['point_array'];
	$pointArray_album = explode(",",$point_array_album);
	$point_array_count_album = count($pointArray_album);
	$point_array_count_album = $point_array_count_album*10;
	if($point_array_album==""){$point_array_count_album="0";}
	
	$mysql2=mysql_query("SELECT alias,alias_activation FROM members_planets WHERE id='$user_post_id' LIMIT 1");
	$row2=mysql_fetch_assoc($mysql2);
		{$alias=$row2['alias'];
		$alias_activation=$row2['alias_activation'];}
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_post_id' LIMIT 1");
	$row2=mysql_fetch_assoc($mysql2);
		{$user_id=$row2['id'];
		$user_firstname=$row2['firstname'];
		$user_lastname=$row2['lastname'];
		$friend_array=$row2['friend_array'];
		$friend_array = explode(",",$friend_array);
		$family_array=$row2['family_array'];
		$family_array = explode(",",$family_array);
		if ($creator_display=="1")
			{$check_pic="../user_files/user$user_id/profile_thumb.jpg";
			$default_pic="../user_files/user0/default_profile_pic_thumb.png";
			if (file_exists($check_pic))
				{$user_pic="<img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/>";}
			else
				{$user_pic="<img src='$default_pic' width='55px' height='55px' class='thumb_background' />";}
				if ($alias_activation=="1") 
					{$user_pic="<a href='#' onclick='return false'>".$user_pic."</a>";}
				else if ($alias_activation=="0") 
					{$user_pic="<a href='../profile/profile.php?id=".$user_id."'>".$user_pic."</a>";}}
		else if ($creator_display=="0")
			{$check_pic="../planet_files/planet$planet_id/planet_thumb.jpg";
			$default_pic="../planet_files/planet0/planet_thumb.png";
			if (file_exists($check_pic))
				{$user_pic="<a href='../planet/planet.php?id=".$planet_id."'><img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic="<a href='../planet/planet.php?id=".$planet_id."'><img src='$default_pic' width='55px' height='55px' class='thumb_background' /></a>";}}
		}
	
	if (((!in_array($ids,$adminArray))AND(!in_array($ids,$creatorArray)))AND($album_type=="c"))
		{$DisplayList .="";}
	else if ((!in_array($ids,$memberArray))AND($album_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="albums";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_album))
		{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$planet_id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_album))
		{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$planet_id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$planet_id.",".$ids.", ".$album_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$planet_id.",".$ids.", ".$album_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_album !="")AND($love_array_album !=""))
		{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_album !="")
		{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_album !="")
		{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_album = "";}
	
	// Little Things
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($album_type=="a"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
	else if($album_type=="b"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
	else if($album_type=="c"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_post_id){$point="<div class='option_box2' id='point_albums".$album_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$album_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_album."</b></div>";}
	else if($point_array_count_album=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_point_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_album."</b></a></div>";}
	$comment_space="";
	if ($comment_count>0)
		{$comment_space = 'class="comment_space"';}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
		{$delete_button_album="<div class='option_box' id='delete_albums".$album_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$album_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_album="";}
	$album_pic="../planet_files/planet$planet_id/planet_album_thumbs_$album_id/planet_album_".$album_id."_cover2.jpg";
	$album_default_pic="../planet_files/planet0/default_album_cover_thumb.png";
	$cacheBuster = rand(9999999,99999999999);
	if (file_exists($album_pic))
		{$album_cover="<a href='../planet/planet.php?id=".$user_page_id."&force_album=".$album_id."'><img class='cover thumb_background' src='$album_pic#$cacheBuster' height='76px' width='130px'/></a>";}
	else {$album_cover="<a href='../planet/planet.php?id=".$user_page_id."&force_album=".$album_id."'><img class='cover thumb_background' src='$album_default_pic#$cacheBuster' height='76px' width='130px'/></a>";}
	if($album_description==""){$album_description="Undefined";}
	if ($album_name=="")
		{$album_name == "Untitled";}
	if ($image_array == ''){$image_counts = '0 Pictures';}
	else if ($image_count == 1){$image_counts = $image_count.' Picture';}
	else if ($image_count > 1){$image_counts = $image_count.' Pictures';}
	if ($creator_display=="0")
		{$profile_link="<a class='profile_link' href='../planet/planet.php?id=".$user_page_id."'>".$planet_name."</a>";}
	else if ($creator_display=="1")
		{if ($alias_activation=="1") 
			{$profile_link="<a class='alias_link' href='#' onclick='return false'>".$alias."</a>";}
		else if ($alias_activation=="0") 
			{$profile_link="<a class='profile_link' href='../profile/profile.php?id=".$user_post_id."'>".$user_firstname." ".$user_lastname."</a>";}
		}
	
	$DisplayList .= "<div id='item_box_albums".$album_id."'>
			<div class='album_box'>
			<div class='album_box1'>".$user_pic."</div>
			<div class='album_box3'><div class='album_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_album."
			</div>
			<div class='album_box21'>".$album_cover."<div ".$comment_space." id='comment_space_albums".$album_id."'></div></div>
			<div class='album_box22'>".$profile_link."</div>
			<div class='album_box22'><b>New Album: </b><a href='../planet/planet.php?id=".$user_page_id."&force_album=".$album_id."' class='body'>".$album_name."</a></div>
			<div class='album_box22'><b>Description: </b>".$album_description."</div>
			<div class='album_box22'><b>Items: </b>".$image_counts."</div>
			<div class='album_box22'>
			<div id='like_love_albums".$album_id."' class='inline like_love'>
			".$like_love_album."
			<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:comment(".$album_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$upload_date."</span>
			".$like_love2_album."</div></div></div>
			<div id='comments_albums".$album_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM planets_albums_comments WHERE album_id='$album_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
	while ($row = mysql_fetch_array ($mysql3))
		{$comment_id = $row['id'];
		$user_page_id_comment = $row['user_page_id'];
		$user_post_id_comment = $row['user_post_id'];
		$the_comment = $row['the_comment'];
		$comment_date = $row['comment_date'];
		$convertedTime = ($myObject -> convert_datetime($comment_date));
		$comment_date = ($myObject -> make_ago($convertedTime));
		$like_array_comment = $row['like_array'];
		$love_array_comment = $row['love_array'];
		$likeArray_comment = explode(",",$like_array_comment);
		$loveArray_comment = explode(",",$love_array_comment);
		$like_array_count_comment = count($likeArray_comment);
		$love_array_count_comment = count($loveArray_comment);
	$comment_point_array_album = $row['point_array'];
	$comment_pointArray_album = explode(",",$comment_point_array_album);
	$comment_point_array_count_album = count($comment_pointArray_album);
	$comment_point_array_count_album = $comment_point_array_count_album*10;
	if($comment_point_array_album==""){$comment_point_array_count_album="0";}

	if (in_array($ids,$likeArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_comment !="")AND($love_array_comment !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_comment = "";}
		
	if(($ids==$user_id)OR($ids==$user_post_id_comment)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id_comment,$creatorArray))AND($user_id!==$user_post_id_comment)))
		{$delete_button="<div class='delete_comment' id='delete_comment_albums".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$album_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_albums".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_album."</b></div>";}
	else if($comment_point_array_count_album=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false'  onmousedown='javascript:display_point_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_album."</b></a></div>";}
						
	$mysql4=mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$user_post_id_comment' LIMIT 1");
	$row2=mysql_fetch_assoc($mysql4);
		{$user_alias=$row2['alias'];
		$user_alias_activation=$row2['alias_activation'];}	
	$mysql4 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id='$user_post_id_comment' LIMIT 1");
	while ($row =mysql_fetch_array ($mysql4))
		{$user_page_id_comment = $row['id'];
		$user_firstname_comment = $row['firstname'];
		$user_lastname_comment = $row['lastname'];
		
		if ($creator_display=="1")
			{$user_check_pic_comment="../user_files/user$user_post_id_comment/profile_thumb.jpg";
			$user_default_pic_comment="../user_files/user0/default_profile_pic_thumb.png";
			if (file_exists($user_check_pic_comment))
				{$commenter_pic_comment="<img src='$user_check_pic_comment#$cacheBuster' width='45px' height='45px' class='thumb_background'/>";}
			else
				{$commenter_pic_comment="<img src='$user_default_pic_comment' width='45px' height='45px' class='thumb_background' />";}
			if ($user_alias_activation=="1") 
				{$comment_profile_link="<a class='alias_link' href='#' onclick='return false'>".$user_alias."</a>";
				$commenter_pic_comment="<a href='#' onclick='return false'>".$commenter_pic_comment."</a>";}
			else if ($user_alias_activation=="0") 
				{$comment_profile_link="<a class='profile_link' href='../profile/profile.php?id=".$user_post_id_comment."'>".$user_firstname_comment." ".$user_lastname_comment."</a>";
				$commenter_pic_comment="<a href='../profile/profile.php?id=".$user_post_id_comment."'>".$commenter_pic_comment."</a>";}}
		else if (($creator_display=="0")AND(in_array($user_post_id_comment,$creatorArray)))
			{$user_check_pic_comment="../planet_files/planet$planet_id/planet_thumb.jpg";
			$user_default_pic_comment="../planet_files/planet0/planet_thumb.png";
			if (file_exists($user_check_pic_comment))
				{$commenter_pic_comment="<img src='$user_check_pic_comment#$cacheBuster' width='45px' height='45px' class='thumb_background'/>";}
			else
				{$commenter_pic_comment="<img src='$user_default_pic_comment' width='45px' height='45px' class='thumb_background' />";}
			$comment_profile_link="<a class='profile_link' href='../planet/planet.php?id=".$planet_id."'>".$planet_name."</a>";
			$commenter_pic_comment="<a href='../planet/planet.php?id=".$planet_id."'>".$commenter_pic_comment."</a>";}
		else if ($creator_display=="0")
			{$user_check_pic_comment="../user_files/user$user_post_id_comment/profile_thumb.jpg";
			$user_default_pic_comment="../user_files/user0/profile_thumb.png";
			if (file_exists($user_check_pic_comment))
				{$commenter_pic_comment="<img src='$user_check_pic_comment#$cacheBuster' width='45px' height='45px' class='thumb_background'/>";}
			else
				{$commenter_pic_comment="<img src='$user_default_pic_comment' width='45px' height='45px' class='thumb_background' />";}
			if ($user_alias_activation=="1") 
				{$comment_profile_link="<a class='alias_link' href='#' onclick='return false'>".$user_alias."</a>";
				$commenter_pic_comment="<a href='#' onclick='return false'>".$commenter_pic_comment."</a>";}
			else if ($user_alias_activation=="0") 
				{$comment_profile_link="<a class='profile_link' href='../profile/profile.php?id=".$user_post_id_comment."'>".$user_firstname_comment." ".$user_lastname_comment."</a>";
				$commenter_pic_comment="<a href='../profile/profile.php?id=".$user_post_id_comment."'>".$commenter_pic_comment."</a>";}}
	
	$DisplayList .='
	<div id="comment_list_albums'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="../profile/profile.php?id='.$user_page_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			'.$comment_profile_link.'
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_albums'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$album_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_albums'.$album_id.'"></div>
			</div></div></div>';
		}
	}
}
	
else if ($union_type=="images_walls")
{$mysql1 = mysql_query("SELECT * FROM planets_images_walls WHERE id='$item_id' AND upload_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$images_wall_id = $row['id'];
	$user_page_id = $row['user_page_id'];
	$user_post_id = $row['user_post_id'];
	$album_id = $row['album_id'];
	$album_name = $row['album_name'];
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$images_wall_type =  $row['images_wall_type'];
	$memory_type =  $row['memory_type'];
	$images =  $row['images'];
	$imagesArray = explode(",",$images);
	$images_count = count($imagesArray);
	shuffle($imagesArray);
	if ($images_count==5)
		{$imagesArray=array_slice($imagesArray,0,4);}
	else if ($images_count>6)
		{$imagesArray=array_slice($imagesArray,0,6);}
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM planets_images_walls_comments WHERE images_wall_id='$images_wall_id' AND delete_comment='1'"));
	$like_array_images_walls = $row['like_array'];
	$love_array_images_walls = $row['love_array'];
	$likeArray_images_walls = explode(",",$like_array_images_walls);
	$loveArray_images_walls = explode(",",$love_array_images_walls);
	$like_array_count_images_walls = count($likeArray_images_walls);
	$love_array_count_images_walls = count($loveArray_images_walls);
	$point_array_images_walls = $row['point_array'];
	$pointArray_images_walls = explode(",",$point_array_images_walls);
	$point_array_count_images_walls = count($pointArray_images_walls);
	$point_array_count_images_walls = $point_array_count_images_walls*10;
	if($point_array_images_walls==""){$point_array_count_images_walls="0";}
	
	$mysql2=mysql_query("SELECT alias,alias_activation FROM members_planets WHERE id='$user_post_id' LIMIT 1");
	$row2=mysql_fetch_assoc($mysql2);
		{$alias=$row2['alias'];
		$alias_activation=$row2['alias_activation'];}
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_post_id' LIMIT 1");
	$row2=mysql_fetch_assoc($mysql2);
		{$user_id=$row2['id'];
		$user_firstname=$row2['firstname'];
		$user_lastname=$row2['lastname'];
		$friend_array=$row2['friend_array'];
		$friend_array = explode(",",$friend_array);
		$family_array=$row2['family_array'];
		$family_array = explode(",",$family_array);
		if ($creator_display=="1")
			{$check_pic="../user_files/user$user_id/profile_thumb.jpg";
			$default_pic="../user_files/user0/default_profile_pic_thumb.png";
			if (file_exists($check_pic))
				{$user_pic="<img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/>";}
			else
				{$user_pic="<img src='$default_pic' width='55px' height='55px' class='thumb_background' />";}
				if ($alias_activation=="1") 
					{$user_pic="<a href='#' onclick='return false'>".$user_pic."</a>";}
				else if ($alias_activation=="0") 
					{$user_pic="<a href='../profile/profile.php?id=".$user_id."'>".$user_pic."</a>";}}
		else if ($creator_display=="0")
			{$check_pic="../planet_files/planet$planet_id/planet_thumb.jpg";
			$default_pic="../planet_files/planet0/planet_thumb.png";
			if (file_exists($check_pic))
				{$user_pic="<a href='../planet/planet.php?id=".$planet_id."'><img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic="<a href='../planet/planet.php?id=".$planet_id."'><img src='$default_pic' width='55px' height='55px' class='thumb_background' /></a>";}}
		}
	
	if (((!in_array($ids,$adminArray))AND(!in_array($ids,$creatorArray)))AND($images_wall_type=="c"))
		{$DisplayList .="";}
	else if ((!in_array($ids,$memberArray))AND($images_wall_type=="b"))
		{$DisplayList .="";}
	else if ($images=="")
		{$DisplayList .="";}
	else {
	
	$comment_type="images_walls";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_images_walls))
		{$like_love_images_walls = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$planet_id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_images_walls))
		{$like_love_images_walls = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$planet_id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_images_walls = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$planet_id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$planet_id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_images_walls !="")AND($love_array_images_walls !=""))
		{$like_love2_images_walls = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_images_walls !="")
		{$like_love2_images_walls = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_images_walls !="")
		{$like_love2_images_walls = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_images_walls = "";}
	
	// Little Things
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($images_wall_type=="a"){$type="<div class='option_box' id='type_change_images_walls".$images_wall_id."'><a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else if($images_wall_type=="b"){$type="<div class='option_box' id='type_change_images_walls".$images_wall_id."'><a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else if($images_wall_type=="c"){$type="<div class='option_box' id='type_change_images_walls".$images_wall_id."'><a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$images_wall_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_images_walls".$images_wall_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_images_walls".$images_wall_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$images_wall_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_post_id){$point="<div class='option_box2' id='point_images_walls".$images_wall_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$images_wall_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_images_walls."</b></div>";}
	else if($point_array_count_images_walls=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_point_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_images_walls."</b></a></div>";}
	$comment_space="";
	if ($comment_count>0)
		{$comment_space = 'comment_space';}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
		{$delete_button_images_walls="<div class='option_box' id='delete_images_walls".$images_wall_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_images_walls="";}
	$cacheBuster = rand(9999999,99999999999);
	if ($creator_display=="0")
		{$profile_link="<a class='profile_link' href='../planet/planet.php?id=".$user_page_id."'>".$planet_name."</a>";}
	else if ($creator_display=="1")
		{if ($alias_activation=="1") 
			{$profile_link="<a class='alias_link' href='#' onclick='return false'>".$alias."</a>";}
		else if ($alias_activation=="0") 
			{$profile_link="<a class='profile_link' href='../profile/profile.php?id=".$user_post_id."'>".$user_firstname." ".$user_lastname."</a>";}
		}
	
	$i=0;
	$pictures="";
	if($images_count==1)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM planets_images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<div style='float:left;'><img class='black_gif' src='barterrain_search_images/black.png' height='415px' width='415px'/></div><table class='black_gif' height='415px' width='415px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../planet_files/planet$user_page_id/planet_album_thumbs_$album_id/planet_album_".$album_id."_thumb_".$value.".jpg";
			$pictures="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$planet_id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic#$cacheBuster' height='415px' width='415px'/></a></div>";}}
	else if($images_count==2)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM planets_images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<div style='float:left;'><img class='black_gif' src='barterrain_search_images/black.png' height='203px' width='203px'/></div><table class='black_gif' height='203px' width='203px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../planet_files/planet$user_page_id/planet_album_thumbs_$album_id/planet_album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$planet_id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic#$cacheBuster' height='203px' width='203px'/></a></div>";}}
	else if($images_count==3)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM planets_images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<div style='float:left;'><img class='black_gif' src='barterrain_search_images/black.png' height='133px' width='133px'/></div><table class='black_gif' height='133px' width='133px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../planet_files/planet$user_page_id/planet_album_thumbs_$album_id/planet_album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$planet_id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic#$cacheBuster' height='133px' width='133px'/></a></div>";}}
	else if($images_count==4)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM planets_images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<div style='float:left;'><img class='black_gif' src='barterrain_search_images/black.png' height='203px' width='203px'/></div><table class='black_gif' height='203px' width='203px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../planet_files/planet$user_page_id/planet_album_thumbs_$album_id/planet_album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$planet_id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic#$cacheBuster' height='203px' width='203px'/></a></div>";}}
	else if($images_count==5)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM planets_images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<div style='float:left;'><img class='black_gif' src='barterrain_search_images/black.png' height='203px' width='203px'/></div><table class='black_gif' height='203px' width='203px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../planet_files/planet$user_page_id/planet_album_thumbs_$album_id/planet_album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$planet_id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic#$cacheBuster' height='203px' width='203px'/></a></div>";}}
	else if($images_count>4)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM planets_images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<div style='float:left;'><img class='black_gif' src='barterrain_search_images/black.png' height='133px' width='133px'/></div><table class='black_gif' height='133px' width='133px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../planet_files/planet$user_page_id/planet_album_thumbs_$album_id/planet_album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$planet_id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic#$cacheBuster' height='133px' width='133px'/></a></div>";}}

	$DisplayList .= "<div id='item_box_images_walls".$images_wall_id."'>
			<div class='images_walls_box'>
			<div class='images_walls_box1'>".$user_pic."</div>
			<div class='images_walls_box2'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_images_walls."
			</div>
			<div class='images_walls_box4'><div style='width:1000px;'>".$profile_link."<br/>
			<b>New Images: </b><a class='body' href='../planet/planet.php?id=".$user_page_id."&force_album=".$album_id."'>".$album_name."</a>!</div></div>	
			<div class='images_walls_box3'>".$pictures."</div>
			<div class='images_walls_box3 ".$comment_space."' id='comment_space_images_walls".$images_wall_id."'>
			<div class='like_love' ".$comment_space." id='like_love_images_walls".$images_wall_id."'>
				".$like_love_images_walls."<span class='dot_divider'> &middot; </span>
				<a href='#' onclick='return false' onmousedown='javascript:comment(".$images_wall_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$upload_date."</span>
				".$like_love2_images_walls."
			</div></div>
			<div id='comments_images_walls".$images_wall_id."'>";
			
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM planets_images_walls_comments WHERE images_wall_id='$images_wall_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
	while ($row = mysql_fetch_array ($mysql3))
		{$comment_id = $row['id'];
		$user_page_id_comment = $row['user_page_id'];
		$user_post_id_comment = $row['user_post_id'];
		$the_comment = $row['the_comment'];
		$comment_date = $row['comment_date'];
		$convertedTime = ($myObject -> convert_datetime($comment_date));
		$comment_date = ($myObject -> make_ago($convertedTime));
		$like_array_comment = $row['like_array'];
		$love_array_comment = $row['love_array'];
		$likeArray_comment = explode(",",$like_array_comment);
		$loveArray_comment = explode(",",$love_array_comment);
		$like_array_count_comment = count($likeArray_comment);
		$love_array_count_comment = count($loveArray_comment);
	$comment_point_array_image = $row['point_array'];
	$comment_pointArray_image = explode(",",$comment_point_array_image);
	$comment_point_array_count_image = count($comment_pointArray_image);
	$comment_point_array_count_image = $comment_point_array_count_image*10;
	if($comment_point_array_image==""){$comment_point_array_count_image="0";}

	if (in_array($ids,$likeArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_comment(".$planet_id.",".$ids.", ".$comment_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_comment !="")AND($love_array_comment !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_comment = "";}
		
	if(($ids==$user_id)OR($ids==$user_post_id_comment)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id_comment,$creatorArray))AND($user_id!==$user_post_id_comment)))
		{$delete_button="<div class='delete_comment' id='delete_comment_images_walls".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$images_wall_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_images_walls".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_image."</b></div>";}
	else if($comment_point_array_count_image=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false'  onmousedown='javascript:display_point_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_image."</b></a></div>";}
						
	$mysql4=mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$user_post_id_comment' LIMIT 1");
	$row2=mysql_fetch_assoc($mysql4);
		{$user_alias=$row2['alias'];
		$user_alias_activation=$row2['alias_activation'];}	
	$mysql4 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id='$user_post_id_comment' LIMIT 1");
	while ($row =mysql_fetch_array ($mysql4))
		{$user_page_id_comment = $row['id'];
		$user_firstname_comment = $row['firstname'];
		$user_lastname_comment = $row['lastname'];
		
		if ($creator_display=="1")
			{$user_check_pic_comment="../user_files/user$user_post_id_comment/profile_thumb.jpg";
			$user_default_pic_comment="../user_files/user0/default_profile_pic_thumb.png";
			if (file_exists($user_check_pic_comment))
				{$commenter_pic_comment="<img src='$user_check_pic_comment#$cacheBuster' width='45px' height='45px' class='thumb_background'/>";}
			else
				{$commenter_pic_comment="<img src='$user_default_pic_comment' width='45px' height='45px' class='thumb_background' />";}
			if ($user_alias_activation=="1") 
				{$comment_profile_link="<a class='alias_link' href='#' onclick='return false'>".$user_alias."</a>";
				$commenter_pic_comment="<a href='#' onclick='return false'>".$commenter_pic_comment."</a>";}
			else if ($user_alias_activation=="0") 
				{$comment_profile_link="<a class='profile_link' href='../profile/profile.php?id=".$user_post_id_comment."'>".$user_firstname_comment." ".$user_lastname_comment."</a>";
				$commenter_pic_comment="<a href='../profile/profile.php?id=".$user_post_id_comment."'>".$commenter_pic_comment."</a>";}}
		else if (($creator_display=="0")AND(in_array($user_post_id_comment,$creatorArray)))
			{$user_check_pic_comment="../planet_files/planet$planet_id/planet_thumb.jpg";
			$user_default_pic_comment="../planet_files/planet0/planet_thumb.png";
			if (file_exists($user_check_pic_comment))
				{$commenter_pic_comment="<img src='$user_check_pic_comment#$cacheBuster' width='45px' height='45px' class='thumb_background'/>";}
			else
				{$commenter_pic_comment="<img src='$user_default_pic_comment' width='45px' height='45px' class='thumb_background' />";}
			$comment_profile_link="<a class='profile_link' href='../planet/planet.php?id=".$planet_id."'>".$planet_name."</a>";
			$commenter_pic_comment="<a href='../planet/planet.php?id=".$planet_id."'>".$commenter_pic_comment."</a>";}
		else if ($creator_display=="0")
			{$user_check_pic_comment="../user_files/user$user_post_id_comment/profile_thumb.jpg";
			$user_default_pic_comment="../user_files/user0/profile_thumb.png";
			if (file_exists($user_check_pic_comment))
				{$commenter_pic_comment="<img src='$user_check_pic_comment#$cacheBuster' width='45px' height='45px' class='thumb_background'/>";}
			else
				{$commenter_pic_comment="<img src='$user_default_pic_comment' width='45px' height='45px' class='thumb_background' />";}
			if ($user_alias_activation=="1") 
				{$comment_profile_link="<a class='alias_link' href='#' onclick='return false'>".$user_alias."</a>";
				$commenter_pic_comment="<a href='#' onclick='return false'>".$commenter_pic_comment."</a>";}
			else if ($user_alias_activation=="0") 
				{$comment_profile_link="<a class='profile_link' href='../profile/profile.php?id=".$user_post_id_comment."'>".$user_firstname_comment." ".$user_lastname_comment."</a>";
				$commenter_pic_comment="<a href='../profile/profile.php?id=".$user_post_id_comment."'>".$commenter_pic_comment."</a>";}}
	
	$DisplayList .='
	<div id="comment_list_images_walls'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="../profile/profile.php?id='.$user_page_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			'.$comment_profile_link.'
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_images_walls'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date">'.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$images_wall_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_images_walls'.$images_wall_id.'"></div>
			</div></div></div>';
		}
	}
}
}}

echo $DisplayList;
if($numRows>0){$number=$number+20;}
?>
<script type="text/javascript">
// Add more Content at end of page
var number = "<?php echo $number; ?>";
var search_box = "<?php echo $search; ?>";
var numRows = "<?php echo $numRows; ?>";
var cacheBuster = "<?php echo $cacheBuster; ?>";
$(window).data('ajaxready23', true).scroll(function()
	{if ($(window).data('ajaxready23') == false) return;
	if($(window).scrollTop()>=$("#bottom_search_planets_albums").height()-$(document).height())
		{$("div#expand_bottom_box").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready23', false);
		$.ajax({cache: false,url:"search_planets_albums_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_planets_albums").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				 $(window).data('ajaxready23', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_box").click(function(){
	{if ($(window).data('ajaxready23') == false) return;
	$("div#expand_bottom_box").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready23', false);
	$.ajax({cache: false,url:"search_planets_albums_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_planets_albums").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				$(window).data('ajaxready23', true);}
			});
		}
	});
});
</script>