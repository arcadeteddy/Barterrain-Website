<?php
ob_start();
include_once "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
if(!isset($number)){$number="0";}
$DisplayList ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";

if(isset($_GET['number']))
	{$number=$_GET['number'];
	$cacheBuster=$_GET['cacheBuster'];
	$id=$_GET['id'];
	$ids=$_GET['ids'];
	$media_id=$_GET['video_id'];}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
////////// WALL!!! //////////
$mysql_union = mysql_query("(SELECT id, post_date AS datetime, union_type FROM videos_posts WHERE video_id='$media_id' AND union_type='videos_posts') ORDER BY datetime DESC LIMIT ".$number.",20");
$numRows=mysql_num_rows($mysql_union);
if ($numRows>0){
while ($row = mysql_fetch_array ($mysql_union))
	{$item_id = $row['id'];
	$datetime = $row['datetime'];
	$union_type = $row['union_type'];

if ($union_type=="videos_posts")
{$mysql1 = mysql_query("SELECT * FROM videos_posts WHERE id='$item_id' AND post_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$videos_post_id = $row['id'];
	$user_id_videos_post = $row['user_id'];
	$media_id = $row['video_id'];
	$video_id = $row['video_id'];
	$the_videos_post = $row['the_post'];
	$videos_post_date = $row['post_date'];
	$convertedTime = ($myObject -> convert_datetime($videos_post_date));
	$videos_post_date = ($myObject -> make_ago($convertedTime));
	$memory_type = $row['memory_type'];
	$videos_post_type = $row['videos_post_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM videos_posts_comments WHERE videos_post_id='$videos_post_id' AND delete_comment='1'"));
	$like_array_videos_post = $row['like_array'];
	$love_array_videos_post = $row['love_array'];
	$point_array_videos_post = $row['point_array'];
	$likeArray_videos_post = explode(",",$like_array_videos_post);
	$loveArray_videos_post = explode(",",$love_array_videos_post);
	$pointArray_videos_post = explode(",",$point_array_videos_post);
	$like_array_count_videos_post = count($likeArray_videos_post);
	$love_array_count_videos_post = count($loveArray_videos_post);
	$point_array_count_videos_post = count($pointArray_videos_post);
	$point_array_count_videos_post = $point_array_count_videos_post*10;
	if($point_array_videos_post==""){$point_array_count_videos_post="0";}
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id_videos_post' LIMIT 1");
	$row2=mysql_fetch_assoc($mysql2);
		{$user_id=$row2['id'];
		$user_firstname=$row2['firstname'];
		$user_lastname=$row2['lastname'];
		$friend_array=$row2['friend_array'];
		$friend_array = explode(",",$friend_array);
		$family_array=$row2['family_array'];
		$family_array = explode(",",$family_array);
		$check_pic="../user_files/user$user_id/profile_thumb.jpg";
		$default_pic="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic))
			{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'><img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
		else
			{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'><img src='$default_pic' width='55px' height='55px' class='thumb_background' /></a>";}
		}
		
	$mysql3 = mysql_query("SELECT user_id,video_name FROM videos WHERE id='$media_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql3))
		{$video_name = $row['video_name'];
		$video_owner_id = $row['user_id'];}
	
	if ((in_array($ids,$friend_array))AND($videos_post_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($videos_post_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="videos_posts";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_videos_post))
		{$like_love_videos_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$videos_post_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_videos_post))
		{$like_love_videos_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$videos_post_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_videos_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$videos_post_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$videos_post_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_videos_post !="")AND($love_array_videos_post !=""))
		{$like_love2_videos_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_videos_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_videos_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_videos_post !="")
		{$like_love2_videos_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_videos_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_videos_post !="")
		{$like_love2_videos_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_videos_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_videos_post = "";}
	
	// Little Things
	if($ids==$user_id_videos_post)
	{if($videos_post_type=="a"){$type="<div class='option_box' id='type_change_videos_posts".$videos_post_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$videos_post_id.",".$comment_type.");'></a></div>";}
	else if($videos_post_type=="b"){$type="<div class='option_box' id='type_change_videos_posts".$videos_post_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$videos_post_id.",".$comment_type.");'></a></div>";}
	else if($videos_post_type=="c"){$type="<div class='option_box' id='type_change_videos_posts".$videos_post_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$videos_post_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id_videos_post)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_videos_posts".$videos_post_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$videos_post_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_videos_posts".$videos_post_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$videos_post_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id_videos_post){$point="<div class='option_box2' id='point_videos_posts".$videos_post_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$videos_post_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_videos_post."</b></div>";}
	else if($point_array_count_videos_post=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_videos_post."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0)
		{$comment_space = 'class="comment_space"';}
	if($ids==$user_id_videos_post)
		{$delete_button_videos_post="<div class='option_box' id='delete_videos_posts".$videos_post_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$videos_post_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_videos_post="";}
		
	$DisplayList .= "<div id='item_box_videos_posts".$videos_post_id."'>
			<div class='media_post_box'>
			<div class='media_post_box1'>".$user_pic."</div>
			<div class='media_post_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_videos_post."
			</div>
			<div style='width:1000px;'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a></div>
			<div class='media_post_box2'>".$the_videos_post."</div>
			<div id='like_love_videos_posts".$videos_post_id."' class='inline'>
			".$like_love_videos_post."
			<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$videos_post_id.",".$comment_type.");'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$videos_post_date."</span>
			".$like_love2_videos_post."</div>
			<div ".$comment_space." id='comment_space_videos_posts".$videos_post_id."'></div>
			<div id='comments_videos_posts".$videos_post_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM videos_posts_comments WHERE videos_post_id='$videos_post_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
	while ($row = mysql_fetch_array ($mysql3))
		{$comment_id = $row['id'];
		$user_page_id_comment = $row['user_page_id'];
		$user_post_id_comment = $row['user_post_id'];
		$the_comment = $row['the_comment'];
		$comment_date = $row['comment_date'];
		$convertedTime = ($myObject -> convert_datetime($comment_date));
		$comment_date = ($myObject -> make_ago($convertedTime));
		$like_array_comment = $row['like_array'];
		$love_array_comment = $row['love_array'];
		$likeArray_comment = explode(",",$like_array_comment);
		$loveArray_comment = explode(",",$love_array_comment);
		$like_array_count_comment = count($likeArray_comment);
		$love_array_count_comment = count($loveArray_comment);
	$comment_point_array_videos_post = $row['point_array'];
	$comment_pointArray_videos_post = explode(",",$comment_point_array_videos_post);
	$comment_point_array_count_videos_post = count($comment_pointArray_videos_post);
	$comment_point_array_count_videos_post = $comment_point_array_count_videos_post*10;
	if($comment_point_array_videos_post==""){$comment_point_array_count_videos_post="0";}

	if (in_array($ids,$likeArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_comment !="")AND($love_array_comment !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_comment = "";}
		
	if(($ids==$user_page_id_comment)OR($ids==$user_post_id_comment))
		{$delete_button="<div class='delete_comment' id='delete_comment_videos_posts".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$videos_post_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_videos_posts".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_videos_post."</b></div>";}
	else if($comment_point_array_count_videos_post=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_videos_post."</b></a></div>";}
						
	$mysql4 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id='$user_post_id_comment' LIMIT 1");
	while ($row =mysql_fetch_array ($mysql4))
		{$user_id_comment = $row['id'];
		$user_firstname_comment = $row['firstname'];
		$user_lastname_comment = $row['lastname'];
		$user_check_pic_comment = "../user_files/user$user_id_comment/profile_thumb.jpg";
		$user_default_pic_comment = "../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($user_check_pic_comment)) 
			{$commenter_pic_comment = "<img  src=\"$user_check_pic_comment#$cacheBuster\" width=\"45px\" height=\"45px\" class=\"thumb_background\" />";} 
		else {$commenter_pic_comment = "<img src=\"$user_default_pic_comment\" width=\"45px\" height=\"45px\" class=\"thumb_background\" />";}
	
	$DisplayList .='
	<div id="comment_list_videos_posts'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_videos_posts'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$videos_post_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= "</div>
			".$expand."
			<div id='comment_videos_posts".$videos_post_id."'></div>
			</div></div></div>";
		}
	}
}
}}

echo $DisplayList;
if($numRows>0){$number=$number+20;}
?>
<script type="text/javascript">
// Add more Content at end of page
var number = "<?php echo $number; ?>";
var numRows = "<?php echo $numRows; ?>";
var cacheBuster = "<?php echo $cacheBuster; ?>";
var video_id = "<?php echo $video_id; ?>";
$(window).data('ajaxready23', true).scroll(function()
	{if ($(window).data('ajaxready23') == false) return;
	if($(window).scrollTop()>=$("#bottom_media_video").height()-$(document).height())
		{$("div#expand_bottom_box").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready23', false);
		$.ajax({cache: false,url:"videos_posts_content.php?number="+number+"&cacheBuster="+cacheBuster+"&id="+id+"&ids="+ids+"&video_id="+video_id,
			success:function(html)
				{if(html){$("#bottom_media_video").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				 $(window).data('ajaxready23', true);}
			});
		}
	});
	
$("div#expand_bottom_box").click(function(){
	{if ($(window).data('ajaxready23') == false) return;
	$("div#expand_bottom_box").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready23', false);
	$.ajax({cache: false,url:"videos_posts_content.php?number="+number+"&cacheBuster="+cacheBuster+"&id="+id+"&ids="+ids+"&video_id="+video_id,
			success:function(html)
				{if(html){$("#bottom_media_video").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				$(window).data('ajaxready23', true);}
			});
		}
	});
</script>
