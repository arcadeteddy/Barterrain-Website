<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";
ob_flush();

$mysql_profile = mysql_query("SELECT friend_array, family_array FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql_profile))
	{$friend_array = $row['friend_array'];
	$friendArray = explode(",",$friend_array);
	$friend_count = count($friendArray);
	$family_array = $row['family_array'];
	$familyArray = explode(",",$family_array);
	$family_count = count($familyArray);
	$total_count = $friend_count + $family_count;
	if(($friend_array!=="")AND($family_array!==""))
		{$FF_array=$friend_array.",".$family_array;}
	else if($family_array!==""){$FF_array=$family_array;}
	else if($friend_array!==""){$FF_array=$friend_array;}
	else {$FF_array="";}
	$FFArray = explode(",",$FF_array);}
$FF_banner="Friends";
if ($family_array!="")
	{$FF_banner="Family & Friends";}
	
// Requests
$RequestsList="";
if(isset($_SESSION['ids'])&&$_SESSION['ids']!=$ids)
	{$RequestsList="";}
else if(isset($_SESSION['ids'])&&$_SESSION['ids']==$ids)
	{$mysql=mysql_query("SELECT * FROM friend_requests WHERE request_id = '$ids' AND request_status = '0' ORDER BY id DESC LIMIT 20") or die ("Sorry, we have a system error!");
	$numRows=mysql_num_rows($mysql);
	if ($numRows < 1)
		{$RequestsList="";}
	else
		{$RequestsList .="<div class='bar_wrap'><div class='body_bars'><img src='barterrain_friends_images/blank.gif' class='friend_requests_bar'/><span class='heading_list'>Friend Requests (".$numRows.")</span></div></div>";
	while ($row=mysql_fetch_array($mysql))
		{$requestID = $row['id'];
		$user_id = $row['user_id'];
		$mysql_name = mysql_query("SELECT id, firstname, lastname, location, primary_school, secondary_school, post_secondary, friend_array, family_array FROM members WHERE id='$user_id' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql_name))
			{$requester_id=$row['id'];
			$requester_firstname=$row['firstname'];
			$requester_lastname=$row['lastname'];
			$requester_location=$row['location'];
			$requester_secondary_school=$row['secondary_school'];
			$requester_post_secondary=$row['post_secondary'];
			$requester_friend_array=$row['friend_array'];
			$requester_family_array=$row['family_array'];
			$check_pic="../user_files/user$user_id/profile_thumb.jpg";
			$default_pic="../user_files/user0/default_profile_pic_thumb.png";
			$cacheBuster = rand(9999999,99999999999);
			if (file_exists($check_pic))
				{$user_pic="<a href='../profile/profile.php?id=$user_id'><img src='$check_pic?$cacheBuster' width='75px' class='thumb_background'/></a>";}
			else{$user_pic="<a href='../profile/profile.php?id=$user_id'><img src='$default_pic' width='75px' class='thumb_background'/></a>";}
			
			if($requester_post_secondary!=""){$place=$requester_post_secondary;}
			else if($requester_secondary_school!=""){$place=$requester_secondary_school;}
			else if($requester_location!=""){$place=$requester_location;}
			else {$place="";}
			if(($requester_friend_array!=="")AND($requester_family_array!==""))
				{$FF_requester_array=$requester_friend_array.",".$requester_family_array;}
			else if($requester_family_array!==""){$FF_requester_array=$requester_family_array;}
			else if($requester_friend_array!==""){$FF_requester_array=$requester_friend_array;}
			else {$FF_requester_array="";}
			$FFrequesterArray = explode(",",$FF_requester_array);
			$FFrequesterArray = array_intersect($FFrequesterArray, $FFArray);
			$FFpersonArray_json_encode = json_encode($FFrequesterArray);
			$FFArray_count=count($FFrequesterArray);
			if ($FFrequesterArray!=1) {$mf_s="Friends";}
			else {$mf_s="Friend";}
			
		if (empty($FFrequesterArray)) {$FFArray_count="0";}
		else {$FFArray_count="<a title='Display Mutual Friends' href='#' onclick='return false' onmousedown='javascript:display_mutual_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.");' class='bold display_button'>".$FFArray_count."</a>";}
			
			$RequestsList .= "<div class='friend_wrap3'><div class='friend_request_1'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'>".$user_pic."</a></div>
				<div class='friend_request_2'>
					<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id."'><b>".$requester_firstname." ".$requester_lastname."</b></a><br/>
					<span class='places'>".$place."</span>
					<span>You Both Have ".$FFArray_count." Mutual ".$mf_s."</span><br/>
					<span id='request".$requestID."'>
						<a href='#' class='bar_link' onclick='return false' onmousedown='javascript:acceptFriendRequest(".$requestID.");' >Accept</a><span class='dot_divider'> &middot;</span>
						<a href='#' class='bar_link' onclick='return false' onmousedown='javascript:rejectFriendRequest(".$requestID.");' >Reject</a>
					</span><span class='dot_divider'> &middot; </span>
						<a href='../messages/messages.php?message_id=".$requester_id."' class='bar_link'>Message</a>
				</div></div>";
			}
		}
		$RequestsList .="<br/><br/>";}
	}
?>

<head>
<script type="text/javascript">
// LightBox
$(document).ready(function() 
	{$(".display_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#display_button").toggle();
		$(".body").addClass("darken");});
		$("fieldset#display_button").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.display_button").length==0)
				{$(".body").removeClass("darken");
				$("fieldset#display_button").hide();}
            });            
	});
</script>
<head>

<body>
<div class="margin"></div>
<div class="friends_sub_body" id="friends_sub_body">
	<div class="bottom_find_friends">
    	<?php echo $RequestsList;?>
        <div id="bottom_find_friends">
			<?php include "find_friends_content.php"; ?>
        </div>
	</div>
	<div id="bottom_box">
		<div class="expand_bottom_find_friends" id="expand_bottom_find_friends">
			<center><span class="expand_bottom_find_friends">&#9660;</span></center>
		</div>
		<div class="expand_bottom_find_friends" id="load_content_scroll" style="display:none;">
			<center><img class="loader" src="barterrain_friends_images/loader_light_<?php echo $color;?>.gif"></center>
		</div>
	</div>
</div>
</body>