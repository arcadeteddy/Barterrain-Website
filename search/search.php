<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include_once "../config.php";

$_SESSION['file_location'] = "search";
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

if (isset($_GET['search']))
	{$search = $_GET['search'];
	$search = strip_tags($_GET['search']);
	$search = mysql_real_escape_string($search);}
else {header("location: ../index.php");exit();}

include_once "../scripts/check_login.php";
ob_flush();

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster=rand(999999999,9999999999999); 
$_SESSION['cacheBuster'] = $cacheBuster;
$DisplayList="";
$friend_list="";
$planets_colonized_list="";
$zero=0;

$mysql_profile = mysql_query("SELECT * FROM members WHERE id='$ids'"); 
while($row = mysql_fetch_array($mysql_profile))
	{$id = $row["id"];
	$fullname = $row["fullname"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	if(($friend_array!=="")AND($family_array!==""))
		{$FF_array=$friend_array.",".$family_array;}
	else if($family_array!==""){$FF_array=$family_array;}
	else if($friend_array!==""){$FF_array=$friend_array;}
	else {$FF_array="";}
	$FFArray = explode(",",$FF_array);
	$FRIENDS = join(',',$FFArray);  
	$planets_array = $row['planets_array'];
	$planetsArray = explode(",",$planets_array);
	$check_pic = "../user_files/user$id/profile_pic.jpg";
	$default_pic = "../user_files/user0/default_profile_pic_thumb.png";
	if (file_exists($check_pic)) {$user_pic="<img class='search_image thumb_background' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else {$user_pic="<img class='search_image thumb_background' src='$default_pic' width='260px'/>";}
	if(($friend_array=="")AND($family_array==""))
		{$FF_array2=$ids;}
	else if($friend_array=="")
		{$FF_array2=$ids.",".$family_array;}
	else if ($family_array=="")
		{$FF_array2=$ids.",".$friend_array;}
	else{$FF_array2=$ids.",".$family_array.",".$friend_array;}
	$FF_array2 = explode(",",$FF_array2);
	$FF_News = join(',',$FF_array2);}
	
$mysql_search_tab = mysql_query("SELECT daily_points1_date,daily_points2_date,search_tab FROM members_log WHERE id='$ids'"); 
while($row = mysql_fetch_array($mysql_search_tab))
	{$daily_points1_date = $row["daily_points1_date"];
	$daily_points2_date = $row["daily_points2_date"];
	$search_tab = $row["search_tab"];}
	
if (($friend_array!=="")OR($family_array!=="")){
// Display Friends List
$mysql_friends=mysql_query("SELECT friend_array, family_array FROM members WHERE id IN ($FRIENDS) LIMIT 20");
$numRows=mysql_num_rows($mysql_friends);
if ($numRows>0){
while($row = mysql_fetch_array($mysql_friends))
	{$FF_friend_array = $row["friend_array"];
	$FF_family_array = $row["family_array"];
	$FF_friendArray=explode(",",$FF_friend_array);
	$FF_familyArray=explode(",",$FF_family_array);
	$FF_FFArray=array_merge($FF_friendArray,$FF_familyArray);
	if(isset($FF_FFArray_added))
		{$FF_FFArray_added=array_merge($FF_FFArray_added,$FF_FFArray);}
	else {$FF_FFArray_added=$FF_FFArray;}
	}
	
	$peopleArray = array_unique($FF_FFArray_added);
	$peopleArray = array_diff($peopleArray, $FFArray);
	$peopleArray = array_filter($peopleArray);
	foreach ($peopleArray as $key => $value) 
		{if ($value == $ids){unset($peopleArray[$key]);}}
	shuffle($peopleArray);
	$peopleArray8 = array_slice($peopleArray,0,4);
	shuffle($peopleArray8);
	$count=count($peopleArray);
	
if ($count>0)
	{$friend_list .= "<br/><div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='friends_lists'/><span class='heading_list'>People You May Know</span></div>
					<div class='float_right'></div>
					</div>";
	$i = 0;
	$friend_list .="<div class='under_side_bars'>";
	foreach ($peopleArray8 as $key => $value)
		{$i++;
		$mysql_name=mysql_query("SELECT id,firstname, lastname, location, friend_array, family_array FROM members WHERE id='$value' LIMIT 1");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friends_friend_array = $row['friend_array'];
			$family_friend_array = $row['family_array'];
			if(($friends_friend_array!=="")AND($family_friend_array!==""))
				{$FF_friend_array=$friends_friend_array.",".$family_friend_array;}
			else if($friends_friend_array!==""){$FF_friend_array=$friends_friend_array;}
			else if($family_friend_array!==""){$FF_friend_array=$family_friend_array;}
			else {$FF_friend_array="";}
			$FFfriendArray = explode(",",$FF_friend_array);
			$FFfriendArray = array_intersect($FFfriendArray, $FFArray);
			$FFpersonArray_json_encode = json_encode($FFfriendArray);
			$FFArray_count=count($FFfriendArray);
			$friend_location = $row['location'];
		$check_pic_friend_bar="../user_files/user$friend_id/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		$cacheBuster = rand(9999999,99999999999);
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='../profile/profile.php?id=$friend_id'><img src='$check_pic_friend_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='../profile/profile.php?id=$friend_id'><img src='$default_pic_friend_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			if ($FFArray_count!=1) {$mf_s="Friends";}
			else {$mf_s="Friend";}
			
		if (empty($FFfriendArray)) {$FFArray_count="0";}
		else {$FFArray_count="<a title='Display Mutual Friends' href='#' onclick='return false' onmousedown='javascript:display_mutual_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.");' class='bold display_button'>".$FFArray_count."</a>";}
			
		$friend_list .="<div class='list_wrap'>
						<div class='list_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a></div>
							<span>You Both Have ".$FFArray_count." Mutual ".$mf_s."</span><br/>
							<span id='request".$friend_id."'><a href='#' class='bar_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");' >Add Friend</a></span>
							<span class='dot_divider'> &middot;</span>
							<a href='messages/messages.php?message_id=".$friend_id."' class='bar_link'>Message</a></div>
						</div>";
			}
		}
	$friend_list .="</div><br/>";
	}
}

// Planets List
$planets_array_list="";
$mysql_planets=mysql_query("SELECT planets_array FROM members WHERE id IN ($FRIENDS)");
$numRows=mysql_num_rows($mysql_planets);
if ($numRows>0){
while($row = mysql_fetch_array($mysql_planets))
	{$planets_array_mutual = $row["planets_array"];
	if ($planets_array_mutual=="")
		{$planets_array_list=$planets_array_list;}
	else if ($planets_array_list!=="")
		{$planets_array_list=$planets_array_list.",".$planets_array_mutual;}
	else if ($planets_array_mutual!=="")
		{$planets_array_list=$planets_array_mutual;}}
		
	$itemArray = explode(",",$planets_array_list);
	$itemArray = array_unique($itemArray);
	$itemArray = array_diff($itemArray, $planetsArray);
	$itemArray = array_filter($itemArray);
	shuffle($itemArray);
	$itemArray = array_slice($itemArray,0,4);
	$count = count($itemArray);

if ($count>0)
	{$planets_colonized_list .= "<br/><div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='planets_lists'/><span class='heading_list'>Recommended Planets</span></div>
					<div class='float_right'></div>
					</div>";
	$i = 0;
	$planets_colonized_list .="<div class='under_side_bars'>";
	foreach ($itemArray as $key => $value)
		{$i++;
		$mysql_planet1=mysql_query("SELECT * FROM planets WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_planet1))
			{$planet_id = $row['id'];
			$create_id = $row['id'];
			$user_id = $row['user_id'];
			$planet_name = $row['planet_name'];
			$likes = $row['likes'];$loves = $row['loves'];
			$planet_description = $row['planet_description'];
			$categories = $row['categories'];
			$categories = $row['categories'];
			if ($categories=="Undefined")
				{$categories="";}
			if ((strlen($categories))>30)
				{$categories = substr($categories,0,30);
				$categories=$categories."...";}
			$member_array = $row['member_array'];
			$memberArray = explode(",",$member_array);
			$FFmemberArray = array_intersect($memberArray, $FFArray);
			$FFpersonArray_json_encode = json_encode($FFmemberArray);
			$member_count=count($memberArray);
			$FFArray_count=count($FFmemberArray);
			$FFArray_count_number=$FFArray_count;
			$check_pic_planet_bar="../planet_files/planet$planet_id/planet_thumb.jpg";
			$default_pic_planet_bar="../planet_files/planet0/planet_thumb.png";
			$cacheBuster = rand(9999999,99999999999);
			if (file_exists($check_pic_planet_bar))
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$planet_id'><img src='$check_pic_planet_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$planet_id'><img src='$default_pic_planet_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			if($categories!==""){$planet_event=$categories;}
			else if($planet_description!==""){$planet_event= "Likes: ".$likes." / Loves: ".$loves;}
			else {$planet_event="";}
			
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
			
		if ($FFArray_count==0) {$FFArray_count="0";}
			else {$FFArray_count="<a title='Display Friends That Are Members' href='#' onclick='return false' onmousedown='javascript:display_planet_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.",1);' class='bold display_button'>".$FFArray_count."</a>";}
			if($FFArray_count_number == 1){$member_count_planets = "Colonized By ".$FFArray_count." Friend";}			
			else {$member_count_planets="Colonized By ".$FFArray_count." Friends";}		

		$planets_colonized_list .="<div class='list_wrap'>
						<div class='list_wrap_1'><a href='http://www.barterrain.com/circles/planet.php?id=".$planet_id."'>".$user_pic_planet_bar."</a></div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/create/planet.php?id=".$planet_id."'><b>".$planet_name."</b></a></div>
							<span>".$member_count_planets."</span>
							<div id='create_ll_".$create_id."'>
								".$like_love_create." ".$like_love2_create."
							</div>
						</div>
						</div>";
			}
		}
	$planets_colonized_list .="</div><br/>";
	}
}}

///// DAILY POINTS! /////
$token_1=""; $token_2="";
$transaction=mysql_query("SELECT daily_points1_date FROM members_log WHERE id='$ids' AND daily_points1_date>DATE_SUB(now(),INTERVAL 24 HOUR) ORDER BY daily_points1_date DESC LIMIT 1") or die (mysql_error());
$numRows=mysql_num_rows($transaction);
if($numRows<1)
	{$token_1="<div id='daily_points1'><a href='#' onclick='return false' onmousedown='javascript:daily_points1(".$id.",".$ids.");'>
				<table class='daily_points_25' height='123px' width='123px'><tr><td><span class='daily_points'>&#5528; 25</span></td></tr></table></a></div>";}
else {$token_1="<a href='#' onclick='return false'><table class='daily_points_0' height='123px' width='123px'><tr><td><span class='daily_points'>&#5528; 0</span></td></tr></table></a>";}
$transaction=mysql_query("SELECT daily_points2_date FROM members_log WHERE id='$ids' AND daily_points2_date>DATE_SUB(now(),INTERVAL 24 HOUR) ORDER BY daily_points2_date DESC LIMIT 1") or die (mysql_error());
$numRows=mysql_num_rows($transaction);
if($numRows<1)
	{$token_2="<div id='daily_points2'><a href='#' onclick='return false' onmousedown='javascript:daily_points2(".$id.",".$ids.");'>
				<table class='daily_points_25' height='123px' width='123px'><tr><td><span class='daily_points'>&#5528; 25</span></td></tr></table></a></div>";}
else {$token_2="<a href='#' onclick='return false'><table class='daily_points_0' height='123px' width='123px'><tr><td><span class='daily_points'>&#5528; 0</span></td></tr></table></a>";}
$daily_points = "<div id='search_page_right_daily_points' style='width:265px;'><br/>
					<div class='left_side_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='daily_points'/><span class='heading_list'>Daily Points</span></div>
						<div class='float_right'></div>
					</div>
					<div>
						".$token_1."".$token_2."
					</div>
				</div>";
				
$selected_window_1 = "";$selected_window_2="";
$hide_div_1="";$hide_div_2="";
if ($search_tab=="1") {$selected_window_1="selected_window";$hide_div_2="hide_div";}
else if ($search_tab=="2") {$selected_window_2="selected_window";$hide_div_1="hide_div";}
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Search</title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_search.php" media="screen"> 
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
<script type="text/javascript" async>
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var color = "<?php echo $color; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var force_album = "";
var force_game = "";
var force_video = "";
var numRows_force_album = "";
var numRows_force_game = "";
var numRows_force_video = "";
var search_box = "<?php echo $search; ?>";
var file_location = "<?php echo "search" ?>";
var interactivePoints = "../scripts/interactive_points.php";
var PageChangerURL = "../scripts/page_changer.php";
</script>
<script src="search_javascript.js" type="text/javascript" async></script> 
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow:auto;overflow-y:scroll;" onload="upload_stuff()" class="search">
<font>
<div class="side_colors_left"></div>

<div class="body"></div>
<div class="search_page_body_cover">
<div class="search_page_body">

<div class="cover_margin_1"></div>
<div class="search_page_left" id="search_page_left">
	<div class="margin"></div>
    <div class="white_background">
    <?php echo $user_pic;?>
    <br/><br/>
	<a href="#" onclick="return false" onmousedown="javascript:window_1(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button search_window_1 <?php echo $selected_window_1;?>"><img src="blank.gif" width="1px" height="1px" class="search_profiles"/><span class="span_side">Search Profiles</span></div></a>
    <a href="#" onclick="return false" onmousedown="javascript:window_2(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button search_window_2 <?php echo $selected_window_2;?>"><img src="blank.gif" width="1px" height="1px" class="search_planets"/><span class="span_side">Search Planets</span></div></a>
   		<div class="<?php echo $hide_div_1;?> profiles_side side_hidden_div"><br/>
            <a href="#" onclick="return false" onmousedown="javascript:window_11(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_11"><img src="blank.gif" width="1px" height="1px" class="search_profiles_posts"/><span class="span_side">Posts</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_15(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_15"><img src="blank.gif" width="1px" height="1px" class="search_profiles_notes"/><span class="span_side">Notes</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_12(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_12"><img src="blank.gif" width="1px" height="1px" class="search_profiles_albums"/><span class="span_side">Albums</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_13(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_13"><img src="blank.gif" width="1px" height="1px" class="search_profiles_games"/><span class="span_side">Games</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_14(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_14"><img src="blank.gif" width="1px" height="1px" class="search_profiles_videos"/><span class="span_side">Videos</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_16(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_16"><img src="blank.gif" width="1px" height="1px" class="search_profiles_profiles"/><span class="span_side">Profiles</span></div></a>
        </div>
    	<div class="<?php echo $hide_div_2;?> planets_side side_hidden_div"><br/>
            <a href="#" onclick="return false" onmousedown="javascript:window_21(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_21"><img src="blank.gif" width="1px" height="1px" class="search_planets_posts"/><span class="span_side">Posts</span></div></a>
             <a href="#" onclick="return false" onmousedown="javascript:window_25(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_25"><img src="blank.gif" width="1px" height="1px" class="search_planets_notes"/><span class="span_side">Notes</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_22(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_22"><img src="blank.gif" width="1px" height="1px" class="search_planets_albums"/><span class="span_side">Albums</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_23(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_23"><img src="blank.gif" width="1px" height="1px" class="search_planets_games"/><span class="span_side">Games</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_24(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_24"><img src="blank.gif" width="1px" height="1px" class="search_planets_videos"/><span class="span_side">Videos</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_26(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button search_window_26"><img src="blank.gif" width="1px" height="1px" class="search_planets_planets"/><span class="span_side">Planets</span></div></a>
        </div>
    </div>
	<div class="side_bottom"></div>
</div>

<div class="search_page_body_left"></div>
<div class="search_page_right" id="search_page_right">
<div class="cover_margin_2"></div><div class="margin"></div>
<div class="search_page_middle_left" id="search_page_middle_left">
	<?php if ($search_tab=="1") {include_once "search_profiles.php";}
	else if ($search_tab=="2") {include_once "search_planets.php";} ?>
</div>

<div class="search_page_middle_right" id="search_page_middle_right">
	<div class="white_background">
	<?php 
	echo $friend_list;
	echo $planets_colonized_list; 
	echo $daily_points; ?>
	</div>
    <div id="profile_page_right_covers">
    	
    </div>
</div>
</div>

<div class="white_background_full"></div>
<div class="white_background_full2"></div>
<div class="white_background_full3"></div>

</div>
<div class="search_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>