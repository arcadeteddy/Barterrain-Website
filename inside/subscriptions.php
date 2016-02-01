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

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";

$mysql = mysql_query("SELECT id,subscriptions_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$user_id=$row['id'];
	$subscriptions_array = $row['subscriptions_array'];
	$subscriptions_array = explode(",",$subscriptions_array);
	$Subscriptions = join(',',$subscriptions_array);}
	
ob_flush();
?>

<script src="inside.js" type="text/javascript" async></script>

<body>
<font>

<div class="just_line"></div>
<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_subscriptions">
	<?php include "subscriptions_content.php";?>
</div>
<div class="bottom_box" id="bottom_box">
	<div class="expand_bottom_wall" id="expand_bottom_box">
		<center><span class="expand_bottom_box">&#9660;</span></center>
	</div>
	<div class="expand_bottom_wall" id="load_content_scroll" style="display:none;">
		<center><img class="loader" src="barterrain_inside_images/loader_light_<?php echo $color;?>.gif" width="220px" height="19px"></center>
	</div>
</div>
</div>

</font>
</body>