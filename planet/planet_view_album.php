<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
// Establish planet interaction token.
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
// Establish planet interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = $_SESSION['cacheBuster'];

$media_type="albums";

$album_id = $_POST['album_id'];
$media_id = $_POST['album_id'];

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

$mysql_views = mysql_query("SELECT unique_views_planets_albums FROM members_planets WHERE id=$ids LIMIT 1");
while($row = mysql_fetch_array($mysql_views))
	{$unique_views_planets_albums = $row['unique_views_planets_albums'];
	$unique_views_planets_albums_explode = explode(",",$unique_views_planets_albums);
	$unique_views_planets_albums_slice = array_slice($unique_views_planets_albums_explode, 0, 1);}
$mysql_views = mysql_query("SELECT unique_views, total_views FROM planets_albums WHERE id=$album_id LIMIT 1");
while($row = mysql_fetch_array($mysql_views))
	{$unique_views = $row['unique_views'];
	$total_views = $row['total_views'];}
if (!in_array($album_id,$unique_views_planets_albums_explode))
	{$unique_views=$unique_views+1;
	$total_views=$total_views+1;
	if ($unique_views_planets_albums != ""){$unique_views_planets_albums = "$album_id,$unique_views_planets_albums";}
	else {$unique_views_planets_albums = "$album_id";}}
else if (!in_array($album_id,$unique_views_planets_albums_slice))
	{$total_views=$total_views+1;
	foreach ($unique_views_planets_albums_explode as $key => $value) 
		{if ($value == $album_id)
			{unset($unique_views_planets_albums_explode[$key]);}}
	$unique_views_planets_albums = implode(",",$unique_views_planets_albums_explode);
	if ($unique_views_planets_albums != ""){$unique_views_planets_albums = "$album_id,$unique_views_planets_albums";}
	else {$unique_views_planets_albums = "$album_id";}}
mysql_query("UPDATE planets_albums SET unique_views='$unique_views', total_views='$total_views' WHERE id='$album_id'");
mysql_query("UPDATE members_planets SET unique_views_planets_albums='$unique_views_planets_albums' WHERE id='$ids'");

$mysql2 = mysql_query("SELECT * FROM planets_albums WHERE id=$album_id");
$numRows2=mysql_num_rows($mysql2);
while ($row = mysql_fetch_array ($mysql2))
	{$album_id = $row['id'];
	$item_id = $row['id'];
	$user_page_id = $row['user_page_id'];
	$user_post_id = $row['user_post_id'];
	$album_name = $row['album_name'];
	$album_description = $row['album_description'];
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$album_type =  $row['album_type'];
	$memory_type =  $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = count($commentArray);
	$like_array_album = $row['like_array'];
	$love_array_album = $row['love_array'];
	$likeArray_album = explode(",",$like_array_album);
	$loveArray_album = explode(",",$love_array_album);
	$like_array_count_album = count($likeArray_album);
	$love_array_count_album = count($loveArray_album);
	$point_array_album = $row['point_array'];
	$pointArray_album = explode(",",$point_array_album);
	$point_array_count_album = count($pointArray_album);
	$point_array_count_album = $point_array_count_album*10;
	if($point_array_album==""){$point_array_count_album="0";}
	}
	
	$comment_type="albums";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_album))
			{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_album))
			{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_album !="")AND($love_array_album !=""))
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_album !="")
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_album !="")
			{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_album = "";}
	
	// Little Things
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($album_type=="a"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
	else if($album_type=="b"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
	else if($album_type=="c"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_post_id){$point="<div class='option_box2' id='point_albums".$album_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$album_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_album."</b></div>";}
	else if($point_array_count_album=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_album."</b></a></div>";}
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
		{$delete_button_album="<div class='option_box' id='delete_albums".$album_id."'><a title='Delete' href='#' class='top_options_delete1' onclick='return false' onmousedown='javascript:delete_media(".$album_id.",".$comment_type.");'></a></div>";}
		else{$delete_button_album="";}
	if($album_description==""){$album_description="";}
	else{$album_description="<br/><b>Description: </b>".$album_description."<br/>";}
	if ($album_name=="")
		{$album_name == "Untitled";}
	
ob_flush();
?>
<head>
<script type="text/javascript">
// CHANGER //
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var album_id = "<?php echo $album_id; ?>";
var media_type = "<?php echo $media_type; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var url = "../scripts/create_interactive_box.php";
var interactiveURL = "../scripts/create_interactive_changer.php";
var like_loveURL = "../scripts/like_love.php";

////////////// TOP BOXES //////////////
function media_post()
	{$("#interactive_error").html('').show();
	$.post(interactiveURL,{interactive:"media_post"},function(data) 
		{$(".top_boxes").removeClass("selected_box");
		$(".top_box1").toggleClass("selected_box");
		$("#bottom_half_box").html(data).show();});
	}
	
////////////// ALBUMS POSTING //////////////
$('#media_post_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function media_post_form()
	{var post_field = $('#post_field');
	var post_type = $('#post_type:checked');
	if (post_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Post field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,ids:ids,media_post:post_field.val(),type:post_type.val(),media_id:album_id,media_type:media_type,typex:type,thisWipit:thisRandNum},function(data)
			{$('#bottom_media_album').html(data).show();
			document.media_post_form.post_field.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}

// DELETE ALBUMS
function delete_media(a,b)
	{$.post(interactiveURL,{item_id:a,item_type:b,typex:type,interactive:"delete_media1"},function(data) 
		{$("#delete_"+b+a).html(data).show();});}
function delete_media2(a,b)
	{$.post(url,{id:id,ids:ids,item_id:a,item_type:b,typex:type,interactive:"delete_media2",thisWipit:thisRandNum},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".planet_window_3").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}

// DELETE IMAGES
function delete_image1(a,b)
	{$.post(interactiveURL,{item_id:a,item_type:b,typex:type,interactive:"delete_image1"},function(data) 
		{$("#delete_image_"+a).html(data).show();});}
function delete_image2(a,b)
	{$.post(url,{id:id,ids:ids,album_id:album_id,item_id:a,item_type:b,typex:type,interactive:"delete_image2",thisWipit:thisRandNum},function(data) 
		{$("#image_box_wrap").html(data).show();});}
		
// Like/Love Images
function Like_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Like_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
function Love_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Love_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
function unlikeLike_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unlikeLike_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
function unloveLove_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unloveLove_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
</script>
</head>

<body>
<font>

<div class="entire_bottom_media" id="entire_bottom_media">
<div><font class="media_header"><?php echo $album_name;?></font><div class='option_box_wrap2'><?php echo $point."".$type."".$memory_box."".$delete_button_album; ?></div></div>
<div class="entire_bottom_media_album"><div class="image_box_wrap" id="image_box_wrap"><?php include "planet_images_list.php"; ?></div></div>
<?php echo $album_description;?><br/><b>Unique Views: </b><?php echo $unique_views;?> | <b>Total Views: </b><?php echo $total_views;?><br/><br/>
<?php echo "<div id='like_love_albums".$album_id."' class='inline'>
			".$like_love_album."
			<span class='dot_divider'> &middot; </span>						
			<span class='post_date'>".$upload_date."</span>
			".$like_love2_album."</div>"; 
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
<div class="bottom_wall" id="bottom_media_album">
	<?php include_once "planet_albums_posts_content.php";?>
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