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

$mysql = mysql_query("SELECT id,family_array, friend_array FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql))
	{$id = $row['id'];
	$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$FF_array2=$ids.",".$family_array.",".$friend_array;
	$FF_array2 = explode(",",$FF_array2);
	$FF_News = join(',',$FF_array2);}
	
ob_flush();
?>

<script src="inside.js" type="text/javascript" async></script>

<body>
<font>

<div class="top_half_box" id="top_half_box">
	<a href="#" class="top_box2 top_boxes" onClick="return false" onMouseDown="javascript:upload_media();"></a><br/>
</div>
<div id="bottom_half_box"><div class="bottom_half_box">
	<a href="#" onClick="return false" onMouseDown="javascript:upload_media();"><input class="top_box_input" placeholder="Upload Something..."/></a>
</div></div>

     <div id="bottom_half_box_media" class="bottom_half_box_hide" style="display:none;">
    	<div id="bottom_half_box3"><div class="bottom_half_box3">
			<a href="#" src="blank.gif" class="upload_choice_images" onClick="return false" onMouseDown="javascript:UploadImages();"></a>
            <a href="#" src="blank.gif" class="upload_choice_gifs" onClick="return false" onMouseDown="javascript:UploadGifs();"></a>
			<a href="#" src="blank.gif" class="upload_choice_videos" onClick="return false" onMouseDown="javascript:UploadVideos();"></a>
			<a href="#" src="blank.gif" class="upload_choice_games" onClick="return false" onMouseDown="javascript:UploadGames();"></a>
		</div></div>
     </div>
    
<br/>
<div id='interactive_error' style='text-align:center;width:100%;'></div>
<div class="just_line"></div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_media">
	<?php include "media_content.php";?>
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