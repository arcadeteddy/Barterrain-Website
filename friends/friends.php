<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include_once "../config.php";

$_SESSION['file_location'] = "friends";
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";

ob_flush();

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = rand(9999999,99999999999);
$search_FF="";
$filter_name="";
$filter_location="";
$filter_primary_school="";
$filter_secondary_school="";
$filter_post_secondary="";
$filter_employer="";

$mysql = mysql_query("SELECT firstname,lastname,friend_array,family_array,invited_array FROM members WHERE id='$ids'");
while($row = mysql_fetch_array($mysql))
	{$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$friend_array = $row["friend_array"];
	$family_array = $row["family_array"];
	$invited_array = $row["invited_array"];
	
	$check_pic="../user_files/user$ids/profile_pic.jpg";
	$default_pic="../user_files/user0/default_profile_pic.png";
	if (file_exists($check_pic)){$user_pic="<img class='profile_image thumb_background' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else{$user_pic="<img class='profile_image thumb_background' src='$default_pic' width='260px' height='auto'/>";}}
	
$FF_banner="Friends";
if ($family_array!="")
	{$FF_banner="Family & Friends";}
	
if ($invited_array!=="") {$hide_all_invited="";}
else {$hide_all_invited="hide_all_invited";} 
if (($friend_array!=="")OR($family_array!="")) {$hide_all_friends="";}
else {$hide_all_friends="hide_all_friends";} 
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Friends - <?php echo "$firstname $lastname"; ?></title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_friends.php" media="screen"> 
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
<script type="text/javascript" async>
var color = "<?php echo $color; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
// Same Length
window.onload=function()
		{$('#friends_page_right').css('min-height', $('#friends_page_left').height()+'px');
		<?php if ((isset($_GET['friends']))AND($_GET['friends']=="all"))
				{echo '$(".side_button").removeClass("selected_window");
						$(".friends_window_3").toggleClass("selected_window");
						$(".filter_list").addClass("hidden_filter_search");
						$(".search_list").removeClass("hidden_filter_search");';}
				else if ((isset($_GET['friends']))AND($_GET['friends']=="invite"))
					{echo '$(".side_button").removeClass("selected_window");
					$(".friends_window_2").toggleClass("selected_window");
					$(".filter_list").addClass("hidden_filter_search");
					$(".search_list").addClass("hidden_filter_search");
					$(".search_invited_list").removeClass("hidden_filter_search");';}
				else {echo '$(".filter_list").removeClass("hidden_filter_search");
					$(".search_list").addClass("hidden_filter_search");';}
		?>};
</script>
<script src="friends.js" type="text/javascript" async></script> 
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow:auto;overflow-y:scroll;" class="inside">
<font>
<div class="side_colors_left"></div>
	
<div class="body"></div>
<div class="friends_page_body_cover">
<div class="friends_page_body_left"></div>
<div class="friends_page_body">

<div class="friends_page_left" id="friends_page_left">
	<div class="margin"></div>
    <div class="white_background">
	<?php echo $user_pic;?><br/><br/>
	<a href="#" class="side_button" onclick="return false" onmousedown="javascript:window_1(<?php echo $ids;?>,<?php echo $id;?>);"><div class="side_button selected_window friends_window_1"><img src="barterrain_friends_images/blank.gif" width='1px' height='1px' class="friends_find"/><span class="friends_side">Find Friends</span></div></a>
	<a href="#" class="side_button" onclick="return false" onmousedown="javascript:window_2(<?php echo $ids;?>,<?php echo $id;?>);"><div class="side_button friends_window_2"><img src="barterrain_friends_images/blank.gif" width='1px' height='1px' class="friends_invite"/><span class="friends_side">Invite Friends</span></div></a>
<a href="#" class="side_button" onclick="return false" onmousedown="javascript:window_3(<?php echo $ids;?>,<?php echo $id;?>);"><div class="side_button friends_window_3"><img src="barterrain_friends_images/blank.gif" width='1px' height='1px' class="friends_all"/><span class="friends_side">All <?php echo $FF_banner; ?></span></div></a>
<div class="filter_list hidden_filter_search" id="filter_list"><br/>
<form action="javascript:filter_query(<?php echo $ids; ?>,<?php echo $id; ?>)" method="post" enctype="multipart/form-data" name="filter_form" id="filter_form">
	<input class="search_input" name="filter_query_name" id="filter_query_name" type="text" value="<?php echo $filter_name; ?>" placeholder="Enter A Name..." maxlength="88"/>
	<input class="search_input" name="filter_query_location" id="filter_query_location" type="text" value="<?php echo $filter_location; ?>" placeholder="Enter A Location..." maxlength="64"/>
	<input class="search_input" name="filter_query_primary_school" id="filter_query_primary_school" type="text" value="<?php echo $filter_primary_school; ?>" placeholder="Enter A Primary School..." maxlength="64"/>
	<input class="search_input" name="filter_query_secondary_school" id="filter_query_secondary_school" type="text" value="<?php echo $filter_secondary_school; ?>" placeholder="Enter A Secondary School..." maxlength="64"/>
	<input class="search_input" name="filter_query_post_secondary" id="filter_query_post_secondary" type="text" value="<?php echo $filter_post_secondary; ?>" placeholder="Enter An University Or College..." maxlength="64"/>
	<input class="search_input" name="filter_query_employer" id="filter_query_employer" type="text" value="<?php echo $filter_employer; ?>" placeholder="Enter An Employer..." maxlength="64"/>
	<input src='barterrain_friends_images/blank.gif' width='1px' height='1px' type="image" name="filter" class="filter_button"/>
	<input type="hidden" name="filter" value="filter_list"/>
</form>
</div>
<div class="search_list <?php echo $hide_all_friends; ?>" id="search_list"><br/>
<form action="javascript:search_query(<?php echo $ids; ?>,<?php echo $id; ?>)" method="post" enctype="multipart/form-data" name="search_form" id="search_form">
	<input class="search_input" name="search_query" id="search_query" type="text" value="<?php echo $search_FF; ?>" placeholder="Search <?php echo $FF_banner; ?>..." maxlength="88"/>
	<input src='barterrain_friends_images/blank.gif' width='1px' height='1px' type="image" name="search" class="search_button"/>
</form>
</div>
<div class="search_invited_list hidden_filter_search <?php echo $hide_all_invited; ?>" id="search_invited_list"><br/>
<form action="javascript:search_invited_query(<?php echo $ids; ?>,<?php echo $id; ?>)" method="post" enctype="multipart/form-data" name="search_invited_form" id="search_invited_form">
	<input class="search_input" name="search_invited_query" id="search_invited_query" type="text" value="<?php echo $search_FF; ?>" placeholder="Search Invited Friends..." maxlength="88"/>
	<input src='barterrain_friends_images/blank.gif' width='1px' height='1px' type="image" name="search_invited_query" class="search_button"/>
</form>
</div>
</div>
<div class="side_bottom"></div>
</div>

<div class="friends_page_right" id="friends_page_right">
<?php
if ((isset($_GET['friends']))AND($_GET['friends']=="all"))
	{include_once "all_friends.php";}
else if ((isset($_GET['friends']))AND($_GET['friends']=="invite"))
	{include_once "invite_friends.php";}
else {include_once "find_friends.php";}
?>
</div>

<div class="white_background_full"></div>


</div>
<div class="friends_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>