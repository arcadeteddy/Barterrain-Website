<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

include_once "../scripts/check_login.php";

$DisplayList="";
$private_public="";
$cacheBuster = $_SESSION['cacheBuster'];

$mysql = mysql_query("SELECT * FROM planets WHERE id='$id'");
while($row = mysql_fetch_array($mysql))
	{$creator_display = $row['creator_display'];
	$user_id = $row['user_id'];
	$creator_array = $row['creator_array'];
	$admin_array = $row['admin_array'];
	$member_array = $row['member_array'];
	$block_array = $row['block_array'];
	$planets_array = $row['planets_array'];
	if ($planets_array=="") {$planets_array=$id;}
	
	$memberArray=explode(",",$member_array);
	$adminArray=explode(",",$admin_array);
	$creatorArray=explode(",",$creator_array);
	$CREATORS=join(',',$creatorArray);
	$planetsArray=explode(",",$planets_array);
	$PLANETS=join(',',$planetsArray);
	}
	
	$check_pic="../user_files/user$id/profile_thumb.jpg";
	$default_pic="../user_files/user0/default_profile_pic_thumb.png";
	if (file_exists($check_pic))
		{$user_pic="<img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/>";}
	else
		{$user_pic="<img src='$default_pic' width='55px' height='55px' class='thumb_background' />";}
	
$DisplayList = "";
	
ob_flush();
?>

<script type="text/javascript">
var url = "../scripts/create_interactive_box.php";
var interactiveURL = "../scripts/create_interactive_changer.php";
////////////// NOTING //////////////
$('#note_form').submit(function(){$('input[type=note]', this).attr('disabled', 'disabled');});
function note_form()
	{var note_subject = $('#note_subject');
	var note_field = $('#note_field');
	var note_type = $('#note_type:checked');
	if (note_subject.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Subject field is empty. Please fill it in!</font><br/><br/>').show();}
	else if (note_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Note field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("#interactive_error").html('').show();
		$.post(url,{id:id,ids:ids,type:type,subject:note_subject.val(),note2:note_field.val(),note_type:note_type.val(),thisWipit:thisRandNum},function(data)
			{$('#bottom_note').html(data).show();
			document.note_form.note_field.value='';
			document.note_form.note_subject.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
	
////////////// DELETING NOTES //////////////
function delete_note1(a)
	{$.post(interactiveURL,{interactive:"delete_note1",note_id:a,thisWipit:thisRandNum},function(data) 
		{$("#delete_notes"+a).html(data).show();});}
function delete_note2(a)
	{$.post(url,{interactive:"delete_note2",note_id:a,thisWipit:thisRandNum},function(data) 
		{$("#item_box_notes"+a).html(data).show();});}
</script>

<body>
<font>
<div class="wall_body" id="wall_body">
	
<?php
if ((isset($_SESSION['ids']))AND(in_array($ids, $creatorArray)))
{echo '<div class="top_half_box" id="top_half_box">
			<a href="#" class="top_box4 top_boxes" onclick="return false" onmousedown="javascript:note();"></a><br/>
		</div>
		<div id="bottom_half_box"><div class="bottom_half_box">
			<a href="#" onclick="return false" onmousedown="javascript:note();"><input class="top_box_input" placeholder="Note Something..."/></a>
		</div></div>
		
		<div id="bottom_half_box_note" class="bottom_half_box_hide" style="display:none;">
    		<div class="bottom_half_box2">
			<form class="note_form" action="javascript:note_form()" method="post" type="multipart/form-data" name="note_form" id="note_form">
			<input class="note_field" name="note_subject" id="note_subject" placeholder="Subject..." />
			<textarea class="note_field" name="note_field" id="note_field" placeholder="Note Something..."></textarea>
			<div class="bottom_box_input">	
			<div class="bottom_box_input1">
				<input class="radio" type="radio" name="note_type" id="note_type" value="a" checked="checked"/> Both
				<input type="radio" name="note_type" id="note_type" value="b" /> Members
				<input type="radio" name="note_type" id="note_type" value="c" /> Admins
			</div>
			<div class="bottom_box_input2"><input src="blank.gif" width="1px" height="1px" type="image" name="note" class="note_button"/></div>
			</div></form></div>
     </div><br/>';
		}
else {echo "";}
?>

<div id='interactive_error' style='text-align:center;width:100%;'></div>
<div class="just_line"></div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_note">
	<?php include "planet_notes_content.php";?>
</div>
<div class="bottom_box" id="bottom_box">
	<div class="expand_bottom_wall" id="expand_bottom_box">
		<center><span class="expand_bottom_box">&#9660;</span></center>
	</div>
	<div class="expand_bottom_wall" id="load_content_scroll" style="display:none;">
		<center><img class="loader" src="barterrain_planet_images/loader_light_<?php echo $color;?>.gif" width="220px" height="19px"></center>
	</div>
</div>
</div>
</div>

</font>
</body>