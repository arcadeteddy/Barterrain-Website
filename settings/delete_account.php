<?php
header("Content-Type: text/html; charset=utf-8");

ob_start();
session_start();
include_once "../config.php";

if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
$error_message = "";
$success_message = "";

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";
ob_flush();

$mysql = mysql_query("SELECT firstname,lastname FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql))
	{$firstname = $row["firstname"];
	$lastname = $row["lastname"];}
?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<title>Delete Account - <?php echo "$firstname $lastname"; ?></title>
<link rel="stylesheet" href="http://www.barterrain.com/barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_settings.php" media="screen">
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript" async></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript" async></script>   
<script type="text/javascript" async>
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var color = "<?php echo $color; ?>";
var InteractiveSetting = "../settings/setting_forms.php";

function checkUncheck1(CheckImg,CheckInput) 
	{var CheckImg = document.getElementById(CheckImg);
	var CheckInput = document.getElementById(CheckInput);
	CheckInput.checked = !CheckInput.checked;
	if (CheckInput.checked)
		{$(".switch1").addClass("switch_checked1");
		$(".switch_checked1").removeClass("switch1");}
	else
		{$(".switch_checked1").addClass("switch1");
			$(".switch1").removeClass("switch_checked1");}
	}
	
function checkUncheck2(CheckImg,CheckInput) 
	{var CheckImg = document.getElementById(CheckImg);
	var CheckInput = document.getElementById(CheckInput);
	CheckInput.checked = !CheckInput.checked;
	if (CheckInput.checked)
		{$(".switch2").addClass("switch_checked2");
		$(".switch_checked2").removeClass("switch2");}
	else
		{$(".switch_checked2").addClass("switch2");
			$(".switch2").removeClass("switch_checked2");}
	}
	
$('#delete_account_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function delete_account_form()
	{var check_input = document.getElementById("check_input").checked;
	var check_input2 = document.getElementById("check_input2").checked;
	var password_delete_account = $('#password_delete_account');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{action:"delete_countdown",id:id,ids:ids,check_input:check_input,check_input2:check_input2,password_delete_account:password_delete_account.val()},function(data)
		{$('#status').html(data).show();
		$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
</script>
</head>

<?php include_once "../inside_banner.php"; ?>

<div class="full_page_loader full_page_loader_hidden"><div class="full_page_loader_background"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="lightbox_body"><fieldset id="display_button"><div id="display_div"><img class="full_page_loader_array full_page_loader_array_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<div class="lightbox_image_body"><fieldset id="display_image_button"><div id="display_image_div"><img class="full_page_loader_image full_page_loader_image_hidden" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/>
</div></fieldset></div>

<body style="overflow-y:scroll;">
<font>
<div class="side_colors_left"></div>

<div class="body"></div>
<div class="delete_page_body_cover">
<div class="margin"></div>
<div class="delete_page_body">
	<form action="javascript:delete_account_form()" method="post" enctype="multipart/form-data" name="delete_account_form" id="delete_account_form">
		<div class="delete_left">	
			<div class="delete_left1">
			   <img src="blank.gif" width="1px" height="1px" class="switch1" name="check_img" id="check_img" onclick="checkUncheck1(this.id,'check_input');" onmousedown="if (event.preventDefault) event.preventDefault()"/>
        		<input name="check" type="checkbox" style="display:none;" id="check_input" class="check_input"/>
			   <img src="blank.gif" width="1px" height="1px" class="switch2" name="check_img2" id="check_img2" onclick="checkUncheck2(this.id,'check_input2')" onmousedown="if (event.preventDefault) event.preventDefault()"/>
        		<input name="check2" type="checkbox" style="display:none;" id="check_input2" class="check_input2"/>
			</div>
			<div class="delete_left2">
				<span class="launch_span">Launch Codes | Password </span>
				<input class="password_delete_account" name="password_delete_account" type="password" id="password_delete_account"/>
			</div>
			<span class="status" id="status">[Awaiting Your Decision]</span>
		</div>
		<div class="delete_middle">
			<img src="blank.gif" width="1px" height="1px" class="delete_account_button" onmousedown="if (event.preventDefault) event.preventDefault()"/>
			<input src="blank.gif" width="1px" height="1px" type="image" class="delete_account_button" name="delete_account_button" id="delete_account_button"/>
		</div>
		<div class="delete_right">
			<span class="launch_span">Self-Destruction</span><br/><span>
			By clicking the big red button to delete your account, you have agreed to the self-destruction terms:<br/><br/>
			1) All profile and planet data will be deleted from Barterrain's databases.<br/><br/>
			2) All uploaded files will be deleted within a week of self-destruction. Please save a copy before going through with self-destruction.<br/><br/>
			3) Posts that your family and friends made on your profile will remain undeleted on their profile.<br/><br/>
			4) Do you agree that you've agreed to this agreement. Agreed? <br/>If not, <a href="../index.php" class="body">click here</a>!</span>        
		</div>
	</form>
</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>