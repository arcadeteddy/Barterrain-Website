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

$mysql1 = mysql_query("SELECT * FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql1))
	{$id = $row['id'];
	$fullname = $row['fullname'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
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
	
// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Profile - <?php echo "$firstname $lastname"; ?></title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_profile.php" media="screen">  
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="barterrain_profile_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="barterrain_profile_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="barterrain_profile_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow:auto;overflow-y:scroll;" onload="upload_stuff()" class="inside">
<font>

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
<div class="profile_page_middle_left" id="profile_page_middle_left">
</div>

<div class="profile_page_middle_right " id="profile_page_middle_right">
</div>
</div>

<div class="white_background_full4 block_background"></div>

</div>
<div class="profile_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>