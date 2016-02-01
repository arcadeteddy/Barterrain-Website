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
if ($planets_tab=="1") {$tab_heading="Popular & Recent";$mysql_order="AND create_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 336 HOUR) ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, create_date DESC";}
else if ($planets_tab=="2") {$tab_heading="Popular";$mysql_order="ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, create_date DESC";}
else if ($planets_tab=="3") {$tab_heading="Recent";$mysql_order="ORDER BY create_date DESC";}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql = mysql_query("SELECT id FROM planets WHERE delete_item='1' ".$mysql_order." LIMIT ".$items_page."");
$numRows=mysql_num_rows($mysql);
$planetsDisplayList="";
if ($numRows>0)
	{// Pagination
	while ($row = mysql_fetch_array($mysql))
	{$planet_id = $row['id'];
	if (!isset($planets_planets_array)){$planets_planets_array=$planet_id;}
	else{$planets_planets_array=$planets_planets_array.",".$planet_id;}}
	$planets_planetsArray=explode(",",$planets_planets_array);
	$list_planets="";
	$pages_planets=ceil($numRows/$items_per_page);
	$page_planets=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_planets-1) * $items_per_page;
	$planetsArray2 = array_slice($planets_planetsArray,$start,$items_per_page);
	
	if($pages_planets>1)
		{for($x=1;$x<=$pages_planets;$x++)
			{if(($x==$page_planets)AND($x==$pages_planets)){$list_planets.="<b>$x</b>";}
			else if($x==$page_planets){$list_planets.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_planets){$list_planets.="<a href='#' onclick='return false' onmousedown='javascript:planets_planets_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_planets.="<a href='#' onclick='return false' onmousedown='javascript:planets_planets_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination

	$planetsDisplayList .= "<div class='planets_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='planets_lists'/><span class='heading_list'>".$tab_heading." Planets</span></div>
					<div class='float_right'>".$list_planets."</div></div>";
	$i = 0;
	$planetsDisplayList .="<div class='under_list_wrap'>";
	foreach ($planetsArray2 as $key => $value)
		{$i++;	
		$mysql_planets=mysql_query("SELECT * FROM planets WHERE id='$value' AND delete_item='1' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_planets))
			{$planet_id = $row['id'];
			$item_id = $row['id'];
			$user_id = $row['user_id'];
			$planet_name = $row['planet_name'];
			$create_date = $row['create_date'];
			$convertedTime = ($myObject -> convert_datetime($create_date));
			$create_date = ($myObject -> make_ago($convertedTime));
			$like_array_planets = $row['like_array'];
			$love_array_planets = $row['love_array'];
			$member_array_planets = $row['member_array'];
			$likeArray_planets = explode(",",$like_array_planets);
			$loveArray_planets = explode(",",$love_array_planets);
			$memberArray_planets = explode(",",$member_array_planets);
			$like_array_count_planets = count($likeArray_planets);
			$love_array_count_planets = count($loveArray_planets);}
			$member_array_count_planets = count($memberArray_planets);
			if ($member_array_count_planets!=1) {$m_s="s";}
			else {$m_s="";}
			
		$comment_type="planets";
		$comment_type=json_encode($comment_type);
			
		if (($like_array_planets !="")AND($love_array_planets !=""))
			{$like_love2_planets = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_planets."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_planets."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_planets !="")
			{$like_love2_planets = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_planets."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_planets !="")
			{$like_love2_planets = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_planets."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_planets = "";}
			
		$planets_pic="../planet_files/planet".$planet_id."/planet_cover.jpg";
		$planets_default_pic="../planet_files/planet0/planet_picture.png";
		if(file_exists($planets_pic))
			{$planets_cover="<a title='".$planet_name."' href='../planet/planet.php?id=".$planet_id."'><img src='$planets_pic#$cacheBuster' height='168px' width='168px' class='thumb_background'/></a>";}
		else{$planets_cover="<a title='".$planet_name."' href='../planet/planet.php?id=".$planet_id."'><img src='$planets_default_pic' height='168px' width='168px' class='thumb_background'/></a>";}
	
		$planetsDisplayList .= '<div class="planets_box_wrap1">
								<div class="planets_box1">
									<div class="planets_box_pic"><div style="float:left;">'.$planets_cover.'</div></div>
								</div>
								<div class="planets_box3">
									<div class="line2"><div class="length"><a title="'.$planet_name.'" class="profile_link" href="../planet/planet.php?id='.$planet_id.'">'.$planet_name.'</a></div></div>
									<br/><div class="line"><div class="length">With <a title="Members Array" class="body" style="color:#000000;" href="#" onclick="return false">'.$member_array_count_planets.'</a> Member'.$m_s.'</div></div>
									<br/><div class="line4"><div class="length"><span class="post_date">'.$create_date.'</span>'.$like_love2_planets.'</div></div>
								</div>
							</div>';
		}
	$planetsDisplayList .="</div>";
	}
echo $planetsDisplayList;
?>