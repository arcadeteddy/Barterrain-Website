<?php
ob_start();
include_once "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
if(!isset($number)){$number="0";}
$DisplayList ="";
$numRows ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";

if(isset($_GET['number']))
	{$number=$_GET['number'];
	$cacheBuster=$_GET['cacheBuster'];
	$id=$_GET['id'];
	$ids=$_GET['ids'];}
if(isset($_GET['search']))
	{$search=$_GET['search'];
	$search = strip_tags($_GET['search']);
	$search = mysql_real_escape_string($search);}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql = mysql_query("SELECT friend_array, family_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$friendArray = explode(",",$friend_array);
	$familyArray = explode(",",$family_array);
	if(($friend_array!=="")AND($family_array!==""))
		{$FF_array=$friend_array.",".$family_array;}
	else if($family_array!==""){$FF_array=$family_array;}
	else if($friend_array!==""){$FF_array=$friend_array;}
	else {$FF_array="";}
	$FFArray = explode(",",$FF_array);
	$FRIENDS = join(',',$FFArray);}
	
////////// SEARCH!!! //////////
if ($FF_array=="") {$mysql_union = mysql_query("(SELECT id, note_date AS datetime, union_type FROM notes WHERE ((user_id='$id') AND delete_item='1') 
								AND (the_note_subject LIKE '%$search%' OR the_note LIKE '%$search%'))
							ORDER BY datetime DESC LIMIT ".$number.",20");}
else {$mysql_union = mysql_query("(SELECT id, note_date AS datetime, union_type FROM notes WHERE ((user_id IN ($FRIENDS) OR user_id='$id') AND delete_item='1') 
								AND (the_note_subject LIKE '%$search%' OR the_note LIKE '%$search%'))
							ORDER BY datetime DESC LIMIT ".$number.",20");}
$numRows=mysql_num_rows($mysql_union);
if($numRows>0)
{while ($row = mysql_fetch_array ($mysql_union))
	{$item_id = $row['id'];
	$datetime = $row['datetime'];
	$union_type = $row['union_type'];

if ($union_type=="notes")
{$mysql1 = mysql_query("SELECT * FROM notes WHERE id='$item_id' AND note_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$note_id = $row['id'];
	$item_id = $row['id'];
	$user_id_note = $row['user_id'];
	$the_note_subject = $row['the_note_subject'];
	$the_note = $row['the_note'];
	$note_date = $row['note_date'];
	$convertedTime = ($myObject -> convert_datetime($note_date));
	$note_date = ($myObject -> make_ago($convertedTime));
	$memory_type = $row['memory_type'];
	$note_type = $row['note_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM notes_comments WHERE note_id='$note_id' AND delete_comment='1'"));
	$like_array_note = $row['like_array'];
	$love_array_note = $row['love_array'];
	$point_array_note = $row['point_array'];
	$likeArray_note = explode(",",$like_array_note);
	$loveArray_note = explode(",",$love_array_note);
	$pointArray_note = explode(",",$point_array_note);
	$like_array_count_note = count($likeArray_note);
	$love_array_count_note = count($loveArray_note);
	$point_array_count_note = count($pointArray_note);
	$point_array_count_note = $point_array_count_note*10;
	if($point_array_note==""){$point_array_count_note="0";}
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id_note' LIMIT 1");
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
	
	if ((in_array($ids,$friend_array))AND($note_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($note_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="notes";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_note))
		{$like_love_note = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$note_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_note))
		{$like_love_note = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$note_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_note = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$note_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$note_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_note !="")AND($love_array_note !=""))
		{$like_love2_note = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_note."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_note."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_note !="")
		{$like_love2_note = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_note."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_note !="")
		{$like_love2_note = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_note."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_note = "";}
	
	// Little Things
	if($ids==$user_id_note)
	{if($note_type=="a"){$type="<div class='option_box' id='type_change_notes".$note_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$note_id.",".$comment_type.");'></a></div>";}
	else if($note_type=="b"){$type="<div class='option_box' id='type_change_notes".$note_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$note_id.",".$comment_type.");'></a></div>";}
	else if($note_type=="c"){$type="<div class='option_box' id='type_change_notes".$note_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$note_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id_note)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_notes".$note_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$note_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_notes".$note_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$note_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id_note){$point="<div class='option_box2' id='point_notes".$note_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$note_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_note."</b></div>";}
	else if($point_array_count_note=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_note."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0)
		{$comment_space = 'class="comment_space"';}
	if($ids==$user_id_note)
		{$delete_button_note="<div class='option_box' id='delete_notes".$note_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$note_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_note="";}
	if ($the_note_subject=="")
		{$the_note_subject == "Untitled";}
		
	$DisplayList .= "<div id='item_box_notes".$note_id."'>
			<div class='note_box'>
			<div class='note_box1'>".$user_pic."</div>
			<div class='note_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_note."
			</div>
			<div class='note_box2'><b>Subject: </b>".$the_note_subject."</div>
			<div class='note_box2'><b>The Note: </b>".$the_note."</div>
			<div id='like_love_notes".$note_id."' class='inline'>
			".$like_love_note."
			<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$note_id.",".$comment_type.");'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$note_date."</span>
			".$like_love2_note."</div>
			<div ".$comment_space." id='comment_space_notes".$note_id."'></div>
			<div id='comments_notes".$note_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM notes_comments WHERE note_id='$note_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_note = $row['point_array'];
	$comment_pointArray_note = explode(",",$comment_point_array_note);
	$comment_point_array_count_note = count($comment_pointArray_note);
	$comment_point_array_count_note = $comment_point_array_count_note*10;
	if($comment_point_array_note==""){$comment_point_array_count_note="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_notes".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$note_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_notes".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_note."</b></div>";}
	else if($comment_point_array_count_note=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_note."</b></a></div>";}
						
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
	<div id="comment_list_notes'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_notes'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$note_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= "</div>
			".$expand."
			<div id='comment_notes".$note_id."'></div>
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
var search_box = "<?php echo $search; ?>";
var numRows = "<?php echo $numRows; ?>";
var cacheBuster = "<?php echo $cacheBuster; ?>";
$(window).data('ajaxready16', true).scroll(function()
	{if ($(window).data('ajaxready16') == false) return;
	if($(window).scrollTop()>=$("#bottom_search_profiles_games").height()-$(document).height())
		{$("div#expand_bottom_box").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready16', false);
		$.ajax({cache: false,url:"search_profiles_games_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_profiles_games").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				 $(window).data('ajaxready16', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_box").click(function(){
	{if ($(window).data('ajaxready16') == false) return;
	$("div#expand_bottom_box").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready16', false);
	$.ajax({cache: false,url:"search_profiles_games_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_profiles_games").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				$(window).data('ajaxready16', true);}
			});
		}
	});
});
</script>