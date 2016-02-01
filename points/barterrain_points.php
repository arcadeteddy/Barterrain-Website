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

<?php // Points Layout ?>
a{border:none;outline:none;}
div.bottom_point_totals{text-align:left;width:100%;}
div.bottom_point_transactions{text-align:left;width:100%;float:left;}
div.margin{height:45px;display:block;}
div.nothing{text-align:center;width:100%;margin-top:6px;}
div.points_page_body{float:left;width:1060px;position:absolute;margin:0px 60px;min-height:100%;}
div.points_page_body_cover{text-align:left;width:1180px;margin:0 auto;overflow:hidden;}
div.points_page_body_left{position:fixed;width:30px;margin-left:235px;background:url('../barterrain_main_images/side_shadows.png') -0px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.points_page_body_right{position:fixed;width:30px;margin-left:1120px;background:url('../barterrain_main_images/side_shadows.png') -30px -0px;background-repeat:repeat-y;height:100%;}
div.points_page_left{float:left;text-align:center;width:265px;z-index:2;}
div.points_page_right{overflow:hidden;float:right;text-align:left;height:100%;width:755px;padding:19px;background-color:#FFFFFF;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.side_bottom{height:22px;width:100%;float:left;background:url('../barterrain_main_images/side_bottom.png') 0px -0px;}
div.white_background{background-color:#FFFFFF;}
div.white_background_full{z-index:-8;background-color:#FFFFFF;height:100%;width:755px;margin-top:-45px;padding:19px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
font.side_header{font-size:22px;font-weight:bold;}
img.points{vertical-align:top;width:32px;height:32px;background:url('barterrain_points_images/points_images.png') -31px 0px;border:none;margin-left:5px;}
img.profile_transactions{width:17px;height:15px;background:url('barterrain_points_images/points_images.png') 0px 0px;border:none;}
img.planet_transactions{width:17px;height:15px;background:url('barterrain_points_images/points_images.png') 0px -17px;border:none;}
img.points_totals{width:15px;height:15px;background:url('barterrain_points_images/points_images.png') -17px 0px;border:none;}
img.profile_image{border-right-style:solid;border-right-width:2px;border-top-style:solid;border-bottom-style:solid;border-left-style:solid;border-width:3px;border-color:<?php echo $color2; ?>;position:relative;z-index:6;}
span.points_heading{vertical-align:bottom;text-align:right;font:31px helvetica, sans-serif;padding-right:5px;}
span.points_side{padding-left:5px;}

<?php // Point Pages ?>
div.bar_wrap{height:27px;width:100%;display:block;margin-top:5px;}
div.expand_bottom_point_transactions{text-align:left;width:100%;margin-top:19px;float:left;}
div.float_left{display:inline-block;float:left;}
div.float_right{display:inline-block;float:right;}
div.points_bars{background-color:#DDDDDD;position:relative;padding:6px;height:15px;width:513px;float:left;}
div.points_bars_end{border-bottom:solid 1px #E5E5E5;float:left;width:100%;margin-bottom:14px;position:relative;}
div.plus_minus_bars{text-align:center;background-color:#DDDDDD;position:relative;margin-left:3px;padding:6px 6px;padding-top:3px;padding-bottom:9px;height:15px;width:100px;float:right;}
div.points_list_1{background-color:#FFFFFF;position:relative;padding:6px;min-height:12px;width:513px;float:left;}
div.points_list_pm_1{text-align:center;background-color:#FFFFFF;position:relative;margin-left:3px;padding:6px 6px;width:100px;float:right;}
div.points_list_2{background-color:<?php echo $color4; ?>;position:relative;padding:6px;min-height:12px;width:513px;float:left;}
div.points_list_pm_2{text-align:center;background-color:<?php echo $color4; ?>;position:relative;margin-left:3px;padding:6px 6px;width:100px;float:right;}
div.points_sub_body{width:100%;margin:0px;margin-top:-5px;padding:0px;text-align:left;}
img.loader{height:15px;}
span.expand_bottom_point_transactions{font:12px helvetica, sans-serif;padding:0px;margin:0px;}
span.heading_list{font:12px helvetica, sans-serif;font-weight:bold;}
span.heading_list_pm{font:15px helvetica, sans-serif;font-weight:bold;}
span.list_span{font:12px helvetica, sans-serif;}
span.mutual{color:#696969;display:block;}
span.nothing{font:15px helvetica, sans-serif;}
table.points_list{padding:0px;margin:0px;border-spacing:0px;}
td{padding:0px;margin:0px;border-spacing:0px;}
td.points_list_1{background-color:#FFFFFF;position:relative;padding:6px;min-height:13px;width:513px;float:left;}
td.points_list_pm_1{text-align:center;background-color:#FFFFFF;position:relative;padding:6px 6px;min-height:13px;width:100px;float:right;}
td.points_list_2{background-color:<?php echo $color4; ?>;position:relative;padding:6px;height:12px;min-height:13px;width:513px;float:left;}
td.points_list_pm_2{text-align:center;background-color:<?php echo $color4; ?>;position:relative;padding:6px 6px;min-height:13px;width:100px;float:right;}
td.points_list_pm_between{width:3px;}

<?php // Point Transactions ?>
div.transactions_bars_end{border-bottom:solid 1px #E5E5E5;float:left;width:100%;}
img.transactions_lists{vertical-align:top;margin-right:5px;width:13px;height:13px;background:url('barterrain_points_images/points_lists.png') -61px 0px;border:none;}

<?php // Point Totals ?>
img.posts_lists{vertical-align:middle;margin-right:5px;width:13px;height:13px;background:url('barterrain_points_images/points_lists.png') 0px 0px;border:none;}
img.media_lists{vertical-align:top;margin-right:5px;width:17px;height:13px;background:url('barterrain_points_images/points_lists.png') -14px 0px;border:none;}
img.creates_lists{vertical-align:middle;margin-right:5px;width:14px;height:13px;background:url('barterrain_points_images/points_lists.png') -32px 0px;border:none;}
img.notes_lists{vertical-align:middle;margin-right:5px;width:13px;height:13px;background:url('barterrain_points_images/points_lists.png') -47px 0px;border:none;}
img.economy_lists{vertical-align:middle;margin-right:5px;width:14px;height:13px;background:url('barterrain_points_images/points_lists.png') -75px 0px;border:none;}

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