<?php
ob_start();
include_once "../config.php";

if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];}
if(isset($_POST['cacheBuster']))
	{$cacheBuster=$_POST['cacheBuster'];}

if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();

$mysql1 = mysql_query("SELECT friend_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql1))
	{$friend_array = $row['friend_array'];
	$friendArray = explode(",",$friend_array);
	$friend_count = count($friendArray);
	$total_count = $friend_count;}

$FFDisplayList = "";
if ($total_count==1)
	{$total="Friend (".$friend_count.")";}
else
	{$total="Friends (".$friend_count.")";}
if ($friend_array!="")
	{// Display Friends List
	$FFArray = explode(",",$friend_array);
	
	// Pagination
	$list_friends="";
	$items_per_page=38;
	$pages_friends=ceil($total_count/$items_per_page);
	$page_friends=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_friends-1) * $items_per_page;
	$FFArray8 = array_slice($FFArray,$start,$items_per_page);
	
	if($pages_friends>1)
		{for($x=1;$x<=$pages_friends;$x++)
			{if(($x==$page_friends)AND($x==$pages_friends)){$list_friends.="<b>$x</b>";}
			else if($x==$page_friends){$list_friends.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_friends){$list_friends.="<a href='#' onclick='return false' onmousedown='javascript:friends_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_friends.="<a href='#' onclick='return false' onmousedown='javascript:friends_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$FFDisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='friends_lists'/><span class='heading_list'>".$total."</span></div>
					<div class='float_right'>".$list_friends."</div></div>";
	$i = 0;
	$FFDisplayList .="<div class='under_middle_friends'>";
	foreach ($FFArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<a href='profile.php?id=$value'><img src='$check_pic_friend_bar#$cacheBuster' height='60px' class='thumb_background'/></a>";}
		else
			{$user_pic_friend_bar="<a href='profile.php?id=$value'><img src='$default_pic_friend_bar' height='60px' class='thumb_background'/></a>";}
		
		$mysql_name=mysql_query("SELECT id,firstname, lastname, location, friend_array, family_array, block_array FROM members WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_name))
			{$friend_id = $row['id'];
			$friend_firstname = $row['firstname'];
			$friend_lastname = $row['lastname'];
			$friend_location = $row['location'];
			$friend_array2 = $row['friend_array'];
			$friendArray2 = explode(",",$friend_array2);
			$family_array2 = $row['family_array'];
			$familyArray2 = explode(",",$family_array2);
			$block_array2 = $row['block_array'];
			$blockArray2 = explode(",",$block_array2);
		if ((in_array($ids,$friendArray2))OR(in_array($ids,$familyArray2))OR($ids==$friend_id))
			{$add_friend = "";}
		else 
			{$add_friend = "<span id='request".$friend_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$friend_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}}
		$remove="";
		if ($ids==$id)
			{$add_friend = "";$remove = "<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:removeAsFriend_friends(".$ids.",".$friend_id.");' class='post_link'>Remove</a>";}
		
		$FFDisplayList .="<div class='friends_box3'>
						<div class='middle_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='middle_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a>".$remove."</div></div>";
		}
		$FFDisplayList .="</div><br/>";
	}
echo $FFDisplayList;
?>
<script type="text/javascript">
var thisRandNum = "<?php echo $thisRandNum; ?>";
var friendRequestURL = "../scripts/request_as_friend.php";
function addAsFriend2(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship2",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#request"+b).html(data).show()});	
	}
// friends Pagination
function friends_list(a,b,c)
	{$.post("friends_list.php?page="+a,{x:a,id:b,ids:c,cacheBuster:cacheBuster},function(data) 
		{$("#friends_list").html(data).show()});	
	}
</script>