<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
// Establish Planet interaction token.
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
// Establish Planet interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = $_SESSION['cacheBuster'];

$media_type="videos";

$video_id = $_POST['video_id'];
$media_id = $_POST['video_id'];

include_once "../scripts/check_login.php";

$mysql = mysql_query("SELECT user_id,creator_array,admin_array,member_array FROM planets WHERE id='$id'");
while($row = mysql_fetch_array($mysql))
	{$user_id = $row['user_id'];
	$creator_array = $row['creator_array'];
	$admin_array = $row['admin_array'];
	$member_array = $row['member_array'];
	
	$memberArray=explode(",",$member_array);
	$adminArray=explode(",",$admin_array);
	$creatorArray=explode(",",$creator_array);
	$CREATORS=join(',',$creatorArray);
	}

$mysql_views = mysql_query("SELECT unique_views_planets_videos FROM members_planets WHERE id=$ids LIMIT 1");
while($row = mysql_fetch_array($mysql_views))
	{$unique_views_planets_videos = $row['unique_views_planets_videos'];
	$unique_views_planets_videos_explode = explode(",",$unique_views_planets_videos);
	$unique_views_planets_videos_slice = array_slice($unique_views_planets_videos_explode, 0, 1);}
$mysql_views = mysql_query("SELECT unique_views, total_views FROM planets_videos WHERE id=$video_id LIMIT 1");
while($row = mysql_fetch_array($mysql_views))
	{$unique_views = $row['unique_views'];
	$total_views = $row['total_views'];}
if (!in_array($video_id,$unique_views_planets_videos_explode))
	{$unique_views=$unique_views+1;
	$total_views=$total_views+1;
	if ($unique_views_planets_videos != ""){$unique_views_planets_videos = "$video_id,$unique_views_planets_videos";}
	else {$unique_views_planets_videos = "$video_id";}}
else if (!in_array($video_id,$unique_views_planets_videos_slice))
	{$total_views=$total_views+1;
	foreach ($unique_views_planets_videos_explode as $key => $value) 
		{if ($value == $video_id)
			{unset($unique_views_planets_videos_explode[$key]);}}
	$unique_views_planets_videos = implode(",",$unique_views_planets_videos_explode);
	if ($unique_views_planets_videos != ""){$unique_views_planets_videos = "$video_id,$unique_views_planets_videos";}
	else {$unique_views_planets_videos = "$video_id";}}
mysql_query("UPDATE planets_videos SET unique_views='$unique_views', total_views='$total_views' WHERE id='$video_id'");
mysql_query("UPDATE members_planets SET unique_views_planets_videos='$unique_views_planets_videos' WHERE id='$ids'");

$mysql2 = mysql_query("SELECT * FROM planets_videos WHERE id=$video_id");
$numRows2=mysql_num_rows($mysql2);
while ($row = mysql_fetch_array ($mysql2))
	{$video_id = $row['id'];
	$item_id = $row['id'];
	$user_page_id = $row['user_page_id'];
	$user_post_id = $row['user_post_id'];
	$video_name = $row['video_name'];
	$video_description = $row['video_description'];
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$video_type =  $row['video_type'];
	$memory_type =  $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = count($commentArray);
	$like_array_video = $row['like_array'];
	$love_array_video = $row['love_array'];
	$likeArray_video = explode(",",$like_array_video);
	$loveArray_video = explode(",",$love_array_video);
	$like_array_count_video = count($likeArray_video);
	$love_array_count_video = count($loveArray_video);
	$point_array_video = $row['point_array'];
	$pointArray_video = explode(",",$point_array_video);
	$point_array_count_video = count($pointArray_video);
	$point_array_count_video = $point_array_count_video*10;
	if($point_array_video==""){$point_array_count_video="0";}
	}
	
	$comment_type="videos";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_video))
			{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_video))
			{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_video !="")AND($love_array_video !=""))
			{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_video !="")
			{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_video !="")
			{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_video = "";}
	
	// Little Things
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($video_type=="a"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}
	else if($video_type=="b"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}
	else if($video_type=="c"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_videos".$video_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$video_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_videos".$video_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$video_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_post_id){$point="<div class='option_box2' id='point_videos".$video_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$video_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_video."</b></div>";}
	else if($point_array_count_video=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_video."</b></a></div>";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
		{$delete_button_video="<div class='option_box' id='delete_videos".$video_id."'><a title='Delete' href='#' class='top_options_delete1' onclick='return false' onmousedown='javascript:delete_media(".$video_id.",".$comment_type.");'></a></div>";}
		else{$delete_button_video="";}
	if($video_description==""){$video_description="";}
	else{$video_description="<br/><b>Description: </b>".$video_description."<br/>";}
	if ($video_name=="")
		{$video_name == "Untitled";}
		
ob_flush();
?>
<head>
<script type="text/javascript">
// CHANGER //
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var video_id = "<?php echo $video_id; ?>";
var media_type = "<?php echo $media_type; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var url = "../scripts/create_interactive_box.php";
var interactiveURL = "../scripts/create_interactive_changer.php";

////////////// TOP BOXES //////////////
function media_post()
	{$("#interactive_error").html('').show();
	$.post(interactiveURL,{interactive:"media_post"},function(data) 
		{$(".top_boxes").removeClass("selected_box");
		$(".top_box1").toggleClass("selected_box");
		$("#bottom_half_box").html(data).show();});
	}
	
////////////// VIDEOS POSTING //////////////
$('#media_post_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function media_post_form()
	{var post_field = $('#post_field');
	var post_type = $('#post_type:checked');
	if (post_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Post field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,ids:ids,media_post:post_field.val(),type:post_type.val(),media_id:video_id,media_type:media_type,typex:type,thisWipit:thisRandNum},function(data)
			{$('#bottom_media_video').html(data).show();
			document.media_post_form.post_field.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
	
// DELETE VIDEOS
function delete_media(a,b)
	{$.post(interactiveURL,{item_id:a,item_type:b,interactive:"delete_media1"},function(data) 
		{$("#delete_"+b+a).html(data).show();});}
function delete_media2(a,b)
	{$.post(url,{id:id,ids:ids,item_id:a,item_type:b,interactive:"delete_media2",typex:type,thisWipit:thisRandNum},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".planet_window_3").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
</script>
</head>

<body>
<font>

<div class="entire_bottom_media" id="entire_bottom_media">
<div><font class="media_header"><?php echo $video_name;?></font><div class='option_box_wrap2'><?php echo $point."".$type."".$memory_box."".$delete_button_video; ?></div></div>
<?php echo "<div class='video_screen_big'>
				<object type='application/x-shockwave-flash' data='../scripts/player.swf' width='755' height='449;'>
    				<param name='allowfullscreen' value='true'>
    				<param name='allowscriptaccess' value='always'>
    				<param name='flashvars' value='file=../planet_files/planet".$user_page_id."/planet_video_".$video_id."/planet_video_".$video_id.".mp4'>
       				<img src='../planet_files/planet".$user_page_id."/planet_video_".$video_id."/planet_video_".$video_id."_cover.jpg' width='417px' height='259px' alt='".$video_name."'>
  				</object>
       		</div>";
?>
<?php echo $video_description;?><br/><b>Unique Views: </b><?php echo $unique_views;?> | <b>Total Views: </b><?php echo $total_views;?><br/><br/>
<?php echo "<div id='like_love_videos".$video_id."' class='inline'>
			".$like_love_video."
			<span class='dot_divider'> &middot; </span>				
			<span class='post_date'>".$upload_date."</span>
			".$like_love2_video."</div>"; 
?>
</div>

<div class="folder_content_left"><br/>
<div class="top_content">
	<div id="top_half_box" class="top_half_box">
		<a href="#" class="top_box1 top_boxes" onclick="return false" onmousedown="javascript:media_post();"></a>
	</div>
	<div id="bottom_half_box">
		<div class="bottom_half_box">
			<a href="#" onclick="return false" onmousedown="javascript:media_post();"><input class="top_box_input" placeholder="Post Something..."/></a>
		</div>
	</div></div><br/>
<div id='interactive_error' style='text-align:center;width:100%;'></div>
<div class="just_line"></div>
<div class="bottom_wall" id="bottom_media_video">
	<?php include "planet_videos_posts_content.php";?>
</div>
<div class="bottom_box2" id="bottom_box">
	<div class="expand_bottom_wall" id="expand_bottom_box">
		<center><span class="expand_bottom_box">&#9660;</span></center>
	</div>
	<div class="expand_bottom_wall" id="load_content_scroll" style="display:none;">
		<center><img class="loader" src="barterrain_planet_images/loader_light_<?php echo $color;?>.gif" width="220px" height="19px"></center>
	</div>
</div>
</div>


</font>
</body>