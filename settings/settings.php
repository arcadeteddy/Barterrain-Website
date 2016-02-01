<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include_once "../config.php";

if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = rand(9999999,99999999999);

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";
ob_flush();

// Section For Profile Picture.
if (isset($_POST['parse_var']))
{if ($_POST['parse_var'] == "profile_picture")
	{$fileName =$_FILES['fileField']['name'];
	$fileTmpLoc =$_FILES['fileField']['tmp_name'];
	$fileType =$_FILES['fileField']['type'];
	$fileSize =$_FILES['fileField']['size'];
	$fileError =$_FILES['fileField']['error'];
	$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
	$exploded_name=explode(".",$fileName);
	$file_ext=end($exploded_name);
	if(!$fileTmpLoc)
		{$error_message = "";}
	else if ($fileSize > 6291456) // 6MB
		{$error_message = "Your Image Size Is Too Large. Please Try Another!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName))
		{$error_message = "Please Only Upload JPG, PNG, or GIF Pictures!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if ($fileError==1)
		{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	else
		{$newname= "profile_pic.jpg";
		$newname_thumb= "profile_thumb.jpg";
		$place_file = move_uploaded_file ($fileTmpLoc, "../user_files/user$ids/".$newname);
		if ($place_file!=true)
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";
			unlink ($fileTmpLoc);}
		else 
			{$success_message="Successfully Saved!<br/><br/>";
			include_once "../scripts/image_functions.php";
			// Profile Picture
			$target_file="../user_files/user$ids/$newname";
			$resized_file="../user_files/user$ids/$newname";
			$wmax=260;
			$hmax=8686;
			img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
			// Profile Thumb
			$target_file="../user_files/user$ids/$newname";
			$resized_file="../user_files/user$ids/$newname_thumb";
			$wmax=75;
			$hmax=8686;
			img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
			$target_file="../user_files/user$ids/$newname_thumb";
			$thumbnail="../user_files/user$ids/$newname_thumb";
			$wthumb=75;
			$hthumb=75;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			/* JPEG Thumb
			if (strtolower($file_ext)!=="jpg")
				{$target_file="../user_files/user$ids/$newname";
				$thumbnail="../user_files/user$ids/$newname_thumb";
				convert_to_jpg($target_file,$thumbnail,$file_ext);}*/
			}	
		}
	}
}

// Section For Cover Picture.
if (isset($_POST['parse_var']))
{if ($_POST['parse_var'] == "cover_picture")
	{$fileName =$_FILES['fileField2']['name'];
	$fileTmpLoc =$_FILES['fileField2']['tmp_name'];
	$fileType =$_FILES['fileField2']['type'];
	$fileSize =$_FILES['fileField2']['size'];
	$fileError =$_FILES['fileField2']['error'];
	$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
	$exploded_name=explode(".",$fileName);
	$file_ext=end($exploded_name);
	
	if(!$fileTmpLoc)
		{$error_message = "";}
	else if ($fileSize > (6291456*8)) // 48MB
		{$error_message = "Your Image Size Is Too Large. Please Try Another!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName))
		{$error_message = "Please Only Upload JPG, PNG, or GIF Pictures!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if ($fileError==1)
		{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	else
		{$newname= "cover_pic.jpg";
		$place_file = move_uploaded_file ($fileTmpLoc, "../user_files/user$ids/".$newname);
		if ($place_file!=true)
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";
			unlink ($fileTmpLoc);}
		else 
			{$success_message="Successfully Saved!<br/><br/>";
			include_once "../scripts/image_functions.php";
			// Profile Picture
			$target_file="../user_files/user$ids/$newname";
			$resized_file="../user_files/user$ids/$newname";
			$wmax=1120;
			$hmax=10000;
			img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
			$target_file="../user_files/user$ids/$newname";
			$thumbnail="../user_files/user$ids/$newname";
			$wthumb=1120;
			$hthumb=300;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			/* JPEG Thumb
			if (strtolower($file_ext)!=="jpg")
				{$target_file="../user_files/user$ids/$newname";
				$thumbnail="../user_files/user$ids/$newname_thumb";
				convert_to_jpg($target_file,$thumbnail,$file_ext);}*/
			}	
		}
	}
}

if (isset($_POST['planet_id']))
	{$planet_id=$_POST['planet_id'];}

// Section For Planet Picture.
if (isset($_POST['parse_var']))
{if ($_POST['parse_var'] == "planet_picture")
	{$fileName =$_FILES['fileField']['name'];
	$fileTmpLoc =$_FILES['fileField']['tmp_name'];
	$fileType =$_FILES['fileField']['type'];
	$fileSize =$_FILES['fileField']['size'];
	$fileError =$_FILES['fileField']['error'];
	$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
	$exploded_name=explode(".",$fileName);
	$file_ext=end($exploded_name);
	if(!$fileTmpLoc)
		{$error_message = "";}
	else if ($fileSize > 6291456) // 6MB
		{$error_message = "Your Image Size Is Too Large. Please Try Another!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName))
		{$error_message = "Please Only Upload JPG, PNG, or GIF Pictures!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if ($fileError==1)
		{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	else
		{$newname= "planet_picture.jpg";
		$newname_thumb= "planet_thumb.jpg";
		$newname_cover= "planet_cover.jpg";
		$place_file = move_uploaded_file ($fileTmpLoc, "../planet_files/planet$planet_id/".$newname);
		if ($place_file!=true)
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";
			unlink ($fileTmpLoc);}
		else 
			{$success_message="Successfully Saved!<br/><br/>";
			include_once "../scripts/image_functions.php";
			// Profile Picture
			$target_file="../planet_files/planet$planet_id/$newname";
			$resized_file="../planet_files/planet$planet_id/$newname";
			$wmax=260;
			$hmax=8686;
			img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
			// Planet Cover
			$target_file="../planet_files/planet$planet_id/$newname";
			$resized_file="../planet_files/planet$planet_id/$newname_cover";
			$wmax=170;
			$hmax=8686;
			img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
			$target_file="../planet_files/planet$planet_id/$newname_cover";
			$thumbnail="../planet_files/planet$planet_id/$newname_cover";
			$wthumb=170;
			$hthumb=170;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			// Planet Thumb
			$target_file="../planet_files/planet$planet_id/$newname_cover";
			$resized_file="../planet_files/planet$planet_id/$newname_thumb";
			$wmax=75;
			$hmax=75;
			img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
			/* JPEG Thumb
			if (strtolower($file_ext)!=="jpg")
				{$target_file="../user_files/user$ids/$newname";
				$thumbnail="../user_files/user$ids/$newname_thumb";
				convert_to_jpg($target_file,$thumbnail,$file_ext);}*/
			}	
		}
	}
}

// Section For Planet Cover Picture.
if (isset($_POST['parse_var']))
{if ($_POST['parse_var'] == "planet_cover_picture")
	{$fileName =$_FILES['fileField2']['name'];
	$fileTmpLoc =$_FILES['fileField2']['tmp_name'];
	$fileType =$_FILES['fileField2']['type'];
	$fileSize =$_FILES['fileField2']['size'];
	$fileError =$_FILES['fileField2']['error'];
	$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
	$exploded_name=explode(".",$fileName);
	$file_ext=end($exploded_name);
	
	if(!$fileTmpLoc)
		{$error_message = "";}
	else if ($fileSize > (6291456*8)) // 48MB
		{$error_message = "Your Image Size Is Too Large. Please Try Another!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName))
		{$error_message = "Please Only Upload JPG, PNG, or GIF Pictures!<br/><br/>";
		unlink ($fileTmpLoc);}
	else if ($fileError==1)
		{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	else
		{$newname= "cover_pic.jpg";
		$place_file = move_uploaded_file ($fileTmpLoc, "../planet_files/planet$planet_id/".$newname);
		if ($place_file!=true)
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";
			unlink ($fileTmpLoc);}
		else 
			{$success_message="Successfully Saved!<br/><br/>";
			include_once "../scripts/image_functions.php";
			// Profile Picture
			$target_file="../planet_files/planet$planet_id/$newname";
			$resized_file="../planet_files/planet$planet_id/$newname";
			$wmax=1120;
			$hmax=10000;
			img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
			$target_file="../planet_files/planet$planet_id/$newname";
			$thumbnail="../planet_files/planet$planet_id/$newname";
			$wthumb=1120;
			$hthumb=300;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			/* JPEG Thumb
			if (strtolower($file_ext)!=="jpg")
				{$target_file="../planet_files/planet$planet_id/$newname";
				$thumbnail="../planet_files/planet$planet_id/$newname_thumb";
				convert_to_jpg($target_file,$thumbnail,$file_ext);}*/
			}	
		}
	}
}

$mysql = mysql_query("SELECT firstname,lastname FROM members WHERE id='$ids'");
while($row = mysql_fetch_array($mysql))
	{$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$check_pic="../user_files/user$ids/profile_pic.jpg";
	$default_pic="../user_files/user0/default_profile_pic.png";
	if (file_exists($check_pic)){$user_pic="<img class='profile_image profile_pic' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else{$user_pic="<img class='profile_image profile_pic thumb_background' src='$default_pic#$cacheBuster' width='260px' height='auto'/>";}}
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Settings - <?php echo "$firstname $lastname"; ?></title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_settings.php" media="screen"> 
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
<script type="text/javascript" async>
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var color = "<?php echo $color; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var InteractiveSetting = "../settings/setting_forms.php";
var PageChangerURL = "../scripts/page_changer.php";
</script> 
<script src="settings_javascript.js" type="text/javascript" async></script> 
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow-y:scroll;">
<font>
<div class="side_colors_left"></div>

<div class="body"></div>
<div class="settings_page_body_cover">
<div class="settings_page_body">

<div class="settings_page_left" id="settings_page_left">
	<div class="margin"></div>
    <div class="white_background">
	<?php echo $user_pic;?>
	<br/><br/>
	<a href="#" onclick="return false" onmousedown="javascript:window_1(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button selected_window settings_window_1"><img src="blank.gif" width="1px" height="1px" class="settings_profile"/><span class="settings_side">Profile Settings</span></div></a>
    <!--<a href="#" onclick="return false" onmousedown="javascript:window_2(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button settings_window_2"><img src="blank.gif" width="1px" height="1px" class="settings_circles"/><span class="settings_side">Circles Settings</span></div></a>-->
	<a href="#" onclick="return false" onmousedown="javascript:window_3(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button settings_window_3"><img src="blank.gif" width="1px" height="1px" class="settings_planet"/><span class="settings_side">Planet Settings</span></div></a>
	<!--<a href="#" onclick="return false" onmousedown="javascript:window_4(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button settings_window_4"><img src="blank.gif" width="1px" height="1px" class="settings_economy"/><span class="settings_side">Economy Settings</span></div></a>-->
    <a href="#" onclick="return false" onmousedown="javascript:window_5(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button settings_window_5"><img src="blank.gif" width="1px" height="1px" class="settings_notifications"/><span class="settings_side">Notification Settings</span></div></a>
	<a href="#" onclick="return false" onmousedown="javascript:window_6(<?php echo $ids;?>,<?php echo $id;?>);" class="side_button"><div class="side_button settings_window_6"><img src="blank.gif" width="1px" height="1px" class="settings_security"/><span class="settings_side">Security Settings</span></div></a>
	</div>
    <div class="side_bottom"></div>
</div>

<div class="settings_page_body_left"></div>

<div class="settings_page_right" id="settings_page_right">
<?php
if ((isset($_GET['settings']))AND($_GET['settings']=="planet"))
	{include_once "planet_settings.php";
	echo '<script type="text/javascript">$(".side_button").removeClass("selected_window");
	$(".settings_window_3").toggleClass("selected_window");</script>';}
else if ((isset($_GET['settings']))AND($_GET['settings']=="notification"))
	{include_once "notification_settings.php";
	echo '<script type="text/javascript">$(".side_button").removeClass("selected_window");
	$(".settings_window_5").toggleClass("selected_window");</script>';}
else {include_once "profile_settings.php";}
?>
</div>
<div class="white_background_full">
</div>

</div>
<div class="settings_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>