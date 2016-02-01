<?php
ob_start();
include_once "../config.php";
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];}
else {$id = $_SESSION['ids'];
	$ids = $_SESSION['ids'];}

include_once "../scripts/check_login.php";
ob_flush();

$RequestsHead="";
$RequestsList="";
$RequestsFoot="";
$add_friend="";

$mysql1 = mysql_query("SELECT * FROM members WHERE id='$ids'");
while($row = mysql_fetch_array($mysql1))
	{$id = $row['id'];
	$firstname = $row['firstname'];
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
<div class="friends_sub_body">
	<div id="friends_list"><?php include_once "friends_list.php"; ?></div>
</div>
</body>