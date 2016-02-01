<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include_once "../config.php";

$cacheBuster = rand(9999999,99999999999);
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";
ob_flush();

$mysql = mysql_query("SELECT firstname,lastname FROM members WHERE id='$ids'");
while($row = mysql_fetch_array($mysql))
	{$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$check_pic="../user_files/user$ids/profile_pic.jpg";
	$default_pic="../user_files/user0/default_profile_pic.png";
	if (file_exists($check_pic)){$user_pic="<img class='profile_image thumb_background' src='$check_pic#$cacheBuster' width='260px' height='auto'/>";}
	else{$user_pic="<img class='profile_image thumb_background' src='$default_pic' width='260px' height='auto'/>";}}
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Points - <?php echo $firstname." ".$lastname;?></title>	
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="../inside/barterrain_inside.php" media="screen">
<link rel="stylesheet" href="barterrain_points.php" media="screen">   
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>
<script type="text/javascript" async>
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var color = "<?php echo $color; ?>";
var like_loveURL = "../scripts/like_love.php";
var PageChangerURL = "../scripts/page_changer.php";

function window_1(a,b)
	{$.post(PageChangerURL,{page:"points_window_1",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".points_window_1").toggleClass("selected_window");
		$(".search_list").addClass("hidden_filter_search");
		$(".filter_list").removeClass("hidden_filter_search");
		$("#points_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_2(a,b)
	{$.post(PageChangerURL,{page:"points_window_2",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".points_window_2").toggleClass("selected_window");
		$(".search_list").addClass("hidden_filter_search");
		$(".filter_list").addClass("hidden_filter_search");
		$("#points_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}

function window_3(a,b)
	{$.post(PageChangerURL,{page:"points_window_3",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".points_window_3").toggleClass("selected_window");
		$(".search_list").addClass("hidden_filter_search");
		$(".filter_list").addClass("hidden_filter_search");
		$("#points_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
// Same Length
window.onload=function()
	{$('#points_page_right').css('min-height', $('#points_page_left').height()+'px');
	<?php if ((isset($_GET['points']))AND($_GET['points']=="totals"))
				{echo '$(".side_button").removeClass("selected_window");
				$(".points_window_3").toggleClass("selected_window");';}
			else if ((isset($_GET['points']))AND($_GET['points']=="planet"))
				{echo '$(".side_button").removeClass("selected_window");
				$(".points_window_2").toggleClass("selected_window");';}
	?>};
</script>
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
<div class="points_page_body_cover">
<div class="points_page_body">

<div class="points_page_left" id="points_page_left">
	<div class="margin"></div>
    <div class="white_background">
	<?php echo $user_pic;?>
    <br/><br/><font class="side_header">&#5528; 
	<?php $mysql_points = mysql_query("SELECT points FROM economy WHERE id=$id");
		while($row = mysql_fetch_array($mysql_points))
			{$points = $row['points'];}
		echo $points;?></font><br/><br/>
	<a href="#" class="side_button" onClick="return false" onMouseDown="javascript:window_1(<?php echo $ids;?>,<?php echo $id;?>);"><div class="side_button selected_window points_window_1"><img src="blank.gif" width="1px" height="1px" class="profile_transactions"/><span class="points_side">Profile Transactions</span></div></a>
    <a href="#" class="side_button" onClick="return false" onMouseDown="javascript:window_2(<?php echo $ids;?>,<?php echo $id;?>);"><div class="side_button points_window_2"><img src="blank.gif" width="1px" height="1px" class="planet_transactions"/><span class="points_side">Planet Transactions</span></div></a>
	<a href="#" class="side_button" onClick="return false" onMouseDown="javascript:window_3(<?php echo $ids;?>,<?php echo $id;?>);"><div class="side_button points_window_3"><img src="blank.gif" width="1px" height="1px" class="points_totals"/><span class="points_side">Point Totals</span></div></a>
    
    </div>
    <div class="side_bottom"></div>
</div>

<div class="points_page_body_left"></div>

<div class="points_page_right" id="points_page_right">
	<?php if ((isset($_GET['points']))AND($_GET['points']=="totals"))
			{include_once "point_totals.php";}
		else if ((isset($_GET['points']))AND($_GET['points']=="planet"))
			{include_once "planet_transactions.php";}
		else {include_once "profile_transactions.php";} ?>
</div>
<div class="white_background_full">
</div>

</div>
<div class="points_page_body_right">
<div id="back_top" class="back_top"><img src="blank.gif" width="1px" height="1px" class="back_top" id="back_top_img"/></div>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>