<?php
ob_start();
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = $_SESSION['cacheBuster'];

$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";

$mysql = mysql_query("SELECT * FROM planets WHERE id='$id'");
while($row = mysql_fetch_array($mysql))
	{$creator_display = $row['creator_display'];
	$user_id = $row['user_id'];
	$creator_array = $row['creator_array'];
	$admin_array = $row['admin_array'];
	$member_array = $row['member_array'];
	$block_array = $row['block_array'];
	$planets_array = $row['planets_array'];
	if ($planets_array=="") {$planets_array=$id;}
	
	$memberArray=explode(",",$member_array);
	$adminArray=explode(",",$admin_array);
	$creatorArray=explode(",",$creator_array);
	$CREATORS=join(',',$creatorArray);
	$planetsArray=explode(",",$planets_array);
	$PLANETS=join(',',$planetsArray);
	}

$mysql2 = mysql_query("SELECT id FROM planets_albums WHERE user_page_id=$id");
$numRows1=mysql_num_rows($mysql2);
$mysql2 = mysql_query("SELECT id FROM planets_videos WHERE user_page_id=$id");
$numRows2=mysql_num_rows($mysql2);
$mysql2 = mysql_query("SELECT id FROM planets_games WHERE user_page_id=$id");
$numRows3=mysql_num_rows($mysql2);

ob_flush();
?>

<script type="text/javascript">
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
// DELETE
function delete_folder1(a,b)
	{$.post(interactiveURL,{item_id:a,item_type:b,typex:type,interactive:"delete_folder1"},function(data) 
		{$("#delete_folder_"+b+a).html(data).show();});}
function delete_folder2(a,b)
	{$.post(url,{id:id,ids:ids,item_id:a,item_type:b,typex:type,interactive:"delete_folder2",thisWipit:thisRandNum},function(data) 
		{$("#"+b+"_list").html(data).show();});}
</script>

<body>
<font>
<?php
if ((isset($_SESSION['ids']))AND(in_array($ids, $creatorArray)))
{echo '<div class="top_half_box" id="top_half_box">
			<a href="#" class="top_box2 top_boxes" onclick="return false" onmousedown="javascript:upload_media();"></a><br/>
		</div>
		<div id="bottom_half_box"><div class="bottom_half_box">
			<a href="#" onclick="return false" onmousedown="javascript:upload_media();"><input class="top_box_input" placeholder="Upload Something..."/></a>
		</div></div>
		
		<div id="bottom_half_box_media" class="bottom_half_box_hide" style="display:none;">
    	<div id="bottom_half_box3"><div class="bottom_half_box3">
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_images" onClick="return false" onMouseDown="javascript:UploadImages();"></a>
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_gifs" onClick="return false" onMouseDown="javascript:UploadGifs();"></a>
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_videos" onClick="return false" onMouseDown="javascript:UploadVideos();"></a>
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_games" onClick="return false" onMouseDown="javascript:UploadGames();"></a>
		</div></div>
     </div><br/>';
		}
else {echo "";}
?>

<div id="interactive_error" style="text-align:center;width:100%;"></div>

<div id="albums_list">
<?php // Albums
include_once "planet_albums_list.php";
?></div>
<div id="member_albums_list">
<?php // Albums
include_once "planet_member_albums_list.php";
?></div>
<div id="games_list">
<?php // Games
include_once "planet_games_list.php";
?></div>
<div id="videos_list">
<?php // Videos
include_once "planet_videos_list.php";
?></div>

</font>
</body>