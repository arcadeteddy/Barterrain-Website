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

<?php // Settings Layout ?>
a{border:none;outline:none;}
div.bottom_footer{text-align:center;width:100%;}
div.margin{height:45px;display:block;}
div.nothing{text-align:center;width:100%;margin-top:6px;}
div.settings_page_body{float:left;width:1060px;position:absolute;margin:0px 60px;min-height:100%;}
div.settings_page_body_cover{text-align:left;width:1180px;margin:0 auto;overflow:hidden;}
div.settings_page_body_left{position:fixed;width:30px;margin-left:235px;background:url('../barterrain_main_images/side_shadows.png') -0px -0px;background-repeat:repeat-y;height:100%;z-index:-2;}
div.settings_page_body_right{position:fixed;width:30px;margin-left:1120px;background:url('../barterrain_main_images/side_shadows.png') -30px -0px;background-repeat:repeat-y;height:100%;}
div.settings_page_left{float:left;text-align:center;width:265px;z-index:2;}
div.settings_page_right{overflow:hidden;float:right;text-align:left;height:100%;width:755px;padding:19px;background-color:#FFFFFF;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;}
div.side_bottom{height:22px;width:100%;float:left;background:url('../barterrain_main_images/side_bottom.png') 0px -0px;}
div.white_background{background-color:#FFFFFF;}
div.white_background_full{z-index:-8;background-color:#FFFFFF;height:100%;width:755px;padding:19px;position:absolute;right:0px;border-left-style:solid;border-right-style:solid;border-color:<?php echo $color2; ?>;border-width:1px;margin-top:-38px;}
font.side_header{font-size:22px;font-weight:bold;}
img.settings{width:32px;height:32px;background:url('barterrain_settings_images/settings_images.png') -50px 0px;border:none;}
img.settings_profile{width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') -16px 0px;border:none;}
img.settings_circles{width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') -83px -17px;border:none;}
img.settings_planet{width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') -33px 0px;border:none;}
img.settings_economy{width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') 0px -17px;border:none;}
img.settings_security{width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') -17px -17px;border:none;}
img.settings_notifications{width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') -34px -17px;border:none;}
img.profile_image{border-right-style:solid;border-right-width:2px;border-bottom-style:solid;border-top-style:solid;border-left-style:solid;border-width:3px;border-color:<?php echo $color2; ?>;}
span.settings_heading{vertical-align:bottom;text-align:right;font:31px helvetica, sans-serif;padding-right:5px;}
span.settings_side{padding-left:5px;}

<?php // Settings Body ?>
a.settings_1{z-index:-10;text-decoration:none;color:#000000;}
div.extra_settings_top{border-top:solid 5px <?php echo $color1; ?>;border-top-style:dashed;}
div.fakeupload{z-index:10;position:absolute;display:inline-block;margin:0px;padding-left:5px;padding-top:5px;width:360px;height:19px;overflow:hidden;}
div.fakeupload2{z-index:5;width:465px;height:24px;padding:0px;overflow:hidden;position:relative;display:inline-block;background:url('barterrain_settings_images/input_picture.png') 0px 0px;background-color:#FFFFFF;}
div.hidden{display:none;}
div.interactive_error{text-align:center;width:100%;color:<?php echo $color1; ?>;}
div.settings_whole{position:relative;overflow:hidden;}
div.settings_1{text-align:left;padding:8px;padding-top:9px;text-align:left;border-bottom:solid 1px #E5E5E5;background:#FFFFFF;display:block;}
div.settings_1:hover{text-align:left;padding:8px;padding-top:9px;border-bottom:solid 1px #E5E5E5;background:<?php echo $color3; ?>;display:block;}
div.settings_1_hover{text-align:left;padding:8px;padding-top:9px;border-bottom:solid 1px #E5E5E5;background:<?php echo $color3; ?>;display:block;}
div.settings_1:active{text-align:left;padding:8px;padding-top:9px;border-bottom:solid 1px #E5E5E5;background:<?php echo $color3; ?>;display:block;}
div.settings_1_active{text-align:left;padding:8px;padding-top:9px;border-bottom:solid 1px <?php echo $color2; ?>;background:<?php echo $color2; ?>;display:block}
div.settings_1_active:hover{text-align:left;padding:8px;padding-top:9px;border-bottom:solid 1px <?php echo $color2; ?>;background:<?php echo $color2; ?>;display:block}
div.settings_1_1{vertical-align:top;position:relative;display:inline-block;font:15px helvetica, sans-serif;font-weight:bold;width:187px;}
div.settings_1_2{position:relative;display:inline-block;font:13px helvetica, sans-serif;color:#696969;width:463px;top:1px;margin-bottom:2px;}
div.settings_1_3{z-index:10;position:absolute;width:35px;float:right;right:8px;top:10px;}
div.settings_2{padding-bottom:13px;width:100%;background:<?php echo $color2; ?>;border-bottom:solid 1px #E5E5E5;}
div.settings_2_1{position:relative;display:inline-block;width:187px;}
div.settings_2_2{position:relative;display:inline-block;width:500px;color:#696969;}
div.settings_2_3{position:relative;display:inline-block;width:187px;vertical-align:top;top:5px;}
div.settings_parts{text-align:left;padding:0px;padding:3px;padding-left:14px;}
input.picture_field{z-index:2;overflow:hidden;position:relative;display:inline-block;padding-left:5px;padding-right:5px;width:465px;height:24px;font:12px helvetica, sans-serif;border:1px solid #abadb3;opacity:0;filter:alpha(opacity=0);-moz-opacity:0;-ms-filter:"alpha(opacity=0)";cursor:pointer;_cursor:hand;}
input.save_button{z-index:2;position:relative;float:right;width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') 0px 0px;margin-right:3px;}
input.error_parts{padding-left:5px;padding-right:5px;width:465px;height:24px;font:12px helvetica, sans-serif;border:1px solid <?php echo $color1; ?>;}
input.settings_parts{padding-left:5px;padding-right:5px;width:453px;height:24px;font:12px helvetica, sans-serif;border:1px solid #abadb3;}
img.cancel_button{z-index:2;position:relative;float:right;width:15px;height:15px;background:url('barterrain_settings_images/settings_images.png') -85px 0px;}
img.settings_thumbs{overflow:hidden;height:55px;width:55px;margin:3px;margin-bottom:0px;margin-left:0px;margin-right:6px;border:1px solid #abadb3;}
img.selected_settings_thumbs{overflow:hidden;height:55px;width:55px;margin:3px;margin-bottom:0px;margin-left:0px;margin-right:6px;border:1px solid <?php echo $color1; ?>;}
select.settings_parts{padding-left:5px;width:465px;font:12px helvetica, sans-serif;height:28px;color:#696969;}
select.settings_birthday{padding-left:5px;width:153px;font:12px helvetica, sans-serif;height:28px;color:#696969;}
textarea.settings_parts{overflow-y:scroll;padding:5px;margin:0px;margin-bottom:-3px;min-width:453px;max-width:453px;height:65px;font:12px helvetica, sans-serif;border:1px solid #abadb3;}

<?php // Settings Delete Account ?>
div.delete_left{vertical-align:top;position:relative;float:left;text-align:center;width:284px;padding:0px 20px;padding-top:58px;}
div.delete_left1{vertical-align:top;text-align:center;padding-left:1px;}
div.delete_left2{vertical-align:top;text-align:center;padding-left:1px;padding-top:30px;}
div.delete_right{vertical-align:top;position:relative;float:left;text-align:center;height:308px;width:202px;padding:19px 15px;margin-top:58px;margin-left:46px;background:url('barterrain_settings_images/delete_terms_border.jpg') 0px 0px;}
div.delete_middle{vertical-align:top;float:left;position:relative;text-align:left;width:405px;height:400px;padding:30px 0px;padding-top:30px;}
div.delete_page_body_cover{margin:0 auto;width:1180px;}
div.delete_page_body{position:absolute;margin:0px 60px;width:1054px;height:461px;border:dashed;border-top:none;border-color:<?php echo $color1; ?>;background-color:#FFFFFF;}
img.delete_account_button{position:absolute;width:405px;height:405px;padding:0px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat -301px 0px;}
img.switch1{width:99px;height:200px;padding:0px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat 0px 0px;display:inline-block;}
img.switch1:active{width:99px;height:200px;padding:0px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat -100px 0px;display:inline-block;}
img.switch2{width:99px;height:200px;padding:0px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat 0px -203px;display:inline-block;margin-left:32px;}
img.switch2:active{width:99px;height:200px;padding:0px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat -100px -203px;display:inline-block;margin-left:32px;}
img.switch_checked1{width:99px;height:200px;padding:0px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat -200px 0px;display:inline-block;}
img.switch_checked2{width:99px;height:200px;padding:0px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat -201px -203px;display:inline-block;margin-left:32px;}
input.delete_account_button{position:absolute;width:137px;height:138px;margin-left:137px;margin-top:130px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat -438px -130px;}
input.delete_account_button:active{position:absolute;width:138px;height:138px;margin:130px;margin-left:136px;background:url('barterrain_settings_images/delete_page_images.jpg') no-repeat -841px -130px;}
input.password_delete_account{border:solid 1px #dd4a4a;width:232px;height:30px;font:16px helvetica, sans-serif;margin-bottom:5px;display:inline-block;}
span.launch_span{text-align:center;margin-bottom:5px;font:20px helvetica, sans-serif;display:block;}
span.status{text-align:center;margin-bottom:5px;font:20px helvetica, sans-serif;display:block;color:#dd4a4a;padding-top:28px;}