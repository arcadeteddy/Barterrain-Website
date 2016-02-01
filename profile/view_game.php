<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
// Establish profile interaction token.
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = $_SESSION['cacheBuster'];

$media_type="games";

$id = $_SESSION['id'];
$ids = $_SESSION['ids'];
$game_id = $_POST['game_id'];
$media_id = $_POST['game_id'];

include_once "../scripts/check_login.php";

$mysql_views = mysql_query("SELECT unique_views_profile_games FROM members WHERE id=$ids LIMIT 1");
while($row = mysql_fetch_array($mysql_views))
	{$unique_views_profile_games = $row['unique_views_profile_games'];
	$unique_views_profile_games_explode = explode(",",$unique_views_profile_games);
	$unique_views_profile_games_slice = array_slice($unique_views_profile_games_explode, 0, 1);}
$mysql_views = mysql_query("SELECT unique_views, total_views FROM games WHERE id=$game_id LIMIT 1");
while($row = mysql_fetch_array($mysql_views))
	{$unique_views = $row['unique_views'];
	$total_views = $row['total_views'];}
if (!in_array($game_id,$unique_views_profile_games_explode))
	{$unique_views=$unique_views+1;
	$total_views=$total_views+1;
	if ($unique_views_profile_games != ""){$unique_views_profile_games = "$game_id,$unique_views_profile_games";}
	else {$unique_views_profile_games = "$game_id";}}
else if (!in_array($game_id,$unique_views_profile_games_slice))
	{$total_views=$total_views+1;
	foreach ($unique_views_profile_games_explode as $key => $value) 
		{if ($value == $game_id)
			{unset($unique_views_profile_games_explode[$key]);}}
	$unique_views_profile_games = implode(",",$unique_views_profile_games_explode);
	if ($unique_views_profile_games != ""){$unique_views_profile_games = "$game_id,$unique_views_profile_games";}
	else {$unique_views_profile_games = "$game_id";}}
mysql_query("UPDATE games SET unique_views='$unique_views', total_views='$total_views' WHERE id='$game_id'");
mysql_query("UPDATE members SET unique_views_profile_games='$unique_views_profile_games' WHERE id='$ids'");

$mysql2 = mysql_query("SELECT id, user_id, game_name FROM games WHERE id=$game_id");
while($row = mysql_fetch_array($mysql2))
	{$user_id = $row['user_id'];
	$game_name = $row['game_name'];}
$mysql2 = mysql_query("SELECT * FROM games WHERE id=$game_id");
$numRows2=mysql_num_rows($mysql2);
while ($row = mysql_fetch_array ($mysql2))
	{$game_id = $row['id'];
	$item_id = $row['id'];
	$user_id = $row['user_id'];
	$game_name = $row['game_name'];
	$game_description = $row['game_description'];
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$game_type =  $row['game_type'];
	$memory_type =  $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = count($commentArray);
	$like_array_game = $row['like_array'];
	$love_array_game = $row['love_array'];
	$likeArray_game = explode(",",$like_array_game);
	$loveArray_game = explode(",",$love_array_game);
	$like_array_count_game = count($likeArray_game);
	$love_array_count_game = count($loveArray_game);
	$point_array_game = $row['point_array'];
	$pointArray_game = explode(",",$point_array_game);
	$point_array_count_game = count($pointArray_game);
	$point_array_count_game = $point_array_count_game*10;
	if($point_array_game==""){$point_array_count_game="0";}
	}
	
	$comment_type="games";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_game))
			{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_game))
			{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_game !="")AND($love_array_game !=""))
			{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_game !="")
			{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_game !="")
			{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_game = "";}
	
	// Little Things
	if($ids==$user_id)
	{if($game_type=="a"){$type="<div class='option_box' id='type_change_games".$game_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$game_id.",".$comment_type.");'></a></div>";}
	else if($game_type=="b"){$type="<div class='option_box' id='type_change_games".$game_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$game_id.",".$comment_type.");'></a></div>";}
	else if($game_type=="c"){$type="<div class='option_box' id='type_change_games".$game_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$game_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_games".$game_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$game_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_games".$game_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$game_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id){$point="<div class='option_box2' id='point_games".$game_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$game_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_game."</b></div>";}
	else if($point_array_count_game=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' title='Point Array' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_game."</b></a></div>";}
	if($ids==$user_id)
		{$delete_button_game="<div class='option_box' id='delete_games".$game_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_media(".$game_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_game="";}
	if($game_description==""){$game_description="";}
	else{$game_description="<br/><b>Description: </b>".$game_description."<br/>";}
	if ($game_name=="")
		{$game_name == "Untitled";}

$check_size="../user_files/user$user_id/game_".$game_id."/game_".$game_id.".swf";
list($width, $height) = getimagesize($check_size);
$multiplier=755/$width;
$height=$multiplier*$height;

ob_flush();
?>
<head>
<script src="profile.js" type="text/javascript" async></script>
<script type="text/javascript" async>
// CHANGER //
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var game_id = "<?php echo $game_id; ?>";
var media_type = "<?php echo $media_type; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var url = "../scripts/interactive_box.php";
var interactiveURL = "../scripts/interactive_changer.php";

////////////// TOP BOXES //////////////
function media_post()
	{$("#interactive_error").html('').show();
	$.post(interactiveURL,{interactive:"media_post"},function(data) 
		{$(".top_boxes").removeClass("selected_box");
		$(".top_box1").toggleClass("selected_box");
		$("#bottom_half_box").html(data).show();});
	}
	
////////////// GAMES POSTING //////////////
$('#media_post_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function media_post_form()
	{var post_field = $('#post_field');
	var post_type = $('#post_type:checked');
	if (post_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Post field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,ids:ids,media_post:post_field.val(),type:post_type.val(),media_id:game_id,media_type:media_type,thisWipit:thisRandNum},function(data)
			{$('#bottom_media_game').html(data).show();
			document.media_post_form.post_field.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
	
// DELETE GAMES
function delete_media(a,b)
	{$.post(interactiveURL,{item_id:a,item_type:b,interactive:"delete_media1"},function(data) 
		{$("#delete_"+b+a).html(data).show();});}
function delete_media2(a,b)
	{$.post(url,{id:id,ids:ids,item_id:a,item_type:b,interactive:"delete_media2",thisWipit:thisRandNum},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_3").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
</script>
</head>

<body>
<font>

<div class="entire_bottom_media" id="entire_bottom_media">
<div><font class="media_header"><?php echo $game_name; ?></font><div class='option_box_wrap2'><?php echo $point."".$type."".$memory_box."".$delete_button_game; ?></div></div>
<object style="width:755px;height:<?php echo $height; ?>px;margin:5px 0px;z-index:-10000;" scale="exactfit" wmode="transparent" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
	<param name="movie" value="../user_files/user<?php echo $id; ?>/game_<?php echo $game_id; ?>/game_<?php echo $game_id; ?>.swf"></param> 
	<param name="wmode" value="opaque"></param> 
</object>
<br/><?php echo $game_description;?><br/><b>Unique Views: </b><?php echo $unique_views;?> | <b>Total Views: </b><?php echo $total_views;?><br/><br/>
<?php echo "<div id='like_love_games".$game_id."' class='inline'>
			".$like_love_game."
			<span class='dot_divider'> &middot; </span><span class='post_date'>".$upload_date."</span>
			".$like_love2_game."</div>"; 
?>
</div>

<div class="folder_content_left"><br/>
<div class="top_content">
	<div id="top_half_box" class="top_half_box">
		<a href='#' class='top_box1 top_boxes' onclick='return false' onmousedown='javascript:media_post();'></a>
	</div>
	<div id="bottom_half_box">
		<div class="bottom_half_box">
			<a href='#' onclick='return false' onmousedown='javascript:media_post();'><input class="top_box_input" placeholder="Post Something..."/></a>
		</div>
	</div>
</div>
<br/>
<div id='interactive_error' style='text-align:center;width:100%;'></div>
<div class="just_line"></div>
<div class="bottom_wall" id="bottom_media_game">
	<?php include "games_posts_content.php";?>
</div>
<div class="bottom_box2" id="bottom_box">
	<div class="expand_bottom_wall" id="expand_bottom_box">
		<center><span class="expand_bottom_box">&#9660;</span></center>
	</div>
	<div class="expand_bottom_wall" id="load_content_scroll" style="display:none;">
		<center><img class="loader" src="barterrain_profile_images/loader_light_<?php echo $color;?>.gif"></center>
	</div>
</div>
</div>


</font>
</body>