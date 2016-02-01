<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = $_SESSION['cacheBuster'];

include_once "../scripts/check_login.php";

$RequestsHead="";
$RequestsList="";
$RequestsFoot="";
$add_friend="";
$mysql1 = mysql_query("SELECT * FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql1))
	{$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
	$friend_array = $row['friend_array'];
	$friendArray = explode(",",$friend_array);
	$friend_count = count($friendArray);
	$family_array = $row['family_array'];
	$familyArray = explode(",",$family_array);
	$family_count = count($familyArray);
	$total_count = $friend_count + $family_count;
	$FF_array=$friend_array.",".$family_array;
	$FFArray = explode(",",$FF_array);}
	
$FF_side="Friends";
if ($family_array!="")
	{$FF_side="Family & Friends";}
	
if(($friend_array!=="")OR($family_array!=="")){$content="<div class='middle_bars'><div class='float_left'><img src='blank.gif' width='1px' height='1px' class='friends_activity_lists'/><span class='heading_list'>Their Activity</span></div><div class='float_right'></div></div>";}
else{$content="";}

ob_flush();
?>

<script src="profile.js" type="text/javascript" async></script>
<script type="text/javascript">
var thisRandNum = "<?php echo $thisRandNum; ?>";
var friendRequestURL = "../scripts/request_as_friend.php";
function acceptFriendRequest (x) 
	{$.post(friendRequestURL,{request:"acceptFriend",requestID:x,thisWipit:thisRandNum},function(data)
		{$("#request"+x).html(data).show();});
	}
function rejectFriendRequest (x) 
	{$.post(friendRequestURL,{request:"rejectFriend",requestID:x,thisWipit:thisRandNum} ,function(data) 
		{$("#request"+x).html(data).show();});
	} 
</script>

<body>
<font>
<div class="friends_body">
<div id="family_list">
<?php // Family
include_once "family_list.php";
?>
</div>
<div id="friends_list">
<?php // Friends
include_once "friends_list.php";
?>
</div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_friends">
	<?php echo $content;
	include "friends_content.php"; ?>
</div>
<div class="bottom_box" id="bottom_box">
	<div class="expand_bottom_wall" id="expand_bottom_box">
		<center><span class="expand_bottom_box">&#9660;</span></center>
	</div>
	<div class="expand_bottom_wall" id="load_content_scroll" style="display:none;">
		<center><img class="loader" src="barterrain_profile_images/loader_light_<?php echo $color;?>.gif" width="220px" height="19px"></center>
	</div>
</div>
</div>

</font>
</body>