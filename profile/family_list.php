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

$mysql1 = mysql_query("SELECT family_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql1))
	{$family_array = $row['family_array'];
	$familyArray = explode(",",$family_array);
	$family_count = count($familyArray);
	$total_count = $family_count;}
	
$FamilyDisplayList = "";
if ($family_array!="")
	{// Display Friends List
	$total="Family (".$family_count.")";
	$FFArray = explode(",",$family_array);
	
	// Pagination
	$list_family="";
	$items_per_page=4;
	$pages_family=ceil($total_count/$items_per_page);
	$page_family=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_family-1) * $items_per_page;
	$FFArray8 = array_slice($FFArray,$start,$items_per_page);
	
	if($pages_family>1)
		{for($x=1;$x<=$pages_family;$x++)
			{if(($x==$page_family)AND($x==$pages_family)){$list_family.="<b>$x</b>";}
			else if($x==$page_family){$list_family.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_family){$list_family.="<a href='#' onclick='return false' onmousedown='javascript:family_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_family.="<a href='#' onclick='return false' onmousedown='javascript:family_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$FamilyDisplayList .= "<div class='middle_bars'>
						<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='family_lists'/><span class='heading_list'>".$total."</span></div>
					<div class='float_right'>".$list_family."</div></div>";
	$i = 0;
	$FamilyDisplayList .="<div class='under_middle_friends'>";
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
			{$add_friend = "";$remove = "<span class='dot_divider'> &middot; </span><a href='#' onclick='return false' onmousedown='javascript:removeAsFriend_family(".$ids.",".$friend_id.");' class='post_link'>Remove</a>";}
			
		$FamilyDisplayList .="<div class='friends_box3'>
						<div class='middle_wrap_1'><a href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'>".$user_pic_friend_bar."</a></div>
						<div class='middle_wrap_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$friend_id."'><b>".$friend_firstname." ".$friend_lastname."</b></a>
							<br/><span class='places'>".$friend_location."</span>
							".$add_friend."<a href='../messages/messages.php?message_id=".$friend_id."' class='post_link'>Message</a>".$remove."</div></div>";
		}
		$FamilyDisplayList .="</div><br/>";
	}
echo $FamilyDisplayList;
?>
<script type="text/javascript">
var thisRandNum = "<?php echo $thisRandNum; ?>";
var friendRequestURL = "../scripts/request_as_friend.php";
function addAsFriend2(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship2",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#request"+b).html(data).show()});	
	}
// friends Pagination
function family_list(a,b,c)
	{$.post("family_list.php?page="+a,{x:a,id:b,ids:c,cacheBuster:cacheBuster},function(data) 
		{$("#family_list").html(data).show()});	
	}
</script>