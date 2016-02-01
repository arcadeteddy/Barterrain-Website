<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

$array="";
$DisplayList ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";
$cacheBuster = $_SESSION['cacheBuster'];

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";

$mysql = mysql_query("SELECT id, firstname, lastname, subscriptions_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$user_id=$row['id'];
	$user_firstname=$row['firstname'];
	$user_lastname=$row['lastname'];
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$subscriptions_array = $row['subscriptions_array'];
	$subscriptionsArray = explode(",",$subscriptions_array);
	$Subscriptions = join(',',$subscriptionsArray);  
	$check_pic="../user_files/user$id/profile_thumb.jpg";
	$default_pic="../user_files/user0/default_profile_pic_thumb.png";
	if (file_exists($check_pic))
		{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$id."'><img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
	else
		{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$id."'><img src='$default_pic' width='55px' height='55px' class='thumb_background' /></a>";}
	}
	
if($subscriptions_array!==""){$content="<div class='middle_bars'><div class='float_left'><img src='blank.gif' width='1px' height='1px' class='subscriptions_activity_lists'/><span class='heading_list'>Their Activity</span></div><div class='float_right'></div></div>";}
else{$content="";}

ob_flush();
?>

<script src="profile.js" type="text/javascript" async></script>

<body>
<font>

<div id="subscribers_list">
<?php // Subscriptions
include_once "subscribers_list.php";
?>
</div>
<div id="subscriptions_list">
<?php // Subscriptions
include_once "subscriptions_list.php";
?>
</div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_subscriptions">
	<?php echo $content;
	include "subscriptions_content.php"; ?>
</div>
<div class="bottom_box" id="bottom_box">
	<div class="expand_bottom_wall" id="expand_bottom_box">
		<center><span class="expand_bottom_box">&#9660;</span></center>
	</div>
	<div class="expand_bottom_wall" id="load_content_scroll" style="display:none;">
		<center><img class="loader" src="barterrain_profile_images/loader_light_<?php echo $color;?>.gif" width="220px" height="19px"></center>
	</div>
</div>
</div>

</font>
</body>