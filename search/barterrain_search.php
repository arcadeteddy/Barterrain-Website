<?php 
header("Content-type: text/css; charset: UTF-8"); 
session_start();
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
?>  

<?php // Search Layout ?>
a{margin:0px;padding:0px;}
div.cover_image{z-index:5;position:absolute;}
div.float_left{display:inline-block;text-align:left;float:left;}
div.float_right{display:inline-block;text-align:right;float:right;}
div.hide_div{display:none;}
div.margin{height:45px;display:block;}
div.search_page_body{float:left;width:1060px;position:absolute;margin:0px 60px;min-height:100%;}
div.search_page_body_cover{text-align:left;width:1180px;margin:0 auto;overflow:hidden;}
div.search_page_body_left{position:fixed;width:30px;margin-left:235px;background:url('../barterrain_main_images/side_shadows.png') -0px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.search_page_body_right{position:fixed;width:30px;margin-left:1120px;background:url('../barterrain_main_images/side_shadows.png') -30px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.search_page_left{float:left;text-align:center;width:265px;z-index:6;overflow:hidden;}
div.search_page_right{float:right;text-align:left;height:100%;width:793px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;position:relative;z-index:3;}
div.search_page_middle_left{overflow:hidden;text-align:left;float:left;width:490px;padding:19px;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.search_page_middle_left.expand{overflow:hidden;text-align:left;float:left;width:763px;padding:19px;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.search_page_middle_right{overflow:hidden;text-align:left;right:right;width:264px;}
div.side_bottom{height:22px;width:100%;float:left;background:url('../barterrain_main_images/side_bottom.png') 0px -0px;}
div.white_background{background-color:#FFFFFF;margin:0px;padding:0px;z-index:-8;}
div.white_background_full{z-index:-8;background-color:#FFFFFF;height:100%;width:793px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.white_background_full2{z-index:-8;background-color:#FFFFFF;height:100%;width:264px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
font.color{color:<?php echo $color1; ?>;}
font.side_header{font-size:22px;font-weight:bold;}
img.cover_image{margin:0px -30px;}
img.search_image{border-right-style:solid;border-right-width:2px;border-top-style:solid;border-bottom-style:solid;border-left-style:solid;border-width:3px;border-color:<?php echo $color2; ?>;position:relative;z-index:6;}
img.search_profiles{outline:0px;width:12px;height:14px;background:url('barterrain_search_images/search_images.png') -32px -95px;}
img.search_planets{outline:0px;width:13px;height:14px;background:url('barterrain_search_images/search_images.png') -71px -63px;}
img.search_profiles_profiles{outline:0px;width:14px;height:14px;background:url('barterrain_search_images/search_images.png') -15px -48px;}
img.search_profiles_posts{width:12px;height:14px;background:url('barterrain_search_images/search_images.png') -46px -94px;}
img.search_profiles_albums{width:17px;height:14px;background:url('barterrain_search_images/search_images.png') -34px 0px;}
img.search_profiles_games{width:13px;height:13px;background:url('barterrain_search_images/search_images.png') -1px -33px;}
img.search_profiles_videos{width:13px;height:13px;background:url('barterrain_search_images/search_images.png') -18px -32px;}
img.search_profiles_notes{width:14px;height:14px;background:url('barterrain_search_images/search_images.png') -70px -48px;}
img.search_planets_planets{outline:0px;width:14px;height:14px;background:url('barterrain_search_images/search_images.png') -71px -63px;;}
img.search_planets_posts{width:12px;height:14px;background:url('barterrain_search_images/search_images.png')  -46px -94px;}
img.search_planets_albums{width:17px;height:14px;background:url('barterrain_search_images/search_images.png') -34px 0px;}
img.search_planets_games{width:13px;height:13px;background:url('barterrain_search_images/search_images.png') -1px -33px;}
img.search_planets_videos{width:13px;height:13px;background:url('barterrain_search_images/search_images.png') -18px -32px;}
img.search_planets_notes{width:14px;height:14px;background:url('barterrain_search_images/search_images.png') -70px -48px;}
span.heading_list{font:12px helvetica, sans-serif;font-weight:bold;}
span.dot_divider{color:#696969;size:12px;}
span.dot_pagination{font-size:12px;}
span.places{color:#696969;display:block;}

<?php // Bars ?>
div.left_side_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:253px;margin-top:5px;}
div.middle_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:478px;}
div.right_side_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;margin-top:3px;width:253px;}
div.under_side_bars{text-align:left;display:inline-block;}

<?php // Display Lists ?>
img.mutual_friends_bar{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_search_images/search_images.png') -32px -32px;border:none;}
img.friends_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_search_images/search_images.png') -16px -48px;border:none;}
img.planets_lists{vertical-align:top;margin-right:6px;width:13px;height:14px;background:url('barterrain_search_images/search_images.png') -71px -64px;border:none;}
img.mutual_friends_planet{vertical-align:top;margin-right:6px;width:17px;height:14px;background:url('barterrain_search_images/search_images.png') -0px -80px;border:none;}

<?php // Side Lists ?>
div.create_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.create_box12{vertical-align:top;float:left;text-align:left;width:66px;padding-right:6px;}
div.create_box2{vertical-align:bottom;text-align:left;width:415px;color:#000000;padding-bottom:2px;}
div.create_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;overflow:hidden;}
div.create_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;overflow:hidden;}
div.list_wrap_1{float:left;width:55px;margin:0px;padding:0px;padding-right:3px;}
div.list_wrap_2{overflow:hidden;vertical-align:top;text-align:left;display:inline-block;margin:0px;padding-left:3px;padding-top:3px;width:189px;}
div.list_wrap_3{overflow:hidden;vertical-align:top;text-align:left;display:inline-block;margin:0px;padding-left:3px;padding-top:3px;width:158px;}
div.list_wrap{text-align:left;overflow:hidden;padding:6px;padding-bottom:0px;}
div.list_wrap2{vertical-align:top;display:inline-block;text-align:left;overflow:hidden;padding:6px;padding-bottom:6px;width:221px;margin:0px 6px;border-bottom:1px solid #DDDDDD;}

<?php // Daily Points ?>
span.daily_points{font-size:35px;color:#5A5A5A;}
table.daily_points_0{position:relative;float:left;text-align:center;background:#FFFFFF;margin-left:6px;margin-top:3px;border:solid 3px <?php echo $color2; ?>;}
table.daily_points_25{position:relative;float:left;text-align:center;background:<?php echo $color2; ?>;margin-left:6px;margin-top:3px;border:solid 3px <?php echo $color2; ?>;}

<?php // Search Profile/Planets Box ?>
div.search_body{width:100%;}
div.search_box{padding:6px;border-bottom:solid 1px #DDDDDD;display:inline-block;}
div.none{padding:8px;border-bottom:solid 1px #DDDDDD;text-align:center;}
div.search_box1{vertical-align:top;float:left;text-align:left;width:55px;padding-right:6px;}
div.search_box2{vertical-align:top;display:inline-block;text-align:left;width:417px;color:#000000;padding-bottom:2px;overflow:hidden;}
div.search_box3{position:relative;vertical-align:top;float:right;text-align:left;width:417px;color:#696969;}