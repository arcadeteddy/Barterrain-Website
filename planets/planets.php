<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include_once "../config.php";

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

$cacheBuster=rand(999999999,9999999999999);  
$_SESSION['cacheBuster'] = $cacheBuster;

	$check_pic = "../user_files/user$ids/profile_pic.jpg";
	$default_pic = "../user_files/user0/default_profile_pic_thumb.png";
	if (file_exists($check_pic)) {$user_pic="<img class='planets_image thumb_background' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else {$user_pic="<img class='planets_image thumb_background' src='$default_pic' width='260px' height='auto'/>";}
	
$mysql_planets_tab = mysql_query("SELECT planets_tab FROM members_log WHERE id='$ids'"); 
while($row = mysql_fetch_array($mysql_planets_tab))
	{$planets_tab = $row["planets_tab"];}
	
	$type_o="planets";
	$type=json_encode($type_o);
	
$selected_window_1 = "";$selected_window_2="";$selected_window_3="";
$hide_div_1="";$hide_div_2="";$hide_div_3="";
if ($planets_tab=="1") {$selected_window_1="selected_window";$hide_div_2="hide_div";$hide_div_3="hide_div";}
else if ($planets_tab=="2") {$selected_window_2="selected_window";$hide_div_1="hide_div";$hide_div_3="hide_div";}
else if ($planets_tab=="3") {$selected_window_3="selected_window";$hide_div_1="hide_div";$hide_div_2="hide_div";}
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Planets</title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_planets.php" media="screen"> 
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script> 
<script type="text/javascript" async>
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var type = "<?php echo $type_o; ?>";
var color = "<?php echo $color; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var cacheBuster = "<?php echo $cacheBuster; ?>";
var PageChangerURL = "../scripts/page_changer.php";
</script>
<script src="planets_javascript.js" type="text/javascript" async></script>
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow:auto;overflow-y:scroll;" onload="upload_stuff()" class="planets">
<font>
<div class="side_colors_left"></div>

<div class="body"></div>
<div class="planets_page_body_cover">
<div class="planets_page_body">

<div class="cover_margin_1"></div>
<div class="planets_page_left" id="planets_page_left">
	<div class="margin"></div>
    <div class="white_background">
    <?php echo $user_pic;?>
    <br/><br/>
	<a href="#" onclick="return false" onmousedown="javascript:window_1(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button planets_window_1 <?php echo $selected_window_1;?>"><img src="blank.gif" width="1px" height="1px" class="planets_popular_recent"/><span class="span_side">Popular & Recent</span></div></a>
    <a href="#" onclick="return false" onmousedown="javascript:window_2(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button planets_window_2 <?php echo $selected_window_2;?>"><img src="blank.gif" width="1px" height="1px" class="planets_popular"/><span class="span_side">Popular</span></div></a>
    <a href="#" onclick="return false" onmousedown="javascript:window_3(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button planets_window_3 <?php echo $selected_window_3;?>"><img src="blank.gif" width="1px" height="1px" class="planets_recent"/><span class="span_side">Recent</span></div></a>
   		<div class="<?php echo $hide_div_1;?> popular_recent_side side_hidden_div"><br/>
            <a href="#" onclick="return false" onmousedown="javascript:window_11(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_11"><img src="blank.gif" width="1px" height="1px" class="planets_albums"/><span class="span_side">Albums</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_12(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_12"><img src="blank.gif" width="1px" height="1px" class="planets_games"/><span class="span_side">Games</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_13(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_13"><img src="blank.gif" width="1px" height="1px" class="planets_videos"/><span class="span_side">Videos</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_14(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_14"><img src="blank.gif" width="1px" height="1px" class="planets_planets"/><span class="span_side">Planets</span></div></a>
        </div>
    	<div class="<?php echo $hide_div_2;?> popular_side side_hidden_div"><br/>
            <a href="#" onclick="return false" onmousedown="javascript:window_21(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_21"><img src="blank.gif" width="1px" height="1px" class="planets_albums"/><span class="span_side">Albums</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_22(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_22"><img src="blank.gif" width="1px" height="1px" class="planets_games"/><span class="span_side">Games</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_23(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_23"><img src="blank.gif" width="1px" height="1px" class="planets_videos"/><span class="span_side">Videos</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_24(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_24"><img src="blank.gif" width="1px" height="1px" class="planets_planets"/><span class="span_side">Planets</span></div></a>
        </div>
        <div class="<?php echo $hide_div_3;?> recent_side side_hidden_div"><br/>
            <a href="#" onclick="return false" onmousedown="javascript:window_31(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_31"><img src="blank.gif" width="1px" height="1px" class="planets_albums"/><span class="span_side">Albums</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_32(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_32"><img src="blank.gif" width="1px" height="1px" class="planets_games"/><span class="span_side">Games</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_33(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_33"><img src="blank.gif" width="1px" height="1px" class="planets_videos"/><span class="span_side">Videos</span></div></a>
            <a href="#" onclick="return false" onmousedown="javascript:window_34(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button extra_side_button planets_window_34"><img src="blank.gif" width="1px" height="1px" class="planets_planets"/><span class="span_side">Planets</span></div></a>
        </div>
    </div>
	<div class="side_bottom"></div>
</div>

<div class="planets_page_body_left"></div>
<div class="planets_page_right">
<div class="cover_margin_2"></div><div class="margin"></div>

<div id="planets_page_right">
	<?php if ($planets_tab=="1") {include_once "planets_popular_recent.php";}
	else if ($planets_tab=="2") {include_once "planets_popular.php";}
	else if ($planets_tab=="3") {include_once "planets_recent.php";} ?>
</div>
</div>

<div class="white_background_full"></div>

</div>
<div class="planets_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>
</html>