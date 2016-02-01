<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

include_once "../scripts/check_login.php";

$DisplayList ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";
$cacheBuster = $_SESSION['cacheBuster'];

$ids = $_SESSION['ids'];

$mysql = mysql_query("SELECT * FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$id = $row['id'];
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];}
	
ob_flush();
?>

<script src="profile.js" type="text/javascript" async></script>

<body>
<font>

<div class="just_line"></div>
<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_memory_box">
	<?php include "memory_box_content.php"; ?>
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