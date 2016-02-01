<?php 
header("Content-type: text/css; charset: UTF-8"); 
session_start();
include "../config.php";
$id=$_SESSION['id'];
$color=$_SESSION['color'];
if (isset($color))
	{if ($color=="blue")
		{$color1="#295FCC";
		$color1_2="#295FCC";
		$color2="#B4C7ED";
		$color3="#CCD9F3";
		$color4="#E3EAF9";}
	else if ($color=="green")
		{$color1="#36B336";
		$color1_2="#36B336";
		$color2="#B9E4B9";
		$color3="#CFEDCF";
		$color4="#E5F5E5";}
	else if ($color=="yellow")
		{$color1="#E5E517";
		$color1_2="#E5E517";
		$color2="#F6F6AE";
		$color3="#F9F9C8";
		$color4="#FCFCE1";}
	else if ($color=="orange")
		{$color1="#E57E17";
		$color1_2="#E57E17";
		$color2="#F6D2AE";
		$color3="#F9E0C8";
		$color4="#FCEEE1";}
	else if ($color=="red")
		{$color1="#CC2929";
		$color1_2="#CC2929";
		$color2="#EDB4B4";
		$color3="#F3CCCC";
		$color4="#F9E3E3";}
	else if ($color=="purple")
		{$color1="#8836B3";
		$color1_2="#8836B3";
		$color2="#D5B9E4";
		$color3="#E3CFED";
		$color4="#F0E5F5";}
	else if ($color=="brown")
		{$color1="#663D14";
		$color1_2="#663D14";
		$color2="#CABBAD";
		$color3="#DAD1C7";
		$color4="#EBE6E1";}
	else if ($color=="black")
		{$color1="#17171A";
		$color1_2="#2A62CA";
		$color2="#AEAEAF";
		$color3="#C8C8C8";
		$color4="#E1E1E1";}
	else
		{$color1="#2A62CA";
		$color1_2="#295FCC";
		$color2="#B4C7ED";
		$color3="#CCD9F3";
		$color4="#E7EDF8";}
	}
else
	{$color1="#295FCC";
	$color1_2="#295FCC";
	$color2="#B4C7ED";
	$color3="#CCD9F3";
	$color4="#E3EAF8";}

// Cover Picture
$mysql_cover = mysql_query("SELECT cover_picture_ext FROM members WHERE id='$id' LIMIT 1");
while($row = mysql_fetch_array($mysql_cover))
	{$cover_picture_ext = $row['cover_picture_ext'];}

$check_pic="../user_files/user$id/profile_pic.jpg";
$check_pic2="../user_files/user$id/cover_pic.".$cover_picture_ext;
if (file_exists($check_pic2))
	{list($width, $height) = getimagesize($check_pic2);
	$multiplier=1120/$width;
	$height=$multiplier*$height;
	$height_1=$height/2;
	$height_2=$height_1+45;
		if (file_exists($check_pic2))
			{$cover_margin_1="div.cover_margin_1{height:".$height_1."px;display:block;}";
			$cover_margin_2="div.cover_margin_2{height:".$height_1."px;display:block;}";}
		else {$cover_margin_1="";$cover_margin_2="";}
	}
?>  

a{border:none;outline:none;}
<?php echo $cover_margin_1;?>
<?php echo $cover_margin_2;?>

<?php // Profile Layout ?>
a{margin:0px;padding:0px;}
div.cover_image{z-index:5;position:absolute;}
div.float_left{display:inline-block;text-align:left;float:left;}
div.float_right{display:inline-block;text-align:right;float:right;}
div.margin{height:45px;display:block;}
div.profile_page_body{float:left;width:1060px;position:absolute;margin:0px 60px;min-height:100%;}
div.profile_page_body_cover{text-align:left;width:1180px;margin:0 auto;overflow:hidden;}
div.profile_page_body_left{position:fixed;width:30px;margin-left:235px;background:url('../barterrain_main_images/side_shadows.png') -0px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.profile_page_body_right{position:fixed;width:30px;margin-left:1120px;background:url('../barterrain_main_images/side_shadows.png') -30px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.profile_page_left{float:left;text-align:center;width:265px;z-index:6;overflow:hidden;}
div.profile_page_right{float:right;text-align:left;height:100%;width:793px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;position:relative;z-index:3;}
div.profile_page_middle_left{overflow:hidden;text-align:left;float:left;width:490px;padding:19px;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.profile_page_middle_left.expand{overflow:hidden;text-align:left;float:left;width:755px;padding:19px;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.profile_page_middle_right{overflow:hidden;text-align:left;right:right;width:264px;}
div.side_bottom{height:22px;width:100%;float:left;background:url('../barterrain_main_images/side_bottom.png') 0px -0px;}
div.white_background{background-color:#FFFFFF;margin:0px;padding:0px;z-index:-8;}
div.white_background_full{z-index:-8;background-color:#FFFFFF;height:100%;width:793px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.white_background_full2{z-index:-8;background-color:#FFFFFF;height:100%;width:264px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.white_background_full3{z-index:-8;background-color:#FFFFFF;height:100%;width:264px;position:absolute;right:0px;border-left-style:solid;;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.white_background_full4{z-index:-8;background-color:#FFFFFF;height:100%;width:795px;position:absolute;right:0px;}
font.side_header{font-size:22px;font-weight:bold;}
font.color{color:<?php echo $color1; ?>;}
img.cover_image{margin:0px -30px;}
img.profile_image{border-right-style:solid;border-right-width:2px;border-top-style:solid;border-bottom-style:solid;border-left-style:solid;border-width:3px;border-color:<?php echo $color2; ?>;position:relative;z-index:6;}
img.profile_header{width:16px;height:17px;background:url('barterrain_profile_images/profile_images.png') -68px 0px;margin-right:6px;}
img.profile_wall{vertical-align:top;width:15px;height:15px;background:url('barterrain_profile_images/profile_images.png') 0px 0px;}
img.profile_info{width:16px;height:15px;background:url('barterrain_profile_images/profile_images.png') -17px 1px;}
img.profile_media{width:16px;height:15px;background:url('barterrain_profile_images/profile_images.png') -34px 1px;}
img.profile_notes{width:15px;height:16px;background:url('barterrain_profile_images/profile_images.png') 0px -17px;}
img.profile_planets{width:14px;height:14px;background:url('barterrain_profile_images/other_images.png') -71px -63px;}
img.profile_friends{width:14px;height:14px;background:url('barterrain_profile_images/other_images.png') -18px -95px;border:none;}
img.profile_subscriptions{width:15px;height:15px;background:url('barterrain_profile_images/profile_images.png') -34px -17px;}
img.profile_memory_box{width:15px;height:15px;background:url('barterrain_profile_images/profile_images.png') -52px -1px;}
span.heading_list{font:12px helvetica, sans-serif;font-weight:bold;}
span.dot_divider{size:12px;}
span.dot_pagination{font-size:12px;}
span.places{color:#696969;display:block;}

<?php // Profile Block ?>
div.block_background{background-color:<?php echo $color1; ?>;background-image:url('barterrain_profile_images/lines.png');}

<?php // Interactive Box ?>
a.create_choice_pages{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') 0px -53px;}
a.create_choice_pages:hover{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') 0px -136px;}
a.create_choice_groups{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') -119px -53px;}
a.create_choice_groups:hover{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') -119px -136px;}
a.create_choice_events{display:inline-block;margin-right:-4px;margin-right:-3px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') -238px -53px;}
a.create_choice_events:hover{display:inline-block;margin-right:-4px;margin-right:-3px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') -238px -136px;}
a.create_choice_shops{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') -357px -53px;}
a.create_choice_shops:hover{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('barterrain_profile_images/post_field2.png') -357px -136px;}
a.top_box1{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') 0px 0px;margin:0px;padding:0px;background-color:<?php echo $color4; ?>;}
a.top_box1.selected_box{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') 0px -27px;margin:0px;padding:0px;background-color:<?php echo $color2; ?>;}
a.top_box2{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -200px 0px;margin:0px;padding:0px;background-color:<?php echo $color4; ?>;}
a.top_box2.selected_box{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -200px -27px;margin:0px;padding:0px;background-color:<?php echo $color2; ?>;}
a.top_box3{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -300px 0px;margin:0px;padding:0px;background-color:<?php echo $color4; ?>;}
a.top_box3.selected_box{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -300px -27px;margin:0px;padding:0px;background-color:<?php echo $color2; ?>;}
a.top_box4{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -400px 0px;margin:0px;padding:0px;background-color:<?php echo $color4; ?>;}
a.top_box4.selected_box{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -400px -27px;margin:0px;padding:0px;background-color:<?php echo $color2; ?>;}
a.top_box5{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -100px 0px;margin:0px;padding:0px;background-color:<?php echo $color4; ?>;}
a.top_box5.selected_box{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') -100px -27px;margin:0px;padding:0px;background-color:<?php echo $color2; ?>;}
a.post1{float:left;width:50px;height:25px;background:url('../barterrain_main_images/post_field.png') -100px -54px;background-color:<?php echo $color2; ?>;}
a.post2{float:left;width:50px;height:25px;background:url('../barterrain_main_images/post_field.png') -152px -54px;background-color:<?php echo $color4; ?>;}
div.post_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.post_box2{vertical-align:top;float:left;text-align:left;width:417px;color:#000000;padding-bottom:2px;overflow:hidden;}
div.post_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;}
div.post_box{padding:6px;border-bottom:solid 1px #DDDDDD;float:left;}
div.bottom_wall{text-align:left;width:100%;}
div.expand_bottom_wall{text-align:left;width:100%;margin-top:19px;float:left;}
div.bottom_box_input{text-align:left;height:25px;width:100%;background-color:<?php echo $color2; ?>;display:block;}
div.bottom_box_input1{float:left;height:22px;width:266px;background-color:<?php echo $color2; ?>;display:block;padding-top:3px;}
div.bottom_box_input2{float:right;height:25px;width:60px;background-color:<?php echo $color2; ?>;display:block;}
div.bottom_box_input3{float:right;height:25px;width:76px;background-color:<?php echo $color2; ?>;display:block;}
div.top_wall{text-align:left;width:100%;}
div.wall_body{width:100%;}
div.bottom_half_box{border:solid 1px <?php echo $color4; ?>;background-color:<?php echo $color4; ?>;padding:6px;}
div.top_half_box{height:25px;}
div.bottom_half_box2{border:solid 1px <?php echo $color2; ?>;background-color:<?php echo $color2; ?>;padding:6px;padding-bottom:0px;}
div.bottom_half_box3{border:solid 1px <?php echo $color2; ?>;background-color:<?php echo $color2; ?>;padding:6px;}
div.upload_files1{z-index:5;margin-bottom:6px;width:100%;height:24px;overflow:hidden;position:relative;display:block;background:url('../barterrain_main_images/input_file.png') 0px 0px;background-color:#FFFFFF;}
div.upload_files2{z-index:5;width:100%;height:24px;overflow:hidden;position:relative;display:block;background:url('../barterrain_main_images/input_file.png') 0px -24px;background-color:#FFFFFF;}
div.upload_files5{z-index:5;margin-bottom:6px;width:100%;height:24px;overflow:hidden;position:relative;display:block;background:url('../barterrain_main_images/input_file.png') 0px -24px;background-color:#FFFFFF;}
div.upload_files3{z-index:5;width:100%;height:24px;overflow:hidden;position:relative;display:block;background:url('../barterrain_main_images/input_file.png') 0px -48px;background-color:#FFFFFF;}
div.upload_files4{z-index:5;margin-bottom:6px;width:100%;height:24px;overflow:hidden;position:relative;display:block;background:url('../barterrain_main_images/input_file.png') 0px -72px;background-color:#FFFFFF;}
div.fakeupload {position:absolute;z-index:10;padding-left:5px;padding-top:6px;width:360px;height:12px;overflow:hidden;}
form{margin:0px;padding:0px;}
img.create_button{width:76px;height:25px;background:url('../barterrain_main_images/post_field.png') -262px -54px;}
img.loader{height:15px;}
img.upload_button{width:76px;height:25px;background:url('../barterrain_main_images/post_field.png') -184px -54px;}
input.create_field{padding-left:5px;width:468px;height:24px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;margin-bottom:5px;}
input.note_field{padding-left:5px;width:468px;height:24px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;margin-bottom:5px;}
input.upload_field{padding-left:5px;width:468px;height:24px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;margin-bottom:5px;}
input.message_field{padding-left:5px;width:468px;height:24px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;margin-bottom:5px;}
input.post_button{width:60px;height:25px;background:url('../barterrain_main_images/post_field.png') 0px -54px;}
input.note_button{width:60px;height:25px;background:url('../barterrain_main_images/post_field.png') -61px -54px;}
input.message_button{width:60px;height:25px;background:url('../barterrain_main_images/post_field.png') -122px -54px;}
input.top_box_input{padding-left:5px;width:468px;font:12px helvetica, sans-serif;height:24px;border:1px solid #DDDDDD;}
input.upload_files2{z-index:2;padding-left:5px;display:block;width:100%;height:24px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;opacity:0;filter:alpha(opacity=0);-moz-opacity:0;-ms-filter:"alpha(opacity=0)";cursor:pointer;_cursor:hand;}
input.upload_files{z-index:2;padding-left:5px;display:block;width:100%;height:24px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;margin-bottom:6px;opacity:0;filter:alpha(opacity=0);-moz-opacity:0;-ms-filter:"alpha(opacity=0)";cursor:pointer;_cursor:hand;}
span.post{font:12px helvetica, sans-serif;width:100%;display:block;padding:2px 0px;}
textarea{margin:0px;padding:0px;}
textarea.create_field{resize:vertical;padding-left:5px;padding-top:6px;width:469px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;}
textarea.post_field{resize:vertical;padding-left:5px;padding-top:6px;margin-bottom:-3px;min-height:76px;width:469px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;}
textarea.note_field{resize:vertical;padding-left:5px;padding-top:6px;margin-bottom:-3px;min-height:43px;width:469px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;}
textarea.upload_field{resize:vertical;padding-left:5px;padding-top:6px;margin-top:1px;margin-bottom:3px;width:469px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;}
textarea.message_field{resize:vertical;padding-left:5px;padding-top:6px;margin-top:1px;margin-bottom:-3px;min-height:50px;width:469px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;}

<?php // Right Top ?>
#right_inside_menu {z-index:-6;text-align:center;display:none;margin:0px;border-top:none;border:solid 1px #000000;padding:5px;width:215px;background:#FFFFFF;margin-top:-1px;}
a.right_top{display:inline-block;vertical-align:top;margin-right:2px;}
a.right_inside_button:link{vertical-align:top;display:inline-block;width:31px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -196px 0px;}
a.right_inside_button:visited{vertical-align:top;display:inline-block;width:31px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -196px 0px;}
a.right_inside_button:hover{vertical-align:top;display:inline-block;width:31px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -196px -27px;}
a.right_inside_button:active{vertical-align:top;display:inline-block;width:31px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -196px -27px;}
a.right_inside_button.right_inside_open{vertical-align:top;display:inline-block;width:31px;height:31px;background:url('barterrain_profile_images/right_inside.jpg') -196px -54px;}
div.interact_message{text-align:center;display:block;width:265px;padding-top:2px;margin-bottom:-2px;}
div.right_top_box{text-align:left;margin:17px 19px;display:inline-block;width:300px;}
div.right_inside_open a:link{z-index:-6;display:block;font-size:12px;padding:3px;background:#FFFFFF;color:#000000;text-decoration:none;}
div.right_inside_open a:visited{z-index:-6;display:block;font-size:12px;padding:3px;background:#FFFFFF;color:#000000;text-decoration:none;}
div.right_inside_open a:hover{z-index:-6;display:block;font-size:12px;padding:3px;background:#DDDDDD;color:#000000;text-decoration:none;}
div.right_inside_open a:active{z-index:-6;display:block;font-size:12px;padding:3px;background:#DDDDDD;color:#000000;text-decoration:none;}
form.right_top{display:inline;}
img.right_inside1{vertical-align:top;float:left;margin-right:5px;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') 0px 0px;}
img.right_inside2{vertical-align:top;float:left;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -98px 0px;}
img.right_inside2:visited{vertical-align:top;float:left;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -98px 0px;}
img.right_inside2:hover{vertical-align:top;float:left;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -98px -27px;}
img.right_inside2:active{vertical-align:top;float:left;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -98px -27px;}
img.right_inside3{vertical-align:top;float:left;margin-right:5px;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') 0px -27px;}
img.right_inside4{vertical-align:top;float:left;margin-right:5px;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') 0px -54px;}
img.right_inside5{vertical-align:top;float:left;margin-right:5px;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -85px -54px;}
img.right_inside6{vertical-align:top;float:left;margin-right:5px;width:93px;height:25px;background:url('barterrain_profile_images/right_inside.jpg') -98px -54px;}
img.right_outside1{vertical-align:top;float:left;margin-right:5px;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') 0px 0px;}
img.right_outside1:hover{vertical-align:top;float:left;margin-right:5px;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') 0px -27px;}
img.right_outside1:active{vertical-align:top;float:left;margin-right:5px;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') 0px -27px;}
img.right_outside2{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -116px 0px;}
img.right_outside2:hover{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -232px -27px;}
img.right_outside2:active{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -232px -27px;}
img.right_outside2{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -116px 0px;}
img.right_outside2:hover{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -232px -27px;}
img.right_outside2:active{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -232px -27px;}
img.right_outside3{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -232px 0px;}
img.right_outside3:hover{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -116px -27px;}
img.right_outside3:active{vertical-align:top;float:left;width:111px;height:25px;background:url('barterrain_profile_images/right_outside.jpg') -116px -27px;}

<?php // Interactive Comments ?>
div.comment_box{float:left;border:solid 1px <?php echo $color4; ?>;background-color:<?php echo $color4; ?>;padding:6px;width:403px;}
div.comment_list{width:411px;background-color:<?php echo $color4; ?>;float:left;vertical-align:top;padding:3px;border-bottom:solid 1px #E5E5E5;overflow:hidden;}
div.comment_1{vertical-align:top;float:left;margin:0px;width:45px;padding-right:6px;}
div.comment_2{vertical-align:top;float:right;margin:0px;width:360px;}
div.comment_space{padding-bottom:6px;}
div.comment_top_options{position:absolute;float:right;right:3px;}
div.expand_comment{float:left;background-color:<?php echo $color4; ?>;width:417px;text-align:center;padding-bottom:2px;color:#696969;}
div.expand_comment:hover{float:left;background-color:<?php echo $color4_2; ?>;width:417px;text-align:center;padding-bottom:2px;color:#696969;}
div.delete_comment{width:15px;float:right;}
input.comment_field{padding:3px 4px;width:393px;font:12px helvetica, sans-serif;border:1px solid #DDDDDD;}
span.expand_bottom_box{font:12px helvetica, sans-serif;padding:0px;margin:0px;}
span.comment{display:block;color:#000000;}

<?php // Interactive Contents ?>
a.bff_type_1{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -48px 0px;background-color:<?php echo $color1; ?>;}
a.bff_type1{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -48px 0px;background-color:<?php echo $color1; ?>;}
a.bff_type1:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -64px 0px;background-color:<?php echo $color1; ?>;}
a.bff_type_2{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -48px -16px;background-color:<?php echo $color1; ?>;}
a.bff_type2{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -48px -16px;background-color:<?php echo $color1; ?>;}
a.bff_type2:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -64px -16px;background-color:<?php echo $color1; ?>;}
a.bff_type_3{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -48px -32px;background-color:<?php echo $color1; ?>;}
a.bff_type3{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -48px -32px;background-color:<?php echo $color1; ?>;}
a.bff_type3:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -64px -32px;background-color:<?php echo $color1; ?>;}
a.bff_type_12{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -48px 0px;background-color:<?php echo $color1; ?>;}
a.bff_type12{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -48px 0px;background-color:<?php echo $color1; ?>;}
a.bff_type12:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -64px 0px;background-color:<?php echo $color1; ?>;}
a.bff_type_22{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -48px -16px;background-color:<?php echo $color1; ?>;}
a.bff_type22{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -48px -16px;background-color:<?php echo $color1; ?>;}
a.bff_type22:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -64px -16px;background-color:<?php echo $color1; ?>;}
a.bff_type_32{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -48px -32px;background-color:<?php echo $color1; ?>;}
a.bff_type32{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -48px -32px;background-color:<?php echo $color1; ?>;}
a.bff_type32:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons2.png') -64px -32px;background-color:<?php echo $color1; ?>;}
a.delete0{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') 0px 0px;background-color:<?php echo $color1; ?>;}
a.delete0:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') 0px -16px;background-color:<?php echo $color1; ?>;}
a.delete1{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') 0px -16px;background-color:<?php echo $color1; ?>;}
a.delete2{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') 0px -32px;background-color:<?php echo $color1; ?>;}
a.point{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -96px -16px;background-color:<?php echo $color1; ?>;}
a.point0{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -96px -0px;background-color:<?php echo $color1; ?>;}
a.point1{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -96px -0px;background-color:<?php echo $color1; ?>;}
a.point1:hover{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -96px -16px;background-color:<?php echo $color1; ?>;}
a.point2{float:left;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -96px -32px;background-color:<?php echo $color1; ?>;}
a.mm_box1{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -80px 0px;background-color:<?php echo $color1; ?>;}
a.mm_box1:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -80px -16px;background-color:<?php echo $color1; ?>;}
a.mm_box2{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') -80px -32px;background-color:<?php echo $color1; ?>;}
a.top_options_delete1{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') 0px 0px;background-color:<?php echo $color1; ?>;}
a.top_options_delete2{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') 0px -32px;background-color:<?php echo $color1; ?>;}
a.top_options_delete1:hover{display:inline-block;width:15px;height:15px;background:url('../barterrain_main_images/option_buttons.png') 0px -16px;background-color:<?php echo $color1; ?>;}
b.point{float:left;vertical-align:top;min-width:9px;padding:0px 3px;text-align:center;color:#666666;margin-top:1px;}
b.point2{float:left;vertical-align:top;min-width:9px;padding:0px 3px;text-align:center;color:#dd4a4a;margin-top:1px;}
b.point3{float:left;vertical-align:top;min-width:9pxpadding:0px 3px;;text-align:center;color:<?php echo $color1_2; ?>;margin-top:1px;}
b.point3{float:left;vertical-align:top;min-width:9px;padding:0px 3px;text-align:center;color:<?php echo $color1_2; ?>;margin-top:1px;}
b.point3:hover{float:left;vertical-align:top;min-width:9px;padding:0px 3px;text-align:center;color:<?php echo $color1_2; ?>;margin-top:1px;text-decoration:underline;}
b.point3:active{float:left;vertical-align:top;min-width:9px;padding:0px 3px;text-align:center;color:<?php echo $color1_2; ?>;margin-top:1px;text-decoration:underline;}
div.block{display:block;width:417px;}
div.back_wall{padding:6px;border-bottom:solid 1px #DDDDDD;text-align:center;}
div.hide_div{display:none;}
div.inline{display:inline-block;}
div.just_line{border-bottom:solid 1px #DDDDDD;}
div.like_love{float:left;position:relative;height:13px;}
div.option_box{width:15px;float:left;}
div.option_box2{float:left;vertical-align:top;}
div.option_box_wrap{position:absolute;right:0px;text-align:right;}
div.top_options{float:right;text-align:right;padding-top:3px;padding-bottom:3px;padding-right:3px;}
img.like_count{padding:0px;margin:0px;vertical-align:middle;width:11px;height:11px;background:url('../barterrain_main_images/like_love.png') -13px 0px;}
img.love_count{padding:0px;margin:0px;vertical-align:middle;width:11px;height:11px;background:url('../barterrain_main_images/like_love.png') 0px 0px;}

<?php // Bars ?>
div.left_side_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:252px;margin-top:5px;}
div.middle_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:478px;}
div.right_side_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;margin-top:3px;width:253px;}
div.under_side_bars{text-align:left;display:inline-block;}

<?php // Display Lists ?>
img.likes_lists{vertical-align:top;margin-right:5px;width:10px;height:11px;background:url('../barterrain_main_images/like_love.png') -14px -0px;border:none;}
img.loves_lists{vertical-align:top;margin-right:6px;width:11px;height:11px;background:url('../barterrain_main_images/like_love.png') -0px -0px;border:none;}
img.points_lists{vertical-align:top;margin-right:6px;width:12px;height:13px;background:url('barterrain_profile_images/other_images.png') -70px -18px;border:none;}
img.mutual_friends_bar{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_profile_images/other_images.png') -32px -32px;border:none;}
img.requests_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_profile_images/other_images.png') -0px -48px;border:none;}
img.friends_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_profile_images/profile_images.png') -18px -18px;border:none;}
img.family_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_profile_images/other_images.png') -52px -1px;border:none;}
img.general_info_bar{vertical-align:top;margin-right:6px;width:15px;height:13px;background:url('barterrain_profile_images/profile_images.png') -17px -2px;border:none;}
img.pages_lists{vertical-align:top;margin-right:6px;width:15px;height:14px;background:url('barterrain_profile_images/other_images.png')  0px -18px;border:none;}
img.groups_lists{vertical-align:top;margin-right:6px;width:15px;height:14px;background:url('barterrain_profile_images/other_images.png') -17px -18px;border:none;}
img.events_lists{vertical-align:top;margin-right:6px;width:15px;height:14px;background:url('barterrain_profile_images/other_images.png') -69px -1px;border:none;}
img.shops_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_profile_images/other_images.png') -52px -18px;border:none;}
img.albums_lists{vertical-align:top;margin-right:6px;width:16px;height:14px;background:url('barterrain_profile_images/other_images.png') -34px -1px;border:none;}
img.videos_lists{vertical-align:top;margin-right:6px;width:15px;height:13px;background:url('barterrain_profile_images/other_images.png') -16px -33px;border:none;}
img.games_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_profile_images/other_images.png') -1px -33px;border:none;}
img.subscribers_lists{vertical-align:top;margin-right:6px;width:18px;height:13px;background:url('barterrain_profile_images/other_images.png') -47px -33px;border:none;}
img.subscriptions_lists{vertical-align:top;margin-right:6px;width:18px;height:13px;background:url('barterrain_profile_images/other_images.png') -66px -33px;border:none;}
img.subscriptions_activity_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_profile_images/other_images.png') -35px -18px;border:none;}
img.information_bar{vertical-align:top;margin-right:6px;width:10px;height:14px;background:url('barterrain_profile_images/other_images.png') -58px -64px;border:none;}
img.planets_lists{vertical-align:top;margin-right:6px;width:13px;height:14px;background:url('barterrain_profile_images/other_images.png') -71px -64px;border:none;}
img.planets_colonized_lists{vertical-align:top;margin-right:6px;width:13px;height:14px;background:url('barterrain_profile_images/other_images.png') -57px -64px;border:none;}
img.mutual_friends_planet{vertical-align:top;margin-right:6px;width:17px;height:14px;background:url('barterrain_profile_images/inside_images.png') -0px -80px;border:none;}
img.planet_info_bar{vertical-align:top;margin-right:6px;width:22px;height:14px;background:url('barterrain_profile_images/other_images.png') -41px -80px;border:none;}
img.profile_info_bar{vertical-align:top;margin-right:6px;width:19px;height:14px;background:url('barterrain_profile_images/other_images.png') -19px -80px;border:none;}
img.friends_activity_lists{vertical-align:top;margin-right:6px;width:14px;height:14px;background:url('barterrain_profile_images/other_images.png') -18px -95px;border:none;}

<?php // Info ?>
div.info_body{width:100%;}
div.info_box{padding:6px;border-bottom:solid 1px <?php echo $color4; ?>;overflow:hidden;}
div.info_box1{vertical-align:top;display:inline-block;text-align:left;width:136px;}
div.info_box2{vertical-align:top;display:inline-block;text-align:left;width:338px;color:#696969;}
div.info_box3{vertical-align:top;display:inline-block;text-align:left;width:100px;color:#696969;}
div.bottom_info{text-align:center;width:100%;}

<?php // Creates ?>
div.create_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.create_box12{vertical-align:top;float:left;text-align:left;width:66px;padding-right:6px;}
div.create_box2{vertical-align:bottom;text-align:left;width:335px;color:#000000;padding-bottom:2px;}
div.create_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;overflow:hidden;}
div.create_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;overflow:hidden;}
div.list_wrap_1{float:left;width:55px;margin:0px;padding:0px;padding-right:3px;}
div.list_wrap_2{overflow:hidden;vertical-align:top;text-align:left;display:inline-block;margin:0px;padding-left:3px;padding-top:3px;width:189px;}
div.list_wrap_3{overflow:hidden;vertical-align:top;text-align:left;display:inline-block;margin:0px;padding-left:3px;padding-top:3px;width:158px;}
div.list_wrap{text-align:left;overflow:hidden;padding:6px;padding-bottom:0px;}
div.list_wrap2{vertical-align:top;display:inline-block;text-align:left;overflow:hidden;padding:6px;padding-bottom:6px;width:221px;margin:0px 6px;border-bottom:1px solid #DDDDDD;}

<?php // Right Side Ad ?>
div.big_list_wrap_1{float:left;width:270px;margin:0px;padding:0px;padding-right:3px;}
div.big_list_wrap_2{overflow:hidden;vertical-align:top;text-align:left;display:inline-block;margin:0px;padding-left:3px;padding-top:3px;width:189px;}
div.big_list_wrap_3{overflow:hidden;vertical-align:top;text-align:left;display:inline-block;margin:0px;padding-left:3px;padding-top:3px;width:158px;}
div.big_list_wrap{text-align:left;overflow:hidden;padding:6px;padding-bottom:0px;}
div.big_list_wrap2{vertical-align:top;display:inline-block;text-align:left;overflow:hidden;padding:6px;padding-bottom:6px;width:221px;margin:0px 6px;border-bottom:1px solid #DDDDDD;}

<?php // Uploads ?>
a.album_tab1{float:left;width:72px;height:25px;background:url('barterrain_inside_images/post_field2.jpg') 0px -0px;}
a.album_tab1.selected_box{float:left;width:72px;height:25px;background:url('barterrain_inside_images/post_field2.jpg') 0px -27px;}
a.album_tab2{float:left;width:72px;height:25px;background:url('barterrain_inside_images/post_field2.jpg') -72px -0px;}
a.album_tab2.selected_box{float:left;width:72px;height:25px;background:url('barterrain_inside_images/post_field2.jpg') -72px -27px;}
a.album_tab3{float:left;width:100px;height:25px;background:url('barterrain_inside_images/post_field2.jpg') -145px -0px;}
a.album_tab3.selected_box{float:left;width:100px;height:25px;background:url('barterrain_inside_images/post_field2.jpg') -145px -27px;}
a.upload_choice_images{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') 0px -82px;}
a.upload_choice_images:hover{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') 0px -165px;}
a.upload_choice_videos{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') -119px -82px;}
a.upload_choice_videos:hover{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') -119px -165px;}
a.upload_choice_gifs{display:inline-block;margin-right:-4px;margin-right:-3px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') -238px -82px;}
a.upload_choice_gifs:hover{display:inline-block;margin-right:-4px;margin-right:-3px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') -238px -165px;}
a.upload_choice_games{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') -357px -82px;}
a.upload_choice_games:hover{display:inline-block;margin-right:-4px;width:119px;height:100px;background:url('../barterrain_main_images/post_field.png') -357px -165px;}
div.album_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:743px;}
div.album_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.album_box21{vertical-align:top;float:left;text-align:left;width:130px;padding-right:6px;color:#000000;}
div.album_box22{vertical-align:top;float:right;text-align:left;width:279px;color:#000000;}
div.album_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;background-color:#FFFFFF;overflow:hidden;}
div.album_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;}
div.album_images{padding:0px 1px;}
div.bottom_middle_profile{text-align:left;width:100%;}
div.folder_pic{float:left;width:213px;padding:0px 3px;height:213px;text-align:center;}
div.folder_pic2{float:left;width:213px;padding:0px 3px;height:125px;text-align:center;}
div.game_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.game_box21{vertical-align:top;float:left;text-align:left;width:130px;padding-right:6px;color:#000000;}
div.game_box22{vertical-align:top;float:right;text-align:left;width:279px;color:#000000;}
div.game_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;background-color:#FFFFFF;overflow:hidden;}
div.game_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;}
div.image_box{position:relative;vertical-align:top;float:left;margin:5px 5px;margin-right:8px;border-bottom:solid 1px #DDDDDD;width:176px;height:212px;overflow:hidden;}
div.image_box1{float:left;border:solid 1px #DDDDDD;width:174px;height:192px;overflow:hidden;}
div.image_box_wrap{position:relative;vertical-align:top;float:left;width:780px;overflow:hidden;}
div.image_pic{padding:0px 3px;width:168px;height:168px;}
div.image_ll{float:left;position:relative;height:13px;margin-top:2px;}
div.image_ll_wrap{position:relative;float:left;text-align:left;width:176px;padding-left:6px;}
div.images_walls_box{float:left;padding:6px;width:478px;overflow:hidden;border-bottom:solid 1px #DDDDDD;}
div.images_walls_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.images_walls_box2{position:relative;vertical-align:top;float:left;text-align:left;width:410px;padding-right:6px;}
div.images_walls_box3{position:relative;vertical-align:top;float:left;text-align:left;width:430px;padding-right:6px;}
div.images_walls_box4{position:relative;vertical-align:top;float:left;text-align:left;width:300px;padding-right:6px;margin-bottom:6px;overflow:hidden;}
div.top_images{margin:10px 0px;float:left;height:100%;}
div.top_images_left{margin-top:25px;margin-right:19px;float:left;height:100%;}
div.top_images_right{float:right;height:100%;width:244px;}
div.top_images_box{float:left;border:solid 3px <?php echo $color2; ?>;width:238px;height:100%;}
div.upload_box{display:inline-block;padding:6px;padding-bottom:3px;margin:0px 6px;border-bottom:solid 1px #DDDDDD;width:221px;overflow:hidden;}
div.upload_box1{float:left;width:219px;height:237px;border:solid 1px #DDDDDD;}
div.upload_box5{float:left;width:219px;height:149px;border:solid 1px #DDDDDD;}
div.upload_box2{float:left;width:215px;padding-left:6px;overflow:hidden;padding-top:3px;}
div.upload_box3{position:relative;float:left;text-align:left;width:215px;padding-left:6px;}
div.upload_box4{position:relative;float:left;width:109px;padding-left:6px;padding-top:3px;}
div.video_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.video_box21{vertical-align:top;float:left;text-align:left;width:417px;padding-right:6px;color:#000000;margin-top:6px;margin-bottom:6px;}
div.video_box22{vertical-align:top;float:left;text-align:left;width:300px;color:#000000;}
div.video_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;background-color:#FFFFFF;overflow:hidden;}
div.video_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;}
div.video_screen{width:417px;}
img.black_gif{position:absolute;float:left;margin:1px;padding:0px;text-align:center;}
img.images_walls{margin:6px;margin-top:0px;margin-left:0px;float:left;border:solid 1px #DDDDDD;}
select.select_choice{padding-left:5px;margin-bottom:6px;width:100%;font:12px helvetica, sans-serif;color:#808080;}
select.select_choice2{float:left;margin-right:3px;padding-left:5px;margin-bottom:6px;width:93px;font:12px helvetica, sans-serif;color:#808080;}
select.select_choice3{float:left;padding-left:5px;margin-bottom:6px;width:92px;font:12px helvetica, sans-serif;color:#808080;}
span.black_gif{font-size:50px;color:white;}
span.image_count{font:11px helvetica, sans-serif;color:#696969;}
span.top_folder_text{font:12px helvetica, sans-serif;color:#696969;}
table.black_gif{position:absolute;float:left;margin:1px;padding:0px;text-align:center;}
video.video_screen{width:417px;}

<?php // Notes ?>
div.note_body{width:100%;}
div.note_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;}
div.none{padding:8px;border-bottom:solid 1px #DDDDDD;text-align:center;}
div.note_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.note_box2{vertical-align:top;display:inline-block;text-align:left;width:417px;color:#000000;padding-bottom:2px;overflow:hidden;}
div.note_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;}

<?php // Friends ?>
div.friends_body{width:100%;text-align:center;}
div.friends_box{padding:6px;border-bottom:solid 1px #DDDDDD;overflow:hidden;display:inline-block;width:478px;}
div.requests_box{padding:18px 6px;border-bottom:solid 1px #DDDDDD;overflow:hidden;float:left;width:478px;}
div.friends_box1{vertical-align:top;float:left;text-align:left;width:75px;padding-right:6px;}
div.friends_box2{vertical-align:top;float:right;text-align:left;width:394px;color:#696969;padding-top:7px;}
div.friends_box3{padding:6px;padding-right:0px;border-bottom:solid 1px #DDDDDD;overflow:hidden;width:227px;display:inline-block;margin:0px 6px;}
div.under_middle_friends{width:490px;text-align:left;}
div.middle_wrap_1{overflow:hidden;vertical-align:top;float:left;width:60px;padding-right:6px;}
div.middle_wrap_2{overflow:hidden;vertical-align:top;text-align:left;float:left;width:158px;margin-top:8px;}
span.text{color:#000000;display:inline-block;}

<?php // View Media ?>
div.entire_bottom_media{width:755px;overflow:hidden;z-index:-10000;background-color:#FFFFFF;border-top:19px solid #FFFFFF;margin-top:-19px;}
div.entire_bottom_media_album{width:753px;overflow:hidden;z-index:-10000;background-color:#FFFFFF;border:1px solid #DDDDDD;margin:5px 0px;}
div.folder_content_left{width:490px;float:left;margin-top:6px;}
div.folder_content_right{width:253px;float:right;margin-top:6px;}
div.media_post_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;}
div.media_post_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.media_post_box2{vertical-align:top;display:inline-block;text-align:left;width:417px;color:#000000;padding-bottom:2px;}
div.media_post_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;}
div.middle_bars_full{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:743px;}
div.none{padding:8px;border-bottom:solid 1px #DDDDDD;text-align:center;}
div.option_box_wrap2{position:relative;float:right;right:0px;top:3px;text-align:right;}
div.video_screen_big{width:755px;margin:5px 0px;}
font.media_header{font-size:14px;font-weight:bold;}
video.video_screen_big{width:755px;}

<?php // Media Posts ?>
div.media_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;}
div.media_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.media_box2{vertical-align:top;display:inline-block;text-align:left;width:417px;color:#000000;padding-bottom:2px;}
div.media_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;}

<?php // View Images ?>
a.image_top_box1{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') 0px 0px;margin:0px;padding:0px;background-color:<?php echo $color4; ?>;}
a.image_top_box1.selected_box{float:left;width:98px;height:25px;background:url('../barterrain_main_images/post_field.png') 0px -27px;margin:0px;padding:0px;background-color:<?php echo $color2; ?>;}
div.display_image_left{float:left;background-color:#000000;height:100%;width:589px;overflow:hidden;}
div.display_image_right{float:right;width:490px;padding:19px;}
div.display_image_top{position:absolute;background-color:white;padding:6px;padding-bottom:5px;width:578px;}
div.display_image_bottom{position:absolute;background-color:white;padding:6px;width:578px;bottom:0px;height:13px;text-align:left;}
div.images_bottom_posts{overflow:auto;overflow-x:hidden;height:422px;}
div.images_bottom_posts.selected_box{overflow:auto;overflow-x:hidden;height:343px;}
div.images_bottom_posts.error_box{overflow:auto;overflow-x:hidden;height:315px;}
div.option_box_wrap3{position:absolute;right:0px;margin-top:-1px;text-align:right;}
