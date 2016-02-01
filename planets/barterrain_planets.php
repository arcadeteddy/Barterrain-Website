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

<?php // Planets Layout ?>
a{margin:0px;padding:0px;}
div.cover_image{z-index:5;position:absolute;}
div.float_left{display:inline-block;text-align:left;float:left;}
div.float_right{display:inline-block;text-align:right;float:right;}
div.hide_div{display:none;}
div.margin{height:45px;display:block;}
div.planets_page_body{float:left;width:1060px;position:absolute;margin:0px 60px;min-height:100%;}
div.planets_page_body_cover{text-align:left;width:1180px;margin:0 auto;overflow:hidden;}
div.planets_page_body_left{position:fixed;width:30px;margin-left:235px;background:url('../barterrain_main_images/side_shadows.png') -0px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.planets_page_body_right{position:fixed;width:30px;margin-left:1120px;background:url('../barterrain_main_images/side_shadows.png') -30px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.planets_page_left{float:left;text-align:center;width:265px;z-index:6;overflow:hidden;}
div.planets_page_right{float:right;text-align:left;height:100%;width:755px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;position:relative;z-index:3;padding:19px;}
div.side_bottom{height:22px;width:100%;float:left;background:url('../barterrain_main_images/side_bottom.png') 0px -0px;}
div.white_background{background-color:#FFFFFF;margin:0px;padding:0px;z-index:-8;}
div.white_background_full{z-index:-8;background-color:#FFFFFF;height:100%;width:793px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.white_background_full2{z-index:-8;background-color:#FFFFFF;height:100%;width:264px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
font.color{color:<?php echo $color1; ?>;}
font.side_header{font-size:22px;font-weight:bold;}
img.cover_image{margin:0px -30px;}
img.like_count{padding:0px;margin:0px;vertical-align:middle;width:11px;height:11px;background:url('../barterrain_main_images/like_love.png') -13px 0px;}
img.love_count{padding:0px;margin:0px;vertical-align:middle;width:11px;height:11px;background:url('../barterrain_main_images/like_love.png') 0px 0px;}
img.planets_image{border-right-style:solid;border-right-width:2px;border-top-style:solid;border-bottom-style:solid;border-left-style:solid;border-width:3px;border-color:<?php echo $color2; ?>;position:relative;z-index:6;}
img.planets_popular_recent{outline:0px;width:15px;height:14px;background:url('barterrain_planets_images/planets_images.png') -31px -0px;}
img.planets_popular{outline:0px;width:15px;height:14px;background:url('barterrain_planets_images/planets_images.png') -15px -0px;}
img.planets_recent{outline:0px;width:13px;height:14px;background:url('barterrain_planets_images/planets_images.png') -0px 1px;}
img.planets_planets{outline:0px;width:13px;height:14px;background:url('barterrain_planets_images/planets_images.png') -0px -18px;}
img.planets_albums{width:17px;height:14px;background:url('barterrain_planets_images/planets_images.png') -15px -18px;}
img.planets_games{width:13px;height:14px;background:url('barterrain_planets_images/planets_images.png')  -33px -18px;}
img.planets_videos{width:15px;height:13px;background:url('barterrain_planets_images/planets_images.png')  -48px -18px;}
span.heading_list{font:12px helvetica, sans-serif;font-weight:bold;}
span.dot_divider{color:#696969;size:12px;}
span.dot_pagination{font-size:12px;}
span.places{color:#696969;display:block;}

<?php // Lists ?>
div.planets_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:743px;}
img.likes_lists{vertical-align:top;margin-right:5px;width:10px;height:11px;background:url('../barterrain_main_images/like_love.png') -14px -0px;border:none;}
img.loves_lists{vertical-align:top;margin-right:6px;width:11px;height:11px;background:url('../barterrain_main_images/like_love.png') -0px -0px;border:none;}
img.points_lists{vertical-align:top;margin-right:6px;width:12px;height:13px;background:url('barterrain_planets_images/other_images.png') -70px -18px;border:none;}
img.albums_lists{vertical-align:top;margin-right:6px;width:16px;height:14px;background:url('barterrain_planets_images/planets_images.png') -15px -19px;border:none;}
img.games_lists{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('barterrain_planets_images/planets_images.png') -33px -19px;border:none;}
img.planets_lists{vertical-align:top;margin-right:6px;width:13px;height:14px;background:url('barterrain_planets_images/planets_images.png') -0px -19px;border:none;}
img.videos_lists{vertical-align:top;margin-right:6px;width:15px;height:13px;background:url('barterrain_planets_images/planets_images.png') -48px -19px;border:none;}

div.planets_box_wrap1{position:relative;vertical-align:top;float:left;margin:5px 5px;margin-right:8px;border-bottom:solid 1px #DDDDDD;width:176px;height:227px;overflow:hidden;}
div.planets_box_wrap2{position:relative;vertical-align:top;float:left;margin:5px 5px;margin-right:8px;border-bottom:solid 1px #DDDDDD;width:176px;height:167px;overflow:hidden;}
div.planets_box1{float:left;border:solid 1px #DDDDDD;width:174px;height:174px;overflow:hidden;}
div.planets_box2{float:left;border:solid 1px #DDDDDD;width:174px;height:114px;overflow:hidden;}
div.planets_box_pic{padding:3px 3px;width:168px;height:168px;}
div.planets_box3{position:relative;float:left;text-align:left;width:176px;padding-left:6px;}
div.length{float:left;position:relative;height:13px;width:8000px;}
div.line{float:left;position:relative;height:13px;width:100%;padding-top:4px;}
div.line2{float:left;position:relative;height:13px;width:100%;padding-top:3px;}
div.line4{float:left;position:relative;height:13px;width:100%;padding-top:2px;}
div.under_list_wrap{float:left;width:781px;text-align:left;margin-bottom:9px;}