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
	
$mysql = mysql_query("SELECT friend_array, family_array FROM members WHERE id='$id'");
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
if ($FF_array=="") {$mysql_union = mysql_query("(SELECT id, post_date AS datetime, union_type FROM posts WHERE ((user_post_id='$id') AND delete_item='1') 
								AND (the_post LIKE '%$search%'))
							UNION ALL(SELECT id, post_date AS datetime, union_type FROM albums_posts WHERE ((user_id='$id') AND delete_item='1')
								AND (the_post LIKE '%$search%'))
							UNION ALL(SELECT id, post_date AS datetime, union_type FROM games_posts WHERE ((user_id='$id') AND delete_item='1')
								AND (the_post LIKE '%$search%'))
							UNION ALL(SELECT id, post_date AS datetime, union_type FROM videos_posts WHERE ((user_id='$id') AND delete_item='1')
								AND (the_post LIKE '%$search%'))
							ORDER BY datetime DESC LIMIT ".$number.",20");}
else {$mysql_union = mysql_query("(SELECT id, post_date AS datetime, union_type FROM posts WHERE ((user_post_id IN ($FRIENDS) OR user_post_id='$id') AND delete_item='1') 
								AND (the_post LIKE '%$search%'))
							UNION ALL(SELECT id, post_date AS datetime, union_type FROM albums_posts WHERE ((user_id IN ($FRIENDS) OR user_id='$id') AND delete_item='1')
								AND (the_post LIKE '%$search%'))
							UNION ALL(SELECT id, post_date AS datetime, union_type FROM games_posts WHERE ((user_id IN ($FRIENDS) OR user_id='$id') AND delete_item='1')
								AND (the_post LIKE '%$search%'))
							UNION ALL(SELECT id, post_date AS datetime, union_type FROM videos_posts WHERE ((user_id IN ($FRIENDS) OR user_id='$id') AND delete_item='1')
								AND (the_post LIKE '%$search%'))
							ORDER BY datetime DESC LIMIT ".$number.",20");}
$numRows=mysql_num_rows($mysql_union);
if($numRows>0)
{while ($row = mysql_fetch_array ($mysql_union))
	{$item_id = $row['id'];
	$datetime = $row['datetime'];
	$union_type = $row['union_type'];
	
if ($union_type=="posts")
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
$(window).data('ajaxready12', true).scroll(function()
	{if ($(window).data('ajaxready12') == false) return;
	if($(window).scrollTop()>=$("#bottom_search_profiles_posts").height()-$(document).height())
		{$("div#expand_bottom_box").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready12', false);
		$.ajax({cache: false,url:"search_profiles_posts_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_profiles_posts").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				 $(window).data('ajaxready12', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_box").click(function(){
	{if ($(window).data('ajaxready12') == false) return;
	$("div#expand_bottom_box").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready12', false);
	$.ajax({cache: false,url:"search_profiles_posts_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_profiles_posts").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				$(window).data('ajaxready12', true);}
			});
		}
	});
});
</script>