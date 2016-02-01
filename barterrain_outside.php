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
		$color3="#E3EAF8";}
	else if ($color=="green")
		{$color1="#36B336";
		$color1_2="#36B336";
		$color2="#B9E4B9";
		$color3="#E5F5E5";}
	else if ($color=="yellow")
		{$color1="#E5E517";
		$color1_2="#E5E517";
		$color2="#F6F6AE";
		$color3="#FCFCE1";}
	else if ($color=="orange")
		{$color1="#E57E17";
		$color1_2="#E57E17";
		$color2="#F6D2AE";
		$color3="#FCEEE1";}
	else if ($color=="red")
		{$color1="#CC2929";
		$color1_2="#CC2929";
		$color2="#EDB4B4";
		$color3="#F8E3E3";}
	else if ($color=="purple")
		{$color1="#8836B3";
		$color1_2="#8836B3";
		$color2="#D5B9E4";
		$color3="#F0E5F5";}
	else if ($color=="brown")
		{$color1="#663D14";
		$color1_2="#663D14";
		$color2="#CABBAD";
		$color3="#EBE6E1";}
	else if ($color=="black")
		{$color1="#17171A";
		$color1_2="#2A62CA";
		$color2="#AEAEAF";
		$color3="#E1E1E1";}
	else
		{$color1="#2A62CA";
		$color1_2="#295FCC";
		$color2="#B4C7ED";
		$color3="#E7EDF8";}
	}
else
	{$color1="#295FCC";
	$color1_2="#295FCC";
	$color2="#B4C7ED";
	$color3="#E3EAF8";}
?>  

a{border:none;outline:none;}

<?php // Outside Other Pages ?>
#outside_pages_1{top:0%;height:100%;width:100%;overflow:hidden;}
#outside_pages_2{top:100%;height:100%;width:100%;overflow:hidden;}
#outside_pages_3{top:200%;height:100%;width:100%;overflow:hidden;}
#outside_pages_4{top:300%;height:100%;width:100%;overflow:hidden;}
#outside_pages_browser{top:0%;height:100%;width:100%;overflow:hidden;}
div.outside_pages_1{left:0px;top:50%;height:266px;margin-top:-133px;}
div.outside_pages_2{left:0px;top:50%;height:448px;margin-top:-224px;}
div.outside_pages_3{left:0px;top:50%;height:182px;margin-top:-91px;}
div.outside_pages_4{left:0px;top:50%;height:258px;margin-top:-121px;}
div.outside_pages_browser{left:0px;top:50%;height:266px;margin-top:-138px;}
div.side_colors_left{position:absolute;height:400%;width:30%;left:0px;
background: -webkit-linear-gradient(left,<?php echo $color2; ?>,<?php echo $color4; ?>); /* For Safari */
background: -o-linear-gradient(right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* For Firefox 3.6 to 15 */
background: linear-gradient(to right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* Standard syntax (must be last) */
opacity:1.0;filter:alpha(opacity=100);}
div.side_colors_right{position:absolute;height:400%;width:30%;right:0px;
background: -webkit-linear-gradient(left,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Safari */
background: -o-linear-gradient(right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Firefox 3.6 to 15 */
background: linear-gradient(to right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* Standard syntax (must be last) */
opacity:1.0;filter:alpha(opacity=100);}
div.side_colors_left_2{position:absolute;height:100%;width:30%;left:0px;
background: -webkit-linear-gradient(left,<?php echo $color2; ?>,<?php echo $color4; ?>); /* For Safari */
background: -o-linear-gradient(right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* For Firefox 3.6 to 15 */
background: linear-gradient(to right,<?php echo $color2; ?>, <?php echo $color4; ?>); /* Standard syntax (must be last) */
opacity:1.0;filter:alpha(opacity=100);}
div.side_colors_right_2{position:absolute;height:100%;width:30%;right:0px;
background: -webkit-linear-gradient(left,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Safari */
background: -o-linear-gradient(right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* For Firefox 3.6 to 15 */
background: linear-gradient(to right,<?php echo $color4; ?>,<?php echo $color2; ?>); /* Standard syntax (must be last) */
opacity:1.0;filter:alpha(opacity=100);}

<?php // Outside Layout ?>
body{overflow:hidden;overflow-y:scroll;background-color:<?php echo $color3; ?>;}
div.content div{position:absolute;width:100%;}
div.barterrain_outside_background{height:100%;width:100%;margin:0 auto;padding:0px;position:absolute;}
div.barterrain_outside{text-align:center;margin:0 auto;padding:0px;}
font.body_font{color:#000000;font:13px helvetica, sans-serif;}
font.error_font{color:<?php echo $color1; ?>;font:13px helvetica, sans-serif;}
th,td{padding:0px;text-align:center;}
tr.space{height:30px;width:250px;text-align:center;overflow:hidden;hspace:0px;}
tr.space2{height:30px;width:250px;text-align:center;overflow:hidden;}
tr.space3{vertical-align:bottom;height:68px;width:250px;text-align:center;overflow:hidden;}
tr.space4{vertical-align:bottom;height:84px;width:250px;text-align:center;overflow:hidden;}
tr.space5{vertical-align:bottom;width:250px;text-align:center;overflow:hidden;}

<?php // Outside Browser ?>
a.chrome_browser{width:120px;height:120px;float:left;background:url('barterrain_outside_images/browsers.png') 5px 0px;}
a.firefox_browser{width:120px;height:120px;float:left;background:url('barterrain_outside_images/browsers.png') -115px 0px;}
a.opera_browser{width:120px;height:120px;float:left;background:url('barterrain_outside_images/browsers.png') -235px 0px;}
a.safari_browser{width:120px;height:120px;float:left;background:url('barterrain_outside_images/browsers.png') -350px 0px;}
body.browser_body{overflow:hidden;background-color:<?php echo $color3; ?>;}
span.browser{color:#000000;font:25px arial, sans-serif;}
table.browser_table{margin:auto;overflow:hidden;margin-top:-2px;text-align:center;border-spacing:0px;}
td.browser_td{width:130px;height:50px;background-color:#FFFFFF;}
td.browser_top_bottom{height:15px;background-color:#FFFFFF;}
td.browser_left_right{width:15px;background-color:#FFFFFF;}
td.browser_top_left{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -0px -0px;background-repeat:no-repeat;overflow:hidden;}
td.browser_top_right{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -235px -0px;background-repeat:no-repeat;overflow:hidden;}
td.browser_bottom_left{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -0px -15px;background-repeat:no-repeat;overflow:hidden;}
td.browser_bottom_right{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -235px -15px;background-repeat:no-repeat;overflow:hidden;}

<?php // Outside Page 1 ?>
a{cursor:pointer;color:<?php echo $color1_2; ?>;}
a{padding:0px;margin:0px;border:none;outline:none;}
a.color_changer_blue{width:32px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') 0px 0px;}
a.color_changer_blue2{width:32px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') 0px -60px;}
a.color_changer_blue:hover{width:32px;height:30px;background:url('barterrain_outside_images/color_changer.png') 0px -30px;}
a.color_changer_blue:active{width:32px;height:30px;background:url('barterrain_outside_images/color_changer.png') 0px -30px;}
a.color_changer_green{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -32px 0px;}
a.color_changer_green2{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -32px -60px;}
a.color_changer_green:hover{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -32px -30px;}
a.color_changer_green:active{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -32px -30px;}
a.color_changer_yellow{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -63px 0px;}
a.color_changer_yellow2{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -63px -60px;}
a.color_changer_yellow:hover{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -63px -30px;}
a.color_changer_yellow:active{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -63px -30px;}
a.color_changer_orange{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -94px 0px;}
a.color_changer_orange2{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -94px -60px;}
a.color_changer_orange:hover{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -94px -30px;}
a.color_changer_orange:active{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -94px -30px;}
a.color_changer_red{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -125px 0px;}
a.color_changer_red2{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -125px -60px;}
a.color_changer_red:hover{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -125px -30px;}
a.color_changer_red:active{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -125px -30px;}
a.color_changer_purple{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -156px 0px;}
a.color_changer_purple2{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -156px -60px;}
a.color_changer_purple:hover{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -156px -30px;}
a.color_changer_purple:active{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -156px -30px;}
a.color_changer_brown{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -187px 0px;}
a.color_changer_brown2{width:31px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -187px -60px;}
a.color_changer_brown:hover{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -187px -30px;}
a.color_changer_brown:active{width:31px;height:30px;background:url('barterrain_outside_images/color_changer.png') -187px -30px;}
a.color_changer_black{width:32px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -218px 0px;}
a.color_changer_black2{width:32px;height:30px;float:left;background:url('barterrain_outside_images/color_changer.png') -218px -60px;}
a.color_changer_black:hover{width:32px;height:30px;background:url('barterrain_outside_images/color_changer.png') -218px -30px;}
a.color_changer_black:active{width:32px;height:30px;background:url('barterrain_outside_images/color_changer.png') -218px -30px;}
div.color_changer{position:relative;text-align:center;width:250px;height:30px;margin-top:-15px;}
input{padding:0px;margin:0px;}
input.email{text-align:center;font:20px helvetica, sans-serif;width:250px;height:30px;background:url('barterrain_outside_images/email_pass_background.png');background-repeat:no-repeat;margin-bottom:8px;}
input.login_button{background-color:<?php echo $color1; ?>;border-color:transparent;background-image:url('barterrain_outside_images/signin_button.png');width:250px;height:30px;}
input.password{text-align:center;font:20px helvetica, sans-serif;width:250px;height:30px;background:url('barterrain_outside_images/email_pass_background.png');background-repeat:no-repeat;margin-bottom:8px;}
input.remember{vertical-align:center;margin-right:3px;}
label.remember{vertical-align:center;font:13px helvetica, sans-serif;}
table.login_table{margin:auto;overflow:hidden;margin-top:22px;text-align:center;border-spacing:0px;}
td.space_center{text-align:center;}

<?php // Outside Page 2 ?>
input.signup_input{text-align:center;font:20px helvetica, sans-serif;width:250px;height:30px;background:url('barterrain_outside_images/email_pass_background.png');background-repeat:no-repeat;margin-bottom:8px;}
input.signup_button{background-color:<?php echo $color1; ?>;border-color:transparent;background-image:url('barterrain_outside_images/signup_button.png');width:250px;height:30px;}
select{padding:0px;margin:0px;}
select.gender{text-align:center;width:250px;color:#696969;margin-bottom:8px;}
select.settings_birthday1{text-align:center;width:102px;color:#696969;margin-bottom:8px;}
select.settings_birthday2{text-align:center;width:70px;color:#696969;margin-bottom:8px;}
table.signup_table{margin:auto;overflow:hidden;margin-top:22px;text-align:center;border-spacing:0px;}

<?php // Outside Page 3 ?>
input.forgot_email{text-align:center;font:20px helvetica, sans-serif;width:250px;height:30px;background:url('barterrain_outside_images/email_pass_background.png');background-repeat:no-repeat;margin-bottom:8px;}
input.reset_button{background-color:<?php echo $color1; ?>;border-color:transparent;background-image:url('barterrain_outside_images/reset_button.png');width:250px;height:30px;}
table.reset_table{margin:auto;overflow:hidden;margin-top:21px;text-align:center;border-spacing:0px;}

<?php // Outside Page 4 ?>
span.contact_us{display:block;width:100%;}
span.contact_us:after{content:"";display:inline-block;width:100%;}
table.contact_us_table{margin:auto;border-spacing:0px;text-align:justify;text-align-last:justify;margin-top:23px;}
td.contact_us_td{width:350px;height:50px;background-color:#FFFFFF;text-align:justify;}
td.contact_us_top_bottom{height:15px;background-color:#FFFFFF;}
td.contact_us_left_right{width:15px;background-color:#FFFFFF;}
td.contact_us_top_left{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -0px -0px;background-repeat:no-repeat;overflow:hidden;}
td.contact_us_top_right{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -235px -0px;background-repeat:no-repeat;overflow:hidden;}
td.contact_us_bottom_left{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -0px -15px;background-repeat:no-repeat;overflow:hidden;}
td.contact_us_bottom_right{width:15px;height:15px;background:url('barterrain_outside_images/email_pass_background.png') -235px -15px;background-repeat:no-repeat;overflow:hidden;}