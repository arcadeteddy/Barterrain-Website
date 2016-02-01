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
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql = mysql_query("SELECT friend_array, family_array FROM members WHERE id='$id'  LIMIT 1");
while($row = mysql_fetch_array($mysql))
	{$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$friendArray = explode(",",$friend_array);
	$familyArray = explode(",",$family_array);
	if(($friend_array!=="")AND($family_array!=="")){$FRIENDS = array_merge($friendArray,$familyArray);}
	else if($friend_array!==""){$FRIENDS = $friendArray;}
	else if($family_array!==""){$FRIENDS = $familyArray;}
	$FRIENDS = join(',',$FRIENDS);}
	
////////// FRIENDS!!! //////////
if(($friend_array!=="")OR($family_array!==""))
{$mysql_union = mysql_query("(SELECT id, post_date AS datetime, union_type FROM posts WHERE user_post_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, note_date AS datetime, union_type FROM notes WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, upload_date AS datetime, union_type FROM albums WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, upload_date AS datetime, union_type FROM images_walls WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, upload_date AS datetime, union_type FROM videos WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, upload_date AS datetime, union_type FROM games WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, post_date AS datetime, union_type FROM albums_posts WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, post_date AS datetime, union_type FROM games_posts WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, post_date AS datetime, union_type FROM videos_posts WHERE user_id IN ($FRIENDS) AND delete_item='1')
					UNION ALL(SELECT id, create_date AS datetime, union_type FROM planets WHERE user_id IN ($FRIENDS) AND delete_item='1') 
					ORDER BY datetime DESC LIMIT ".$number.",20");
$numRows=mysql_num_rows($mysql_union);
if($numRows>0)
{while ($row = mysql_fetch_array ($mysql_union))
	{$item_id = $row['id'];
	$datetime = $row['datetime'];
	$union_type = $row['union_type'];
	
	if($union_type=="pages_member_posts"){$typex="pages";$typex_s="page";}
	else if($union_type=="groups_member_posts"){$typex="groups";$typex_s="group";}
	else if($union_type=="events_member_posts"){$typex="events";$typex_s="event";}
	else if($union_type=="shops_member_posts"){$typex="shops";$typex_s="shop";}
	else {$typex="";$typex_s="";}
	
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

else if ($union_type=="posts")
{$mysql1 = mysql_query("SELECT * FROM posts WHERE id='$item_id' AND post_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$post_id = $row['id'];
	$user_page_id = $row['user_page_id'];
	$user_post_id = $row['user_post_id'];
	$the_post = $row['the_post'];
	$post_date = $row['post_date'];
	$convertedTime = ($myObject -> convert_datetime($post_date));
	$post_date = ($myObject -> make_ago($convertedTime));
	$post_type =  $row['post_type'];
	$memory_type =  $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM posts_comments WHERE post_id='$post_id' AND delete_comment='1'"));
	$like_array_post = $row['like_array'];
	$love_array_post = $row['love_array'];
	$point_array_post = $row['point_array'];
	$likeArray_post = explode(",",$like_array_post);
	$loveArray_post = explode(",",$love_array_post);
	$pointArray_post = explode(",",$point_array_post);
	$like_array_count_post = count($likeArray_post);
	$love_array_count_post = count($loveArray_post);
	$point_array_count_post = count($pointArray_post);
	$point_array_count_post = $point_array_count_post*10;
	if($point_array_post==""){$point_array_count_post="0";}
	
	$mysql2=mysql_query("SELECT id, firstname, lastname,friend_array, family_array FROM members WHERE id='$user_post_id' LIMIT 1");
	$row2=mysql_fetch_assoc ($mysql2);
		{$user_id=$row2['id'];
		$user_firstname=$row2['firstname'];
		$user_lastname=$row2['lastname'];
		$friend_array=$row2['friend_array'];
		$friend_array = explode(",",$friend_array);
		$family_array=$row2['family_array'];
		$family_array = explode(",",$family_array);}
	$mysql22=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_page_id' LIMIT 1");
	$row2=mysql_fetch_assoc ($mysql22);
		{$user_id2=$row2['id'];
		$user_firstname2=$row2['firstname'];
		$user_lastname2=$row2['lastname'];
		$friend_array2=$row2['friend_array'];
		$friend_array2 = explode(",",$friend_array2);
		$family_array2=$row2['family_array'];
		$family_array2 = explode(",",$family_array2);}
	
	if ((in_array($ids,$friend_array))AND($post_type=="c")AND($user_page_id!==$ids)AND($user_post_id!==$ids))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($post_type=="b")AND($user_page_id!==$ids)AND($user_post_id!==$ids))
		{$DisplayList .="";}
	else if ((in_array($ids,$friend_array2))AND($post_type=="c")AND($user_page_id!==$ids)AND($user_post_id!==$ids))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array2))AND($post_type=="b")AND($user_page_id!==$ids)AND($user_post_id!==$ids))
		{$DisplayList .="";}
	else {
	
	$comment_type="posts";
	$comment_type=json_encode($comment_type);

	if (in_array($ids,$likeArray_post))
		{$like_love_post="<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_post))
		{$like_love_post="<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_post="<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_post !="")AND($love_array_post !=""))
		{$like_love2_post="<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_post !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_post !="")
		{$like_love2_post="<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_post="";}
	
	// Little Things
	$user_check_pic = "../user_files/user$user_id/profile_thumb.jpg";
	$user_default_pic = "../user_files/user0/default_profile_pic_thumb.png";
	if (file_exists($user_check_pic)) 
		{$poster_pic = "<img  src='$user_check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/>";} 
	else {$poster_pic = "<img src='$user_default_pic' width='55px' height='55px' class='thumb_background'/>";}
	$comment_space="";
	if ($comment_array>0){$comment_space = 'class="comment_space"';}
	if($ids==$user_post_id)
	{if($post_type=="a"){$type="<div class='option_box' id='type_change_posts".$post_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$post_id.",".$comment_type.");'></a></div>";}
	else if($post_type=="b"){$type="<div class='option_box' id='type_change_posts".$post_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$post_id.",".$comment_type.");'></a></div>";}
	else if($post_type=="c"){$type="<div class='option_box' id='type_change_posts".$post_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$post_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if(($user_page_id==$user_post_id)AND($ids==$user_post_id))
		{if(($memory_type=="b")OR($memory_type=="c")){$memory_box="<div class='option_box' id='memory_box_posts".$post_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box2_posts(".$post_id.",".$comment_type.",".$ids.");'></a></div>";}
		else if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_posts".$post_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box2_posts(".$post_id.",".$comment_type.",".$ids.");'></a></div>";}}
	else if(($ids==$user_page_id)AND($memory_type=="b"))
		{$memory_box="<div class='option_box' id='memory_box_posts".$post_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box2_posts(".$post_id.",".$comment_type.",".$ids.");'></a></div>";}
	else if(($ids==$user_post_id)AND($memory_type=="c"))
		{$memory_box="<div class='option_box' id='memory_box_posts".$post_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box2_posts(".$post_id.",".$comment_type.",".$ids.");'></a></div>";}
	else if(($memory_type=="d")AND(($ids==$user_post_id)OR($ids==$user_page_id)))
		{$memory_box="<div class='option_box' id='memory_box_posts".$post_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box2_posts(".$post_id.",".$comment_type.",".$ids.");'></a></div>";}
	else if(($ids==$user_post_id)OR($ids==$user_page_id))
		{$memory_box="<div class='option_box' id='memory_box_posts".$post_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box2_posts(".$post_id.",".$comment_type.",".$ids.");'></a></div>";}
	else{$memory_box="";}
	if($ids!==$user_post_id){$point="<div class='option_box2' id='point_posts".$post_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$post_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_post."</b></div>";}
	else if($point_array_count_post=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_post."</b></div>";}
	if(($ids==$user_page_id)OR($ids==$user_post_id))
		{$delete_button_post="<div class='option_box' id='delete_posts".$post_id."'><a href='#' title='Delete Post' class='delete0' onclick='return false' onmousedown='javascript:delete_post1(".$post_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_post="";}
	if($user_post_id!==$user_page_id)
		{$profile_link="<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a> &#9658; <font style='color:black;font-size:14px;'>Profile: </font><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id2."'>".$user_firstname2." ".$user_lastname2."</a>";}
	else {$profile_link="<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a>";}
	
	$DisplayList .= "<div id='box_posts".$post_id."'>
			<div class='post_box'>
			<div class='post_box1'><a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$poster_pic."</a></div>
			<div class='post_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_post."
			</div>
			<div class='post_box2'>".$profile_link."</div>
			<div class='post_box2'>".$the_post."</div>
			<div id='like_love_posts".$post_id."' class='inline'>
			".$like_love_post."
			<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$post_id.",".$comment_type.");'>Comment</a>
			<span class='dot_divider'> &middot; </span><span class='post_date'>".$post_date."</span>
			".$like_love2_post."</div>
			<div ".$comment_space." id='comment_space_posts".$post_id."'></div>
			<div id='comments_posts".$post_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM posts_comments WHERE post_id='$post_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
	while($row=mysql_fetch_array($mysql3))
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
	$comment_point_array_post = $row['point_array'];
	$comment_pointArray_post = explode(",",$comment_point_array_post);
	$comment_point_array_count_post = count($comment_pointArray_post);
	$comment_point_array_count_post = $comment_point_array_count_post*10;
	if($comment_point_array_post==""){$comment_point_array_count_post="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_posts".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$post_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_posts".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_post."</b></div>";}
	else if($comment_point_array_count_post=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_post."</b></a></div>";}
						
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
	<div id="comment_list_posts'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_posts'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
		
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$post_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_posts'.$post_id.'"></div>
			</div></div></div>';
		}
	}
}

else if ($union_type=="albums")
{$mysql1 = mysql_query("SELECT * FROM albums WHERE id='$item_id' AND upload_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$album_id = $row['id'];
	$user_id = $row['user_id'];
	$album_name = $row['album_name'];
	$album_description = $row['album_description'];
	$album_description_length = strlen($album_description);
	$album_description = substr($album_description, 0, 35);
	if ($album_description_length>35){$album_description=$album_description.'...';}
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$album_type =  $row['album_type'];
	$memory_type =  $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM albums_comments WHERE album_id='$album_id' AND delete_comment='1'"));
	$image_array = $row['image_array'];
	$imageArray = explode(",",$image_array);
	$image_count = count($imageArray);
	$imageArray3 = array_slice($imageArray,0,3);
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
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id' LIMIT 1");
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
	
	if ((in_array($ids,$friend_array))AND($album_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($album_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="albums";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_album))
		{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_album))
		{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_album = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$album_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_album !="")AND($love_array_album !=""))
		{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_album !="")
		{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_album !="")
		{$like_love2_album = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_album."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_album = "";}
		
	// Little Things
	if($ids==$user_id)
	{if($album_type=="a"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
	else if($album_type=="b"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}
	else if($album_type=="c"){$type="<div class='option_box' id='type_change_albums".$album_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$album_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_albums".$album_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$album_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id){$point="<div class='option_box2' id='point_albums".$album_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$album_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_album."</b></div>";}
	else if($point_array_count_album=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_album."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0){$comment_space = 'class="comment_space"';}
	if($ids==$user_id)
		{$delete_button_album="<div class='option_box' id='delete_albums".$album_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$album_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_album="";}
	$album_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_cover2.jpg";
	$album_default_pic="../user_files/user0/default_album_cover_thumb.png";
	if (file_exists($album_pic))
		{$album_cover="<a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_album=".$album_id."'><img class='cover thumb_background' src='$album_pic#$cacheBuster' height='76px' width='130px'/></a>";}
	else {$album_cover="<a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_album=".$album_id."'><img class='cover thumb_background' src='$album_default_pic' height='76px' width='130px'/></a>";}
	if($album_description==""){$album_description="Undefined";}
	if ($album_name=="")
		{$album_name == "Untitled";}
	if ($image_array == ''){$image_counts = '0 Pictures';}
	else if ($image_count == 1){$image_counts = $image_count.' Picture';}
	else if ($image_count > 1){$image_counts = $image_count.' Pictures';}
	
	$DisplayList .= "<div id='item_box_albums".$album_id."'>
			<div class='album_box'>
			<div class='album_box1'>".$user_pic."</div>
			<div class='album_box3'><div class='album_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_album."
			</div>
			<div class='album_box21'>".$album_cover."<div ".$comment_space." id='comment_space_albums".$album_id."'></div></div>
			<div class='album_box22'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a></div>
			<div class='album_box22'><b>New Album: </b><a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_album=".$album_id."' class='body'>".$album_name."</a></div>
			<div class='album_box22'><b>Description: </b>".$album_description."</div>
			<div class='album_box22'><b>Items: </b>".$image_counts."</div>
			<div class='album_box22'>
			<div id='like_love_albums".$album_id."' class='inline like_love'>
			".$like_love_album."
			<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:comment(".$album_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$upload_date."</span>
			".$like_love2_album."</div></div></div>
			<div id='comments_albums".$album_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM albums_comments WHERE album_id='$album_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_album = $row['point_array'];
	$comment_pointArray_album = explode(",",$comment_point_array_album);
	$comment_point_array_count_album = count($comment_pointArray_album);
	$comment_point_array_count_album = $comment_point_array_count_album*10;
	if($comment_point_array_album==""){$comment_point_array_count_album="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_albums".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$album_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_albums".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_album."</b></div>";}
	else if($comment_point_array_count_album=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_album."</b></a></div>";}
						
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
	<div id="comment_list_albums'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_albums'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$album_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_albums'.$album_id.'"></div>
			</div></div></div>';
		}
	}
}
	
else if ($union_type=="images_walls")
{$mysql1 = mysql_query("SELECT * FROM images_walls WHERE id='$item_id' AND upload_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$images_wall_id = $row['id'];
	$user_id = $row['user_id'];
	$album_id = $row['album_id'];
	$album_name = $row['album_name'];
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$images_wall_type =  $row['images_wall_type'];
	$memory_type =  $row['memory_type'];
	$images =  $row['images'];
	$imagesArray = explode(",",$images);
	$images_count = count($imagesArray);
	shuffle($imagesArray);
	if ($images_count==5)
		{$imagesArray=array_slice($imagesArray,0,4);}
	else if ($images_count>6)
		{$imagesArray=array_slice($imagesArray,0,6);}
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM images_walls_comments WHERE images_wall_id='$images_wall_id' AND delete_comment='1'"));
	$like_array_images_walls = $row['like_array'];
	$love_array_images_walls = $row['love_array'];
	$likeArray_images_walls = explode(",",$like_array_images_walls);
	$loveArray_images_walls = explode(",",$love_array_images_walls);
	$like_array_count_images_walls = count($likeArray_images_walls);
	$love_array_count_images_walls = count($loveArray_images_walls);
	$point_array_images_walls = $row['point_array'];
	$pointArray_images_walls = explode(",",$point_array_images_walls);
	$point_array_count_images_walls = count($pointArray_images_walls);
	$point_array_count_images_walls = $point_array_count_images_walls*10;
	if($point_array_images_walls==""){$point_array_count_images_walls="0";}
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id' LIMIT 1");
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
	
	if ((in_array($ids,$friend_array))AND($images_wall_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($images_wall_type=="b"))
		{$DisplayList .="";}
	else if ($images=="")
		{$DisplayList .="";}
	else {
	
	$comment_type="images_walls";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_images_walls))
		{$like_love_images_walls = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_images_walls))
		{$like_love_images_walls = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_images_walls = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$images_wall_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_images_walls !="")AND($love_array_images_walls !=""))
		{$like_love2_images_walls = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_images_walls !="")
		{$like_love2_images_walls = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_images_walls !="")
		{$like_love2_images_walls = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_images_walls."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_images_walls = "";}
	
	// Little Things
	if($ids==$user_id)
	{if($images_wall_type=="a"){$type="<div class='option_box' id='type_change_images_walls".$images_wall_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else if($images_wall_type=="b"){$type="<div class='option_box' id='type_change_images_walls".$images_wall_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else if($images_wall_type=="c"){$type="<div class='option_box' id='type_change_images_walls".$images_wall_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$images_wall_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_images_walls".$images_wall_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_images_walls".$images_wall_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$images_wall_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id){$point="<div class='option_box2' id='point_images_walls".$images_wall_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$images_wall_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_images_walls."</b></div>";}
	else if($point_array_count_images_walls=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_images_walls."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0){$comment_space='comment_space';}
	if($ids==$user_id)
		{$delete_button_image="<div class='option_box' id='delete_images_walls".$images_wall_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$images_wall_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_image="";}
	
	$i=0;
	$pictures="";
	if($images_count==1)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<img class='black_gif' src='barterrain_profile_images/black.png' height='415px' width='415px'/><table class='black_gif' height='415px' width='415px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_thumb_".$value.".jpg";
			$pictures="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic' height='415px' width='415px'/></a></div>";}}
	else if($images_count==2)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<img class='black_gif' src='barterrain_profile_images/black.png' height='203px' width='203px'/><table class='black_gif' height='203px' width='203px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic' height='203px' width='203px'/></a></div>";}}
	else if($images_count==3)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<img class='black_gif' src='barterrain_profile_images/black.png' height='133px' width='133px'/><table class='black_gif' height='133px' width='133px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic' height='133px' width='133px'/></a></div>";}}
	else if($images_count==4)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<img class='black_gif' src='barterrain_profile_images/black.png' height='203px' width='203px'/><table class='black_gif' height='203px' width='203px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic' height='203px' width='203px'/></a></div>";}}
	else if($images_count==5)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<img class='black_gif' src='barterrain_profile_images/black.png' height='203px' width='203px'/><table class='black_gif' height='203px' width='203px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic' height='203px' width='203px'/></a></div>";}}
	else if($images_count>4)
		{foreach ($imagesArray as $key => $value)
			{$black_gif="";$ext="";
			$mysql_gif=mysql_query("SELECT ext FROM images WHERE id='$value' LIMIT 1");
			$row=mysql_fetch_assoc($mysql_gif);
				{$ext=$row['ext'];}
			if ($ext=="gif") {$black_gif="<div style='float:left;'><img class='black_gif' src='barterrain_profile_images/black.png' height='133px' width='133px'/></div><table class='black_gif' height='133px' width='133px' ><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
			$i++;$images_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_thumb_".$value.".jpg";
			$pictures .="<div style='float:left;'><a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img class='images_walls' src='$images_pic' height='133px' width='133px'/></a></div>";}}

	$DisplayList .= "<div id='item_box_images_walls".$images_wall_id."'>
			<div class='images_walls_box'>
			<div class='images_walls_box1'>".$user_pic."</div>
			<div class='images_walls_box2'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_image."
			</div>
			<div class='images_walls_box4'><div style='width:1000px;'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a><br/>
			<b>New Images: </b><a class='body' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_album=".$album_id."'>".$album_name."</a></div></div>	
			<div class='images_walls_box3'>".$pictures."</div>
			<div class='images_walls_box3 ".$comment_space."' id='comment_space_images_walls".$images_wall_id."'>
			<div class='like_love' id='like_love_images_walls".$images_wall_id."'>
				".$like_love_images_walls."<span class='dot_divider'> &middot; </span>
				<a href='#' onclick='return false' onmousedown='javascript:comment(".$images_wall_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$upload_date."</span>
				".$like_love2_images_walls."
			</div></div>
			<div id='comments_images_walls".$images_wall_id."'>";
			
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM images_walls_comments WHERE images_wall_id='$images_wall_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_image = $row['point_array'];
	$comment_pointArray_image = explode(",",$comment_point_array_image);
	$comment_point_array_count_image = count($comment_pointArray_image);
	$comment_point_array_count_image = $comment_point_array_count_image*10;
	if($comment_point_array_image==""){$comment_point_array_count_image="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_images_walls".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$images_wall_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_images_walls".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_image."</b></div>";}
	else if($comment_point_array_count_image=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_image."</b></a></div>";}
						
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
	<div id="comment_list_images_walls'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_images_walls'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date">'.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$images_wall_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_images_walls'.$images_wall_id.'"></div>
			</div></div></div>';
		}
	}
}

else if ($union_type=="videos")
{$mysql1 = mysql_query("SELECT * FROM videos WHERE id='$item_id' AND upload_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$video_id = $row['id'];
	$user_id = $row['user_id'];
	$video_name = $row['video_name'];
	$video_description = $row['video_description'];
	$video_description_length = strlen($video_description);
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$video_type =  $row['video_type'];
	$memory_type =  $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM videos_comments WHERE video_id='$video_id' AND delete_comment='1'"));
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
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id' LIMIT 1");
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
	
	if ((in_array($ids,$friend_array))AND($video_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($video_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="videos";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_video))
		{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_video))
		{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_video = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$video_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_video !="")AND($love_array_video !=""))
		{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_video !="")
		{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_video !="")
		{$like_love2_video = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_video."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_video = "";}
	
	// Little Things
	if($ids==$user_id)
	{if($video_type=="a"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}
	else if($video_type=="b"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}
	else if($video_type=="c"){$type="<div class='option_box' id='type_change_videos".$video_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$video_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_videos".$video_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$video_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_videos".$video_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$video_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id){$point="<div class='option_box2' id='point_videos".$video_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$video_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_video."</b></div>";}
	else if($point_array_count_video=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_video."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0){$comment_space = 'class="comment_space"';}
	if($ids==$user_id)
		{$delete_button_video="<div class='option_box' id='delete_videos".$video_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$video_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_video="";}
	if($video_description==""){$video_description="Undefined";}
	if ($video_name=="")
		{$video_name == "Untitled";}
	
	$DisplayList .= "<div id='item_box_videos".$video_id."'>
			<div class='video_box'>
			<div class='video_box1'>".$user_pic."</div>
			<div class='video_box3'><div class='video_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_video."
			</div>
			<div class='video_box22'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a></div>
			<div class='video_box22'><b>New Video: </b><a class='body' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_video=".$video_id."'>".$video_name."</a></div>
			<div class='video_box21'>
				<div class='video_screen'>
				<object type='application/x-shockwave-flash' data='../scripts/player.swf' width='417px' height='259px;'>
    				<param name='allowfullscreen' value='true'>
    				<param name='allowscriptaccess' value='always'>
    				<param name='flashvars' value='file=../user_files/user".$user_id."/video_".$video_id."/video_".$video_id.".mp4'>
       				<img src='../user_files/user".$user_id."/video_".$video_id."/video_".$video_id."_cover.jpg' width='417px' height='259px' alt='".$video_name."'>
  				</object>
				</div>
			</div>
			<div class='video_box22'><div ".$comment_space." id='comment_space_videos".$video_id."'>
			<div id='like_love_videos".$video_id."' class='inline'>
			".$like_love_video."
			<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:comment(".$video_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$upload_date."</span>
			".$like_love2_video."</div></div>
			</div></div>
			<div id='comments_videos".$video_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM videos_comments WHERE video_id='$video_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_video = $row['point_array'];
	$comment_pointArray_video = explode(",",$comment_point_array_video);
	$comment_point_array_count_video = count($comment_pointArray_video);
	$comment_point_array_count_video = $comment_point_array_count_video*10;
	if($comment_point_array_video==""){$comment_point_array_count_video="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_videos".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$video_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_videos".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_video."</b></div>";}
	else if($comment_point_array_count_video=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_video."</b></a></div>";}
						
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
	<div id="comment_list_videos'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_videos'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$video_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_videos'.$video_id.'"></div>
			</div></div></div>';
		}
	}
}
	
else if ($union_type=="games")
{$mysql1 = mysql_query("SELECT * FROM games WHERE id='$item_id' AND upload_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$game_id = $row['id'];
	$user_id = $row['user_id'];
	$game_name = $row['game_name'];
	$game_description = $row['game_description'];
	$game_description_length = strlen($game_description);
	$game_description = substr($game_description, 0, 35);
	$categories = $row['categories'];
	if ($game_description_length>35){$game_description=$game_description.'...';}
	$upload_date = $row['upload_date'];
	$convertedTime = ($myObject -> convert_datetime($upload_date));
	$upload_date = ($myObject -> make_ago($convertedTime));
	$game_type =  $row['game_type'];
	$memory_type =  $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM games_comments WHERE game_id='$game_id' AND delete_comment='1'"));
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
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id' LIMIT 1");
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
	
	if ((in_array($ids,$friend_array))AND($game_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($game_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="games";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_game))
		{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_game))
		{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_game = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$game_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_game !="")AND($love_array_game !=""))
		{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_game !="")
		{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_game !="")
		{$like_love2_game = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_game."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_game = "";}
	
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
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_game."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0){$comment_space = 'class="comment_space"';}
	if($ids==$user_id)
		{$delete_button_game="<div class='option_box' id='delete_games".$game_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$game_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_game="";}
	$game_pic="../user_files/user$user_id/game_$game_id/game_".$game_id."_cover.jpg";
	$game_default_pic="../user_files/user0/default_game_cover_thumb.png";
	if (file_exists($game_pic))
		{$game_cover="<a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_game=".$game_id."'><img class='cover thumb_background' src='$game_pic' height='76px' width='130px'/></a>";}
	else {$game_cover="<a href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_game=".$game_id."'><img class='cover thumb_background' src='$game_default_pic' height='76px' width='130px'/></a>";}
	if($game_description==""){$game_description="Undefined";}
	if ($game_name=="")
		{$game_name == "Untitled";}
	
	$DisplayList .= "<div id='item_box_games".$game_id."'>
			<div class='game_box'>
			<div class='game_box1'>".$user_pic."</div>
			<div class='game_box3'><div class='game_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_game."
			</div>
			<div class='game_box21'>".$game_cover."<div ".$comment_space." id='comment_space_games".$game_id."'></div></div>
			<div class='game_box22'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a></div>
			<div class='game_box22'><b>New Game: </b><a class='body' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."&force_game=".$game_id."'>".$game_name."</a></div>
			<div class='game_box22'><b>Description: </b>".$game_description."</div>
			<div class='game_box22'><b>Category: </b>".$categories."</div>
			<div class='game_box22'>
			<div id='like_love_games".$game_id."' class='inline'>
			".$like_love_game."
			<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:comment(".$game_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$upload_date."</span>
			".$like_love2_game."</div></div></div>
			<div id='comments_games".$game_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM games_comments WHERE game_id='$game_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_game = $row['point_array'];
	$comment_pointArray_game = explode(",",$comment_point_array_game);
	$comment_point_array_count_game = count($comment_pointArray_game);
	$comment_point_array_count_game = $comment_point_array_count_game*10;
	if($comment_point_array_game==""){$comment_point_array_count_game="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_games".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$game_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_games".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_game."</b></div>";}
	else if($comment_point_array_count_game=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_game."</b></a></div>";}
						
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
	<div id="comment_list_games'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_games'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$game_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_games'.$game_id.'"></div>
			</div></div></div>';
		}
	}
}

else if ($union_type=="albums_posts")
{$mysql1 = mysql_query("SELECT * FROM albums_posts WHERE id='$item_id' AND post_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$albums_post_id = $row['id'];
	$user_id_albums_post = $row['user_id'];
	$media_id = $row['album_id'];
	$the_albums_post = $row['the_post'];
	$albums_post_date = $row['post_date'];
	$convertedTime = ($myObject -> convert_datetime($albums_post_date));
	$albums_post_date = ($myObject -> make_ago($convertedTime));
	$memory_type = $row['memory_type'];
	$albums_post_type = $row['albums_post_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM albums_posts_comments WHERE albums_post_id='$albums_post_id' AND delete_comment='1'"));
	$like_array_albums_post = $row['like_array'];
	$love_array_albums_post = $row['love_array'];
	$point_array_albums_post = $row['point_array'];
	$likeArray_albums_post = explode(",",$like_array_albums_post);
	$loveArray_albums_post = explode(",",$love_array_albums_post);
	$pointArray_albums_post = explode(",",$point_array_albums_post);
	$like_array_count_albums_post = count($likeArray_albums_post);
	$love_array_count_albums_post = count($loveArray_albums_post);
	$point_array_count_albums_post = count($pointArray_albums_post);
	$point_array_count_albums_post = $point_array_count_albums_post*10;
	if($point_array_albums_post==""){$point_array_count_albums_post="0";}
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id_albums_post' LIMIT 1");
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
		
	$mysql3 = mysql_query("SELECT user_id,album_name FROM albums WHERE id='$media_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql3))
		{$album_name = $row['album_name'];
		$album_owner_id = $row['user_id'];}
	
	if ((in_array($ids,$friend_array))AND($albums_post_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($albums_post_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="albums_posts";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_albums_post))
		{$like_love_albums_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$albums_post_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_albums_post))
		{$like_love_albums_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$albums_post_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_albums_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$albums_post_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$albums_post_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_albums_post !="")AND($love_array_albums_post !=""))
		{$like_love2_albums_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_albums_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_albums_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_albums_post !="")
		{$like_love2_albums_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_albums_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_albums_post !="")
		{$like_love2_albums_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_albums_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_albums_post = "";}
	
	// Little Things
	if($ids==$user_id_albums_post)
	{if($albums_post_type=="a"){$type="<div class='option_box' id='type_change_albums_posts".$albums_post_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$albums_post_id.",".$comment_type.");'></a></div>";}
	else if($albums_post_type=="b"){$type="<div class='option_box' id='type_change_albums_posts".$albums_post_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$albums_post_id.",".$comment_type.");'></a></div>";}
	else if($albums_post_type=="c"){$type="<div class='option_box' id='type_change_albums_posts".$albums_post_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$albums_post_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id_albums_post)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_albums_posts".$albums_post_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$albums_post_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_albums_posts".$albums_post_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$albums_post_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id_albums_post){$point="<div class='option_box2' id='point_albums_posts".$albums_post_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$albums_post_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_albums_post."</b></div>";}
	else if($point_array_count_albums_post=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_albums_post."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0)
		{$comment_space = 'class="comment_space"';}
	if($ids==$user_id_albums_post)
		{$delete_button_albums_post="<div class='option_box' id='delete_albums_posts".$albums_post_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$albums_post_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_albums_post="";}
		
	$DisplayList .= "<div id='item_box_albums_posts".$albums_post_id."'>
			<div class='media_post_box'>
			<div class='media_post_box1'>".$user_pic."</div>
			<div class='media_post_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_albums_post."
			</div>
			<div style='width:1000px;'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a> <font style='color:black;'>&#9658; <font style='color:black;font-size:14px;'>Album: </font></font>
				<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$album_owner_id."&force_album=".$media_id."'>".$album_name."</a></div>
			<div class='media_post_box2'>".$the_albums_post."</div>
			<div id='like_love_albums_posts".$albums_post_id."' class='inline'>
			".$like_love_albums_post."
			<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$albums_post_id.",".$comment_type.");'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$albums_post_date."</span>
			".$like_love2_albums_post."</div>
			<div ".$comment_space." id='comment_space_albums_posts".$albums_post_id."'></div>
			<div id='comments_albums_posts".$albums_post_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM albums_posts_comments WHERE albums_post_id='$albums_post_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_albums_post = $row['point_array'];
	$comment_pointArray_albums_post = explode(",",$comment_point_array_albums_post);
	$comment_point_array_count_albums_post = count($comment_pointArray_albums_post);
	$comment_point_array_count_albums_post = $comment_point_array_count_albums_post*10;
	if($comment_point_array_albums_post==""){$comment_point_array_count_albums_post="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_albums_posts".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$albums_post_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_albums_posts".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_albums_post."</b></div>";}
	else if($comment_point_array_count_albums_post=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_albums_post."</b></a></div>";}
						
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
	<div id="comment_list_albums_posts'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_albums_posts'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$albums_post_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= "</div>
			".$expand."
			<div id='comment_albums_posts".$albums_post_id."'></div>
			</div></div></div>";
		}
	}
}

else if ($union_type=="games_posts")
{$mysql1 = mysql_query("SELECT * FROM games_posts WHERE id='$item_id' AND post_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$games_post_id = $row['id'];
	$user_id_games_post = $row['user_id'];
	$media_id = $row['game_id'];
	$the_games_post = $row['the_post'];
	$games_post_date = $row['post_date'];
	$convertedTime = ($myObject -> convert_datetime($games_post_date));
	$games_post_date = ($myObject -> make_ago($convertedTime));
	$memory_type = $row['memory_type'];
	$games_post_type = $row['games_post_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM games_posts_comments WHERE games_post_id='$games_post_id' AND delete_comment='1'"));
	$like_array_games_post = $row['like_array'];
	$love_array_games_post = $row['love_array'];
	$point_array_games_post = $row['point_array'];
	$likeArray_games_post = explode(",",$like_array_games_post);
	$loveArray_games_post = explode(",",$love_array_games_post);
	$pointArray_games_post = explode(",",$point_array_games_post);
	$like_array_count_games_post = count($likeArray_games_post);
	$love_array_count_games_post = count($loveArray_games_post);
	$point_array_count_games_post = count($pointArray_games_post);
	$point_array_count_games_post = $point_array_count_games_post*10;
	if($point_array_games_post==""){$point_array_count_games_post="0";}
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id_games_post' LIMIT 1");
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
		
	$mysql3 = mysql_query("SELECT user_id,game_name FROM games WHERE id='$media_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql3))
		{$game_name = $row['game_name'];
		$game_owner_id= $row['user_id'];}
	
	if ((in_array($ids,$friend_array))AND($games_post_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($games_post_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="games_posts";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_games_post))
		{$like_love_games_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$games_post_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_games_post))
		{$like_love_games_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$games_post_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_games_post = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$games_post_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$games_post_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_games_post !="")AND($love_array_games_post !=""))
		{$like_love2_games_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_games_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_games_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_games_post !="")
		{$like_love2_games_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_games_post."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_games_post !="")
		{$like_love2_games_post = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_games_post."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_games_post = "";}
	
	// Little Things
	if($ids==$user_id_games_post)
	{if($games_post_type=="a"){$type="<div class='option_box' id='type_change_games_posts".$games_post_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$games_post_id.",".$comment_type.");'></a></div>";}
	else if($games_post_type=="b"){$type="<div class='option_box' id='type_change_games_posts".$games_post_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$games_post_id.",".$comment_type.");'></a></div>";}
	else if($games_post_type=="c"){$type="<div class='option_box' id='type_change_games_posts".$games_post_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$games_post_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id_games_post)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_games_posts".$games_post_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$games_post_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_games_posts".$games_post_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$games_post_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id_games_post){$point="<div class='option_box2' id='point_games_posts".$games_post_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$games_post_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_games_post."</b></div>";}
	else if($point_array_count_games_post=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_games_post."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0)
		{$comment_space = 'class="comment_space"';}
	if($ids==$user_id_games_post)
		{$delete_button_games_post="<div class='option_box' id='delete_games_posts".$games_post_id."'><a href='#' title='Delete' class='delete0' onclick='return false' onmousedown='javascript:delete_item1(".$games_post_id.",".$comment_type.");'></a></div>";}
	else{$delete_button_games_post="";}
		
	$DisplayList .= "<div id='item_box_games_posts".$games_post_id."'>
			<div class='media_post_box'>
			<div class='media_post_box1'>".$user_pic."</div>
			<div class='media_post_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."".$delete_button_games_post."
			</div>
			<div style='width:1000px;'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a> <font style='color:black;'>&#9658; <font style='color:black;font-size:14px;'>Game: </font></font>
				<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$game_owner_id."&force_game=".$media_id."'>".$game_name."</a></div>
			<div class='media_post_box2'>".$the_games_post."</div>
			<div id='like_love_games_posts".$games_post_id."' class='inline'>
			".$like_love_games_post."
			<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$games_post_id.",".$comment_type.");'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$games_post_date."</span>
			".$like_love2_games_post."</div>
			<div ".$comment_space." id='comment_space_games_posts".$games_post_id."'></div>
			<div id='comments_games_posts".$games_post_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM games_posts_comments WHERE games_post_id='$games_post_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_games_post = $row['point_array'];
	$comment_pointArray_games_post = explode(",",$comment_point_array_games_post);
	$comment_point_array_count_games_post = count($comment_pointArray_games_post);
	$comment_point_array_count_games_post = $comment_point_array_count_games_post*10;
	if($comment_point_array_games_post==""){$comment_point_array_count_games_post="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_games_posts".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$games_post_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_games_posts".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_games_post."</b></div>";}
	else if($comment_point_array_count_games_post=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_games_post."</b></a></div>";}
						
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
	<div id="comment_list_games_posts'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_games_posts'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$games_post_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= "</div>
			".$expand."
			<div id='comment_games_posts".$games_post_id."'></div>
			</div></div></div>";
		}
	}
}

if ($union_type=="videos_posts")
{$mysql1 = mysql_query("SELECT * FROM videos_posts WHERE id='$item_id' AND post_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$videos_post_id = $row['id'];
	$user_id_videos_post = $row['user_id'];
	$media_id = $row['video_id'];
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
			<div style='width:1000px;'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a> <font style='color:black;'>&#9658; <font style='color:black;font-size:14px;'>Video: </font></font>
				<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$video_owner_id."&force_video=".$media_id."'>".$video_name."</a></div>
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

else if ($union_type=="planets")
{$mysql1 = mysql_query("SELECT * FROM planets WHERE id='$item_id' AND create_date='$datetime' LIMIT 1");
while ($row = mysql_fetch_array ($mysql1))
	{$planet_id = $row['id'];
	$user_id = $row['user_id'];
	$planet_name = $row['planet_name'];
	$planet_description = $row['planet_description'];
	$planet_description_length = strlen($planet_description);
	$planet_description = substr($planet_description, 0, 25);
	if ($planet_description_length>25){$planet_description=$planet_description.'...';}
	$planet_date = $row['create_date'];
	$convertedTime = ($myObject -> convert_datetime($planet_date));
	$planet_date = ($myObject -> make_ago($convertedTime));
	$planet_type = $row['planet_type'];
	$memory_type = $row['memory_type'];
	$comment_array = $row['comment_array'];
	$commentArray = explode(",",$comment_array);
	$comment_count = mysql_num_rows(mysql_query("SELECT id FROM planets_comments WHERE planet_id='$planet_id' AND delete_comment='1'"));
	$like_array_planet = $row['like_array'];
	$love_array_planet = $row['love_array'];
	$point_array_planet = $row['point_array'];
	$likeArray_planet = explode(",",$like_array_planet);
	$loveArray_planet = explode(",",$love_array_planet);
	$pointArray_planet = explode(",",$point_array_planet);
	$like_array_count_planet = count($likeArray_planet);
	$love_array_count_planet = count($loveArray_planet);
	$point_array_count_planet = count($pointArray_planet);
	$point_array_count_planet = $point_array_count_planet*10;
	if($point_array_planet==""){$point_array_count_planet="0";}
	
	$mysql2=mysql_query("SELECT id, firstname, lastname, friend_array, family_array FROM members WHERE id='$user_id' LIMIT 1");
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
	
	if ((in_array($ids,$friend_array))AND($planet_type=="c"))
		{$DisplayList .="";}
	else if ((in_array($ids,$family_array))AND($planet_type=="b"))
		{$DisplayList .="";}
	else {
	
	$comment_type="planets";
	$comment_type=json_encode($comment_type);
	
	if (in_array($ids,$likeArray_planet))
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_planet))
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_planet !="")AND($love_array_planet !=""))
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_planet !="")
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_planet !="")
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_planet = "";}
	
	// Little Things
	if($ids==$user_id)
	{if($planet_type=="a"){$type="<div class='option_box' id='type_change_planets".$planet_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$planet_id.",".$comment_type.");'></a></div>";}
	else if($planet_type=="b"){$type="<div class='option_box' id='type_change_planets".$planet_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$planet_id.",".$comment_type.");'></a></div>";}
	else if($planet_type=="c"){$type="<div class='option_box' id='type_change_planets".$planet_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$planet_id.",".$comment_type.");'></a></div>";}}
	else{$type="";}
	if($ids==$user_id)
	{if($memory_type=="a"){$memory_box="<div class='option_box' id='memory_box_planets".$planet_id."'><a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$planet_id.",".$comment_type.");'></a></div>";}
	else if($memory_type=="b"){$memory_box="<div class='option_box' id='memory_box_planets".$planet_id."'><a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$planet_id.",".$comment_type.");'></a></div>";}}
	else{$memory_box="";}
	if($ids!==$user_id){$point="<div class='option_box2' id='point_planets".$planet_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$planet_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_planet."</b></div>";}
	else if($point_array_count_planet=="0"){$point="";}
	else{$point="<div title='Point Array' class='option_box2'><a href='#' class='point0 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_planet."</b></a></div>";}
	$comment_space="";
	if ($comment_array>0)
		{$comment_space = 'class="comment_space"';}
	if($planet_description==""){$planet_description="Undefined";}
	$check_pic_planet_bar="../planet_files/planet$planet_id/planet_thumb.jpg";
	$default_pic_planet_bar="../planet_files/planet0/planet_thumb.png";
	if (file_exists($check_pic_planet_bar))
		{$user_pic_planet_bar="<a href='../planet/planet.php?id=$planet_id'><img src='$check_pic_planet_bar#$cacheBuster' height='66px' width='66px' class='thumb_background'/></a>";}
	else {$user_pic_planet_bar="<a href='../planet/planet.php?id=$planet_id'><img src='$default_pic_planet_bar' height='66px' width='66px' class='thumb_background'/></a>";}

		
	$DisplayList .= "<div id='item_box_planets".$planet_id."'>
			<div class='create_box'>
			<div class='create_box1'>".$user_pic."</div>
			<div class='create_box3'>
			<div class='option_box_wrap'>
				".$point."".$type."".$memory_box."
			</div>
			<div class='create_box12'>".$user_pic_planet_bar."<div ".$comment_space." id='comment_space_planets".$planet_id."'></div></div>
			<div class='create_box2'><a class='profile_link' href='../profile/profile.php?id=".$user_id."'>".$user_firstname." ".$user_lastname."</a></div>
			<div class='create_box2'><b>New Planet: </b><a class='body' href='../planet/planet.php?id=".$planet_id."'>".$planet_name."</a></div>
			<div class='create_box2'><b>Description: </b>".$planet_description."</div>
			<div id='like_love_planets".$planet_id."' class='inline'>
			".$like_love_planet."
			<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:comment(".$planet_id.",".$comment_type.");' class='post_link'>Comment</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$planet_date."</span>
			".$like_love2_planet."</div>
			<div id='comments_planets".$planet_id."'>";
	
	// COMMENTS
	$mysql3 = mysql_query("SELECT * FROM planets_comments WHERE planet_id='$planet_id' AND delete_comment='1' ORDER BY LENGTH(love_array) DESC, LENGTH(like_array) DESC, comment_date DESC LIMIT 2");
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
	$comment_point_array_planet = $row['point_array'];
	$comment_pointArray_planet = explode(",",$comment_point_array_planet);
	$comment_point_array_count_planet = count($comment_pointArray_planet);
	$comment_point_array_count_planet = $comment_point_array_count_planet*10;
	if($comment_point_array_planet==""){$comment_point_array_count_planet="0";}

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
		{$delete_button="<div class='delete_comment' id='delete_comment_planets".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$planet_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_planets".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count_planet."</b></div>";}
	else if($comment_point_array_count_planet=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count_planet."</b></a></div>";}
						
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
	<div id="comment_list_planets'.$comment_id.'">
	<div class="comment_list">
		<div class="comment_1"><a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$commenter_pic_comment.'</a></div>
		<div class="comment_2">
			<div class="comment_top_options">'.$comment_point.''.$delete_button.'</div>
			<a class="profile_link" href="http://www.barterrain.com/profile/profile.php?id='.$user_id_comment.'">'.$user_firstname_comment.' '.$user_lastname_comment.'</a> 
			<span class="comment">'.$the_comment.'</span>
			<div class="like_love" id="like_love_comment_planets'.$comment_id.'">'.$like_love_comment.'<span class="dot_divider"> &middot;</span>
			<span class="post_date"> '.$comment_date.'</span>
			'.$like_love2_comment.'</div>
		</div>
	</div></div>';}}
	
	if(($comment_array!=="")AND($comment_count>2)){$expand="<a onclick='return false' onmousedown='javascript:expand_comments(".$planet_id.",".$comment_type.");'><div class='expand_comment'>More Comments &#9660;</div></a>";}
	else{$expand='';}
	
	$DisplayList .= '</div>
			'.$expand.'
			<div id="comment_planets'.$planet_id.'"></div>
			</div></div></div>';
		}
	}
}
}}}

echo $DisplayList;
if($numRows>0){$number=$number+20;}
?>
<script type="text/javascript">
// Add more Content at end of page
var number = "<?php echo $number; ?>";
var numRows = "<?php echo $numRows; ?>";
var cacheBuster = "<?php echo $cacheBuster; ?>";
$(window).data('ajaxready5', true).scroll(function()
	{if ($(window).data('ajaxready5') == false) return;
	if($(window).scrollTop()>=$("#bottom_friends").height()-$(document).height())
		{$("div#expand_bottom_box").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready5', false);
		$.ajax({cache: false,url:"friends_content.php?number="+number+"&cacheBuster="+cacheBuster+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_friends").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				 $(window).data('ajaxready5', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_box").click(function(){
	{if ($(window).data('ajaxready5') == false) return;
	$("div#expand_bottom_box").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready5', false);
	$.ajax({cache: false,url:"friends_content.php?number="+number+"&cacheBuster="+cacheBuster+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_friends").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				$(window).data('ajaxready5', true);}
			});
		}
	});
});
</script>