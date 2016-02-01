<font>
<?php
include_once "../config.php";
$DisplayList="";

if ($_POST['display']=="like_array")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_json_encode=json_encode($item_type);
	$item_type_s=substr($item_type,0,-1);
	$uc_item_type=ucfirst($item_type_s);
	
	if ($item_type=="posts") {$create_id="user_page_id";}
	else {$create_id="user_id";}
	$create_type="profile";
	
	if ($item_type=="images_walls") {$this_these="These";$uc_item_type="Images";}
	else if ($item_type=="games_posts") {$this_these="This";$uc_item_type="Game Post";}
	else if ($item_type=="videos_posts") {$this_these="This";$uc_item_type="Video Post";}
	else if ($item_type=="albums_posts") {$this_these="This";$uc_item_type="Album Post";}
	else if ($item_type=="images_posts") {$this_these="This";$uc_item_type="Image Post";}
	else if ($item_type=="member_posts") {$this_these="This";$uc_item_type="Member Post";}
	else {$this_these="This";}
	
	if($item_type=="planets")
		{$create_id="user_id";}
	else if(isset($_POST['type'])) 
		{if($item_type=="link_creates")
			{$typex=$_POST['type'];
			$create_type_s=substr($typex,0,-1);
			$uc_create_type=ucfirst($create_type_s);
			$create_id="user_page_id";
			$uc_item_type=$uc_create_type." Link";}	
		else if($_POST['type']=="planets") 
			{$typex=$_POST['type'];
			$item_type=$typex."_".$item_type;
			$create_id="user_page_id";
			$create_type="planet";
			$uc_item_type="Planet ".$uc_item_type;}
		}
	
	$mysql_name=mysql_query("SELECT ".$create_id." AS create_id, like_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row = mysql_fetch_array($mysql_name))
		{$create_id = $row['create_id'];
		$like_array = $row['like_array'];
		$likeArray = explode(",",$like_array);
		$like_count = count($likeArray);}
	
	// Pagination
	$list_like="";
	$items_per_page=16;
	$pages_like=ceil($like_count/$items_per_page);
	$page_like=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_like-1) * $items_per_page;
	$LikeArray8 = array_slice($likeArray,$start,$items_per_page);
	
	if($pages_like>1)
		{for($x=1;$x<=$pages_like;$x++)
			{if(($x==$page_like)AND($x==$pages_like)){$list_like.="<b>$x</b>";}
			else if($x==$page_like){$list_like.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_like){$list_like.="<a href='#' onclick='return false' onmousedown='javascript:display_like_array_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_like.="<a href='#' onclick='return false' onmousedown='javascript:display_like_array_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='likes_lists'/><span class='heading_list'>Likes For ".$this_these." ".$uc_item_type." (".$like_count.")</span></div>
					<div class='float_right'>".$list_like."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($LikeArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
else if ($_POST['display']=="love_array")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_json_encode=json_encode($item_type);
	$item_type_s=substr($item_type,0,-1);
	$uc_item_type=ucfirst($item_type_s);
	
	if ($item_type=="posts") {$create_id="user_page_id";}
	else {$create_id="user_id";}
	$create_type="profile";
	
	if ($item_type=="images_walls") {$this_these="These";$uc_item_type="Images";}
	else if ($item_type=="games_posts") {$this_these="This";$uc_item_type="Game Post";}
	else if ($item_type=="videos_posts") {$this_these="This";$uc_item_type="Video Post";}
	else if ($item_type=="albums_posts") {$this_these="This";$uc_item_type="Album Post";}
	else if ($item_type=="images_posts") {$this_these="This";$uc_item_type="Image Post";}
	else if ($item_type=="member_posts") {$this_these="This";$uc_item_type="Member Post";}
	else {$this_these="This";}
	
	if($item_type=="planets")
		{$create_id="user_id";}
	else if(isset($_POST['type'])) 
		{if($item_type=="link_creates")
			{$typex=$_POST['type'];
			$create_type_s=substr($typex,0,-1);
			$uc_create_type=ucfirst($create_type_s);
			$create_id="user_page_id";
			$uc_item_type=$uc_create_type." Link";}	
		else if($_POST['type']=="planets") 
			{$typex=$_POST['type'];
			$item_type=$typex."_".$item_type;
			$create_id="user_page_id";
			$create_type="planet";
			$uc_item_type="Planet ".$uc_item_type;}
		}
	
	$mysql_name=mysql_query("SELECT ".$create_id." AS create_id, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row = mysql_fetch_array($mysql_name))
		{$create_id = $row['create_id'];
		$love_array = $row['love_array'];
		$loveArray = explode(",",$love_array);
		$love_count = count($loveArray);}
	
	// Pagination
	$list_love="";
	$items_per_page=16;
	$pages_love=ceil($love_count/$items_per_page);
	$page_love=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_love-1) * $items_per_page;
	$loveArray8 = array_slice($loveArray,$start,$items_per_page);
	
	if($pages_love>1)
		{for($x=1;$x<=$pages_love;$x++)
			{if(($x==$page_love)AND($x==$pages_love)){$list_love.="<b>$x</b>";}
			else if($x==$page_love){$list_love.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_love){$list_love.="<a href='#' onclick='return false' onmousedown='javascript:display_love_array_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_love.="<a href='#' onclick='return false' onmousedown='javascript:display_love_array_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='loves_lists'/><span class='heading_list'>Loves For ".$this_these." ".$uc_item_type." (".$love_count.")</span></div>
					<div class='float_right'>".$list_love."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($loveArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
else if ($_POST['display']=="point_array")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_json_encode=json_encode($item_type);
	$item_type_s=substr($item_type,0,-1);
	$uc_item_type=ucfirst($item_type_s);
	
	if ($item_type=="posts") {$create_id="user_page_id";}
	else {$create_id="user_id";}
	$create_type="profile";
	
	if ($item_type=="images_walls") {$this_these="These";$uc_item_type="Images";}
	else if ($item_type=="games_posts") {$this_these="This";$uc_item_type="Game Post";}
	else if ($item_type=="videos_posts") {$this_these="This";$uc_item_type="Video Post";}
	else if ($item_type=="albums_posts") {$this_these="This";$uc_item_type="Album Post";}
	else if ($item_type=="images_posts") {$this_these="This";$uc_item_type="Image Post";}
	else if ($item_type=="member_posts") {$this_these="This";$uc_item_type="Member Post";}
	else {$this_these="This";}
	
	if($item_type=="planets")
		{$create_id="user_id";}
	else if(isset($_POST['type'])) 
		{if($item_type=="link_creates")
			{$typex=$_POST['type'];
			$create_type_s=substr($typex,0,-1);
			$uc_create_type=ucfirst($create_type_s);
			$create_id="user_page_id";
			$uc_item_type=$uc_create_type." Link";}	
		else if($_POST['type']=="planets") 
			{$typex=$_POST['type'];
			$item_type=$typex."_".$item_type;
			$create_id="user_page_id";
			$create_type="planet";
			$uc_item_type="Planet ".$uc_item_type;}
		}
	
	$mysql_name=mysql_query("SELECT ".$create_id." AS create_id, point_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row = mysql_fetch_array($mysql_name))
		{$create_id = $row['create_id'];
		$point_array = $row['point_array'];
		$pointArray = explode(",",$point_array);
		$point_count = count($pointArray);
		$total_count = $point_count*10;
		$pointArray = array_unique($pointArray);
		$pointArray_count = count($pointArray);}
	
	// Pagination
	$list_point="";
	$items_per_page=16;
	$pages_point=ceil($pointArray_count/$items_per_page);
	$page_point=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_point-1) * $items_per_page;
	$pointArray8 = array_slice($pointArray,$start,$items_per_page);
	
	if($pages_point>1)
		{for($x=1;$x<=$pages_point;$x++)
			{if(($x==$page_point)AND($x==$pages_point)){$list_point.="<b>$x</b>";}
			else if($x==$page_point){$list_point.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_point){$list_point.="<a href='#' onclick='return false' onmousedown='javascript:display_point_array_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_point.="<a href='#' onclick='return false' onmousedown='javascript:display_point_array_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination

	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='points_lists'/><span class='heading_list'>Points For ".$this_these." ".$uc_item_type." (".$total_count.")</span></div>
					<div class='float_right'>".$list_point."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($pointArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href=http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
else if ($_POST['display']=="like_array_comment")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_json_encode=json_encode($item_type);
	$item_type_s=substr($item_type,0,-1);
	$uc_item_type=ucfirst($item_type_s);

	$create_type="profile";
	
	if ($item_type=="images_walls") {$this_these="These";$uc_item_type="Images";}
	else if ($item_type=="games_posts") {$this_these="This";$uc_item_type="Game Post";}
	else if ($item_type=="videos_posts") {$this_these="This";$uc_item_type="Video Post";}
	else if ($item_type=="albums_posts") {$this_these="This";$uc_item_type="Album Post";}
	else if ($item_type=="images_posts") {$this_these="This";$uc_item_type="Image Post";}
	else if ($item_type=="member_posts") {$this_these="This";$uc_item_type="Member Post";}
	else {$this_these="This";}
	
	if($item_type=="planets")
		{$create_id="user_id";}
	else if(isset($_POST['type'])) 
		{if($item_type=="link_creates")
			{$typex=$_POST['type'];
			$create_type_s=substr($typex,0,-1);
			$uc_create_type=ucfirst($create_type_s);
			$create_id="user_page_id";
			$uc_item_type=$uc_create_type." Link";}	
		else if($_POST['type']=="planets") 
			{$typex=$_POST['type'];
			$item_type=$typex."_".$item_type;
			$create_id="user_page_id";
			$create_type="planet";
			$uc_item_type="Planet ".$uc_item_type;}
		}
	
	$mysql_name=mysql_query("SELECT user_page_id AS create_id, like_array FROM ".$item_type."_comments WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row = mysql_fetch_array($mysql_name))
		{$create_id = $row['create_id'];
		$like_array = $row['like_array'];
		$likeArray = explode(",",$like_array);
		$like_count = count($likeArray);}
	
	// Pagination
	$list_like="";
	$items_per_page=16;
	$pages_like=ceil($like_count/$items_per_page);
	$page_like=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_like-1) * $items_per_page;
	$LikeArray8 = array_slice($likeArray,$start,$items_per_page);
	
	if($pages_like>1)
		{for($x=1;$x<=$pages_like;$x++)
			{if(($x==$page_like)AND($x==$pages_like)){$list_like.="<b>$x</b>";}
			else if($x==$page_like){$list_like.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_like){$list_like.="<a href='#' onclick='return false' onmousedown='javascript:display_like_array_comment_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_like.="<a href='#' onclick='return false' onmousedown='javascript:display_like_array_comment_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='likes_lists'/><span class='heading_list'>Likes For ".$this_these." ".$uc_item_type." Comment (".$like_count.")</span></div>
					<div class='float_right'>".$list_like."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($LikeArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
else if ($_POST['display']=="love_array_comment")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_json_encode=json_encode($item_type);
	$item_type_s=substr($item_type,0,-1);
	$uc_item_type=ucfirst($item_type_s);

	$create_type="profile";
	
	if ($item_type=="images_walls") {$this_these="These";$uc_item_type="Images";}
	else if ($item_type=="games_posts") {$this_these="This";$uc_item_type="Game Post";}
	else if ($item_type=="videos_posts") {$this_these="This";$uc_item_type="Video Post";}
	else if ($item_type=="albums_posts") {$this_these="This";$uc_item_type="Album Post";}
	else if ($item_type=="images_posts") {$this_these="This";$uc_item_type="Image Post";}
	else if ($item_type=="member_posts") {$this_these="This";$uc_item_type="Member Post";}
	else {$this_these="This";}
	
	if($item_type=="planets")
		{$create_id="user_id";}
	else if(isset($_POST['type'])) 
		{if($item_type=="link_creates")
			{$typex=$_POST['type'];
			$create_type_s=substr($typex,0,-1);
			$uc_create_type=ucfirst($create_type_s);
			$create_id="user_page_id";
			$uc_item_type=$uc_create_type." Link";}	
		else if($_POST['type']=="planets") 
			{$typex=$_POST['type'];
			$item_type=$typex."_".$item_type;
			$create_id="user_page_id";
			$create_type="planet";
			$uc_item_type="Planet ".$uc_item_type;}
		}
	
	$mysql_name=mysql_query("SELECT user_page_id AS create_id, love_array FROM ".$item_type."_comments WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row = mysql_fetch_array($mysql_name))
		{$create_id = $row['create_id'];
		$love_array = $row['love_array'];
		$loveArray = explode(",",$love_array);
		$love_count = count($loveArray);}
	
	// Pagination
	$list_love="";
	$items_per_page=16;
	$pages_love=ceil($love_count/$items_per_page);
	$page_love=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_love-1) * $items_per_page;
	$loveArray8 = array_slice($loveArray,$start,$items_per_page);
	
	if($pages_love>1)
		{for($x=1;$x<=$pages_love;$x++)
			{if(($x==$page_love)AND($x==$pages_love)){$list_love.="<b>$x</b>";}
			else if($x==$page_love){$list_love.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_love){$list_love.="<a href='#' onclick='return false' onmousedown='javascript:display_love_array_comment_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_love.="<a href='#' onclick='return false' onmousedown='javascript:display_love_array_comment_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='loves_lists'/><span class='heading_list'>Loves For ".$this_these." ".$uc_item_type." Comment (".$love_count.")</span></div>
					<div class='float_right'>".$list_love."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($loveArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
else if ($_POST['display']=="point_array_comment")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_json_encode=json_encode($item_type);
	$item_type_s=substr($item_type,0,-1);
	$uc_item_type=ucfirst($item_type_s);

	$create_type="profile";
	
	if ($item_type=="images_walls") {$this_these="These";$uc_item_type="Images";}
	else if ($item_type=="games_posts") {$this_these="This";$uc_item_type="Game Post";}
	else if ($item_type=="videos_posts") {$this_these="This";$uc_item_type="Video Post";}
	else if ($item_type=="albums_posts") {$this_these="This";$uc_item_type="Album Post";}
	else if ($item_type=="images_posts") {$this_these="This";$uc_item_type="Image Post";}
	else if ($item_type=="member_posts") {$this_these="This";$uc_item_type="Member Post";}
	else {$this_these="This";}
	
	if($item_type=="planets")
		{$create_id="user_id";}
	else if(isset($_POST['type'])) 
		{if($item_type=="link_creates")
			{$typex=$_POST['type'];
			$create_type_s=substr($typex,0,-1);
			$uc_create_type=ucfirst($create_type_s);
			$create_id="user_page_id";
			$uc_item_type=$uc_create_type." Link";}	
		else if($_POST['type']=="planets") 
			{$typex=$_POST['type'];
			$item_type=$typex."_".$item_type;
			$create_id="user_page_id";
			$create_type="planet";
			$uc_item_type="Planet ".$uc_item_type;}
		}
	
	$mysql_name=mysql_query("SELECT user_page_id AS create_id, point_array FROM ".$item_type."_comments WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row = mysql_fetch_array($mysql_name))
		{$create_id = $row['create_id'];
		$point_array = $row['point_array'];
		$pointArray = explode(",",$point_array);
		$point_count = count($pointArray);
		$total_count = $point_count*10;
		$pointArray = array_unique($pointArray);
		$pointArray_count = count($pointArray);}
	
	// Pagination
	$list_point="";
	$items_per_page=16;
	$pages_point=ceil($pointArray_count/$items_per_page);
	$page_point=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_point-1) * $items_per_page;
	$pointArray8 = array_slice($pointArray,$start,$items_per_page);
	
	if($pages_point>1)
		{for($x=1;$x<=$pages_point;$x++)
			{if(($x==$page_point)AND($x==$pages_point)){$list_point.="<b>$x</b>";}
			else if($x==$page_point){$list_point.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_point){$list_point.="<a href='#' onclick='return false' onmousedown='javascript:display_point_array_comment_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_point.="<a href='#' onclick='return false' onmousedown='javascript:display_point_array_comment_x(".$x.",".$id.",".$ids.",".$item_id.",".$item_type_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='points_lists'/><span class='heading_list'>Points For ".$this_these." ".$uc_item_type." Comment (".$total_count.")</span></div>
					<div class='float_right'>".$list_point."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($pointArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
else if ($_POST['display']=="mutual_FF_array")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$mutual_FFArray=$_POST['mutual_FF_array'];
	$mutual_FF_count = count($mutual_FFArray);
	$mutual_FFArray_json_encode = json_encode($mutual_FFArray);
	
	// Pagination
	$list_friend="";
	$items_per_page=16;
	$pages_friend=ceil($mutual_FF_count/$items_per_page);
	$page_friend=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_friend-1) * $items_per_page;
	$friendArray8 = array_slice($mutual_FFArray,$start,$items_per_page);
	
	if($pages_friend>1)
		{for($x=1;$x<=$pages_friend;$x++)
			{if(($x==$page_friend)AND($x==$pages_friend)){$list_friend.="<b>$x</b>";}
			else if($x==$page_friend){$list_friend.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_friend){$list_friend.="<a href='#' onclick='return false' onmousedown='javascript:display_mutual_FF_array_x(".$x.",".$id.",".$ids.",".$mutual_FFArray_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_friend.="<a href='#' onclick='return false' onmousedown='javascript:display_mutual_FF_array_x(".$x.",".$id.",".$ids.",".$mutual_FFArray_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='mutual_friends_bar'/><span class='heading_list'>Mutual Friends (".$mutual_FF_count.")</span></div>
					<div class='float_right'>".$list_friend."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($friendArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
else if ($_POST['display']=="planet_FF_array")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$planet_FFArray=$_POST['planet_FF_array'];
	$planet_FF_count = count($planet_FFArray);
	$planet_FFArray_json_encode = json_encode($planet_FFArray);
	
	// Pagination
	$list_friend="";
	$items_per_page=16;
	$pages_friend=ceil($planet_FF_count/$items_per_page);
	$page_friend=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_friend-1) * $items_per_page;
	$friendArray8 = array_slice($planet_FFArray,$start,$items_per_page);
	
	if($pages_friend>1)
		{for($x=1;$x<=$pages_friend;$x++)
			{if(($x==$page_friend)AND($x==$pages_friend)){$list_friend.="<b>$x</b>";}
			else if($x==$page_friend){$list_friend.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_friend){$list_friend.="<a href='#' onclick='return false' onmousedown='javascript:display_planet_FF_array_x(".$x.",".$id.",".$ids.",".$planet_FFArray_json_encode.");' class='bold'>".$x."</a>";}
			else {$list_friend.="<a href='#' onclick='return false' onmousedown='javascript:display_planet_FF_array_x(".$x.",".$id.",".$ids.",".$planet_FFArray_json_encode.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$DisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' class='mutual_friends_planet'/><span class='heading_list'>Colonized Friends (".$planet_FF_count.")</span></div>
					<div class='float_right'>".$list_friend."</div></div>";
	$i = 0;
	$DisplayList .="<div class='under_middle_friends'>";
	foreach ($friendArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='http://www.barterrain.com/profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		
		$DisplayList .="<div class='display_array_box'>
						<div class='display_array_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='display_array_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div></div>";
		}
		$DisplayList .="</div>";
	}
	
	
echo '<div class="display_div">'.$DisplayList.'</div>';
?>
<script type="text/javascript">
var friendRequestURL = "../scripts/request_as_friend.php";
function addAsFriend2(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship2",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#request"+b).html(data).show()});	
	}
	
// Scores Array
function display_like_array_x(a,b,c,d,e)
	{$.post("../scripts/display_array.php?page="+a,{display:"like_array",x:a,id:b,ids:c,item_id:d,item_type:e},function(data) 
		{$("#display_div").html(data).show()});	
	}
function display_love_array_x(a,b,c,d,e)
	{$.post("../scripts/display_array.php?page="+a,{display:"love_array",x:a,id:b,ids:c,item_id:d,item_type:e},function(data) 
		{$("#display_div").html(data).show()});	
	}
function display_point_array_x(a,b,c,d,e)
	{$.post("../scripts/display_array.php?page="+a,{display:"point_array",x:a,id:b,ids:c,item_id:d,item_type:e},function(data) 
		{$("#display_div").html(data).show()});	
	}
function display_like_array_comment_x(a,b,c,d,e)
	{$.post("../scripts/display_array.php?page="+a,{display:"like_array_comment",x:a,id:b,ids:c,item_id:d,item_type:e},function(data) 
		{$("#display_div").html(data).show()});	
	}
function display_love_array_comment_x(a,b,c,d,e)
	{$.post("../scripts/display_array.php?page="+a,{display:"love_array_comment",x:a,id:b,ids:c,item_id:d,item_type:e},function(data) 
		{$("#display_div").html(data).show()});	
	}
function display_point_array_comment_x(a,b,c,d,e)
	{$.post("../scripts/display_array.php?page="+a,{display:"point_array_comment",x:a,id:b,ids:c,item_id:d,item_type:e},function(data) 
		{$("#display_div").html(data).show()});	
	}
	
// Mutual Array
function display_mutual_FF_array_x(a,b,c,d)
	{$.post("../scripts/display_array.php?page="+a,{display:"mutual_FF_array",x:a,id:b,ids:c,mutual_FF_array:d},function(data) 
		{$("#display_div").html(data).show()});	
	}
// Mutual Array
function display_planet_FF_array_x(a,b,c,d)
	{$.post("../scripts/display_array.php?page="+a,{display:"planet_FF_array",x:a,id:b,ids:c,planet_FF_array:d},function(data) 
		{$("#display_div").html(data).show()});	
	}
</script>
</font>