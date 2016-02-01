<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

$bottom_hidden_box="";
$DisplayList ="";
$nothing ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";
$cacheBuster = $_SESSION['cacheBuster'];

$error_message="";$brbr="";
if (isset($_GET['error_message'])) 
	{$error_message = $_GET['error_message'];$brbr="<br/><br/>";}

include_once "../scripts/check_login.php";

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

$existing_creates="";
$mysql = mysql_query("SELECT id, planet_name FROM planets WHERE user_id=$ids AND id NOT IN ($PLANETS) AND id!='$id'");
	while($row = mysql_fetch_array($mysql))
	{$create_id=$row['id'];
	$create_name=$row['planet_name'];
	$existing_creates .= '<option value="'.$create_id.'">Link To '.$create_name.'</option>';}

$top_box="";
$bottom_box="";
$bottom_half_box="";


// Post Box
if ((isset($_SESSION['ids']))AND(in_array($ids, $creatorArray)))
	{$top_box .= "<div class='top_wall'><div id='top_half_box' class='top_half_box'>
    			<a href='#' class='top_box1 top_boxes' onclick='return false' onmousedown='javascript:post();'></a>
				<a href='#' class='top_box4 top_boxes' onclick='return false' onmousedown='javascript:note();'></a>
				<a href='#' class='top_box2 top_boxes' onclick='return false' onmousedown='javascript:upload_media();'></a>
				<a href='#' class='top_box5 top_boxes' onclick='return false' onmousedown='javascript:planet();'></a>
				<br/></div>";
	$top_box .= '<div id="bottom_half_box_post" class="bottom_half_box_hide" style="display:none;">
    		<div class="bottom_half_box2"><form class="post_form" action="javascript:post_form()" method="post" type="multipart/form-data" name="post_form">
			<textarea class="post_field" name="post_field" id="post_field" placeholder="Post Something..."></textarea>
			<div class="bottom_box_input">	
				<div class="bottom_box_input1">
					<input class="radio" type="radio" name="post_type" id="post_type" value="a" checked="checked"/> Both
					<input type="radio" name="post_type" id="post_type" value="b" /> Members
					<input type="radio" name="post_type" id="post_type" value="c" /> Admins
				</div>
				<div class="bottom_box_input2"><input src="blank.gif" width="1px" height="1px" type="image" name="post" class="post_button"/></div>
			</div></form></div>
     </div>
	 	 
     <div id="bottom_half_box_media" class="bottom_half_box_hide" style="display:none;">
    	<div id="bottom_half_box3"><div class="bottom_half_box3">
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_images" onClick="return false" onMouseDown="javascript:UploadImages();"></a>
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_gifs" onClick="return false" onMouseDown="javascript:UploadGifs();"></a>
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_videos" onClick="return false" onMouseDown="javascript:UploadVideos();"></a>
			<a href="#" src="blank.gif" width="1px" height="1px" class="upload_choice_games" onClick="return false" onMouseDown="javascript:UploadGames();"></a>
		</div></div>
     </div>
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
     </div>
     <div id="bottom_half_box_planet" class="bottom_half_box_hide" style="display:none;">
    	<div class="bottom_half_box2">
		<form class="planet_form" name="planet_form" id="planet_form" action="../scripts/create_interactive_parse.php" method="post" enctype="multipart/form-data">
		<select name="new_create" id="new_create" class="select_choice" onchange="javascript:add_remove_new_create();">
			<option value="planets" selected="selected">New Planet...</option>
			'.$existing_creates.'
		</select>
		<div id="add_remove_new_create">
		<input class="create_field" name="create_name" id="create_name" placeholder="Planet Name..." maxlength="128"/>
		<textarea class="create_field" name="create_description" id="create_description" rows="3" placeholder="Planet Description..." maxlength="250"></textarea>
		<select name="categories" id="categories" class="select_choice">
			<option value="">Choose a Category...</option>
            <option value="Artist">Artist</option>
			<option value="Brand / Product">Brand / Product</option>
			<option value="Business / Company / Organization">Business / Company / Organization</option>
            <option value="Critic">Critic</option>
            <option value="Education">Education</option>
			<option value="Entertainment">Entertainment</option>
            <option value="Indefinable">Indefinable</option>
			<option value="Non-Profit Cause">Non-Profit Cause</option>
            <option value="Personal">Personal</option>
			<option value="Public Figure">Public Figure</option>
			<option value="Other">Other</option>
		</select>
		<div class="upload_files2">
			<div id="fakeupload2_planet" class="fakeupload"></div>
			<input onChange="display_picture_planet()"  id="upload_files2_planet" class="upload_files2" type="file" size="76" name="planet_picture"/>
		</div>		
		</div>
		<div class="bottom_box_input">	
			<div class="bottom_box_input1">
				<input class="radio" type="radio" name="create_type2" id="create_type2" value="a" checked="checked"/> Both
				<input type="radio" name="create_type2" id="create_type2" value="b" /> Members
				<input type="radio" name="create_type2" id="create_type2" value="c" /> Admins |
				<input class="radio" type="radio" name="create_type" id="create_type" value="a" checked="checked"/> Both
				<input type="radio" name="create_type" id="create_type" value="b" /> Friends
				<input type="radio" name="create_type" id="create_type" value="c" /> Family
			</div>
			<div class="bottom_box_input3">
				<a href="javascript:planet_form();"><img src="blank.gif" width="1px" height="1px" name="create" class="create_button"/></a>
				<input name="parse_var" type="hidden" value="create_planet" id="create_planet"/></div>
				<input name="id" type="hidden" value="'.$id.'"/>
				<input name="type" type="hidden" value="planets"/>
		</div></form></div>
     </div>';	
	 $top_box .= "<div id='bottom_half_box'><div class='bottom_half_box'>
			<a href='#' onclick='return false' onmousedown='javascript:post();'><input class='top_box_input' placeholder='Post Something...'/></a>
		</div></div></div><br/>";
	}
else if ((isset($_SESSION['ids']))AND((in_array($ids, $adminArray))OR(in_array($ids, $memberArray))))
	{$top_box .= "<div class='top_wall'><div id='top_half_box' class='top_half_box'><a href='#' class='top_box1 top_boxes' onclick='return false' onmousedown='javascript:post();'></a></div>";
	$top_box .= '<div id="bottom_half_box_post" class="bottom_half_box_hide" style="display:none;">
    		<div class="bottom_half_box2"><form class="post_form" action="javascript:post_form()" method="post" type="multipart/form-data" name="post_form">
			<textarea class="post_field" name="post_field" id="post_field" placeholder="Post Something..."></textarea>
			<div class="bottom_box_input">	
				<div class="bottom_box_input1">
					<input class="radio" type="radio" name="post_type" id="post_type" value="a" checked="checked"/> Both
					<input type="radio" name="post_type" id="post_type" value="b" /> Members
					<input type="radio" name="post_type" id="post_type" value="c" /> Admins
				</div>
				<div class="bottom_box_input2"><input src="blank.gif" width="1px" height="1px" type="image" name="post" class="post_button"/></div>
			</div></form></div>
     	</div>';
	 $top_box .= "<div id='bottom_half_box'><div class='bottom_half_box'>
			<a href='#' onclick='return false' onmousedown='javascript:post();'><input class='top_box_input' placeholder='Post Something...'/></a>
		</div></div></div><br/>";}

ob_flush();
?>

<script type="text/javascript">
var url = "../scripts/create_interactive_box.php";
var interactiveURL = "../scripts/create_interactive_changer.php";
////////////// POSTING //////////////
$('#post_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function post_form()
	{var post_field = $('#post_field');
	var post_type = $('#post_type:checked');
	if (post_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Post field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,ids:ids,type:type,post:post_field.val(),post_type:post_type.val(),thisWipit:thisRandNum},function(data)
			{$('#bottom_wall').html(data).show();
			document.post_form.post_field.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
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
		$.post(url,{id:id,ids:ids,type:type,subject:note_subject.val(),note:note_field.val(),note_type:note_type.val(),thisWipit:thisRandNum},function(data)
			{$('#bottom_wall').html(data).show();
			document.note_form.note_field.value='';
			document.note_form.note_subject.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
</script>

<body>
<font>
<div class="wall_body" id="wall_body">
	<?php echo $top_box; ?>

<div id='interactive_error' style='text-align:center;width:100%;'><font class="color" style="font:12px helvetica, sans-serif;"><?php echo $error_message;?></font><?php echo $brbr;?></div>
<div class="just_line"></div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_wall">
	<?php include "planet_wall_content.php";?>
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