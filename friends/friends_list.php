<?php
ob_start();
include_once "../config.php";
$FFDisplayList="";
$FF_array="";
$count="";

if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];}
else
	{$id = $_SESSION['ids'];
	$ids = $_SESSION['ids'];}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();

$mysql1 = mysql_query("SELECT friend_array, family_array FROM members WHERE id='$ids'");
while($row = mysql_fetch_array($mysql1))
	{$friend_array = $row['friend_array'];
	$friendArray = explode(",",$friend_array);
	$family_array = $row['family_array'];
	$familyArray = explode(",",$family_array);
	if (($friend_array != "")AND($family_array !="")){$FF_array=$family_array.",".$friend_array;}
	else if ($friend_array != ""){$FF_array=$friend_array;}
	else if ($family_array !=""){$FF_array=$family_array;}
	$FFArray = explode(",",$FF_array);
	$FFArray2 = join(',',$FFArray);
	$FF_count = count($FFArray);}
	
if (($friend_array != "")AND($family_array !=""))
	{$total = "All Family & Friends (".$FF_count.")";}
else if ($friend_array != "")
	{$total = "All Friends (".$FF_count.")";}
else if ($family_array !="")
	{$total = "All Family (".$FF_count.")";}
	
if((isset($_POST['search_query']))AND($_POST['search_query']!=""))
	{if (($friend_array != "")AND($family_array !=""))
		{$total = "All Family & Friends";}
	else if ($friend_array != "")
		{$total = "All Friends";}
	else if ($family_array !="")
		{$total = "All Family";}
	$search_query=preg_replace('#[^a-z A-Z -]#i','',$_POST['search_query']);
	$mysql_query="SELECT id, firstname, lastname, location, secondary_school, post_secondary FROM members WHERE (id IN ($FFArray2)) AND (fullname LIKE '%$search_query%' OR firstname LIKE '%$search_query%' OR lastname LIKE '%$search_query%') LIMIT 60";
	$mysql_name=mysql_query($mysql_query);
	$count=mysql_num_rows($mysql_name);
	if($count>=1)
		{if ($count!=1) {$result_s="Results";}
		else {$result_s="Result";}
		$list_friends="<a href='#' onclick='return false' class='bold'>".$count." ".$result_s."</a>";
		$FFDisplayList .= "<div class='bar_wrap'><div class='body_bars'>
						<div class='float_left'><img src='barterrain_friends_images/blank.gif' class='all_friends_bar'/><span class='heading_list'>".$total."</span></div>
						<div class='float_right'>".$list_friends."</div>
					</div></div><div class='under_middle_friends2'>";
					
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_secondary_school = $row['secondary_school'];
			$friend_post_secondary = $row['post_secondary'];
			if($friend_post_secondary!=""){$friend_place=$friend_post_secondary;}
			else if($friend_secondary_school!=""){$friend_place=$friend_secondary_school;}
			else if($friend_location!=""){$friend_place=$friend_location;}
			else {$friend_place="";}
			
		$check_pic_friend_bar="../user_files/user$friend_id/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar)){$user_pic_friend_bar="<a href='../profile/profile.php?id=$friend_id'><img src='$check_pic_friend_bar?$cacheBuster' height='65px' class='thumb_background'/></a>";}
		else{$user_pic_friend_bar="<a href='../profile/profile.php?id=$friend_id'><img src='$default_pic_friend_bar' height='65px' class='thumb_background'/></a>";}
		
		$FFDisplayList .="<div class='friends_box3'>
							<div class='middle_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
							<div class='middle_wrap_2'>
								<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
								<span class='places'>".$friend_place."</span>
								<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a>
							</div>
						</div>";
			}
		$FFDisplayList .="</div>";}
	else
		{if ($count!=1) {$result_s="Results";}
		else {$result_s="Result";}
		$list_friends="<a href='#' onclick='return false' class='bold'>0 ".$result_s."</a>";
		$FFDisplayList .= "<div class='bar_wrap'><div class='body_bars'>
						<div class='float_left'><img src='barterrain_friends_images/blank.gif' class='all_friends_bar'/><span class='heading_list'>".$total."</span></div>
						<div class='float_right'>".$list_friends."</div>
					</div></div>";
		}
	}
else {
if (($friend_array!=="")OR($family_array!==""))
	{// Pagination
	$list_friends="";
	$items_per_page=60;
	$pages_friends=ceil($FF_count/$items_per_page);
	$page_friends=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_friends-1) * $items_per_page;
	$FFArray8 = array_slice($FFArray,$start,$items_per_page);
	
	if($pages_friends>1)
		{for($x=1;$x<=$pages_friends;$x++)
			{if(($x==$page_friends)AND($x==$pages_friends)){$list_friends.="<b>$x</b>";}
			else if($x==$page_friends){$list_friends.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_friends){$list_friends.="<a href='#' onclick='return false' onmousedown='javascript:friends_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_friends.="<a href='#' onclick='return false' onmousedown='javascript:friends_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$FFDisplayList .= "<div class='bar_wrap'><div class='body_bars'>
						<div class='float_left'><img src='barterrain_friends_images/blank.gif' class='all_friends_bar'/><span class='heading_list'>".$total."</span></div>
						<div class='float_right'>".$list_friends."</div>
					</div></div>";
	$i = 0;
	$FFDisplayList .="<div class='under_middle_friends2'>";
	foreach ($FFArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='../profile/profile.php?id=$value'><img src='$check_pic_friend_bar?$cacheBuster' height='65px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='../profile/profile.php?id=$value'><img src='$default_pic_friend_bar' height='65px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id, firstname, lastname, location, secondary_school, post_secondary FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_secondary_school = $row['secondary_school'];
			$friend_post_secondary = $row['post_secondary'];
			if($friend_post_secondary!=""){$friend_place=$friend_post_secondary;}
			else if($friend_secondary_school!=""){$friend_place=$friend_secondary_school;}
			else if($friend_location!=""){$friend_place=$friend_location;}
			else{$friend_place="";}}
		
		$FFDisplayList .="<div class='friends_box3'>
							<div class='middle_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
							<div class='middle_wrap_2'>
								<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
								<span class='places'>".$friend_place."</span>
								<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a>
							</div>
						</div>";
		}
		$FFDisplayList .="</div>";
	}
	else {$mysql=mysql_query("SELECT * FROM friend_requests WHERE request_id = '$ids' AND request_status = '0' ORDER BY id DESC LIMIT 1") or die ("Sorry, we have a system error!");
		$numRows=mysql_num_rows($mysql);
		if ($numRows < 1)
			{echo "<div class='bar_wrap'><div class='body_bars'>
						<div class='float_left'><img src='barterrain_friends_images/blank.gif' class='all_friends_bar'/><span class='heading_list'>All Friends (0)</span></div>
						<div class='float_right'></div>
					</div></div>";}
		}
}
echo $FFDisplayList;
?>
<script type="text/javascript">
// friends Pagination
function friends_list(a,b,c)
	{$.post("friends_list.php?page="+a,{x:a,id:b,ids:c},function(data) 
		{$("#friends_list").html(data).show()});	
	}
</script>