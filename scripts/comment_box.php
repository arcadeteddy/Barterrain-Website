<?php 
session_start();
include "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

$cacheBuster=rand(999999999,9999999999999);  
$DisplayList="";
$comment ="";
$comments ="";
$id = $_SESSION['id'];
$ids = $_SESSION['ids'];

$color=$_SESSION['color'];
if (isset($color))
	{if ($color=="blue")
		{$color1="#295FCC";
		$color1_2="#295FCC";
		$color2="#B4C7ED";
		$color3="#CCD9F3";
		$color4="#E3EAF9";}
	else if ($color=="green")
		{$color1="#36B336";
		$color1_2="#36B336";
		$color2="#B9E4B9";
		$color3="#CFEDCF";
		$color4="#E5F5E5";}
	else if ($color=="yellow")
		{$color1="#E5E517";
		$color1_2="#E5E517";
		$color2="#F6F6AE";
		$color3="#F9F9C8";
		$color4="#FCFCE1";}
	else if ($color=="orange")
		{$color1="#E57E17";
		$color1_2="#E57E17";
		$color2="#F6D2AE";
		$color3="#F9E0C8";
		$color4="#FCEEE1";}
	else if ($color=="red")
		{$color1="#CC2929";
		$color1_2="#CC2929";
		$color2="#EDB4B4";
		$color3="#F3CCCC";
		$color4="#F9E3E3";}
	else if ($color=="purple")
		{$color1="#8836B3";
		$color1_2="#8836B3";
		$color2="#D5B9E4";
		$color3="#E3CFED";
		$color4="#F0E5F5";}
	else if ($color=="brown")
		{$color1="#663D14";
		$color1_2="#663D14";
		$color2="#CABBAD";
		$color3="#DAD1C7";
		$color4="#EBE6E1";}
	else if ($color=="black")
		{$color1="#17171A";
		$color1_2="#2A62CA";
		$color2="#AEAEAF";
		$color3="#C8C8C8";
		$color4="#E1E1E1";}
	else
		{$color1="#2A62CA";
		$color1_2="#295FCC";
		$color2="#B4C7ED";
		$color3="#CCD9F3";
		$color4="#E7EDF8";}
	}
else
	{$color1="#295FCC";
	$color1_2="#295FCC";
	$color2="#B4C7ED";
	$color3="#CCD9F3";
	$color4="#E3EAF8";}

if (isset($_POST["interactive"])){
///////////////// COMMENT POINT 1 /////////////////
if ($_POST["interactive"] == "comment_point1")
	{$ids=$_POST['ids'];
	$comment_id=$_POST['comment_id'];
	$comment_type=$_POST['comment_type'];
	$mysql = mysql_query("SELECT point_array FROM ".$comment_type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$point_array = $row['point_array'];
		$pointArray = explode(",",$point_array);
		$point_array_count = count($pointArray);
		$point_array_count = $point_array_count*10;
		if($point_array==""){$point_array_count="0";}}
	$comment_type= json_encode($comment_type);
	echo "<a href='#' title='Give Points For Awesomeness!' class='point2' onclick='return false' onmousedown='javascript:comment_point2(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$point_array_count."</b>";
	exit();}
///////////////// COMMENT POINT 2 /////////////////
if ($_POST["interactive"] == "comment_point2")
	{$ids=$_POST['ids'];
	$comment_id=$_POST['comment_id'];
	$comment_type=$_POST['comment_type'];
	$comment_typex_s=substr($comment_type, 0, -1);
	if ($comment_type=="posts"){$table2="user_page_id";$create_type="profile";$create_type_total="profile";}
	else if ($comment_type=="pages_member_posts"){$table2="user_page_id";$create_type="page";$create_type_total="pages";$comment_typex_s="member_post";}
	else if ($comment_type=="groups_member_posts"){$table2="user_page_id";$create_type="group";$create_type_total="groups";$comment_typex_s="member_post";}
	else if ($comment_type=="events_member_posts"){$table2="user_page_id";$create_type="event";$create_type_total="events";$comment_typex_s="member_post";}
	else if ($comment_type=="shops_member_posts"){$table2="user_page_id";$create_type="shop";$create_type_total="shops";$comment_typex_s="member_post";}
	else{$table2="user_id";$create_type="profile";$create_type_total="profile";}
	
	$mysql = mysql_query("SELECT ".$comment_typex_s."_id AS item_id, user_post_id, point_array FROM ".$comment_type."_comments WHERE id='$comment_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_id = $row['user_post_id'];
		$item_id = $row['item_id'];
		$point_array = $row['point_array'];
		$pointArray = explode(",",$point_array);
		$point_array_count = count($pointArray);
		if($point_array==""){$point_array_count="0";}}
	$mysql = mysql_query("SELECT points FROM economy WHERE id='$ids' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_lose_points = $row['points'];}
	$mysql = mysql_query("SELECT id, points FROM economy WHERE id='$user_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_gain_points = $row['points'];}
		
	if($user_lose_points>9)
		{$user_lose_points=$user_lose_points-10;
		$user_gain_points=$user_gain_points+10;
		if (($comment_type == "images_walls")OR($comment_type == "pages_images_walls")OR($comment_type == "groups_images_walls")OR($comment_type == "events_images_walls")OR($comment_type == "shops_images_walls"))
			{$comment_type_total = "images";}
		else if (($comment_type == "pages_member_posts")OR($comment_type == "groups_member_posts")OR($comment_type == "events_member_posts")OR($comment_type == "shops_member_posts"))
			{$comment_type_total = "member_posts";}
		else {$comment_type_total = $comment_type;}
		if ($point_array != ""){$point_array = "$point_array,$ids";}
		else {$point_array = "$ids";}
		
		mysql_query("UPDATE economy SET points='$user_lose_points' WHERE id='$ids'");
		mysql_query("UPDATE economy SET points='$user_gain_points' WHERE id='$user_id'");
		mysql_query("UPDATE point_totals_comments SET ".$create_type_total."_".$comment_type_total."_plus = ".$create_type_total."_".$comment_type_total."_plus + 10 WHERE id='$user_id'");
		mysql_query("UPDATE point_totals_comments SET ".$create_type_total."_".$comment_type_total."_minus = ".$create_type_total."_".$comment_type_total."_minus + 10 WHERE id = '$ids'");
		mysql_query("UPDATE ".$comment_type."_comments SET point_array='$point_array' WHERE id='$comment_id'");
	
		if($comment_type=="link_creates"){$mysql_create_id = mysql_query("SELECT user_page_id FROM link_creates WHERE id='$item_id' LIMIT 1");}
		else{$mysql_create_id = mysql_query("SELECT ".$table2." AS user_page_id FROM ".$comment_type." WHERE id='$item_id' LIMIT 1");}
		while ($row = mysql_fetch_array ($mysql_create_id))
			{$create_id = $row['user_page_id'];}
	
		$transaction=mysql_query("SELECT transaction_date FROM point_transactions_comments WHERE minus_id='$ids' AND plus_id='$user_id' AND item_id='$comment_id' AND create_type='$create_type' AND create_id='$create_id' 
									AND transaction_type='$comment_type' AND transaction_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 24 HOUR) ORDER BY transaction_date DESC LIMIT 1");
		$numRows=mysql_num_rows($transaction);
		if($numRows>0)
			{while ($row = mysql_fetch_array ($transaction))
				{$transaction_date = $row['transaction_date'];}
			mysql_query("UPDATE point_transactions_comments SET transaction_amount = transaction_amount + 10 WHERE minus_id='$ids' AND plus_id='$user_id' AND item_id='$comment_id' 
							AND create_type='$create_type' AND transaction_type='$comment_type' AND transaction_date='$transaction_date'");}
		else {mysql_query("INSERT INTO point_transactions_comments (minus_id,plus_id,item_id,create_type,create_id,transaction_amount,transaction_type,transaction_date) 
							VALUES ('$ids','$user_id','$comment_id','$create_type','$create_id',10,'$comment_type',UTC_TIMESTAMP())");}
	
		$mysql = mysql_query("SELECT point_array FROM ".$comment_type."_comments WHERE id='$comment_id' LIMIT 1");
		while ($row = mysql_fetch_array ($mysql))
			{$point_array = $row['point_array'];
			$pointArray = explode(",",$point_array);
			$point_array_count = count($pointArray);
			$point_array_count = $point_array_count*10;
			if($point_array==""){$point_array_count="0";}}
		$comment_type= json_encode($comment_type);
		echo "<a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$point_array_count."</b>";
		}
	else
		{$point_array_count = $point_array_count*10;
		echo "<a href='#' title='Not Enough Points!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point2'>".$point_array_count."</b>";}
exit();}

///////////////// COMMENT CHANGER /////////////////
if ($_POST["interactive"] == "Comment")
	{$item_id=$_POST['item_id'];
	$comment_type=$_POST['comment_type'];
	$comment_type= json_encode($comment_type);
	echo "<div class='comment_box'><form class='comment_form' action='javascript:comment_form(".$item_id.",".$comment_type.")' method='post' type='multipart/form-data' name='comment_form'>
			<input class='comment_field' name='comment_field' id='comment_field".$item_id."' rows='1' placeholder='Comment...'/>
		</form></div>";exit();}
//////////////////// END OF CHANGERS ////////////////////

///////////////// DELETE COMMENT /////////////////
if ($_POST["interactive"] == "delete_comment1")
	{$comment_id=$_POST['comment_id'];
	$comment_type=$_POST['comment_type'];
	$comment_type= json_encode($comment_type);
	$item_id=$_POST['item_id'];
	echo "<div class='delete_comment' id='delete_comment".$comment_id."'><a href='#' title='Delete From Comments' class='delete2' onclick='return false' onmousedown='javascript:delete_comment2(".$item_id.",".$comment_id.",".$comment_type.");'></a></div>";
	exit();}
///////////////// DELETE COMMENT /////////////////
if ($_POST["interactive"] == "delete_comment2")
	{$comment_id=$_POST['comment_id'];
	$comment_type=$_POST['comment_type'];
	$item_id=$_POST['item_id'];
	$mysql=mysql_query("SELECT comment_array FROM ".$comment_type." WHERE id='$item_id' LIMIT 1");
	while ($row =mysql_fetch_array ($mysql))
		{$comment_array=$row['comment_array'];
		$commentArray = explode(",", $comment_array);}
	foreach ($commentArray as $key => $value) 
		{if ($value == $comment_id)
			{unset($commentArray[$key]);}}
	$new_string = implode(",",$commentArray);
	
	mysql_query("UPDATE ".$comment_type."_comments SET delete_comment='0' WHERE id='$comment_id'");
	echo '';
	exit();}

///////////////// EXPANDING COMMENTS /////////////////
if ($_POST["interactive"] == "expand_comments")
	{$item_id=$_POST['item_id'];
	$comment_type=$_POST['comment_type'];
	$comment_type_s=substr($comment_type, 0, -1);
	$comment_type2="$comment_type";
	$mysql3 = mysql_query("SELECT * FROM ".$comment_type."_comments WHERE ".$comment_type_s."_id='$item_id' AND delete_comment='1' ORDER BY comment_date DESC LIMIT 30");
	$comment_type= json_encode($comment_type);
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
	$comment_point_array = $row['point_array'];
	$comment_pointArray = explode(",",$comment_point_array);
	$comment_point_array_count = count($comment_pointArray);
	$comment_point_array_count = $comment_point_array_count*10;
	if($comment_point_array==""){$comment_point_array_count="0";}
	
	if (in_array($ids,$likeArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span><a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_comment !="")AND($love_array_comment !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_comment = "";}
						
	$mysql4 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id='$user_post_id_comment' LIMIT 1");
	while ($row =mysql_fetch_array ($mysql4))
		{$user_id_comment = $row['id'];
		$user_firstname_comment = $row['firstname'];
		$user_lastname_comment = $row['lastname'];}
		$user_check_pic_comment = "../user_files/user$user_id_comment/profile_thumb.jpg";
		$user_default_pic_comment = "../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($user_check_pic_comment)) 
			{$commenter_pic_comment = "<img  src=\"$user_check_pic_comment#$cacheBuster\" width=\"45px\" class=\"thumb_background\" />";} 
		else {$commenter_pic_comment = "<img src=\"$user_default_pic_comment\" width=\"45px\" class=\"thumb_background\" />";}
	
	if(($ids==$user_page_id_comment)OR($ids==$user_post_id_comment))
		{$delete_button="<div class='delete_comment' id='delete_comment_".$comment_type2."".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$item_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_".$comment_type2."".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count."</b></div>";}
	else if($comment_point_array_count=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point' onclick='return false'></a><a title='Point Array' href='#' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count."</b></a></div>";}

	$DisplayList .="<div id='comment_list_".$comment_type2."".$comment_id."'>
	<div class='comment_list'>
		<div class='comment_1'><a class='profile_link' href='http://localhost/msm/profile/profile.php?id=".$user_id_comment."'>".$commenter_pic_comment."</a></div>
		<div class='comment_2'>
			<div class='comment_top_options'>".$comment_point."".$delete_button."</div>
			<a class='profile_link' href='http://localhost/msm/profile/profile.php?id=".$user_id_comment."'>".$user_firstname_comment." ".$user_lastname_comment."</a> 
			<span class='comment'>".$the_comment."</span>
			<div class='like_love' id='like_love_comment_".$comment_type2."".$comment_id."'>".$like_love_comment."<span class='dot_divider'> &middot;</span>
			<span class='post_date'> ".$comment_date."</span>
			".$like_love2_comment."</div>
		</div>
	</div></div>";}
echo $DisplayList;exit();}
///////////////// EXPANDING COMMENTS END /////////////////
}

///////////////// COMMENTING /////////////////
if(isset($_POST['the_comment']))
	{$item_id=$_POST['item_id'];
	$comment_type=$_POST['comment_type'];
	$comment_type_s=substr($comment_type, 0, -1);
	$comment_type_c = ucfirst($comment_type_s);
	if(($comment_type=="pages_member_posts")OR($comment_type=="groups_member_posts")OR($comment_type=="events_member_posts")OR($comment_type=="shops_member_posts"))
		{$comment_type_s="member_post";}
	$id=$_POST['id'];
	$ids=$_POST['ids'];
	$comment=$_POST['the_comment'];
	$comment = stripslashes($comment);
	$comment = strip_tags($comment);
	$comment = mysql_real_escape_string($comment);
	if ($comment_type=="posts") {$user_id_type="user_post_id";}
	else {$user_id_type="user_id";}
	$mysql_comment_array = mysql_query("SELECT ".$user_id_type." AS user_id, comment_array FROM ".$comment_type." WHERE id='$item_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_comment_array))
		{$user_id = $row['user_id'];
		$comment_array = $row['comment_array'];}
// Insert into database.
	$mysql1 = mysql_query("INSERT INTO ".$comment_type."_comments (".$comment_type_s."_id,user_page_id, user_post_id, the_comment, comment_date) VALUES ('$item_id','$id', '$ids', '$comment', UTC_TIMESTAMP())") or die (mysql_error());
	$comment_id=mysql_insert_id();
	if ($comment_array != "")
		{$comment_array_new = "$comment_array,$comment_id";}
	else {$comment_array_new = "$comment_id";}
	$mysql2 = mysql_query("UPDATE ".$comment_type." SET comment_array = '$comment_array_new' WHERE id='$item_id'") or die (mysql_error());
	
// Refresh the comments.
	$comment_type2="$comment_type";
	$mysql3 = mysql_query("SELECT * FROM ".$comment_type."_comments WHERE ".$comment_type_s."_id='$item_id' AND delete_comment='1' ORDER BY comment_date DESC LIMIT 3");
	$comment_type= json_encode($comment_type);
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
	$comment_point_array = $row['point_array'];
	$comment_pointArray = explode(",",$comment_point_array);
	$comment_point_array_count = count($comment_pointArray);
	$comment_point_array_count = $comment_point_array_count*10;
	if($comment_point_array==""){$comment_point_array_count="0";}
	
	if (in_array($ids,$likeArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_comment))
		{$like_love_comment = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_comment(".$id.",".$ids.", ".$comment_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_comment ="<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_comment !="")AND($love_array_comment !=""))
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' class='love_count'/>";}
	else if ($like_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$like_array_count_comment."</a> <img src='blank.gif' class='like_count'/>";}
	else if ($love_array_comment !="")
		{$like_love2_comment = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'>".$love_array_count_comment."</a> <img src='blank.gif' class='love_count'/>";}
	else
		{$like_love2_comment = "";}
						
	$mysql4 = mysql_query("SELECT id, firstname, lastname FROM members WHERE id='$user_post_id_comment' LIMIT 1");
	while ($row =mysql_fetch_array ($mysql4))
		{$user_id_comment = $row['id'];
		$user_firstname_comment = $row['firstname'];
		$user_lastname_comment = $row['lastname'];}
		$user_check_pic_comment = "../user_files/user$user_id_comment/profile_thumb.jpg";
		$user_default_pic_comment = "../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($user_check_pic_comment)) 
			{$commenter_pic_comment = "<img  src=\"$user_check_pic_comment#$cacheBuster\" width=\"45px\" class=\"thumb_background\" />";} 
		else {$commenter_pic_comment = "<img src=\"$user_default_pic_comment\" width=\"45px\" class=\"thumb_background\" />";}
	
	if(($ids==$user_page_id_comment)OR($ids==$user_post_id_comment))
		{$delete_button="<div class='delete_comment' id='delete_comment_".$comment_type2."".$comment_id."'><a href='#' title='Delete From Comments' class='delete1' onclick='return false' onmousedown='javascript:delete_comment1(".$item_id.",".$comment_id.",".$comment_type.");'></a></div>";}
	else{$delete_button="";}
	if($ids!==$user_post_id_comment){$comment_point="<div class='option_box2' id='comment_point_".$comment_type2."".$comment_id."'><a href='#' title='Give Points For Awesomeness!' class='point' onclick='return false' onmousedown='javascript:comment_point1(".$ids.",".$comment_id.",".$comment_type.");'></a><b class='point'>".$comment_point_array_count."</b></div>";}
	else if($comment_point_array_count=="0"){$comment_point="";}
	else{$comment_point="<div title='Point Array' class='option_box2'><a href='#' class='point' onclick='return false'></a><a title='Point Array' href='#' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array_comment(".$id.",".$ids.",".$comment_id.",".$comment_type.");'><b class='point3'>".$comment_point_array_count."</b></a></div>";}

	$DisplayList .="<div id='comment_list_".$comment_type2."".$comment_id."'>
	<div class='comment_list'>
		<div class='comment_1'><a class='profile_link' href='http://localhost/msm/profile/profile.php?id=".$user_id_comment."'>".$commenter_pic_comment."</a></div>
		<div class='comment_2'>
			<div class='comment_top_options'>".$comment_point."".$delete_button."</div>
			<a class='profile_link' href='http://localhost/msm/profile/profile.php?id=".$user_id_comment."'>".$user_firstname_comment." ".$user_lastname_comment."</a> 
			<span class='comment'>".$the_comment."</span>
			<div class='like_love' id='like_love_comment_".$comment_type2."".$comment_id."'>".$like_love_comment."<span class='dot_divider'> &middot;</span>
			<span class='post_date'> ".$comment_date."</span>
			".$like_love2_comment."</div>
		</div>
	</div></div>";}
echo $DisplayList;

// Email Content
	if ($user_id!==$ids)
		{$mysql = mysql_query("SELECT firstname, lastname, email, email_comment_notification_activation FROM members WHERE id='$user_id'");
		while($row = mysql_fetch_array($mysql))
			{$firstname_email = $row['firstname'];
			$lastname_email = $row['lastname'];
			$email = $row['email'];
			$email_comment_notification_activation = $row['email_comment_notification_activation'];}
		$mysql2 = mysql_query("SELECT firstname, lastname FROM members WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
	if ($email_comment_notification_activation=="1")
			{$subject = "New Comment From ".$firstname." ".$lastname." [".date("F jS, Y | H:i:s")."]";
			$headers = 'From: Barterrain <comment@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <comment@barterrain.com>' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$email_check_pic = "../user_files/user".$ids."/profile_thumb.jpg";
			$email_default_pic = "http://www.barterrain.com/user_files/user0/default_profile_pic_thumb.png";
			if (file_exists($email_check_pic)) 
				{$email_pic = "<img src='http://www.barterrain.com/user_files/user".$ids."/profile_thumb.jpg' width='75px' height='75px' style='background-color:".$color2.";'/>";} 
			else {$email_pic = "<img src='$email_default_pic' width='75px' height='75px' style='background-color:".$color2.";'/>";}
	
			$message = "<html>
						<head>
    						<title>".$subject."</title>
						</head>";
			$message .= "<body style='z-index:20;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;'>
							<div style='z-index:20;text-align:center;position:relative;height:45px;width:100%;margin:0px;padding:0px;background-color:".$color1.";float:left;'>
							<table style='z-index:20;text-align:center;position:relative;height:45px;width:150px;margin:0px;padding:0px;margin:auto;vertical-align:top;' align='center'><tr><td>
   		 					<a href='http://www.barterrain.com/' style='text-decoration:none;height:40px;width:150px;margin:0px;padding:0px;' title='Baterrain'>
								<img src=\"http://www.barterrain.com/barterrain_email_images/main_title.png\" style='margin:auto;max-height:40px;width:150px;background:url(\"http://www.barterrain.com/barterrain_email_images/main_title.png\") no-repeat 0 0;' onMouseDown='if (event.preventDefault) event.preventDefault()'/>
							</a>
							</td></tr></table></div>
						</body>";
			$message .= "<body style='z-index:10;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;float:left;'>
						<div style='z-index:10;text-align:center;position:relative;height:auto;width:100%;margin:0px;padding:0px;background-color:".$color4.";float:left;'>
						<table style='margin:auto;border:0px;border-spacing:0px;text-align:justify;text-align-last:justify;padding-top:23px;padding-bottom:23px;' cellspacing='0' cellpadding='0' align='center'>
							<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_right.png\"></td>
							</tr>
        	   				<tr style='position:relative;'>
							 	<td style='width:15px;background-color:#FFFFFF;'></td>
								<td style='width:580px;height:50px;background-color:#FFFFFF;vertical-align:top;'>
								<table><tr>
            						<td style='text-align:left;float:left;vertical-align:top;'><a href=\"http://www.barterrain.com/profile/profile.php?id=".$ids."\">".$email_pic."</a></td>
									<td style='text-align:left;width:450px;float:left;vertical-align:top;padding-left:15px;'>
										<a href=\"http://www.barterrain.com/profile/profile.php?id=".$ids."\" style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>
											".$firstname." ".$lastname."</a>
										<br/><font style='font:16px helvetica, sans-serif;margin:0px;padding:0px;'> New Comment: <i>\"".$comment."\"</i></font>
									</td>
								</tr></table>
            					</td>
								<td style='width:15px;background-color:#FFFFFF;'></td>
							</tr>
            				<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_right.png\"></td>			
							</tr>
							<tr><td></td><td style='padding-top:23px;'>
								<div style='z-index:10;text-align:center;position:relative;' align='center'>
								<font style='color:#000000'>
									Forgot your Barterrain password? 
									<a href=\"http://www.barterrain.com?forgot_password=true\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to get a temporary password.
									<br/>Want to unsubscribe from these notification emails? 
									<a href=\"http://www.barterrain.com/settings/settings.php?settings=notification\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to change notification settings.
								 	<br/>Received this email in error? Did you not sign up for Barterrain? 
									Contact <a href=\"mailto:error@barterrain.com\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>error@barterrain.com</a>!
								</font>
								</div>
							</td><td></td></tr>
        				</table>
						</div></body>
						</html>";
		
			mail($email,$subject,$message,$headers,'-fcomment@barterrain.com');
			}
		}
exit();}
///////////////// COMMENTING END /////////////////
?>