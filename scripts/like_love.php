<?php
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

session_start();
include "../config.php";

///////////////// Like/Love POSTS /////////////////
///////////////////////////////////////////////////
if ($_POST["like_love"] == "Like_post")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$post_id = preg_replace('#[^0-9]#i', '', $_POST['post_id']);
	$item_id = $post_id;
	$item_type = $_POST['item_type'];
	$mysql_post = mysql_query("SELECT user_post_id,like_array, love_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_post_id=$row['user_post_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_post_id!==$ids)
		{$likes=$likes+1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_post_id'") or die (mysql_error());
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET like_array = '$like_array' WHERE id='$post_id'") or die (mysql_error());
	
	$mysql = mysql_query("SELECT id, user_page_id, user_post_id, post_date, like_array, love_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$post_id = $row['id'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$post_date = $row['post_date'];
		$convertedTime = ($myObject -> convert_datetime($post_date));
		$post_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);
	
	if((($id!==$user_page_id)OR($id!==$user_post_id))AND($item_type=="posts"))
		{$SeeFriendship="<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:SeeFriendship(".$user_page_id.", ".$user_post_id.",".$id.");'>See Friendship</a>";}
	else{$SeeFriendship="";}

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_post(".$id.",".$ids.",".$post_id.",".$comment_type.");'>Unlike</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$post_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$post_date."</span>
		".$like_love2_post."";exit();
	}

// Love
if ($_POST["like_love"] == "Love_post")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$post_id = preg_replace('#[^0-9]#i', '', $_POST['post_id']);
	$item_id = $post_id;
	$item_type = $_POST['item_type'];
	$mysql_post = mysql_query("SELECT user_post_id,like_array, love_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font color='#dd4a4a'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_post_id=$row['user_post_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_post_id!==$ids)
		{$loves=$loves+1;}
	$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_post_id'") or die (mysql_error());
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET love_array = '$love_array' WHERE id='$post_id'") or die (mysql_error());
	
	$mysql = mysql_query("SELECT id, user_page_id, user_post_id, post_date, like_array, love_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$post_id = $row['id'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$post_date = $row['post_date'];
		$convertedTime = ($myObject -> convert_datetime($post_date));
		$post_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);
	
	if((($id!==$user_page_id)OR($id!==$user_post_id))AND($item_type=="posts"))
		{$SeeFriendship="<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:SeeFriendship(".$user_page_id.", ".$user_post_id.",".$id.");'>See Friendship</a>";}
	else{$SeeFriendship="";}
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Unlove</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$post_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$post_date."</span>
		".$like_love2_post."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "unlikeLike_post")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$post_id = preg_replace('#[^0-9]#i', '', $_POST['post_id']);
	$item_id = $post_id;
	$item_type = $_POST['item_type'];
	$mysql_like_array = mysql_query("SELECT user_post_id,like_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_like_array))
		{$like_array = $row['like_array'];
		$user_post_id = $row['user_post_id'];}
	$likeArray = explode(",", $like_array);
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$mysql = mysql_query("UPDATE ".$item_type." SET like_array='$new_string' WHERE id='$post_id'");
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_post_id!==$ids)
		{$likes=$likes-1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_post_id'") or die (mysql_error());
	
	$mysql = mysql_query("SELECT id, user_page_id, user_post_id, post_date, like_array, love_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$post_id = $row['id'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$post_date = $row['post_date'];
		$convertedTime = ($myObject -> convert_datetime($post_date));
		$post_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);
	
	if((($id!==$user_page_id)OR($id!==$user_post_id))AND($item_type=="posts"))
		{$SeeFriendship="<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:SeeFriendship(".$user_page_id.", ".$user_post_id.",".$id.");'>See Friendship</a>";}
	else{$SeeFriendship="";}

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$post_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$post_date."</span>
		".$like_love2_post."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "unloveLove_post")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$post_id = preg_replace('#[^0-9]#i', '', $_POST['post_id']);
	$item_id = $post_id;
	$item_type = $_POST['item_type'];
	$mysql_love_array = mysql_query("SELECT user_post_id,love_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_love_array))
		{$user_post_id = $row['user_post_id'];
		$love_array = $row['love_array'];}
	$loveArray = explode(",", $love_array);
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$mysql = mysql_query("UPDATE ".$item_type." SET love_array='$new_string' WHERE id='$post_id'");
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_post_id!==$ids)
		{$loves=$loves-1;}
	$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_post_id'") or die (mysql_error());

	$mysql = mysql_query("SELECT id, user_page_id, user_post_id, post_date, like_array, love_array FROM ".$item_type." WHERE id='$post_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$post_id = $row['id'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$post_date = $row['post_date'];
		$convertedTime = ($myObject -> convert_datetime($post_date));
		$post_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}

	$comment_type=json_encode($item_type);
	
	if((($id!==$user_page_id)OR($id!==$user_post_id))AND($item_type=="posts"))
		{$SeeFriendship="<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:SeeFriendship(".$user_page_id.", ".$user_post_id.",".$id.");'>See Friendship</a>";}
	else{$SeeFriendship="";}
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_post(".$id.",".$ids.", ".$post_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$post_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$post_date."</span>
		".$like_love2_post."";exit();
	}
//////////////// Like/Love POSTS END ////////////////
/////////////////////////////////////////////////////

///////////////// Like/Love WALL STUFF /////////////////
///////////////////////////////////////////////////
if ($_POST["like_love"] == "Like_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	else if ($item_type_s=="images_wall"){$item_type_s="upload";}
	else if ($item_type_s=="planet"){$item_type_s="create";}
	else if ($item_type_s=="page"){$item_type_s="create";}
	else if ($item_type_s=="group"){$item_type_s="create";}
	else if ($item_type_s=="event"){$item_type_s="create";}
	else if ($item_type_s=="shop"){$item_type_s="create";}
	else if ($item_type_s=="games_post"){$item_type_s="post";}
	else if ($item_type_s=="videos_post"){$item_type_s="post";}
	else if ($item_type_s=="albums_post"){$item_type_s="post";}
	else if ($item_type_s=="images_post"){$item_type_s="post";}
	$mysql = mysql_query("SELECT user_id, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_id!==$ids)
		{$likes=$likes+1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET like_array = '$like_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlike</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}

// Love
if ($_POST["like_love"] == "Love_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	else if ($item_type_s=="images_wall"){$item_type_s="upload";}
	else if ($item_type_s=="planet"){$item_type_s="create";}
	else if ($item_type_s=="page"){$item_type_s="create";}
	else if ($item_type_s=="group"){$item_type_s="create";}
	else if ($item_type_s=="event"){$item_type_s="create";}
	else if ($item_type_s=="shop"){$item_type_s="create";}
	else if ($item_type_s=="games_post"){$item_type_s="post";}
	else if ($item_type_s=="videos_post"){$item_type_s="post";}
	else if ($item_type_s=="albums_post"){$item_type_s="post";}
	else if ($item_type_s=="images_post"){$item_type_s="post";}
	$mysql_post = mysql_query("SELECT user_id,like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font color='#dd4a4a'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_id!==$ids)
		{$loves=$loves+1;}
	$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET love_array = '$love_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlove</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "unlikeLike_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	else if ($item_type_s=="images_wall"){$item_type_s="upload";}
	else if ($item_type_s=="planet"){$item_type_s="create";}
	else if ($item_type_s=="page"){$item_type_s="create";}
	else if ($item_type_s=="group"){$item_type_s="create";}
	else if ($item_type_s=="event"){$item_type_s="create";}
	else if ($item_type_s=="shop"){$item_type_s="create";}
	else if ($item_type_s=="games_post"){$item_type_s="post";}
	else if ($item_type_s=="videos_post"){$item_type_s="post";}
	else if ($item_type_s=="albums_post"){$item_type_s="post";}
	else if ($item_type_s=="images_post"){$item_type_s="post";}
	$mysql_like_array = mysql_query("SELECT user_id,like_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_like_array))
		{$user_id = $row['user_id'];
		$like_array = $row['like_array'];}
	$likeArray = explode(",", $like_array);
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$mysql = mysql_query("UPDATE ".$item_type." SET like_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_id!==$ids)
		{$likes=$likes-1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "unloveLove_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	else if ($item_type_s=="images_wall"){$item_type_s="upload";}
	else if ($item_type_s=="planet"){$item_type_s="create";}
	else if ($item_type_s=="page"){$item_type_s="create";}
	else if ($item_type_s=="group"){$item_type_s="create";}
	else if ($item_type_s=="event"){$item_type_s="create";}
	else if ($item_type_s=="shop"){$item_type_s="create";}
	else if ($item_type_s=="games_post"){$item_type_s="post";}
	else if ($item_type_s=="videos_post"){$item_type_s="post";}
	else if ($item_type_s=="albums_post"){$item_type_s="post";}
	else if ($item_type_s=="images_post"){$item_type_s="post";}
	$mysql_love_array = mysql_query("SELECT user_id,love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_love_array))
		{$user_id = $row['user_id'];
		$love_array = $row['love_array'];}
	$loveArray = explode(",", $love_array);
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$mysql = mysql_query("UPDATE ".$item_type." SET love_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_id!==$ids)
		{$loves=$loves-1;}
	$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}

	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}
//////////////// Like/Love WALL STUFF END ////////////////
//////////////////////////////////////////////////////////

/////////////// Like/Love Comments ///////////////
//////////////////////////////////////////////////
if ($_POST["like_love"] == "Like_comment")
	{$type=$_POST['comment_type'];
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";}
	else{$typex="";}
	$id = $_POST['id'];
	$ids = preg_replace('#[^0-9]#i', '', $_POST['ids']);
	$comment_id = preg_replace('#[^0-9]#i', '', $_POST['comment_id']);
	$mysql_comment = mysql_query("SELECT user_post_id,like_array, love_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_comment);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_comment))
		{$user_post_id=$row['user_post_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_post_id!==$ids)
		{$likes=$likes+1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_post_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$typex."".$type."_comments SET like_array = '$like_array' WHERE id='$comment_id'") or die (mysql_error());
	
	$mysql = mysql_query("SELECT id, comment_date, like_array, love_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$comment_id = $row['id'];
		$comment_date = $row['comment_date'];
		$convertedTime = ($myObject -> convert_datetime($comment_date));
		$comment_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
		$comment_type= json_encode($type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_comment = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlike</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$comment_date."</span>
		".$like_love2_comment."";exit();
	}

// Love
if ($_POST["like_love"] == "Love_comment")
	{$ids = preg_replace('#[^0-9]#i', '', $_POST['ids']);
	$id = $_POST['id'];
	$comment_id = preg_replace('#[^0-9]#i', '', $_POST['comment_id']);
	$type=$_POST['comment_type'];
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";}
	else{$typex="";}
	$mysql_comment = mysql_query("SELECT user_post_id,like_array, love_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_comment);
	if ($num_rows < 1)
		{echo "<font color='#dd4a4a'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_comment))
		{$user_post_id=$row['user_post_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_post_id!==$ids)
		{$loves=$loves+1;}
	$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_post_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$typex."".$type."_comments SET love_array = '$love_array' WHERE id='$comment_id'") or die (mysql_error());
	
	$mysql = mysql_query("SELECT id, comment_date, like_array, love_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$comment_id = $row['id'];
		$comment_date = $row['comment_date'];
		$convertedTime = ($myObject -> convert_datetime($comment_date));
		$comment_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
		$comment_type= json_encode($type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_comment = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlove</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$comment_date."</span>
		".$like_love2_comment."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "unlikeLike_comment")
	{$comment_id = preg_replace('#[^0-9]#i','',$_POST['comment_id']);
	$id = $_POST['id'];
	$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$type=$_POST['comment_type'];
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";}
	else{$typex="";}
	$mysql_like_array = mysql_query("SELECT user_post_id,like_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_like_array))
		{$user_post_id = $row['user_post_id'];
		$like_array = $row['like_array'];}
	$likeArray = explode(",", $like_array);
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$mysql = mysql_query("UPDATE ".$typex."".$type."_comments SET like_array='$new_string' WHERE id='$comment_id'");
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_post_id!==$ids)
		{$likes=$likes-1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_post_id'") or die (mysql_error());
	
	$mysql = mysql_query("SELECT id, comment_date, like_array, love_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$comment_id = $row['id'];
		$comment_date = $row['comment_date'];
		$convertedTime = ($myObject -> convert_datetime($comment_date));
		$comment_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
		$comment_type= json_encode($type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_comment = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Love</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$comment_date."</span>
		".$like_love2_comment."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "unloveLove_comment")
	{$comment_id = preg_replace('#[^0-9]#i','',$_POST['comment_id']);
	$id = $_POST['id'];
	$ids = preg_replace('#[^0-9]#i','',$_POST['ids']);
	$type=$_POST['comment_type'];
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";}
	else{$typex="";}
	$mysql_love_array = mysql_query("SELECT user_post_id,love_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_love_array))
		{$user_post_id = $row['user_post_id'];
		$love_array = $row['love_array'];}
	$loveArray = explode(",", $love_array);
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$mysql = mysql_query("UPDATE ".$typex."".$type."_comments SET love_array='$new_string' WHERE id='$comment_id'");
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_post_id!==$ids)
		{$loves=$loves-1;}
	$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_post_id'") or die (mysql_error());
	
	$mysql = mysql_query("SELECT id, comment_date, like_array, love_array FROM ".$typex."".$type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$comment_id = $row['id'];
		$comment_date = $row['comment_date'];
		$convertedTime = ($myObject -> convert_datetime($comment_date));
		$comment_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}

	$comment_type= json_encode($type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_comment = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Love</a><span class='dot_divider'> &middot; </span><span class='post_date'>".$comment_date."</span>
		".$like_love2_comment."";exit();
	}
/////////////// Like/Love Comments ///////////////
//////////////////////////////////////////////////

///////////////// Like/Love FOLDERS ///////////////
///////////////////////////////////////////////////
if ($_POST["like_love"] == "Like_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";$user_id_get="user_post_id";}
	else{$typex="";$user_id_get="user_id";}
	$mysql = mysql_query("SELECT ".$user_id_get." AS user_id, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_id!==$ids)
		{$likes=$likes+1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$typex."".$item_type." SET like_array = '$like_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlike</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}

// Love
if ($_POST["like_love"] == "Love_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";$user_id_get="user_post_id";}
	else{$typex="";$user_id_get="user_id";}
	$mysql_post = mysql_query("SELECT ".$user_id_get." AS user_id,like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font color='#dd4a4a'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_id!==$ids)
		{$loves=$loves+1;}
	$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$typex."".$item_type." SET love_array = '$love_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlove</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "unlikeLike_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";$user_id_get="user_post_id";}
	else{$typex="";$user_id_get="user_id";}
	$mysql_like_array = mysql_query("SELECT ".$user_id_get." AS user_id,like_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_like_array))
		{$user_id = $row['user_id'];
		$like_array = $row['like_array'];}
	$likeArray = explode(",", $like_array);
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$mysql = mysql_query("UPDATE ".$typex."".$item_type." SET like_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_id!==$ids)
		{$likes=$likes-1;}
	$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "unloveLove_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if ($item_type_s=="album"){$item_type_s="upload";}
	else if ($item_type_s=="video"){$item_type_s="upload";}
	else if ($item_type_s=="game"){$item_type_s="upload";}
	if((isset($_POST['typex']))AND($type!="link_creates")){$typex=$_POST['typex'];$typex=$typex."_";$user_id_get="user_post_id";}
	else{$typex="";$user_id_get="user_id";}
	$mysql_love_array = mysql_query("SELECT ".$user_id_get." AS user_id,love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_love_array))
		{$user_id = $row['user_id'];
		$love_array = $row['love_array'];}
	$loveArray = explode(",", $love_array);
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$mysql = mysql_query("UPDATE ".$typex."".$item_type." SET love_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_id!==$ids)
		{$loves=$loves-1;}
	$UpdateArray = mysql_query("UPDATE members SET loves='$loves' WHERE id='$user_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}

	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2_post."";exit();
	}
//////////////// Like/Love FOLDERS ////////////////
///////////////////////////////////////////////////

///////////////// Like/Love IMAGES ///////////////
///////////////////////////////////////////////////
if ($_POST["like_love"] == "Like_image")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['image_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if((isset($_POST['typex']))AND($item_type!="link_creates")){$typex_0=$_POST['typex'];$typex=$typex_0."_";$typex_2=$typex_0;$user_id_get="user_page_id";}
	else{$typex="";$typex_2="members";$user_id_get="user_id";}
	$mysql = mysql_query("SELECT ".$user_id_get." AS user_id, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT likes FROM ".$typex_2." WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_id!==$ids)
		{$likes=$likes+1;}
	$UpdateArray = mysql_query("UPDATE ".$typex_2." SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$typex."".$item_type." SET like_array = '$like_array' WHERE id='$item_id'") or die (mysql_error());

	$mysql2 = mysql_query("SELECT id, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<div class='like_love'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_image(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlike</a>&nbsp;</div> ".$like_love2_post;exit();
	}

// Love
if ($_POST["like_love"] == "Love_image")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['image_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if((isset($_POST['typex']))AND($item_type!="link_creates")){$typex_0=$_POST['typex'];$typex=$typex_0."_";$typex_2=$typex_0;$user_id_get="user_page_id";}
	else{$typex="";$typex_2="members";$user_id_get="user_id";}
	$mysql_post = mysql_query("SELECT ".$user_id_get." AS user_id,like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font color='#dd4a4a'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT loves FROM ".$typex_2." WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_id!==$ids)
		{$loves=$loves+1;}
	$UpdateArray = mysql_query("UPDATE ".$typex_2." SET loves = '$loves' WHERE id='$user_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$typex."".$item_type." SET love_array = '$love_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<div class='like_love'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_image(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlove</a>&nbsp;</div> ".$like_love2_post;exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "unlikeLike_image")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['image_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if((isset($_POST['typex']))AND($item_type!="link_creates")){$typex_0=$_POST['typex'];$typex=$typex_0."_";$typex_2=$typex_0;$user_id_get="user_page_id";}
	else{$typex="";$typex_2="members";$user_id_get="user_id";}
	$mysql_like_array = mysql_query("SELECT ".$user_id_get." AS user_id,like_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_like_array))
		{$user_id = $row['user_id'];
		$like_array = $row['like_array'];}
	$likeArray = explode(",", $like_array);
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$mysql = mysql_query("UPDATE ".$typex."".$item_type." SET like_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT likes FROM ".$typex_2." WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	if($user_id!==$ids)
		{$likes=$likes-1;}
	$UpdateArray = mysql_query("UPDATE ".$typex_2." SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<div class='like_love'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_image(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_image(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>&nbsp;</div> ".$like_love2_post."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "unloveLove_image")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['image_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	if((isset($_POST['typex']))AND($item_type!="link_creates")){$typex_0=$_POST['typex'];$typex=$typex_0."_";$typex_2=$typex_0;$user_id_get="user_page_id";}
	else{$typex="";$typex_2="members";$user_id_get="user_id";}
	$mysql_love_array = mysql_query("SELECT ".$user_id_get." AS user_id,love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_love_array))
		{$user_id = $row['user_id'];
		$love_array = $row['love_array'];}
	$loveArray = explode(",", $love_array);
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$mysql = mysql_query("UPDATE ".$typex."".$item_type." SET love_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT loves FROM ".$typex_2." WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	if($user_id!==$ids)
		{$loves=$loves-1;}
	$UpdateArray = mysql_query("UPDATE ".$typex_2." SET loves='$loves' WHERE id='$user_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, like_array, love_array FROM ".$typex."".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}

	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<div class='like_love'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_image(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_image(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>&nbsp;</div> ".$like_love2_post."";exit();
	}
//////////////// Like/Love IMAGES ////////////////
///////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
/////////////// Like/Love INFORMATION CIRCLES ///////////////
if ($_POST["like_love"] == "Like_circle")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s="create";
	$mysql = mysql_query("SELECT user_id, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT likes FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	$likes=$likes+1;
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET likes = '$likes' WHERE id='$item_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET like_array = '$like_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_circle(".$ids.",".$item_id.",".$comment_type.");'>Unlike</a>
		".$like_love2_post."";exit();
	}

// Love
if ($_POST["like_love"] == "Love_circle")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s="create";
	$mysql_post = mysql_query("SELECT user_id,like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_id=$row['user_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	$mysql_user = mysql_query("SELECT loves FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	$loves=$loves+1;
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET loves = '$loves' WHERE id='$item_id'") or die (mysql_error());
	
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET love_array = '$love_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_circle(".$ids.", ".$item_id.",".$comment_type.");'>Unlove</a>
		".$like_love2_post."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "unlikeLike_circle")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s="create";
	$mysql_like_array = mysql_query("SELECT user_id,like_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_like_array))
		{$user_id = $row['user_id'];
		$like_array = $row['like_array'];}
	$likeArray = explode(",", $like_array);
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$mysql = mysql_query("UPDATE ".$item_type." SET like_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT likes FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$likes=$row['likes'];}
	$likes=$likes-1;
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET likes = '$likes' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_circle(".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_circle(".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		".$like_love2_post."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "unloveLove_circle")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s="create";
	$mysql_love_array = mysql_query("SELECT user_id,love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_love_array))
		{$user_id = $row['user_id'];
		$love_array = $row['love_array'];}
	$loveArray = explode(",", $love_array);
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$mysql = mysql_query("UPDATE ".$item_type." SET love_array='$new_string' WHERE id='$item_id'");
	
	$mysql_user = mysql_query("SELECT loves FROM ".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql_user))
		{$loves=$row['loves'];}
	$loves=$loves-1;
	$UpdateArray = mysql_query("UPDATE ".$item_type." SET loves = '$loves' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$item_type_s."_date, like_array, love_array FROM ".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$item_type_s."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}

	$comment_type=json_encode($item_type);
		
	if (($like_array !="")AND($love_array !=""))
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2_post = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_post = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_circle(".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_circle(".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		".$like_love2_post."";exit();
	}
/////////////// Like/Love INFORMATION CIRCLES ///////////////
/////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
/////////////// Like/Love INFORMATION CREATE ///////////////
if ($_POST["like_love"] == "Like_create")
	{$user_id = $_POST['user_id'];
	$ids = $_POST['ids'];
	$create_id = $_POST['create_id'];
	$create_type=$_POST['type'];
	$mysql = mysql_query("SELECT likes, like_array, love_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font class='post_link'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$like_array=$row['like_array'];
		$love_array=$row['love_array'];
		$likes=$row['likes'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	$likes=$likes+1;
	
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET likes = '$likes' WHERE id='$create_id'") or die (mysql_error());
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET like_array = '$like_array' WHERE id='$create_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT like_array, love_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$like_array_create = $row['like_array'];
		$love_array_create = $row['love_array'];
		$likeArray_create = explode(",",$like_array_create);
		$loveArray_create = explode(",",$love_array_create);
		$like_array_count_create = count($likeArray_create);
		$love_array_count_create = count($loveArray_create);}
		
	$typex=json_encode($create_type);

	if (($like_array_create !="")AND($love_array_create !=""))
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>
						<span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_create = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_create(".$user_id.",".$ids.",".$create_id.");'>Unlike</a>
		".$like_love2_create."";exit();
	}

// Love
if ($_POST["like_love"] == "Love_create")
	{$user_id = $_POST['user_id'];
	$ids = $_POST['ids'];
	$create_id = $_POST['create_id'];
	$create_type=$_POST['type'];
	$mysql = mysql_query("SELECT loves, like_array, love_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font class='post_link'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$like_array=$row['like_array'];
		$love_array=$row['love_array'];
		$loves=$row['loves'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	$loves=$loves+1;
	
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET loves = '$loves' WHERE id='$create_id'") or die (mysql_error());
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET love_array = '$love_array' WHERE id='$create_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT like_array, love_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$like_array_create = $row['like_array'];
		$love_array_create = $row['love_array'];
		$likeArray_create = explode(",",$like_array_create);
		$loveArray_create = explode(",",$love_array_create);
		$like_array_count_create = count($likeArray_create);
		$love_array_count_create = count($loveArray_create);}

	$typex=json_encode($create_type);

	if (($like_array_create !="")AND($love_array_create !=""))
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>
						<span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_create = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_create(".$user_id.",".$ids.",".$create_id.");'>Unlove</a>
		".$like_love2_create."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "unlikeLike_create")
	{$user_id = $_POST['user_id'];
	$ids = $_POST['ids'];
	$create_id = $_POST['create_id'];
	$create_type=$_POST['type'];
	$mysql = mysql_query("SELECT likes, like_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql))
		{$like_array = $row['like_array'];
		$likes = $row['likes'];}
	$likeArray = explode(",", $like_array);
	
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$likes=$likes-1;
	
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET likes = '$likes' WHERE id='$create_id'") or die (mysql_error());
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET like_array='$new_string' WHERE id='$create_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT like_array, love_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$like_array_create = $row['like_array'];
		$love_array_create = $row['love_array'];
		$likeArray_create = explode(",",$like_array_create);
		$loveArray_create = explode(",",$love_array_create);
		$like_array_count_create = count($likeArray_create);
		$love_array_count_create = count($loveArray_create);}

	$typex=json_encode($create_type);

	if (($like_array_create !="")AND($love_array_create !=""))
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>
						<span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_create = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_create(".$user_id.", ".$ids.",".$create_id.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_create(".$user_id.", ".$ids.",".$create_id.");'>Love</a>
		".$like_love2_create."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "unloveLove_create")
	{$user_id = $_POST['user_id'];
	$ids = $_POST['ids'];
	$create_id = $_POST['create_id'];
	$create_type=$_POST['type'];
	$mysql = mysql_query("SELECT loves, love_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1") or die ("Sorry, we have a system error!");
	while ($row=mysql_fetch_array($mysql))
		{$love_array = $row['love_array'];
		$loves = $row['loves'];}
	$loveArray = explode(",", $love_array);
	
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$loves=$loves-1;
	
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET loves = '$loves' WHERE id='$create_id'") or die (mysql_error());
	$UpdateArray = mysql_query("UPDATE ".$create_type." SET love_array='$new_string' WHERE id='$create_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT like_array, love_array FROM ".$create_type." WHERE id='$create_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$like_array_create = $row['like_array'];
		$love_array_create = $row['love_array'];
		$likeArray_create = explode(",",$like_array_create);
		$loveArray_create = explode(",",$love_array_create);
		$like_array_count_create = count($likeArray_create);
		$love_array_count_create = count($loveArray_create);}

	$typex=json_encode($create_type);

	if (($like_array_create !="")AND($love_array_create !=""))
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>
						<span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$like_array_count_create."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array_create !="")
		{$like_love2_create = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$user_id.",".$ids.", ".$create_id.",".$typex.");'>".$love_array_count_create."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_create = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_create(".$user_id.", ".$ids.",".$create_id.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_create(".$user_id.", ".$ids.",".$create_id.");'>Love</a>
		".$like_love2_create."";exit();
	}
/////////////// Like/Love INFORMATION CREATE ///////////////
/////////////////////////////////////////////////////////////

///////////////// Like/Love CREATE STUFF /////////////////
///////////////////////////////////////////////////
if ($_POST["like_love"] == "create_Like_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['typex'];
	if($item_type=="link_creates"){$mysql_post = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM link_creates WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");}
	else{$mysql_post = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");}
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_post_id=$row['user_post_id'];
		$user_page_id=$row['user_page_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="images_wall"){$front_date="upload";}
	else if ($item_type_s=="page"){$front_date="create";}
	else if ($item_type_s=="event"){$front_date="create";}
	else if ($item_type_s=="shop"){$front_date="create";}
	else if ($item_type_s=="note"){$front_date="note";}
	else if ($item_type_s=="post"){$front_date="post";}
	else if ($item_type_s=="member_post"){$front_date="post";}
	else if ($item_type_s=="games_post"){$front_date="post";}
	else if ($item_type_s=="videos_post"){$front_date="post";}
	else if ($item_type_s=="albums_post"){$front_date="post";}
	else if ($item_type_s=="images_post"){$front_date="post";}
	else if ($item_type_s=="link_create"){$front_date="link_create";}
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		$likes=$likes+1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET likes = '$likes' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		if($user_post_id!==$ids)
			{$likes=$likes+1;}
		$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_post_id'") or die (mysql_error());}
	
	if($item_type=="link_creates"){$UpdateArray = mysql_query("UPDATE link_creates SET like_array = '$like_array' WHERE id='$item_id'") or die (mysql_error());}
	else{$UpdateArray = mysql_query("UPDATE ".$typex."_".$item_type." SET like_array = '$like_array' WHERE id='$item_id'") or die (mysql_error());}
	
	if($item_type=="link_creates"){$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row = mysql_fetch_array ($mysql))
		{$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$item_date = $row['item_date'];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=$item_type;
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_item(".$id.",".$ids.",".$item_id.",".$comment_type.");'>Unlike</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}

// Love
if ($_POST["like_love"] == "create_Love_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['typex'];
	if($item_type=="link_creates"){$mysql_post = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM link_creates WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");}
	else{$mysql_post = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");}
	$num_rows = mysql_num_rows($mysql_post);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql_post))
		{$user_post_id=$row['user_post_id'];
		$user_page_id=$row['user_page_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="images_wall"){$front_date="upload";}
	else if ($item_type_s=="page"){$front_date="create";}
	else if ($item_type_s=="event"){$front_date="create";}
	else if ($item_type_s=="shop"){$front_date="create";}
	else if ($item_type_s=="note"){$front_date="note";}
	else if ($item_type_s=="post"){$front_date="post";}
	else if ($item_type_s=="member_post"){$front_date="post";}
	else if ($item_type_s=="games_post"){$front_date="post";}
	else if ($item_type_s=="videos_post"){$front_date="post";}
	else if ($item_type_s=="albums_post"){$front_date="post";}
	else if ($item_type_s=="images_post"){$front_date="post";}
	else if ($item_type_s=="link_create"){$front_date="link_create";}
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		$loves=$loves+1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET loves = '$loves' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		if($user_post_id!==$ids)
			{$loves=$loves+1;}
		$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_post_id'") or die (mysql_error());}
	
	if($item_type=="link_creates"){$UpdateArray = mysql_query("UPDATE link_creates SET love_array = '$love_array' WHERE id='$item_id'") or die (mysql_error());}
	else{$UpdateArray = mysql_query("UPDATE ".$typex."_".$item_type." SET love_array = '$love_array' WHERE id='$item_id'") or die (mysql_error());}
	
	if($item_type=="link_creates"){$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row = mysql_fetch_array ($mysql))
		{$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$item_date = $row['item_date'];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=$item_type;
	$comment_type=json_encode($comment_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_item(".$id.",".$ids.",".$item_id.",".$comment_type.");'>Unlove</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "create_unlikeLike_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['typex'];
	if($item_type=="link_creates"){$mysql_like_array = mysql_query("SELECT user_page_id,user_post_id,like_array FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql_like_array = mysql_query("SELECT user_page_id,user_post_id,like_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row=mysql_fetch_array($mysql_like_array))
		{$like_array = $row['like_array'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];}
	$likeArray = explode(",", $like_array);
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="images_wall"){$front_date="upload";}
	else if ($item_type_s=="page"){$front_date="create";}
	else if ($item_type_s=="event"){$front_date="create";}
	else if ($item_type_s=="shop"){$front_date="create";}
	else if ($item_type_s=="note"){$front_date="note";}
	else if ($item_type_s=="post"){$front_date="post";}
	else if ($item_type_s=="member_post"){$front_date="post";}
	else if ($item_type_s=="games_post"){$front_date="post";}
	else if ($item_type_s=="videos_post"){$front_date="post";}
	else if ($item_type_s=="albums_post"){$front_date="post";}
	else if ($item_type_s=="images_post"){$front_date="post";}
	else if ($item_type_s=="link_create"){$front_date="link_create";}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	if($item_type=="link_creates"){$mysql = mysql_query("UPDATE link_creates SET like_array='$new_string' WHERE id='$item_id'");}
	else{$mysql = mysql_query("UPDATE ".$typex."_".$item_type." SET like_array='$new_string' WHERE id='$item_id'");}
	
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		$likes=$likes-1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET likes = '$likes' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		if($user_post_id!==$ids)
			{$likes=$likes-1;}
		$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_post_id'") or die (mysql_error());}
	
	if($item_type=="link_creates"){$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row = mysql_fetch_array ($mysql))
		{$post_id = $row['id'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$item_date = $row['item_date'];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "create_unloveLove_item")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['typex'];
	if($item_type=="link_creates"){$mysql_love_array = mysql_query("SELECT user_page_id,user_post_id,love_array FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql_love_array = mysql_query("SELECT user_page_id,user_post_id,love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row=mysql_fetch_array($mysql_love_array))
		{$love_array = $row['love_array'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];}
	$loveArray = explode(",", $love_array);
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="images_wall"){$front_date="upload";}
	else if ($item_type_s=="page"){$front_date="create";}
	else if ($item_type_s=="event"){$front_date="create";}
	else if ($item_type_s=="shop"){$front_date="create";}
	else if ($item_type_s=="note"){$front_date="note";}
	else if ($item_type_s=="post"){$front_date="post";}
	else if ($item_type_s=="member_post"){$front_date="post";}
	else if ($item_type_s=="games_post"){$front_date="post";}
	else if ($item_type_s=="videos_post"){$front_date="post";}
	else if ($item_type_s=="albums_post"){$front_date="post";}
	else if ($item_type_s=="images_post"){$front_date="post";}
	else if ($item_type_s=="link_create"){$front_date="link_create";}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	if($item_type=="link_creates"){$mysql = mysql_query("UPDATE link_creates SET love_array='$new_string' WHERE id='$item_id'");}
	else{$mysql = mysql_query("UPDATE ".$typex."_".$item_type." SET love_array='$new_string' WHERE id='$item_id'");}
	
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		$loves=$loves-1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET loves = '$loves' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_post_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		if($user_post_id!==$ids)
			{$loves=$loves-1;}
		$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_post_id'") or die (mysql_error());}
	
	if($item_type=="link_creates"){$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql = mysql_query("SELECT id, user_page_id, user_post_id, like_array, love_array, ".$front_date."_date AS item_date FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row = mysql_fetch_array ($mysql))
		{$post_id = $row['id'];
		$user_page_id = $row['user_page_id'];
		$user_post_id = $row['user_post_id'];
		$item_date = $row['item_date'];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
		
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_item(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:comment(".$item_id.",".$comment_type.");'>Comment</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}
//////////////// Like/Love CREATE STUFF END ////////////////
/////////////////////////////////////////////////////

///////////////// Like/Love CREATE FOLDERS ///////////////
///////////////////////////////////////////////////
if ($_POST["like_love"] == "create_Like_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = $_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}

	$mysql = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_post_id=$row['user_post_id'];
		$user_page_id=$row['user_page_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($like_array != "")
		{$like_array = "$like_array,$ids";}
	else {$like_array = "$ids";}
	
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		$likes=$likes+1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET likes = '$likes' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		if($user_post_id!==$ids)
			{$likes=$likes+1;}
		$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());}
	
	$UpdateArray = mysql_query("UPDATE ".$typex."_".$item_type." SET like_array = '$like_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$front_date."_date, like_array, love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$front_date."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlike</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}

// Love
if ($_POST["like_love"] == "create_Love_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}

	$mysql = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_post_id=$row['user_post_id'];
		$user_page_id=$row['user_page_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Liked</a>";exit();}
	else if(in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Loved</a>";exit();}
	if ($love_array != "")
		{$love_array = "$love_array,$ids";}
	else {$love_array = "$ids";}
	
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		$loves=$loves+1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET loves = '$loves' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		if($user_post_id!==$ids)
			{$loves=$loves+1;}
		$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_id'") or die (mysql_error());}
	
	$UpdateArray = mysql_query("UPDATE ".$typex."_".$item_type." SET love_array = '$love_array' WHERE id='$item_id'") or die (mysql_error());
	
	$mysql2 = mysql_query("SELECT id, ".$front_date."_date, like_array, love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$front_date."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}	
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Unlove</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}
	
// Unliking Like
if ($_POST['like_love'] == "create_unlikeLike_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}

	$mysql = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_post_id=$row['user_post_id'];
		$user_page_id=$row['user_page_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(!in_array($ids, $likeArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unliked</a>";exit();}
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		$likes=$likes-1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET likes = '$likes' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT likes FROM members WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$likes=$row['likes'];}
		if($user_post_id!==$ids)
			{$likes=$likes-1;}
		$UpdateArray = mysql_query("UPDATE members SET likes = '$likes' WHERE id='$user_id'") or die (mysql_error());}
	
	foreach ($likeArray as $key => $value) 
		{if ($value == $ids)
			{unset($likeArray[$key]);}}
	$new_string = implode(",",$likeArray);
	$mysql = mysql_query("UPDATE ".$typex."_".$item_type." SET like_array='$new_string' WHERE id='$item_id'");
	
	$mysql2 = mysql_query("SELECT id, ".$front_date."_date, like_array, love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$front_date."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}		
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}

// Unloving Love
if ($_POST['like_love'] == "create_unloveLove_folder")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$item_id = preg_replace('#[^0-9]#i', '', $_POST['item_id']);
	$item_type = $_POST['item_type'];
	$item_type_s=substr($item_type, 0, -1);
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	if ($item_type_s=="album"){$front_date="upload";}
	else if ($item_type_s=="video"){$front_date="upload";}
	else if ($item_type_s=="game"){$front_date="upload";}

	$mysql = mysql_query("SELECT user_page_id,user_post_id,like_array,love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
	$num_rows = mysql_num_rows($mysql);
	if ($num_rows < 1)
		{echo "<font style='font:11px helvetica, sans-serif;color:#dd4a4a;'>An Error Has Occured!</font>";exit();}
	while ($row=mysql_fetch_array($mysql))
		{$user_post_id=$row['user_post_id'];
		$user_page_id=$row['user_page_id'];
		$like_array=$row['like_array'];
		$love_array=$row['love_array'];}
	$likeArray = explode(",",$like_array);
	$loveArray = explode(",",$love_array);
	
	if(!in_array($ids, $loveArray))
		{echo "<a href='#' onclick='return false' class='post_link'>Already Unloved</a>";exit();}
	if ($item_type_s!=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM ".$typex." WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		$loves=$loves-1;
		$UpdateArray = mysql_query("UPDATE ".$typex." SET loves = '$loves' WHERE id='$user_page_id'") or die (mysql_error());}
	else if ($item_type_s=="member_post")
		{$mysql_user = mysql_query("SELECT loves FROM members WHERE id='$user_page_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_user))
			{$loves=$row['loves'];}
		if($user_post_id!==$ids)
			{$loves=$loves-1;}
		$UpdateArray = mysql_query("UPDATE members SET loves = '$loves' WHERE id='$user_id'") or die (mysql_error());}
	
	foreach ($loveArray as $key => $value) 
		{if ($value == $ids)
			{unset($loveArray[$key]);}}
	$new_string = implode(",",$loveArray);
	$mysql = mysql_query("UPDATE ".$typex."_".$item_type." SET love_array='$new_string' WHERE id='$item_id'");
	
	$mysql2 = mysql_query("SELECT id, ".$front_date."_date, like_array, love_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql2))
		{$item_id = $row['id'];
		$item_date = $row["".$front_date."_date"];
		$convertedTime = ($myObject -> convert_datetime($item_date));
		$item_date = ($myObject -> make_ago($convertedTime));
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$likeArray = explode(",",$like_array);
		$loveArray = explode(",",$love_array);
		$like_array_count = count($likeArray);
		$love_array_count = count($loveArray);}
	
	$comment_type=json_encode($item_type);

	if (($like_array !="")AND($love_array !=""))
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array !="")
		{$like_love2 = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2 = "";}			
	
	echo "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
		<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_folder(".$id.",".$ids.", ".$item_id.",".$comment_type.");'>Love</a>
		<span class='dot_divider'> &middot;</span><span class='post_date'> ".$item_date."</span>
		".$like_love2."";exit();
	}
//////////////// Like/Love CREATE FOLDERS ////////////////
///////////////////////////////////////////////////
?>