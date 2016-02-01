<?php
ob_start();
include_once "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];}
if(isset($_POST['cacheBuster']))
	{$cacheBuster=$_POST['cacheBuster'];}
	
$mysql = mysql_query("SELECT user_id,creator_array,admin_array,member_array FROM planets WHERE id='$id'");
while($row = mysql_fetch_array($mysql))
	{$user_id = $row['user_id'];
	$creator_array = $row['creator_array'];
	$admin_array = $row['admin_array'];
	$member_array = $row['member_array'];
	
	$memberArray=explode(",",$member_array);
	$adminArray=explode(",",$admin_array);
	$creatorArray=explode(",",$creator_array);
	$CREATORS=join(',',$creatorArray);
	}
	
if ((in_array($ids,$adminArray))OR(in_array($ids,$creatorArray)))
	{$view_type="";}
else if (in_array($ids,$memberArray))
	{$view_type="AND game_type!='c'";}
else {$view_type="AND game_type!='b' AND game_type!='c'";}

if (!in_array($ids,$memberArray))
	{$hide_llc_front="<div style='display:none;'>";
	$hide_llc_back="</div>";}
else
	{$hide_llc_front="";
	$hide_llc_back="";}

unset($games_array);
$mysql = mysql_query("SELECT id FROM planets_games WHERE user_page_id=$id ".$view_type." AND delete_item='1' ORDER BY upload_date DESC");
$numRows=mysql_num_rows($mysql);

$gamesDisplayList="";
if ($numRows>0)
	{// Pagination
	while ($row = mysql_fetch_array($mysql))
	{$game_id = $row['id'];
	if (!isset($games_array)){$games_array=$game_id;}
	else{$games_array=$games_array.",".$game_id;}}
	$gamesArray=explode(",",$games_array);
	$list_games="";
	$items_per_page=4;
	$pages_games=ceil($numRows/$items_per_page);
	$page_games=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_games-1) * $items_per_page;
	$gamesArray2 = array_slice($gamesArray,$start,$items_per_page);
	
	if($pages_games>1)
		{for($x=1;$x<=$pages_games;$x++)
			{if(($x==$page_games)AND($x==$pages_games)){$list_games.="<b>$x</b>";}
			else if($x==$page_games){$list_games.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_games){$list_games.="<a href='#' onclick='return false' onmousedown='javascript:games_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_games.="<a href='#' onclick='return false' onmousedown='javascript:games_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination

	$gamesDisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='games_lists'/><span class='heading_list'>Games (".$numRows.")</span></div>
					<div class='float_right'>".$list_games."</div></div>";
	$i = 0;
	$gamesDisplayList .="<div class='under_middle_friends'>";
	foreach ($gamesArray2 as $key => $value)
		{$i++;	
		$mysql_game=mysql_query("SELECT * FROM planets_games WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_game))
			{$game_id = $row['id'];
			$item_id = $row['id'];
			$user_page_id = $row['user_page_id'];
			$user_post_id = $row['user_post_id'];
			$game_name = $row['game_name'];
			if(strlen($game_name)>25){$game_name=substr($game_name, 0, 25)."...";}
			$game_type = $row['game_type'];
			$memory_type = $row['memory_type'];
			$upload_date = $row['upload_date'];
			$convertedTime = ($myObject -> convert_datetime($upload_date));
			$upload_date = ($myObject -> make_ago($convertedTime));
			$like_array_game = $row['like_array'];
			$love_array_game = $row['love_array'];
			$likeArray_game = explode(",",$like_array_game);
			$loveArray_game = explode(",",$love_array_game);
			$like_array_count_game = count($likeArray_game);
			$love_array_count_game = count($loveArray_game);
			$point_array_game = $row['point_array'];
			$pointArray_game = explode(",",$point_array_game);
			$point_array_count_game = count($pointArray_game);
			$point_array_count_game = $point_array_count_game*10;
			if($point_array_game==""){$point_array_count_game="0";}
			}

		$comment_type="games";
		$comment_type=json_encode($comment_type);
	
		if (in_array($ids,$likeArray_game))
			{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_game))
			{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_game !="")AND($love_array_game !=""))
			{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_game !="")
			{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_game !="")
			{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_game = "";}
		
		// Little Things
		if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($game_type=="a"){$type="<div class='option_box' id='type_change_games".$game_id."'><a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$game_id.",".$comment_type.");'></a></div>";}
	else if($game_type=="b"){$type="<div class='option_box' id='type_change_games".$game_id."'><a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$game_id.",".$comment_type.");'></a></div>";}
	else if($game_type=="c"){$type="<div class='option_box' id='type_change_games".$game_id."'><a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$game_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_games".$game_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$game_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_games".$game_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$game_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_post_id){$point="<div class='option_box2' id='point_games".$game_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$game_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_game."</b></div>";}
	else if($point_array_count_game=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_game."</b></a></div>";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
		{$delete_button_folder="<div class='option_box' id='delete_folder_games".$game_id."'><a title='Delete' href='#' class='top_options_delete1' onclick='return false' onmousedown='javascript:delete_folder1(".$game_id.",".$comment_type.");'></a></div>";}
		else{$delete_button_folder="";}
			
		$game_pic="../planet_files/planet$user_page_id/planet_game_$game_id/planet_game_".$game_id."_cover.jpg";
		$game_default_pic="../planet_files/planet0/default_game_cover.png";
		if(file_exists($game_pic))
			{$game_cover="<a href='#' onclick='return false' onmousedown='javascript:game_opener(".$ids.",".$id.",".$game_id.");'><img src='$game_pic#$cacheBuster' height='125px' width='213px' class='thumb_background'/></a>";}
		else{$game_cover="<a href='#' onclick='return false' onmousedown='javascript:game_opener(".$ids.",".$id.",".$game_id.");'><img src='$game_default_pic' height='125px' width='213px' class='thumb_background'/></a>";}
	
		$gamesDisplayList .= '<div class="upload_box" id="upload_game_box'.$game_id.'">
								<div class="upload_box5">
									<div class="upload_box4"><span class="top_folder_text"></span></div>
									<div class="top_options">
										'.$point.''.$type.''.$memory_box.''.$delete_button_folder.'
									</div>
									<div class="folder_pic2">'.$game_cover.'</div>
								</div>
								<div class="upload_box2">
									<a class="profile_link" href="#" onclick="return false" onmousedown="javascript:game_opener('.$ids.','.$id.','.$game_id.');">'.$game_name.'</a>
								</div>
								<div class="upload_box3">
									<div class="like_love" id="like_love_games'.$game_id.'">'.$hide_llc_front.''.$like_love_game.'
									<span class="dot_divider"> &middot; </span>'.$hide_llc_back.'<span class="post_date">'.$upload_date.'</span>'.$like_love2_game.'</div>
								</div>
							</div>';
		}
	$gamesDisplayList .="<br/><br/></div>";
	}
echo $gamesDisplayList;
?>