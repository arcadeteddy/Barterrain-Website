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

$mysql1 = mysql_query("SELECT creator_array,admin_array FROM planets WHERE id=$id");
while($row = mysql_fetch_array($mysql1))
	{$creator_array = $row['creator_array'];
	$creatorArray = explode(",",$creator_array);
	$admin_array = $row['admin_array'];
	$adminArray = explode(",",$admin_array);
	$admin_count = count($adminArray);
	$total_count = $admin_count;}
	
	$type_o="planets";
	$type=json_encode($type_o);
	
$adminDisplayList = "";
if ($admin_array!="")
	{// Display Friends List
	if ($total_count==1) {$total="Admin (".$admin_count.")";}
	else  {$total="Admins (".$admin_count.")";}
	$FFArray = explode(",",$admin_array);
	
	// Pagination
	$list_admin="";
	$items_per_page=4;
	$pages_admin=ceil($total_count/$items_per_page);
	$page_admin=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_admin-1) * $items_per_page;
	$FFArray8 = array_slice($FFArray,$start,$items_per_page);
	
	if($pages_admin>1)
		{for($x=1;$x<=$pages_admin;$x++)
			{if(($x==$page_admin)AND($x==$pages_admin)){$list_admin.="<b>$x</b>";}
			else if($x==$page_admin){$list_admin.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_admin){$list_admin.="<a href='#' onclick='return false' onmousedown='javascript:admin_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_admin.="<a href='#' onclick='return false' onmousedown='javascript:admin_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$adminDisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='family_lists'/><span class='heading_list'>".$total."</span></div>
					<div class='float_right'>".$list_admin."</div></div>";
	$i = 0;
	$adminDisplayList .="<div class='under_middle_friends'>";
	foreach ($FFArray8 as $key => $value)
		{$i++;
		$check_pic_friend_bar="../user_files/user$value/profile_thumb.jpg";
		$default_pic_friend_bar="../user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($check_pic_friend_bar))
			{$user_pic_friend_bar="<img src='$check_pic_friend_bar#$cacheBuster' height='60px' class='thumb_background'/>";}
		else
			{$user_pic_friend_bar="<img src='$default_pic_friend_bar' height='60px' class='thumb_background'/>";}
		
		$mysql_name=mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$value' LIMIT 1");
		$row=mysql_fetch_assoc($mysql_name);
			{$alias=$row['alias'];
			$alias_activation=$row['alias_activation'];}
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
		if ((in_array($ids,$creatorArray))AND($ids!==$friend_id))
			{$remove = "<a href='#' onclick='return false' onmousedown='javascript:LeaveAdmin2(".$friend_id.",".$id.",".$type.");' class='post_link'>Remove</a>";}
		
		if ($alias_activation=="1") 
			{$user_pic_member_bar="<a href='#' onclick='return false'>".$user_pic_friend_bar."</a>";
			$profile_link_member_bar="<a class='alias_link' href='#' onclick='return false'><b>".$alias."</b></a>";}
		else if ($alias_activation=="0") 
			{$user_pic_member_bar="<a href='../profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a>";
			$profile_link_member_bar="<a class='profile_link' href='../profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>";}
		
		$adminDisplayList .="<div class='friends_box3'>
						<div class='middle_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='middle_wrap_2'>".$profile_link_member_bar."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$remove."</div></div>";
		}
		$adminDisplayList .="</div><br/>";
	}
echo $adminDisplayList;
?>
<script type="text/javascript">
var thisRandNum = "<?php echo $thisRandNum; ?>";
var friendRequestURL = "../scripts/request_as_friend.php";
function addAsFriend2(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship2",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#request"+b).html(data).show()});	
	}
// friends Pagination
function admin_list(a,b,c)
	{$.post("planet_admins_list.php?page="+a,{x:a,id:b,ids:c,cacheBuster:cacheBuster},function(data) 
		{$("#admins_list").html(data).show()});	
	}
</script>