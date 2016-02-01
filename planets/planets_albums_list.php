<?php
ob_start();
include_once "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$cacheBuster=$_POST['cacheBuster'];}
if(isset($_POST['items_per_page']))
	{$items_per_page=$_POST['items_per_page'];}

if ($items_per_page=="8") {$items_page="40";}
else {$items_page="100";}
	
$mysql_tab=mysql_query("SELECT * FROM members_log WHERE id='$ids' LIMIT 1") or die ("Sorry, we have a system error!");
while ($row = mysql_fetch_array($mysql_tab))
	{$planets_tab = $row['planets_tab'];}
if ($planets_tab=="1") {$tab_heading="Popular & Recent";$mysql_order="AND upload_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 336 HOUR) ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, upload_date DESC";}
else if ($planets_tab=="2") {$tab_heading="Popular";$mysql_order="ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, upload_date DESC";}
else if ($planets_tab=="3") {$tab_heading="Recent";$mysql_order="ORDER BY upload_date DESC";}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql = mysql_query("SELECT id FROM planets_albums WHERE album_type='a' AND delete_item='1' ".$mysql_order." LIMIT ".$items_page."");
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
	$pages_albums=ceil($numRows/$items_per_page);
	$page_albums=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_albums-1) * $items_per_page;
	$albumsArray2 = array_slice($albumsArray,$start,$items_per_page);
	
	if($pages_albums>1)
		{for($x=1;$x<=$pages_albums;$x++)
			{if(($x==$page_albums)AND($x==$pages_albums)){$list_albums.="<b>$x</b>";}
			else if($x==$page_albums){$list_albums.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_albums){$list_albums.="<a href='#' onclick='return false' onmousedown='javascript:planets_albums_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_albums.="<a href='#' onclick='return false' onmousedown='javascript:planets_albums_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination

	$albumsDisplayList .= "<div class='planets_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='albums_lists'/><span class='heading_list'>".$tab_heading." Albums</span></div>
					<div class='float_right'>".$list_albums."</div></div>";
	$i = 0;
	$albumsDisplayList .="<div class='under_list_wrap'>";
	foreach ($albumsArray2 as $key => $value)
		{$i++;	
		$mysql_album=mysql_query("SELECT * FROM planets_albums WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_album))
			{$album_id = $row['id'];
			$item_id = $row['id'];
			$user_page_id = $row['user_page_id'];
			$user_post_id = $row['user_post_id'];
			$album_name = $row['album_name'];
			$upload_date = $row['upload_date'];
			$convertedTime = ($myObject -> convert_datetime($upload_date));
			$upload_date = ($myObject -> make_ago($convertedTime));
			$like_array_album = $row['like_array'];
			$love_array_album = $row['love_array'];
			$likeArray_album = explode(",",$like_array_album);
			$loveArray_album = explode(",",$love_array_album);
			$like_array_count_album = count($likeArray_album);
			$love_array_count_album = count($loveArray_album);}
		$mysql_planet=mysql_query("SELECT planet_name FROM planets WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_planet))
			{$planet_name = $row['planet_name'];}
			
		$comment_type="albums";
		$comment_type=json_encode($comment_type);
			
		if (($like_array_album !="")AND($love_array_album !=""))
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_album !="")
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_album !="")
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_album = "";}
			
		$album_pic="../planet_files/planet".$user_page_id."/planet_album_thumbs_".$album_id."/planet_album_".$album_id."_cover.jpg";
		$album_default_pic="../planet_files/planet0/default_album_cover.png";
		if(file_exists($album_pic))
			{$album_cover="<a title='".$album_name."' href='../planet/planet.php?id=".$user_page_id."&force_album=".$album_id."'><img src='$album_pic#$cacheBuster' height='168px' width='168px' class='thumb_background'/></a>";}
		else{$album_cover="<a title='".$album_name."' href='../planet/planet.php?id=".$user_page_id."&force_album=".$album_id."'><img src='$album_default_pic' height='168px' width='168px' class='thumb_background'/></a>";}
	
		$albumsDisplayList .= '<div class="planets_box_wrap1">
								<div class="planets_box1">
									<div class="planets_box_pic"><div style="float:left;">'.$album_cover.'</div></div>
								</div>
								<div class="planets_box3">
									<div class="line2"><div class="length"><a title="'.$album_name.'" class="profile_link" href="../planet/planet.php?id='.$user_page_id.'&force_album='.$album_id.'">'.$album_name.'</a></div></div>
									<br/><div class="line"><div class="length">By <a title="'.$planet_name.'" class="body" href="../planet/planet.php?id='.$user_page_id.'">'.$planet_name.'</a></div></div>
									<br/><div class="line4"><div class="length"><span class="post_date">'.$upload_date.'</span>'.$like_love2_album.'</div></div>
								</div>
							</div>';
		}
	$albumsDisplayList .="<br/><br/></div>";
	}
echo $albumsDisplayList;
?>