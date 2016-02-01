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
	{$view_type="AND album_type!='c'";}
else if (in_array($ids,$family_array))
	{$view_type="AND album_type!='b'";}
else {$view_type="";}

$mysql = mysql_query("SELECT id FROM albums WHERE user_id=$id $view_type AND delete_item='1' ORDER BY upload_date DESC");
$numRows=mysql_num_rows($mysql);

$albumsDisplayList="";
if ($numRows>0)
	{// Pagination
	while ($row = mysql_fetch_array($mysql))
	{$album_id = $row['id'];
	if (!isset($albums_array)){$albums_array=$album_id;}
	else{$albums_array=$albums_array.",".$album_id;}}
	$albumsArray=explode(",",$albums_array);
	$list_albums="";
	$items_per_page=8;
	$pages_albums=ceil($numRows/$items_per_page);
	$page_albums=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_albums-1) * $items_per_page;
	$albumsArray2 = array_slice($albumsArray,$start,$items_per_page);
	
	if($pages_albums>1)
		{for($x=1;$x<=$pages_albums;$x++)
			{if(($x==$page_albums)AND($x==$pages_albums)){$list_albums.="<b>$x</b>";}
			else if($x==$page_albums){$list_albums.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_albums){$list_albums.="<a href='#' onclick='return false' onmousedown='javascript:albums_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_albums.="<a href='#' onclick='return false' onmousedown='javascript:albums_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination

	$albumsDisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='albums_lists'/><span class='heading_list'>Albums (".$numRows.")</span></div>
					<div class='float_right'>".$list_albums."</div></div>";
	$i = 0;
	$albumsDisplayList .="<div class='under_middle_friends'>";
	foreach ($albumsArray2 as $key => $value)
		{$i++;	
		$mysql_album=mysql_query("SELECT * FROM albums WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_album))
			{$album_id = $row['id'];
			$item_id = $row['id'];
			$user_id = $row['user_id'];
			$album_name = $row['album_name'];
			if(strlen($album_name)>25){$album_name=substr($album_name, 0, 25)."...";}
			$album_type = $row['album_type'];
			$memory_type = $row['memory_type'];
			$upload_date = $row['upload_date'];
			$convertedTime = ($myObject -> convert_datetime($upload_date));
			$upload_date = ($myObject -> make_ago($convertedTime));
			$like_array_album = $row['like_array'];
			$love_array_album = $row['love_array'];
			$image_array = $row['image_array'];
			$likeArray_album = explode(",",$like_array_album);
			$loveArray_album = explode(",",$love_array_album);
			$imageArray = explode(",",$image_array);
			$like_array_count_album = count($likeArray_album);
			$love_array_count_album = count($loveArray_album);
			$image_array_count = count($imageArray);
			$point_array_album = $row['point_array'];
			$pointArray_album = explode(",",$point_array_album);
			$point_array_count_album = count($pointArray_album);
			$point_array_count_album = $point_array_count_album*10;
			if($point_array_album==""){$point_array_count_album="0";}
			}

		$comment_type="albums";
		$comment_type=json_encode($comment_type);
	
		if (in_array($ids,$likeArray_album))
			{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_album))
			{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_album !="")AND($love_array_album !=""))
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_album !="")
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_album !="")
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_album = "";}
		
		// Little Things
		if($ids==$user_id)
			{if($album_type=="a"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
			else if($album_type=="b"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
			else if($album_type=="c"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}}
		else{$type="";}
		if($ids==$user_id)
			{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Store in Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}
			else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Remove from Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}}
		else{$memory_box="";}
		if($ids==$user_id)
			{$delete_button_folder="<div class='option_box' id='delete_folder_albums".$album_id."'><a href='#' title='Delete' class='top_options_delete1' onclick='return false' onmousedown='javascript:delete_folder1(".$album_id.",".$comment_type.");'></a></div>";}
		else{$delete_button_folder="";}
		if($ids!==$user_id){$point="<div class='option_box2' id='point_albums".$album_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$album_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_album."</b></div>";}
		else if($point_array_count_album=="0"){$point="";}
		else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_album."</b></a></div>";}
		if($image_array_count=="1"){$count=$image_array_count." Picture";}
		else{$count=$image_array_count." Pictures";}
			
		$album_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_cover.jpg";
		$album_default_pic="../user_files/user0/default_album_cover.png";
		if(file_exists($album_pic))
			{$album_cover="<a href='#' onclick='return false' onmousedown='javascript:album_opener(".$ids.",".$id.",".$album_id.");'><img src='$album_pic#$cacheBuster' height='213px' width='213px' class='thumb_background'/></a>";}
		else{$album_cover="<a href='#' onclick='return false' onmousedown='javascript:album_opener(".$ids.",".$id.",".$album_id.");'><img src='$album_default_pic' height='213px' width='213px' class='thumb_background'/></a>";}
	
		$albumsDisplayList .= '<div class="upload_box" id="upload_album_box'.$album_id.'">
								<div class="upload_box1">
									<div class="upload_box4"></div>
									<div class="top_options">
										'.$point.''.$type.''.$memory_box.''.$delete_button_folder.'
									</div>
									<div class="folder_pic">'.$album_cover.'</div>
								</div>
								<div class="upload_box2">
									<a class="profile_link" href="#" onclick="return false" onmousedown="javascript:album_opener('.$ids.','.$id.','.$album_id.');">'.$album_name.'</a>
								</div>
								<div class="upload_box3">
									<div class="like_love" id="like_love_albums'.$album_id.'">'.$like_love_album.'
									<span class="dot_divider"> &middot; </span><span class="post_date">'.$upload_date.'</span>'.$like_love2_album.'</div>
								</div>
							</div>';
		}
	$albumsDisplayList .="<br/><br/></div>";
	}
echo $albumsDisplayList;
?>