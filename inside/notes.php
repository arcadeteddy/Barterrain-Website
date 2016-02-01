<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

include_once "../scripts/check_login.php";

$cacheBuster = $_SESSION['cacheBuster'];
$DisplayList="";
$private_public="";
$mysql = mysql_query("SELECT * FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
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
	$likes = $row['likes'];
	$loves = $row['loves'];
	$scores = $row['scores'];}
	
	$check_pic="../user_files/user$id/profile_thumb.jpg";
	$default_pic="../user_files/user0/default_profile_pic_thumb.png";
	if (file_exists($check_pic))
		{$user_pic="<img src='$check_pic#$cacheBuster' width='55px' class='thumb_background'/>";}
	else
		{$user_pic="<img src='$default_pic' width='55px' class='thumb_background' />";}
	
$DisplayList = "";
	
ob_flush();
?>

<script src="inside.js" type="text/javascript" async></script>
<script type="text/javascript">
////////////// NOTING //////////////
$('#note_form').submit(function(){$('input[type=note]', this).attr('disabled', 'disabled');});
function note_form()
	{var note_subject = $('#note_subject');
	var note_field = $('#note_field');
	var note_type = $('#note_type:checked');
	var url = "../scripts/interactive_box.php";
	if (note_subject.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Subject field is empty. Please fill it in!</font><br/><br/>').show();}
	else if (note_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Note field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,subject:note_subject.val(),note:note_field.val(),type:note_type.val(),file_location:file_location,thisWipit:thisRandNum},function(data)
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
	
<?php
if (isset($_SESSION['ids']) && $_SESSION['ids'] != $id)
	{echo "";}
else if (isset($_SESSION['ids']) && $_SESSION['ids'] == $id)
{echo '<div class="top_half_box" id="top_half_box">
			<a href="#" class="top_box4 top_boxes" onclick="return false" onmousedown="javascript:note();"></a><br/>
		</div>
		<div id="bottom_half_box"><div class="bottom_half_box">
			<a href="#" onclick="return false" onmousedown="javascript:note();"><input class="top_box_input" placeholder="Note Something..."/></a>
		</div></div>';}
?>
	
     <div id="bottom_half_box_note" class="bottom_half_box_hide" style="display:none;">
    		<div class="bottom_half_box2">
			<form class="note_form" action="javascript:note_form()" method="post" type="multipart/form-data" name="note_form" id="note_form">
			<input class="note_field" name="note_subject" id="note_subject" placeholder="Subject..." />
			<textarea class="note_field" name="note_field" id="note_field" placeholder="Note Something..."></textarea>
			<div class="bottom_box_input">	
			<div class="bottom_box_input1">
				<input class="radio" type="radio" name="note_type" id="note_type" value="a" checked="checked"/> Both
				<input type="radio" name="note_type" id="note_type" value="b" /> Friends
				<input type="radio" name="note_type" id="note_type" value="c" /> Family
			</div>
			<div class="bottom_box_input2"><input src="blank.gif" type="image" name="note" class="note_button"/></div>
			</div></form></div>
     </div>
     
<br/>
<div id='interactive_error' style='text-align:center;width:100%;'></div>
<div class="just_line"></div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_note">
	<?php include "notes_content.php"; ?>
</div>
<div class="bottom_box" id="bottom_box">
	<div class="expand_bottom_wall" id="expand_bottom_box">
		<center><span class="expand_bottom_box">&#9660;</span></center>
	</div>
	<div class="expand_bottom_wall" id="load_content_scroll" style="display:none;">
		<center><img class="loader" src="barterrain_inside_images/loader_light_<?php echo $color;?>.gif" width="220px" height="19px"></center>
	</div>
</div>
</div>

</font>
</body>