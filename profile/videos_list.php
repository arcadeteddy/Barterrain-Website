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
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql = mysql_query("SELECT friend_array,family_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$friend_array=$row['friend_array'];
	$friend_array = explode(",",$friend_array);
	$family_array=$row['family_array'];
	$family_array = explode(",",$family_array);}
	
if (in_array($ids,$friend_array))
	{$view_type="AND video_type!='c'";}
else if (in_array($ids,$family_array))
	{$view_type="AND video_type!='b'";}
else {$view_type="";}

$mysql = mysql_query("SELECT id FROM videos WHERE user_id=$id $view_type AND delete_item='1' ORDER BY upload_date DESC");
$numRows=mysql_num_rows($mysql);

$videosDisplayList="";
if ($numRows>0)
	{// Pagination
	while ($row = mysql_fetch_array($mysql))
	{$video_id = $row['id'];
	if (!isset($videos_array)){$videos_array=$video_id;}
	else{$videos_array=$videos_array.",".$video_id;}}
	$videosArray=explode(",",$videos_array);
	$list_videos="";
	$items_per_page=4;
	$pages_videos=ceil($numRows/$items_per_page);
	$page_videos=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_videos-1) * $items_per_page;
	$videosArray2 = array_slice($videosArray,$start,$items_per_page);
	
	if($pages_videos>1)
		{for($x=1;$x<=$pages_videos;$x++)
			{if(($x==$page_videos)AND($x==$pages_videos)){$list_videos.="<b>$x</b>";}
			else if($x==$page_videos){$list_videos.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_videos){$list_videos.="<a href='#' onclick='return false' onmousedown='javascript:videos_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_videos.="<a href='#' onclick='return false' onmousedown='javascript:videos_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination

	$videosDisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='videos_lists'/><span class='heading_list'>Videos (".$numRows.")</span></div>
					<div class='float_right'>".$list_videos."</div></div>";
	$i = 0;
	$videosDisplayList .="<div class='under_middle_friends'>";
	foreach ($videosArray2 as $key => $value)
		{$i++;	
		$mysql_video=mysql_query("SELECT * FROM videos WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_video))
			{$video_id = $row['id'];
			$item_id = $row['id'];
			$user_id = $row['user_id'];
			$video_name = $row['video_name'];
			if(strlen($video_name)>25){$video_name=substr($video_name, 0, 25)."...";}
			$video_type = $row['video_type'];
			$memory_type = $row['memory_type'];
			$upload_date = $row['upload_date'];
			$convertedTime = ($myObject -> convert_datetime($upload_date));
			$upload_date = ($myObject -> make_ago($convertedTime));
			$like_array_video = $row['like_array'];
			$love_array_video = $row['love_array'];
			$likeArray_video = explode(",",$like_array_video);
			$loveArray_video = explode(",",$love_array_video);
			$like_array_count_video = count($likeArray_video);
			$love_array_count_video = count($loveArray_video);
			$point_array_video = $row['point_array'];
			$pointArray_video = explode(",",$point_array_video);
			$point_array_count_video = count($pointArray_video);
			$point_array_count_video = $point_array_count_video*10;
			if($point_array_video==""){$point_array_count_video="0";}
			}

		$comment_type="videos";
		$comment_type=json_encode($comment_type);
	
		if (in_array($ids,$likeArray_video))
			{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_video))
			{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_video !="")AND($love_array_video !=""))
			{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_video !="")
			{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_video !="")
			{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_video = "";}
		
		// Little Things
		if($ids==$user_id)
			{if($video_type=="a"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}
			else if($video_type=="b"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}
			else if($video_type=="c"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}}
		else{$type="";}
		if($ids==$user_id)
			{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_videos".$video_id."'><a href='#' title='Store in Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$video_id.",".$comment_type.");'></a></div>";}
			else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_videos".$video_id."'><a href='#' title='Remove from Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$video_id.",".$comment_type.");'></a></div>";}}
		else{$memory_box="";}
		if($ids==$user_id)
			{$delete_button_folder="<div class='option_box'  id='delete_folder_videos".$video_id."'><a title='Delete' href='#' class='top_options_delete1' onclick='return false' onmousedown='javascript:delete_folder1(".$video_id.",".$comment_type.");'></a></div>";}
		else{$delete_button_folder="";}
		if($ids!==$user_id){$point="<div class='option_box2' id='point_videos".$video_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$video_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_video."</b></div>";}
		else if($point_array_count_video=="0"){$point="";}
		else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_video."</b></a></div>";}
	
			
		$video_pic="../user_files/user$user_id/video_$video_id/video_".$video_id."_cover.jpg";
		$video_default_pic="../user_files/user0/default_video_cover.png";
		if(file_exists($video_pic))
			{$video_cover="<a href='#' onclick='return false' onmousedown='javascript:video_opener(".$ids.",".$id.",".$video_id.");'><img src='$video_pic' height='125px' width='213px' class='thumb_background'/></a>";}
		else{$video_cover="<a href='#' onclick='return false' onmousedown='javascript:video_opener(".$ids.",".$id.",".$video_id.");'><img src='$video_default_pic' height='125px' width='213px' class='thumb_background'/></a>";}
	
		$videosDisplayList .= '<div class="upload_box" id="upload_video_box'.$video_id.'">
								<div class="upload_box5">
									<div class="upload_box4"></div>
									<div class="top_options">
										'.$point.''.$type.''.$memory_box.''.$delete_button_folder.'
									</div>
									<div class="folder_pic2">'.$video_cover.'</div>
								</div>
								<div class="upload_box2">
									<a class="profile_link" href="#" onclick="return false" onmousedown="javascript:video_opener('.$ids.','.$id.','.$video_id.');">'.$video_name.'</a>
								</div>
								<div class="upload_box3">
									<div class="like_love" id="like_love_videos'.$video_id.'">'.$like_love_video.'
									<span class="dot_divider"> &middot; </span><span class="post_date">'.$upload_date.'</span>'.$like_love2_video.'</div>
								</div>
							</div>';
		}
	$videosDisplayList .="<br/><br/></div>";
	}
echo $videosDisplayList;
?>