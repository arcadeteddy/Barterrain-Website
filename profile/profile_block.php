<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
include "../config.php";

$_SESSION['file_location'] = "profile";
$file_location = "profile";
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];
if (isset($_GET['id'])) 
	{$id = preg_replace('#[^0-9]#i', '', $_GET['id']);}
$_SESSION['id'] = $id;

include_once "../scripts/check_login.php";
if ($id!==$ids)
	{include_once "../scripts/check_block.php";}
ob_flush();

$cacheBuster=rand(999999999,9999999999999);   
$_SESSION['cacheBuster'] = $cacheBuster;

$error_message="";
$success_message="";
$right_top_box="";
$margin_top_1="";
$margin_top_2="";
$mysql1 = mysql_query("SELECT * FROM members WHERE id=$id");
$mysql2 = mysql_query("SELECT * FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql1))
	{$id = $row['id'];
	$fullname = $row['fullname'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
	$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	if(($friend_array!=="")AND($family_array!==""))
		{$FF_array=$friend_array.",".$family_array;}
	else if($family_array!==""){$FF_array=$family_array;}
	else{$FF_array=$friend_array;}
	$FFArray = explode(",",$FF_array);
	$subscriptions_array = $row['subscriptions_array'];
	$subscribers_array = $row['subscribers_array'];
	$groups_array = $row['groups_array'];
	$pages_array = $row['pages_array'];
	$events_array_profile = $row['events_array'];
	$shops_array = $row['shops_array'];
	$cover_picture_ext = $row['cover_picture_ext'];
	$check_pic="../user_files/user$id/profile_pic.jpg";
	$default_pic="../user_files/user0/default_profile_pic.png";
	if (file_exists($check_pic))
		{$user_pic="<img class='profile_image thumb_background' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else
		{$user_pic="<img class='profile_image thumb_background' src='$default_pic' width='260px' height='auto'/>";}
	$check_pic2="../user_files/user$id/cover_pic.".$cover_picture_ext."";
	if (file_exists($check_pic2))
		{$cover_pic="<img class='cover_image' src='$check_pic2#$cacheBuster' width='1120px' height='auto'/>";}
	else{$cover_pic="";}
	}
while($row = mysql_fetch_array($mysql2))
	{$friend_array_ids = $row['friend_array'];
	$family_array_ids = $row['family_array'];
	if(($friend_array_ids!=="")AND($family_array_ids!==""))
		{$FF_array_ids=$friend_array_ids.",".$family_array_ids;}
	else if($family_array_ids!==""){$FF_array_ids=$family_array_ids;}
	else{$FF_array_ids=$friend_array_ids;}
	$FFArray_ids = explode(",",$FF_array_ids);
	}
	
// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);

// Top Right Menu
$php_self = $_SERVER['REQUEST_URI'];
if (isset($_SESSION['ids']) && $_SESSION['ids'] != $id)
	{$mysqlArray = mysql_query("SELECT friend_array, family_array, block_array, subscriptions_array FROM members WHERE id='$ids' LIMIT 1");
	while ($row = mysql_fetch_array($mysqlArray))
		{$rt_friend_array = $row['friend_array'];
		$rt_family_array = $row['family_array'];
		$rt_block_array = $row['block_array'];
		$rt_subscribe_array = $row['subscriptions_array'];}
	$rt_friend_array = explode(",",$rt_friend_array);
	$rt_family_array = explode(",",$rt_family_array);
	$rt_block_array = explode(",",$rt_block_array);
	$rt_subscribe_array = explode(",",$rt_subscribe_array);
	if (in_array($id,$rt_subscribe_array)) {$subscribe1="<img src='blank.gif' width='1px' height='1px' name='subscribed' class='right_inside6'/>";
		$subscribe2="<a href='#' onclick='return false' onmousedown='javascript:unsubscribeUser($ids, $id);'>Unsubscribe to this Person</a>";}
	else {$subscribe1="<a href='#' onclick='return false' onmousedown='javascript:subscribeUser($ids, $id);' class='right_top' id='inline'><img src='blank.gif' width='1px' height='1px' name='unsubscribe' class='right_inside2'/></a>";
		$subscribe2="";}
	if ((in_array($id,$rt_block_array))AND((in_array($id,$rt_friend_array))OR(in_array($id,$rt_family_array))))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='blocked' class='right_inside4'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' onclick='return false' onmousedown='javascript:unblockUser($ids, $id);'>Unblock this Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove this Person</a>
						</div></fieldset></div></div>";}
	else if (in_array($id,$rt_friend_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='friend' class='right_inside1'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' class='right_inside_open' onclick='return false' onmousedown='javascript:FriendstoFamily($ids, $id);'>Friends to Family</a>
						<a href='#' onclick='return false' onmousedown='javascript:blockUser($ids, $id);'>Block this Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove this Person</a>
						</div></fieldset></div></div>";}
	else if (in_array($id,$rt_family_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><img src='blank.gif' width='1px' height='1px' name='family' class='right_inside3'/>
						".$subscribe1."
						<a href='#' class='right_top right_inside_button' title='Options' onmousedown='if (event.preventDefault) event.preventDefault()'></a>
						<div><fieldset id='right_inside_menu'><div class='right_inside_open'>
						<a href='#' class='right_inside_open' onclick='return false' onmousedown='javascript:FamilytoFriends($ids, $id);'>Family to Friends</a>
						<a href='#' onclick='return false' onmousedown='javascript:blockUser($ids, $id);'>Block this Person</a>
						".$subscribe2."
						<a href='#' onclick='return false' onmousedown='javascript:removeAsFriend(".$ids.",".$id.");'>Remove this Person</a>
						</div></fieldset></div></div>";}

	else if (in_array($id,$rt_block_array))
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><a href='#' class='right_top' onclick='return false' onmousedown='javascript:addAsFriend(".$ids.",".$id.");'>
						<img src='blank.gif' width='1px' height='1px' name='add_friend' class='right_outside1'/></a>
						<a href='#' onmousedown='javascript:unblockUser($ids, $id);' class='right_top' id='inline'>						
						<img src='blank.gif' width='1px' height='1px' name='unblock' class='right_outside3'/></a></div>";}
	else
		{$right_top_box = "<div class='right_top_box' id='right_top_box'><a href='#' class='right_top' onclick='return false' onmousedown='javascript:addAsFriend(".$ids.",".$id.");'>
						<img src='blank.gif' width='1px' height='1px' name='add_friend' class='right_outside1'/></a>
						<a href='#' onmousedown='javascript:blockUser($ids, $id);' class='right_top' id='inline'>						
						<img src='blank.gif' width='1px' height='1px' name='block' class='right_outside2'/></a></div>";}
	}
else if (isset($_SESSION['ids']) && $_SESSION['ids'] == $id)
	{$right_top_box = "";}
	
// Display Friends List
$mutual_list = "";
$friendArray = array_intersect($FFArray_ids, $FFArray);
$friendArray_count = count($friendArray);
if (($friendArray_count>0)AND($FF_array!=="")AND($FF_array_ids!==""))
	{shuffle($friendArray);
	$friendArray8 = array_slice($friendArray,0,8);
	$friend_count = count($friendArray);
	
	$mutual_list .= "<div class='left_side_bars'>
					<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='mutual_friends_bar'/><span class='heading_list'>Mutual Friends (".$friend_count.")</span></div>
					<div class='float_right'></div>
					</div>";
	$i = 0;
	$mutual_list .="<div class='under_side_bars'>";
	foreach ($friendArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='profile.php?id=$value'><img src='$check_pic_friend_bar#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='profile.php?id=$value'><img src='$default_pic_friend_bar' width='55px' height='55px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id,firstname, lastname, location, friend_array, family_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);}
			
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else {$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}
			
		$mutual_list .="<div class='list_wrap'>
						<div class='list_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='list_wrap_2'><div class='profile_link'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a></div>
							<span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a></div>
						</div>";
			
		}
		$mutual_list .="</div><br/><br/>";
	}
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Profile - <?php echo "$firstname $lastname"; ?></title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_profile.php" media="screen">  
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
<script type="text/javascript" async>
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var color = "<?php echo $color; ?>";
var file_location = "<?php echo $file_location; ?>";
var interactiveURL = "../scripts/interactive_changer.php";
var interactive = "../scripts/interactive_box.php";
var commentURL = "../scripts/comment_box.php";
var url = "../scripts/interactive_box.php";	
var like_loveURL = "../scripts/like_love.php";

// Friends Options Menu
$(document).ready(function() 
	{$(".right_inside_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#right_inside_menu").toggle();
		$(".right_inside_button").toggleClass("right_inside_open");});
		$("fieldset#right_inside_menu").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.right_inside_button").length==0)
				{$(".right_inside_button").removeClass("right_inside_open");
				$("fieldset#right_inside_menu").hide();}
            });            
	});
	
// Friends Options
var friendRequestURL = "../scripts/request_as_friend.php";
function addAsFriend(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function addAsFriend2(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship2",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#request"+b).html(data).show()});	
	}
function blockUser(a,b)
	{$.post(friendRequestURL,{request:"blockUser",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function unblockUser(a,b)
	{$.post(friendRequestURL,{request:"unblockUser",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
</script>
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="barterrain_profile_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="barterrain_profile_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="barterrain_profile_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow:auto;overflow-y:scroll;" onload="upload_stuff()" class="inside">
<font>
<div class="side_colors_left"></div>

<div class="body"></div>
<div class="profile_page_body_cover">
<div class="profile_page_body">

<div class="cover_image"><div class="margin"></div><?php echo $cover_pic;?></div>

<div class="cover_margin_1"></div>
<div class="profile_page_left" id="profile_page_left">
	<div class="margin"></div>
    <div class="white_background">
    <?php echo $user_pic;?>
    <br/><br/><font class="side_header"><img src="blank.gif" width="1px" height="1px" class="profile_header"/><?php echo $fullname;?></font>
    </div>
	<div class="side_bottom"></div>
</div>

<div class="profile_page_body_left"></div>
<div class="profile_page_right " id="profile_page_right">
<div class="cover_margin_2"></div><div class="margin"></div>
<div class="profile_page_middle_left" id="profile_page_middle_left">
	
</div>

<div class="profile_page_middle_right " id="profile_page_middle_right">
	<div class="interact_message" id="top_result_div">
	<?php echo $right_top_box;?><br/>
	<div class="interact_message" id="top_result_div2">
		<font color="#dd4a4a"><?php print"$error_message";?></font>
		<font color="#4773C4"><?php print"$success_message";?></font>
		<?php if(($error_message=="")AND($success_message=="")){echo '';}?>
	</div>
    </div>
	<div class="white_background">
    <?php 
	echo $mutual_list;
	?>
	</div>
</div>
</div>

<div class="white_background_full block_background"></div>
<div class="white_background_full2"></div>
<div class="white_background_full3"></div>

</div>
<div class="profile_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>