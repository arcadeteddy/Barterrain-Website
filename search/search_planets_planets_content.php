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
$mysql_union = mysql_query("(SELECT id, link_create_date AS datetime, union_type FROM link_creates WHERE (delete_item='1')
								AND (create_name LIKE '%$search%'))
							UNION ALL(SELECT id, create_date AS datetime, union_type FROM planets WHERE (delete_item='1')
								AND (planet_name LIKE '%$search%' OR planet_description LIKE '%$search%'))
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

if ($union_type=="planets")
{$mysql_name = mysql_query("SELECT * FROM planets WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
while ($row=mysql_fetch_array($mysql_name))
	{$planet_search_id=$row['id'];
	$planet_search_name=$row['planet_name'];
	$planet_search_description=$row['planet_description'];
	$planet_search_categories=$row['categories'];
	$planet_search_member_array=$row['member_array'];
	$check_pic="../planet_files/planet$planet_search_id/planet_thumb.jpg";
	$default_pic="../planet_files/planet0/planet_thumb.png";
	$cacheBuster = rand(9999999,99999999999);
	if (file_exists($check_pic))
		{$user_pic="<a href='../planet/planet.php?id=$planet_search_id'><img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
	else{$user_pic="<a href='../planet/planet.php?id=$planet_search_id'><img src='$default_pic' width='55px' height='55px' class='thumb_background'/></a>";}
	
			$like_array = $row['like_array'];
			$love_array = $row['love_array'];
			$like_array_planet = $row['like_array'];
			$love_array_planet = $row['love_array'];
			$likeArray_planet = explode(",",$like_array_planet);
			$loveArray_planet = explode(",",$love_array_planet);
			$like_array_count_planet = count($likeArray_planet);
			$love_array_count_planet = count($loveArray_planet);
			
			$comment_type="planets";
			$comment_type=json_encode($comment_type);

	if (in_array($ids,$likeArray_planet))
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_circle(".$ids.",".$planet_search_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_planet))
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_circle(".$ids.",".$planet_search_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_circle(".$ids.",".$planet_search_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_circle(".$ids.",".$planet_search_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_planet !="")AND($love_array_planet !=""))
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$planet_search_id.",".$comment_type.");'>".$like_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$planet_search_id.",".$comment_type.");'>".$love_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_planet !="")
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$planet_search_id.",".$comment_type.");'>".$like_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_planet !="")
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$planet_search_id.",".$comment_type.");'>".$love_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_planet = "";}
	
	if($planet_search_categories!=""){$categories="<span class='places'>".$planet_search_categories."</span>";}
	else {$categories="";}
	$planet_search_memberArray = explode(",",$planet_search_member_array);
	$FFplanet_searchArray = array_intersect($planet_search_memberArray, $FFArray);
	$FFpersonArray_json_encode = json_encode($FFplanet_searchArray);
	$FFArray_count=count($FFplanet_searchArray);
			
	if (empty($FFplanet_searchArray)) {$FFArray_count_text="0";}
	else {$FFArray_count_text="<a title='Display Friends That Are Members' href='#' onclick='return false' onmousedown='javascript:display_planet_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.",1);' class='bold display_button'>".$FFArray_count."</a>";}
	if(($FFArray_count == 1)OR(!empty($FFplanet_searchArray))){$member_count_planets = "Colonized By ".$FFArray_count_text." Friend";}			
	else {$member_count_planets="Colonized By ".$FFArray_count_text." Friends";}	
	
	$DisplayList .= "<div>
						<div class='search_box'>
							<div class='search_box1'>".$user_pic."</div>
						<div class='search_box3'>
							<div class='search_box2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$planet_search_id."'><b>".$planet_search_name."</b></a></div>
							<div class='search_box2'><span class='mutual'>".$categories."".$member_count_planets."</span><br/></div>
							<div class='search_box2'>
								<div class='planet_ll' id='information_circle_planets".$planet_search_id."'>
									".$like_love_planet."".$like_love2_planet."
								</div>
							</div>
						</div>
						</div>
					</div>";
	}
}

else if ($union_type=="link_creates")
{$mysql1 = mysql_query("SELECT * FROM link_creates WHERE id='$item_id' AND link_create_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$link_create_id = $row['id'];
	$user_page_id = $row['user_page_id'];
	$user_post_id = $row['user_post_id'];
	$planet_id = $row['planet_id'];
	$page_id = $row['page_id'];
	$group_id = $row['group_id'];
	$event_id = $row['event_id'];
	$shop_id = $row['shop_id'];
	$create_type = $row['create_type'];
	$create_type_s = substr($create_type,0,-1);
	$link_create_date = $row['link_create_date'];
	$convertedTime = ($myObject -> convert_datetime($link_create_date));
	$link_create_date = ($myObject -> make_ago($convertedTime));
	$link_create_type = $row['link_create_type'];
	$memory_type = $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM link_creates_comments WHERE link_create_id='$link_create_id' AND delete_comment='1'"));
	$like_array_link_create = $row['like_array'];
	$love_array_link_create = $row['love_array'];
	$point_array_link_create = $row['point_array'];
	$likeArray_link_create = explode(",",$like_array_link_create);
	$loveArray_link_create = explode(",",$love_array_link_create);
	$pointArray_link_create = explode(",",$point_array_link_create);
	$like_array_count_link_create = count($likeArray_link_create);
	$love_array_count_link_create = count($loveArray_link_create);
	$point_array_count_link_create = count($pointArray_link_create);
	$point_array_count_link_create = $point_array_count_link_create*10;
	if($point_array_link_create==""){$point_array_count_link_create="0";}
	
	if ($planet_id!=="0") {$create_id=$planet_id;$typex_text="Planet";}
	else if ($page_id!=="0") {$create_id=$page_id;$typex_text="Page";}
	else if ($group_id!=="0") {$create_id=$group_id;$typex_text="Group";}
	else if ($event_id!=="0") {$create_id=$event_id;$typex_text="Event";}
	else if ($shop_id!=="0") {$create_id=$shop_id;$typex_text="Shop";}
	
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
			{$check_pic="../planet_files/planet$user_page_id/planet_thumb.jpg";
			$default_pic="../planet_files/planet0/planet_thumb.png";
			if (file_exists($check_pic))
				{$user_pic="<a href='../planet/planet.php?id=".$user_page_id."'><img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic="<a href='../planet/planet.php?id=".$user_page_id."'><img src='$default_pic' width='55px' height='55px' class='thumb_background' /></a>";}}
		}
	
	if ($user_page_id==$planet_id)
		{$mysql_create=mysql_query("SELECT ".$create_type_s."_name AS create_name, ".$create_type_s."_description AS create_description FROM ".$create_type." WHERE id='$user_page_id' LIMIT 1");
		$row=mysql_fetch_assoc($mysql_create);
			{$create_name=$row['create_name'];
			$create_description=$row['create_description'];
			$create_description_length = strlen($create_description);
			$create_description = substr($create_description, 0, 25);
			if ($create_description_length>25){$create_description=$create_description.'...';}}}
	else
		{$mysql_create=mysql_query("SELECT ".$create_type_s."_name AS create_name, ".$create_type_s."_description AS create_description FROM ".$create_type." WHERE id='$create_id' LIMIT 1");
		$row=mysql_fetch_assoc($mysql_create);
			{$create_name=$row['create_name'];
			$create_description=$row['create_description'];
			$create_description_length = strlen($create_description);
			$create_description = substr($create_description, 0, 25);
			if ($create_description_length>25){$create_description=$create_description.'...';}}}
	
	if (((!in_array($ids,$adminArray))AND(!in_array($ids,$creatorArray)))AND($link_create_type=="c"))
		{$DisplayList .="";}
	else if ((!in_array($ids,$memberArray))AND($link_create_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="link_creates";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_link_create))
		{$like_love_link_create = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$planet_id.",".$ids.", ".$link_create_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_link_create))
		{$like_love_link_create = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$planet_id.",".$ids.", ".$link_create_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_link_create = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$planet_id.",".$ids.", ".$link_create_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$planet_id.",".$ids.", ".$link_create_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_link_create !="")AND($love_array_link_create !=""))
		{$like_love2_link_create = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_link_create."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_link_create."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_link_create !="")
		{$like_love2_link_create = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_link_create."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_link_create !="")
		{$like_love2_link_create = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_link_create."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_link_create = "";}
	
	// Little Things
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($link_create_type=="a"){$type="<div class='option_box' id='type_change_link_creates".$link_create_id."'><a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$link_create_id.",".$comment_type.");'></a></div>";}
	else if($link_create_type=="b"){$type="<div class='option_box' id='type_change_link_creates".$link_create_id."'><a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$link_create_id.",".$comment_type.");'></a></div>";}
	else if($link_create_type=="c"){$type="<div class='option_box' id='type_change_link_creates".$link_create_id."'><a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$link_create_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_link_creates".$link_create_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$link_create_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_link_creates".$link_create_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$link_create_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_post_id){$point="<div class='option_box2' id='point_link_creates".$link_create_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$link_create_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_link_create."</b></div>";}
	else if($point_array_count_link_create=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_point_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_link_create."</b></a></div>";}
	$comment_space="";
	if ($comment_count>0)
		{$comment_space = 'class="comment_space"';}
	if($create_description==""){$create_description="Undefined";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
		{$delete_button_link_create="<div class='option_box' id='delete_link_creates".$link_create_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$link_create_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_link_create="";}
	
	if ($user_page_id==$planet_id)
		{$check_pic_link_create_bar="../planet_files/planet$user_page_id/planet_thumb.jpg";
		$default_pic_link_create_bar="../planet_files/planet0/planet_thumb.png";
		$planet_link_create_id=$user_page_id;}
	else if ($create_id==$planet_id)
		{$check_pic_link_create_bar="../planet_files/planet$create_id/planet_thumb.jpg";
		$default_pic_link_create_bar="../planet_files/planet0/planet_thumb.png";
		$planet_link_create_id=$create_id;}
	
	if (file_exists($check_pic_link_create_bar))
		{$user_pic_link_create_bar="<a href='../planet/planet.php?id=$planet_link_create_id'><img src='$check_pic_link_create_bar#$cacheBuster' height='66px' width='66px' class='thumb_background'/></a>";}
	else {$user_pic_link_create_bar="<a href='../planet/planet.php?id=$planet_link_create_id'><img src='$default_pic_link_create_bar' height='66px' width='66px' class='thumb_background'/></a>";}
	if ($creator_display=="0")
		{$profile_link="<a class='profile_link' href='../planet/planet.php?id=".$user_page_id."'>".$planet_name."</a>";}
	else if ($creator_display=="1")
		{if ($alias_activation=="1") 
			{$profile_link="<a class='alias_link' href='#' onclick='return false'>".$alias."</a>";}
		else if ($alias_activation=="0") 
			{$profile_link="<a class='profile_link' href='../profile/profile.php?id=".$user_post_id."'>".$user_firstname." ".$user_lastname."</a>";}
		}
		
	$DisplayList .= "<div id='item_box_link_creates".$link_create_id."'>
			<div class='create_box'>
			<div class='create_box1'>".$user_pic."</div>
			<div class='create_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_link_create."
			</div>
			<div class='create_box12'>".$user_pic_link_create_bar."<div ".$comment_space." id='comment_space_link_creates".$link_create_id."'></div></div>
			<div class='create_box2'>".$profile_link."</div>
			<div class='create_box2'><b>New ".$typex_text." Link: </b><a class='body' href='../planet/planet.php?id=".$planet_link_create_id."'>".$create_name."</a></div>
			<div class='create_box2'><b>Description: </b>".$create_description."</div>
			<div id='like_love_link_creates".$link_create_id."' class='inline'>
			".$hide_llc_front."
			".$like_love_link_create."
			<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:comment(".$link_create_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span>".$hide_llc_back."<span class='post_date'>".$link_create_date."</span>
			".$like_love2_link_create."</div>
			<div id='comments_link_creates".$link_create_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM link_creates_comments WHERE link_create_id='$link_create_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_link_create = $row['point_array'];
	$comment_pointArray_link_create = explode(",",$comment_point_array_link_create);
	$comment_point_array_count_link_create = count($comment_pointArray_link_create);
	$comment_point_array_count_link_create = $comment_point_array_count_link_create*10;
	if($comment_point_array_link_create==""){$comment_point_array_count_link_create="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_link_creates".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$link_create_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_link_creates".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_link_create."</b></div>";}
	else if($comment_point_array_count_link_create=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false'  onmousedown='javascript:display_point_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$planet_id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_link_create."</b></a></div>";}
						
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
			{$user_check_pic_comment="../planet_files/planet$user_page_id/planet_thumb.jpg";
			$user_default_pic_comment="../planet_files/planet0/planet_thumb.png";
			if (file_exists($user_check_pic_comment))
				{$commenter_pic_comment="<img src='$user_check_pic_comment#$cacheBuster' width='45px' height='45px' class='thumb_background'/>";}
			else
				{$commenter_pic_comment="<img src='$user_default_pic_comment' width='45px' height='45px' class='thumb_background' />";}
			$comment_profile_link="<a class='profile_link' href='../planet/planet.php?id=".$user_page_id."'>".$planet_name."</a>";
			$commenter_pic_comment="<a href='../planet/planet.php?id=".$user_page_id."'>".$commenter_pic_comment."</a>";}
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
	<div id="comment_list_link_creates'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="../profile/profile.php?id='.$user_page_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			'.$comment_profile_link.'
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_link_creates'.$comment_id.'">'.$hide_llc_front.''.$like_love_comment.'<span class="dot_divider"> &middot;</span>'.$hide_llc_back.'
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$link_create_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_link_creates'.$link_create_id.'"></div>
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
$(window).data('ajaxready21', true).scroll(function()
	{if ($(window).data('ajaxready21') == false) return;
	if($(window).scrollTop()>=$("#bottom_search_planets_planets").height()-$(document).height())
		{$("div#expand_bottom_box").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready21', false);
		$.ajax({cache: false,url:"search_planets_planets_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_planets_planets").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				 $(window).data('ajaxready21', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_box").click(function(){
	{if ($(window).data('ajaxready21') == false) return;
	$("div#expand_bottom_box").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready21', false);
	$.ajax({cache: false,url:"search_planets_planets_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_planets_planets").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				$(window).data('ajaxready21', true);}
			});
		}
	});
});
</script>