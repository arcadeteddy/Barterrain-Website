<?php 
ob_start("ob_gzhandler");
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

a{border:none;outline:none;}

<?php // All Pages ?>
a{margin:0px;padding:0px;outline:none;border:none;}
a.alias_link:link{color:#000000;text-decoration:none;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.alias_link:visited{color:#000000;text-decoration:none;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.alias_link:hover{color:#000000;text-decoration:underline;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.alias_link:active{color:#000000;text-decoration:underline;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.alias_body_link:link{color:#000000;text-decoration:none;font-weight:bold;width:500px;}
a.alias_body_link:visited{color:#000000;text-decoration:none;font-weight:bold;width:500px;}
a.alias_body_link:hover{color:#000000;text-decoration:underline;font-weight:bold;width:500px;}
a.alias_body_link:active{color:#000000;text-decoration:underline;font-weight:bold;width:500px;}
a.bar_link:link{color:<?php echo $color1_2; ?>;text-decoration:none;font:11px helvetica, sans-serif;}
a.bar_link:visited{color:<?php echo $color1_2; ?>;text-decoration:none;font:11px helvetica, sans-serif;}
a.bar_link:hover{color:<?php echo $color1_2; ?>;text-decoration:underline;font:11px helvetica, sans-serif;}
a.bar_link:active{color:<?php echo $color1_2; ?>;text-decoration:underline;font:11px helvetica, sans-serif;}
a.body:link{color:<?php echo $color1_2; ?>;text-decoration:none;}
a.body:visited{color:<?php echo $color1_2; ?>;text-decoration:none;}
a.body:hover{color:<?php echo $color1_2; ?>;text-decoration:underline;}
a.body:active{color:<?php echo $color1_2; ?>;text-decoration:underline;}
a.bold:link{color:<?php echo $color1_2; ?>;text-decoration:none;font-weight:bold;}
a.bold:visited{color:<?php echo $color1_2; ?>;text-decoration:none;font-weight:bold;}
a.bold:hover{color:<?php echo $color1_2; ?>;text-decoration:underline;font-weight:bold;}
a.bold:active{color:<?php echo $color1_2; ?>;text-decoration:underline;font-weight:bold;}
a.footer:link{color:<?php echo $color1_2; ?>;text-decoration:none;}
a.footer:visited{color:<?php echo $color1_2; ?>;text-decoration:none;}
a.footer:hover{color:<?php echo $color1_2; ?>;text-decoration:underline;}
a.footer:active{color:<?php echo $color1_2; ?>;text-decoration:underline;}
a.header:link{color:#FFFFFF;text-decoration:none;font:15px helvetica, sans-serif;}
a.header:visited{color:#FFFFFF;text-decoration:none;font:15px helvetica, sans-serif;}
a.header:hover{color:#FFFFFF;text-decoration:none;color:#EFEFEF;font:15px helvetica, sans-serif;}
a.header:active{color:#FFFFFF;text-decoration:none;color:#EFEFEF;font:15px helvetica, sans-serif;}
a.post_link:link{width:800px;display:inline;color:<?php echo $color1_2; ?>;text-decoration:none;font:11px helvetica, sans-serif;}
a.post_link:visited{width:800px;color:<?php echo $color1_2; ?>;text-decoration:none;font:11px helvetica, sans-serif;}
a.post_link:hover{width:800px;color:<?php echo $color1_2; ?>;text-decoration:underline;font:11px helvetica, sans-serif;}
a.post_link:active{width:800px;color:<?php echo $color1_2; ?>;text-decoration:underline;font:11px helvetica, sans-serif;}
a.profile_link:link{color:<?php echo $color1_2; ?>;text-decoration:none;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.profile_link:visited{color:<?php echo $color1_2; ?>;text-decoration:none;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.profile_link:hover{color:<?php echo $color1_2; ?>;text-decoration:underline;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.profile_link:active{color:<?php echo $color1_2; ?>;text-decoration:underline;font:14px helvetica, sans-serif;font-weight:bold;width:500px;}
a.side_button:link{width:265px;font:15px helvetica, sans-serif;text-decoration:none;color:#000000;}
a.side_button:visited{width:265px;font:15px helvetica, sans-serif;text-decoration:none;color:#000000;}
a.side_button:hover{width:265px;font:15px helvetica, sans-serif;text-decoration:none;color:#000000;}
a.side_button:active{width:265px;font:15px helvetica, sans-serif;text-decoration:none;color:#000000;}
body{background-color:<?php echo $color4; ?>;}
div{border:none;outline:none;padding:0px;margin:0px;}
div.darken{position:fixed;z-index:15;width:100%;height:100%;background-color:<?php echo $color4; ?>;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;}
div.profile_link{width:500px;}
div.side_button{background:#FFFFFF;display:block;width:265px;padding:2px 0px;}
div.side_button:hover{background:<?php echo $color3; ?>;display:block;width:265px;padding:2px 0px;}
div.side_button:active{background:<?php echo $color3; ?>;display:block;width:265px;padding:2px 0px;}
div.side_button.selected_window{background:<?php echo $color2; ?>;display:block;width:265px;padding:2px 0px;}
div.side_button2{background:#FFFFFF;display:block;width:265px;padding:2px 0px;height:35px;}
div.side_button2:hover{background:<?php echo $color3; ?>;display:block;width:265px;padding:2px 0px;height:35px;}
div.side_button2:active{background:<?php echo $color3; ?>;display:block;width:265px;padding:2px 0px;height:35px;}
div.side_button2.selected_window{background:<?php echo $color2; ?>;display:block;width:265px;padding:2px 0px;height:35px;}
div.side_padding{position:relative;display:inline;}
font.error_message_11px{color:<?php echo $color1; ?>;font:11px helvetica, sans-serif;}
font.error_message_12px{color:<?php echo $color1; ?>;font:12px helvetica, sans-serif;}
font.success_message_11px{color:<?php echo $color1; ?>;font:11px helvetica, sans-serif;}
font.success_message_12px{color:<?php echo $color1; ?>;font:12px helvetica, sans-serif;display:inline-block;margin-top:-2px;}
form{margin:0px;padding:0px;}
hr{margin:0px 20px;color:#E5E5E5;}
html{height:100%;}
img{border:none;outline:none;margin:0px;padding:0px;}
img.banner_profile_transactions{width:17px;height:15px;background:url('http://www.barterrain.com/points/barterrain_points_images/points_images.png') 0px -2px;border:none;margin:0px;margin-right:3px;padding:0px;vertical-align:middle;}
img.banner_planet_transactions{width:17px;height:15px;background:url('http://www.barterrain.com/points/barterrain_points_images/points_images.png') 0px -19px;border:none;margin:0px;margin-right:3px;padding:0px;vertical-align:middle;}
img.thumb_background{background-color:<?php echo $color2; ?>;}
input{border:none;outline:none;}
span.dot_divider{color:#A1A1A1;margin:0px;padding:0px;font:10px helvetica, sans-serif;}
span.places{color:#696969;display:block;width:300px;}
span.post_date{font:11px helvetica, sans-serif;color:#A1A1A1;margin:0px;padding:0px;}
span.side_button{vertical-align:top;top:9px;position:relative;padding-left:3px;height:20px;width:200px;}
span.span_side{padding-left:5px;}
.fixedBtm {margin-right:350px;position:fixed;bottom:0;}
.fixedTop {margin-right:350px;position:fixed;top:0;}
.fixedTop_34 {margin-right:350px;position:fixed;top:0;padding-top:34px;}
.fixedBtm_34 {margin-right:350px;position:fixed;bottom:0;}

div.side_colors_left{z-index:-10;position:fixed;height:100%;width:30%;left:0px;
background: -webkit-linear-gradient(left,<?php echo $color2; ?>,<?php echo $color4; ?>); /* For Safari */
background: -o-linear-gradient(right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* For Firefox 3.6 to 15 */
background: linear-gradient(to right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* Standard syntax (must be last) */
opacity:1;filter:alpha(opacity=100);}
div.side_colors_right{z-index:-10;position:fixed;height:100%;width:30%;right:0px;
background: -webkit-linear-gradient(left,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Safari */
background: -o-linear-gradient(right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Firefox 3.6 to 15 */
background: linear-gradient(to right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* Standard syntax (must be last) */
opacity:1;filter:alpha(opacity=100);}

<?php // Barterrian Banner Layout ?>
body.banner{top:0px;padding:0px;margin:auto;z-index:20;overflow:hidden;overflow-y:scroll;}
div.banner{z-index:20;text-align:center;position:relative;top:0px;height:45px;width:1060px;margin:auto;background-color:<?php echo $color1; ?>;}
div.banner100{z-index:20;text-align:center;position:fixed;top:0px;height:45px;width:100%;background-color:<?php echo $color1; ?>;}
div.banner_left{z-index:20;display:inline-block;height:40px;top:0px;float:left;width:270px;margin:0px;padding-top:5px;}
div.banner_middle{z-index:20;text-align:center;display:inline-block;height:40px;top:0px;float:left;width:520px;margin:0px;padding-top:5px;}
div.banner_middle_outside{z-index:20;text-align:center;height:40px;width:150px;top:0px;margin:auto;padding-top:5px;}
div.banner_right{z-index:20;text-align:right;display:inline-block;float:right;width:270px;margin:0px;padding-top:5px;}
font{font:12px helvetica, sans-serif;margin:0px;padding:0px;}

<?php // Barterrian Banner Links ?>
a.title:link{text-decoration:none;height:40px;width:150px;padding:0px;margin-top:-3px;background:url('http://www.barterrain.com/barterrain_banner_images/main_title.png') no-repeat 0 0;display: inline-block;float:left;}
a.title:visited{text-decoration:none;height:40px;width:150px;padding:0px;margin-top:-3px;background:url('http://www.barterrain.com/barterrain_banner_images/main_title.png') no-repeat 0 0;display: inline-block;float:left;}
a.title:hover{text-decoration:none;height:40px;width:150px;padding:0px;margin-top:-3px;background-position: 0 -40px;display:inline-block;float:left;}
a.title:active{text-decoration:none;height:40px;width:150px;padding:0px;margin-top:-3px;background-position: 0 -40px;display: inline-block;float:left;}
a.profile_button:link{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -120px;float:left;}
a.profile_button:visited{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -120px;float:left;;}
a.profile_button:hover{text-decoration:underline;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -120px;float:left;}
a.profile_button:active{text-decoration:underline;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -120px;float:left;}
a.planets_button:link{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -160px;float:left;margin-left:3px;}
a.planets_button:visited{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -160px;float:left;margin-left:3px;}
a.planets_button:hover{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px; background-position: -35px -160px;float:left;margin-left:3px;}
a.planets_button:active{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -160px;float:left;margin-left:3px;}
a.planets_button.selected_button_bottom{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat -70px -160px;float:left;margin-left:3px;}
a.economy_button:link{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -200px;display: inline-block;}
a.economy_button:visited{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -200px;display: inline-block;}
a.economy_button:hover{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -200px;display:inline-block;}
a.economy_button:active{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -200px;display: inline-block;}
a.points_button:link{text-decoration:none;height:34px;width:113px;padding:0px;margin:0px;background-color:<?php echo $color1; ?>;font:19px helvetica, sans-serif;color:#FFFFFF;float:left;vertical-align:top;padding-top:6px;text-align:center;margin-left:5px;}
a.points_button:visited{text-decoration:none;height:34px;width:113px;padding:0px;margin:0px;background-color:<?php echo $color1; ?>;font:19px helvetica, sans-serif;color:#FFFFFF;float:left;vertical-align:top;padding-top:6px;text-align:center;margin-left:5px;}
a.points_button:hover{text-decoration:none;height:34px;width:113px;padding:0px;margin:0px;background-color:<?php echo $color1; ?>;font:19px helvetica, sans-serif;color:#EFEFEF;float:left;vertical-align:top;padding-top:6px;text-align:center;margin-left:5px;}
a.points_button:active{text-decoration:none;height:34px;width:113px;padding:0px;margin:0px;background-color:<?php echo $color1; ?>;font:19px helvetica, sans-serif;color:#EFEFEF;float:left;vertical-align:top;padding-top:6px;text-align:center;margin-left:5px;}
a.points_button.selected_button_bottom{text-decoration:none;height:34px;width:113px;background-color:white;font:19px helvetica, sans-serif;color:<?php echo $color1; ?>;float:left;vertical-align:top;padding-top:6px;text-align:center;margin:0px;margin-left:5px;}
a.friends_button:link{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 0;float:left;margin-left:3px;}
a.friends_button:visited{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 0;float:left;margin-left:3px;}
a.friends_button:hover{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px 0;float:left;margin-left:3px;}
a.friends_button:active{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px 0;float:left;margin-left:3px;}
a.friends_button.selected_button_bottom{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat -70px 0;float:left;margin-left:3px;}
a.messages_button:link{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -40px;float:left;margin-left:3px;}
a.messages_button:visited{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -40px;float:left;margin-left:3px;}
a.messages_button:hover{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -40px;float:left;margin-left:3px;}
a.messages_button:active{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -40px;float:left;margin-left:3px;}
a.messages_button.selected_button_bottom{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat -70px -40px;float:left;margin-left:3px;}
a.notifications_button:link{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -80px;float:left;margin-left:3px;}
a.notifications_button:visited{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -80px;float:left;margin-left:3px;}
a.notifications_button:hover{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -80px;float:left;margin-left:3px;}
a.notifications_button:active{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -80px;float:left;margin-left:3px;}
a.notifications_button.selected_button_bottom{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat -70px -80px;float:left;margin-left:3px;}
a.settings_button:link{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -240px;float:left;margin-left:3px;}
a.settings_button:visited{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat 0 -240px;float:left;margin-left:3px;}
a.settings_button:hover{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -240px;float:left;margin-left:3px;}
a.settings_button:active{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background-position: -35px -240px;float:left;margin-left:3px;}
a.settings_button.selected_button_bottom{text-decoration:none;height:40px;width:35px;padding:0px;margin:0px;background:url('http://www.barterrain.com/barterrain_banner_images/banner_buttons.png') no-repeat -70px -240px;float:left;margin-left:3px;}
span.head_button{float:right;}
span.head_button_left{float:left;}

<?php // Barterrian Inside Layout ?>
a.find_link{float:right;text-align:right;display:block;font-size:12px;padding:4px;background:#FFFFFF;color:<?php echo $color1; ?>;text-decoration:none;}
b.banner{display:block;font-size:12px;padding:4px;background:#FFFFFF;color:#000000;text-decoration:none;}
body{padding:0px;margin:0px;}
div.banner_friend_1{overflow:hidden;vertical-align:top;float:left;width:55px;margin:0px;padding:0px;}
div.banner_friend_2{overflow:hidden;text-align:left;vertical-align:top;float:left;width:183px;margin:0px;padding-top:5px;padding-left:6px;}
div.banner_friend_wrap1{padding:5px;padding-bottom:0px;overflow:hidden;}
div.fmn_body_top{border-bottom:solid 1px #DDDDDD;margin-top:26px;overflow:hidden;}
div.fmn_body_top2{border-bottom:solid 1px #DDDDDD;margin-top:31px;overflow:hidden;}
div.fmn_body_middle{border-top:solid 1px #DDDDDD;padding-top:4px;margin-top:5px;}
div.nothing_banner{margin-top:15px;margin-bottom:14px;}
div.points_body_top{border-bottom:solid 1px #DDDDDD;margin-top:26px;overflow:hidden;}
div.points_body_middle{border-top:solid 1px #DDDDDD;padding-top:4px;}
div.points_fix{vertical-align:middle;margin-top:-2px;}
div.points_none{margin-top:15px;margin-bottom:15px;}
div.sub_button{z-index:5;text-align:center;position:absolute;margin:0px;margin-top:18px;border-top:none;border-left:solid 1px <?php echo $color1; ?>; border-right:solid 1px <?php echo $color1; ?>;border-bottom:solid 1px <?php echo $color1; ?>;padding:5px;width:254px;background:#FFFFFF;top:27px;right:0px;}
div.sub_button_bottom a:link{z-index:5;display:block;font-size:12px;padding:4px;background:#FFFFFF;color:#000000;text-decoration:none;margin-top:1px;}
div.sub_button_bottom a:visited{z-index:5;display:block;font-size:12px;padding:4px;background:#FFFFFF;color:#000000;text-decoration:none;margin-top:1px;}
div.sub_button_bottom a:hover{z-index:5;display:block;font-size:12px;padding:4px;background:<?php echo $color1; ?>;color:#FFFFFF;text-decoration:none;margin-top:1px;}
div.sub_button_bottom a:active{z-index:5;display:block;font-size:12px;padding:4px;background:<?php echo $color1; ?>;color:#FFFFFF;text-decoration:none;margin-top:1px;}
fieldset#sub_button_planets{position:absolute;display:none;margin:0px;border:none;width:0px;top:0px;left:248px;}
fieldset#sub_button_points{position:absolute;display:none;margin:0px;border:none;width:0px;top:0px;right:0px;}
fieldset#sub_button_friends{position:absolute;display:none;margin:0px;border:none;width:0px;top:0px;right:0px;}
fieldset#sub_button_messages{position:absolute;display:none;margin:0px;border:none;width:0px;top:0px;right:0px;}
fieldset#sub_button_notifications{position:absolute;display:none;margin:0px;border:none;width:0px;top:0px;right:0px;}
fieldset#sub_button_settings{position:absolute;display:none;margin:0px;border:none;width:0px;top:0px;right:0px;}
input.search_box{margin:0px;padding:0px;padding-left:10px;font:18px helvetica, sans-serif;width:450px;height:35px;background:url('http://www.barterrain.com/barterrain_banner_images/search_box.png');}
span.list_span{font:12px helvetica, sans-serif;vertical-align:middle;}
span.nothing_banner{color:#000000;}
table.banner_points_list{padding:0px;margin:0px;border-spacing:0px;vertical-align:middle;}
td{padding:0px;margin:0px;border-spacing:0px;vertical-align:middle;}
td.banner_points_list_1{background-color:#FFFFFF;position:relative;padding:6px;padding-bottom:1px;padding-top:5px;min-height:19px;width:192px;float:left;}
td.banner_points_list_pm_1{text-align:center;background-color:#FFFFFF;position:relative;padding:6px 6px;padding-bottom:1px;padding-top:5px;min-height:19px;width:35px;float:right;}
td.banner_points_list_2{background-color:<?php echo $color4; ?>;position:relative;padding:6px;padding-bottom:1px;padding-top:5px;min-height:19px;width:192px;float:left;}
td.banner_points_list_pm_2{text-align:center;background-color:<?php echo $color4; ?>;position:relative;padding:6px 6px;padding-bottom:1px;padding-top:5px;min-height:19px;width:35px;float:right;}
td.banner_points_list_pm_between{width:3px;}
tr{padding:0px;margin:0px;border-spacing:0px;}

<?php // Page Loader ?>
div.full_page_loader_hidden{display:none;overflow:hidden;}
div.full_page_loader_background{position:fixed;width:100%;height:100%;z-index:15;background-color:<?php echo $color4; ?>;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;}
img.full_page_loader{position:fixed;top:50%;left:50%;z-index:20;margin-top:-43px;margin-left:-65px;}
img.full_page_loader_array{position:fixed;top:50%;left:50%;z-index:20;margin-top:-43px;margin-left:-65px;}
img.full_page_loader_array_hidden{display:none;}
img.full_page_loader_image{position:fixed;top:50%;left:50%;z-index:20;margin-top:-43px;margin-left:-65px;}
img.full_page_loader_image_hidden{display:none;}

<?php // Barterrian Inside Layout ?>
a.find_link{float:right;text-align:right;display:block;font-size:12px;padding:4px;background:#FFFFFF;color:<?php echo $color1; ?>;text-decoration:none;}
b.banner{display:block;font-size:12px;padding:4px;background:#FFFFFF;color:#000000;text-decoration:none;}
body{padding:0px;margin:0px;}
div.banner_friend_1{overflow:hidden;vertical-align:top;float:left;width:55px;margin:0px;padding:0px;}
div.banner_friend_2{overflow:hidden;text-align:left;vertical-align:top;float:left;width:183px;margin:0px;padding-top:5px;padding-left:6px;}
div.banner_friend_wrap1{padding:5px;padding-right:0px;padding-bottom:0px;overflow:hidden;}
div.points_body_top{border-bottom:solid 1px #DDDDDD;margin-top:26px;overflow:hidden;}
div.points_body_middle{border-top:solid 1px #DDDDDD;padding-top:4px;}
div.points_fix{vertical-align:middle;margin-top:-2px;}
div.points_none{margin-top:15px;margin-bottom:15px;}
div.sub_button{z-index:5;text-align:center;position:absolute;margin:0px;margin-top:18px;border-top:none;border-left:solid 1px <?php echo $color1; ?>; border-right:solid 1px <?php echo $color1; ?>;border-bottom:solid 1px <?php echo $color1; ?>;padding:5px;width:254px;background:#FFFFFF;top:27px;right:0px;}
div.sub_button_bottom a:link{z-index:5;display:block;font-size:12px;padding:4px;background:#FFFFFF;color:#000000;text-decoration:none;margin-top:1px;}
div.sub_button_bottom a:visited{z-index:5;display:block;font-size:12px;padding:4px;background:#FFFFFF;color:#000000;text-decoration:none;margin-top:1px;}
div.sub_button_bottom a:hover{z-index:5;display:block;font-size:12px;padding:4px;background:<?php echo $color1; ?>;color:#FFFFFF;text-decoration:none;margin-top:1px;}
div.sub_button_bottom a:active{z-index:5;display:block;font-size:12px;padding:4px;background:<?php echo $color1; ?>;color:#FFFFFF;text-decoration:none;margin-top:1px;}
span.list_span{font:12px helvetica, sans-serif;}
span.nothing_banner{color:#000000;}

<?php // Display Box ?>
fieldset#display_button{z-index:16;text-align:center;position:fixed;margin:0px;border:none;}
fieldset#display_image_button{z-index:16;text-align:center;position:fixed;margin:0px;border:none;}
div.display_array_box{padding:6px;border-bottom:solid 1px #DDDDDD;overflow:hidden;width:221px;display:inline-block;margin:0px 6px;}
div.display_div{z-index:16;text-align:center;position:fixed;margin:0px;border:solid 1px <?php echo $color1; ?>;padding:19px;height:380px;width:490px;margin-top:-193px;background-color:#FFFFFF;overflow:auto;}
div.display_image_div{z-index:16;text-align:center;position:fixed;margin:0px;border:solid 1px <?php echo $color1; ?>;height:538px;width:1118px;margin-top:-253px;background-color:#FFFFFF;overflow:hidden;}
div.float_left{display:inline-block;text-align:left;float:left;}
div.float_right{display:inline-block;text-align:right;float:right;}
div.full_page_display_image{position:absolute;margin:1px;margin-top:-252px;width:1118px;height:538px;z-index:20;background-color:<?php echo $color4; ?>;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;}
div.lightbox_body{z-index:16;position:absolute;text-align:center;vertical-align:middle;top:50%;left:50%;margin:0px -277px;}
div.lightbox_image_body{z-index:16;position:absolute;text-align:center;vertical-align:middle;top:50%;left:50%;margin:0px -572px;}
div.display_array_wrap_1{overflow:hidden;vertical-align:top;float:left;width:60px;padding-right:6px;}
div.display_array_wrap_2{overflow:hidden;vertical-align:top;text-align:left;float:left;width:136px;margin-top:8px;}
div.middle_bars{display:inline-block;background-color:#DDDDDD;text-align:left;padding:6px;width:478px;}
div.under_middle_friends{width:490px;text-align:left;}
img.mutual_friends_bar{vertical-align:top;margin-right:6px;width:13px;height:13px;background:url('http://www.barterrain.com/inside/barterrain_inside_images/inside_images.png') -32px -32px;border:none;}
span.heading_list{font:12px helvetica, sans-serif;font-weight:bold;}

<?php // Back Top ?>
div.back_top{float:left;width:55px;height:55px;position:fixed;bottom:30px;z-index:0;position:absolute;z-index:8888;}
img.back_top{vertical-align:middle;float:left;width:55px;height:55px;background:url('http://www.barterrain.com/barterrain_banner_images/back_top.png') 0px 0px;display:none;background-color:<?php echo $color1; ?>;z-index:88;}