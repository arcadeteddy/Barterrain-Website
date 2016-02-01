<?php
ob_start();
include_once "../config.php";
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";
ob_flush();

$mysql1 = mysql_query("SELECT * FROM members WHERE id=$ids");
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
	
$FF_title="";
if (($friend_array!="")AND($family_array!=""))
	{$FF_title='Family & Friends';}
else if ($friend_array!="")
	{$FF_title='Friends';}
else if ($family_array!="")
	{$FF_title='Family';}
else
	{$FF_title='Friends';}
?>

<head>
<script type="text/javascript">
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var thisRandNum = "<?php echo $thisRandNum; ?>";
var interactiveBox = "../scripts/interactive_box.php";
function invite_friends_form()
	{var invite_message = $('#invite_message').val();
	var invite_email1 = $('#invite_email1').val();
	var invite_email2 = $('#invite_email2').val();
	var invite_email3 = $('#invite_email3').val();
	var invite_email4 = $('#invite_email4').val();
	var invite_email5 = $('#invite_email5').val();
	$.post(interactiveBox,{invite_friends:"invite_friends",id:id,ids:ids,invite_message:invite_message,invite_email1:invite_email1,invite_email2:invite_email2,invite_email3:invite_email3,invite_email4:invite_email4,invite_email5:invite_email5,thisWipit:thisRandNum},function(data) 
		{$("#float_right").html(data).show();
		document.invite_friends_form.invite_email1.value='';
		document.invite_friends_form.invite_email2.value='';
		document.invite_friends_form.invite_email3.value='';
		document.invite_friends_form.invite_email4.value='';
		document.invite_friends_form.invite_email5.value='';});}
</script>
</head>

<body>
<div class="margin"></div>
<div class="friends_sub_body">
    <div class="invite_friends">
    	<div class='bar_wrap'>
    	<div class='body_bars'>
			<div class='float_left'><img src='barterrain_friends_images/blank.gif' class='invite_friends_bar'/><span class='heading_list'>Invite Friends</span></div>
			<div class='float_right' id='float_right'></div>
		</div>
        </div>
        <form action="javascript:invite_friends_form()" method="post" enctype="multipart/form-data" name="invite_friends_form">
        <div class="invite_left">
        	<textarea class="invite_message" type="text" name="invite_message" id="invite_message" placeholder="Enter A Message..." value=""></textarea>
        </div>
        <div class="invite_right">
        	<input class="invite_email1" name="invite_email1" id="invite_email1" type="text" placeholder="Enter An Email..." maxlength="88"/>
            <input class="invite_email" name="invite_email2" id="invite_email2" type="text" placeholder="Enter An Email..." maxlength="88"/>
            <input class="invite_email" name="invite_email3" id="invite_email3" type="text" placeholder="Enter An Email..." maxlength="88"/>
            <input class="invite_email" name="invite_email4" id="invite_email4" type="text" placeholder="Enter An Email..." maxlength="88"/>
            <input class="invite_email" name="invite_email5" id="invite_email5" type="text" placeholder="Enter An Email..." maxlength="88"/>
            <input src='barterrain_friends_images/blank.gif' type="image" name="invite" class="invite_button"/>
        </div>
        </form>
    </div>
	<div id="invited_friends_list"><?php include_once "invited_friends_list.php"; ?></div>
</div>
</body>