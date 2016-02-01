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
?>  

<?php // Friends Layout ?>
a{border:none;outline:none;}
div.bar_wrap{height:27px;width:100%;display:block;margin-top:5px;}
div.expand_bottom_find_friends{text-align:left;width:100%;margin-top:19px;float:left;}
div.filter_list{text-align:left;width:201px;padding:0px 32px;}
div.friends_page_body{float:left;width:1060px;position:absolute;margin:0px 60px;min-height:100%;}
div.friends_page_body_cover{text-align:left;width:1180px;margin:0 auto;overflow:hidden;}
div.friends_page_body_left{position:fixed;width:30px;margin-left:295px;background:url('../barterrain_main_images/side_shadows.png') -0px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.friends_page_body_right{position:fixed;width:30px;margin-left:1120px;background:url('../barterrain_main_images/side_shadows.png') -30px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.friends_page_left{float:left;text-align:center;width:265px;z-index:2;}
div.friends_page_right{overflow:hidden;text-align:left;float:right;width:755px;padding:19px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.friends_sub_body{width:100%;margin:0px;margin-top:-5px;padding:0px;text-align:left;}
div.hidden_filter_search{display:none;}
div.hide_all_friends{display:none;}
div.hide_all_invited{display:none;}
div.margin{height:45px;display:block;}
div.nothing{text-align:center;width:100%;padding-top:20px;}
div.search_list{text-align:left;width:201px;padding:0px 32px;}
div.search_invited_list{text-align:left;width:201px;padding:0px 32px;}
div.side_bottom{height:22px;width:100%;float:left;background:url('../barterrain_main_images/side_bottom.png') 0px -0px;}
div.white_background{background-color:#FFFFFF;}
div.white_background_full{z-index:-8;background-color:#FFFFFF;height:100%;width:755px;margin-top:-38px;padding:19px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
img.friends{vertical-align:top;width:32px;height:32px;background:url('barterrain_friends_images/friends_images.png') -31px 0px;border:none;margin-left:5px;}
img.friends_find{width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png') 0px 0px;border:none;}
img.friends_invite{width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png')  -0px -17px;border:none;}
img.friends_all{width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png') -16px -17px;border:none;}
img.loader{height:15px;}
img.profile_image{border-right-style:solid;border-right-width:2px;border-top-style:solid;border-bottom-style:solid;border-left-style:solid;border-width:3px;border-color:<?php echo $color2; ?>;}
input.filter_button{padding:0px;vertical-align:bottom;width:201px;height:24px;margin-top:3px;border:none;background:url('barterrain_friends_images/filter_button.png');background-color:<?php echo $color1; ?>;}
input.invite_button{padding:0px;vertical-align:bottom;width:201px;height:24px;margin-top:3px;border:none;background:url('barterrain_friends_images/invite_button.png');background-color:<?php echo $color1; ?>;}
input.search_button{padding:0px;vertical-align:bottom;width:201px;height:24px;margin-top:3px;border:none;background:url('barterrain_friends_images/search_button.png');background-color:<?php echo $color1; ?>;}
input.search_input{padding-left:5px;width:193px;height:24px;font:12px helvetica, sans-serif;border:1px solid #abadb3;margin:3px 0px;}
span.expand_bottom_find_friends{font:12px helvetica, sans-serif;padding:0px;margin:0px;}
span.friends_heading{vertical-align:bottom;text-align:right;font:31px helvetica, sans-serif;padding-right:5px;}
span.friends_side{padding-left:5px;}
span.heading_list{font:12px helvetica, sans-serif;font-weight:bold;}
span.mutual{color:#696969;display:block;}
span.nothing{font:15px helvetica, sans-serif;}

<?php // Find Friends ?>
div.bottom_find_friends{text-align:left;width:100%;}
img.find_friends_bar{vertical-align:middle;margin-right:5px;width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png') -0px -1px;border:none;}
img.mutual_friends_bar{vertical-align:middle;margin-right:5px;width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png') -0px -35px;border:none;}

<?php // Invite Friends ?>
div.invite_friends{text-align:left;width:755px;margin-bottom:19px;display:block;position:relative;float:left;}
div.invite_right{text-align:left;width:201px;float:right;}
div.invite_left{text-align:left;width:548px;float:left;}
img.invite_friends_bar{vertical-align:middle;margin-right:5px;width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png') -0px -18px;border:none;}
input.invite_email{padding:0px;padding-left:5px;width:195px;height:24px;font:12px helvetica, sans-serif;border:1px solid #abadb3;margin:3px 0px;}
input.invite_email1{padding:0px;padding-left:5px;width:195px;height:24px;font:12px helvetica, sans-serif;border:1px solid #abadb3;margin-bottom:3px;margin-top:9px;}
textarea.invite_message{padding-left:5px;padding-top:4px;margin-top:9px;width:541px;height:177px;max-width:100%;max-height:177px;font:12px helvetica, sans-serif;border:1px solid #abadb3;}

<?php // All Friends ?>
div.body_bars{background-color:#DDDDDD;position:relative;padding:6px;height:15px;width:743px;float:left;}
div.float_left{display:inline-block;float:left;}
div.float_right{display:inline-block;float:right;}
div.friends_box3{padding:6px;border-bottom:solid 1px #DDDDDD;overflow:hidden;width:169px;display:inline-block;margin:0px 3px;}
div.friend_request_1{vertical-align:top;text-align:left;float:left;margin:0px;width:75px;padding:6px 6px;}
div.friend_request_2{overflow:hidden;vertical-align:middle;text-align:left;float:right;margin:0px;width:278px;padding-top:13px;}
div.friend_wrap3{border-bottom:solid 1px #E5E5E5;overflow:hidden;width:365px;display:inline-block;margin:0px 6px;}
div.middle_wrap_1{float:left;width:65px;margin:0px;padding:0px;margin-right:6px;}
div.middle_wrap_2{float:right;overflow:hidden;vertical-align:top;text-align:left;margin:0px;width:98px;padding-top:1px;}
div.under_middle_friends2{width:100%;text-align:left;float:left;padding-left:3px;}
img.friend_requests_bar{vertical-align:middle;margin-right:5px;width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png') -16px -1px;border:none;}
img.all_friends_bar{vertical-align:middle;margin-right:5px;width:15px;height:15px;background:url('barterrain_friends_images/friends_images.png') -16px -18px;border:none;}