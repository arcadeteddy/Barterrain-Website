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

$mysql = mysql_query("SELECT firstname,lastname FROM members WHERE id=$id");
$mysql2 = mysql_query("SELECT id FROM albums WHERE user_id=$id");
$numRows1=mysql_num_rows($mysql2);
$mysql2 = mysql_query("SELECT id FROM games WHERE user_id=$id");
$numRows2=mysql_num_rows($mysql2);
while($row = mysql_fetch_array($mysql))
	{$firstname = $row['firstname'];
	$lastname = $row['lastname'];}

ob_flush();
?>

<script src="profile.js" type="text/javascript" async></script>
<script type="text/javascript">
// INPUT FIREFOX FIXER //
$('input[type="file"]').attr('size', '76');
// CHANGER //
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";

<script type="text/javascript">		
function remove_new_album()
	{$.post(interactiveURL,{interactive:"remove_new_album"},function(data) 
		{$("#remove_new_album").html(data).show();});}
function add_new_album()
	{$.post(interactiveURL,{interactive:"add_new_album"},function(data) 
		{$("#remove_new_album").html(data).show();});}
</script>

<body>
<font>
<?php
if (isset($_SESSION['ids']) && $_SESSION['ids'] != $id)
	{echo "";}
else if (isset($_SESSION['ids']) && $_SESSION['ids'] === $id)
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
     	</div>
		
		<br/>';}
?>

<div id='interactive_error' style='text-align:center;width:100%;'></div>

<div id="albums_list">
<?php // Albums
include_once "albums_list.php";
?></div>
<div id="games_list">
<?php // Games
include_once "games_list.php";
?></div>
<div id="videos_list">
<?php // Videos
include_once "videos_list.php";
?></div>

</font>
</body>