<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

$array="";
$DisplayList ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";
$cacheBuster = $_SESSION['cacheBuster'];

$error_message="";
if (isset($_GET['error_message'])) 
	{$error_message = $_GET['error_message'];}

$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";

$mysql = mysql_query("SELECT id,family_array, friend_array FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql))
	{$id = $row['id'];
	$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$FF_array2=$ids.",".$family_array.",".$friend_array;
	$FF_array2 = explode(",",$FF_array2);
	$FF_News = join(',',$FF_array2);}

// Post Box
$top_box = "<a href='#' class='top_box1 top_boxes' onclick='return false' onmousedown='javascript:post();'></a>
			<a href='#' class='top_box4 top_boxes' onclick='return false' onmousedown='javascript:note();'></a>
			<a href='#' class='top_box2 top_boxes' onclick='return false' onmousedown='javascript:upload_media();'></a>
			<a href='#' class='top_box5 top_boxes' onclick='return false' onmousedown='javascript:planet();'></a><br/>";

ob_flush();
?>

<script src="inside.js" type="text/javascript" async></script>

<body>
<font>

<div class="wall_body" id="wall_body">
<div class="top_wall">
	<div id="top_half_box" class="top_half_box">
		<?php echo $top_box;?>
	</div>
	<div id="bottom_half_box">
		<div class="bottom_half_box">
			<a href='#' onclick='return false' onmousedown='javascript:post();'><input class="top_box_input" placeholder="Post Something..."/></a>
		</div>
	</div>
    <div id="bottom_half_box_post" class="bottom_half_box_hide" style="display:none;">
    		<div class="bottom_half_box2"><form class="post_form" action="javascript:post_form()" method="post" type="multipart/form-data" name="post_form">
			<textarea class="post_field" name="post_field" id="post_field" placeholder="Post Something..."></textarea>
			<div class="bottom_box_input">	
				<div class="bottom_box_input1">
					<input class="radio" type="radio" name="post_type" id="post_type" value="a" checked="checked"/> Both
					<input type="radio" name="post_type" id="post_type" value="b" /> Friends
					<input type="radio" name="post_type" id="post_type" value="c" /> Family
				</div>
				<div class="bottom_box_input2"><input src="blank.gif" type="image" name="post" class="post_button"/></div>
			</div></form></div>
     </div>
     <div id="bottom_half_box_media" class="bottom_half_box_hide" style="display:none;">
    	<div id="bottom_half_box3"><div class="bottom_half_box3">
			<a href="#" src="blank.gif" class="upload_choice_images" onClick="return false" onMouseDown="javascript:UploadImages();"></a>
            <a href="#" src="blank.gif" class="upload_choice_gifs" onClick="return false" onMouseDown="javascript:UploadGifs();"></a>
			<a href="#" src="blank.gif" class="upload_choice_videos" onClick="return false" onMouseDown="javascript:UploadVideos();"></a>
			<a href="#" src="blank.gif" class="upload_choice_games" onClick="return false" onMouseDown="javascript:UploadGames();"></a>
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
				<input type="radio" name="note_type" id="note_type" value="b" /> Friends
				<input type="radio" name="note_type" id="note_type" value="c" /> Family
			</div>
			<div class="bottom_box_input2"><input src="blank.gif" type="image" name="note" class="note_button"/></div>
			</div></form></div>
     </div>
     <div id="bottom_half_box_planet" class="bottom_half_box_hide" style="display:none;">
    	<div class="bottom_half_box2">
		<form class="planet_form" name="planet_form" id="planet_form" action="../scripts/interactive_parse.php" method="post" enctype="multipart/form-data">
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
			<div id="fakeupload2" class="fakeupload"></div>
			<input onChange="display_picture()"  id="upload_files2" class="upload_files2" type="file" size="76" name="planet_picture"/>
		</div>		
		<div class="bottom_box_input">	
			<div class="bottom_box_input1">
				<input class="radio" type="radio" name="create_type" id="create_type" value="a" checked="checked"/> Both
				<input type="radio" name="create_type" id="create_type" value="b" /> Friends
				<input type="radio" name="create_type" id="create_type" value="c" /> Family
			</div>
			<div class="bottom_box_input3">
				<a href="javascript:planet_form();"><img src="blank.gif" name="create" class="create_button"/></a>
				<input name="parse_var" type="hidden" value="create_planet" id="create_planet"/></div>
		</div></form></div>
     </div>
     <div id="bottom_half_box_points" class="bottom_half_box_hide" style="display:none;">
    	<div id="bottom_half_box3"><div class="bottom_half_box3">
			<a href="#" src="blank.gif" class="points_choice_advertise" onClick="return false" onMouseDown="javascript:PointsAdvertise();"></a>
            <a href="#" src="blank.gif" class="points_choice_bc" onClick="return false" onMouseDown="javascript:PointsBC();"></a>
			<a href="#" src="blank.gif" class="points_choice_reveal" onClick="return false" onMouseDown="javascript:PointsReveal();"></a>
			<a href="#" src="blank.gif" class="points_choice_tt" onClick="return false" onMouseDown="javascript:PointsTT();"></a>
		</div></div>
     </div>
</div>
<br/>
<div id='interactive_error' style='text-align:center;width:100%;'><font class="color" style="font:12px helvetica, sans-serif;"></font></div>
<div class="just_line"></div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_news">
	<?php include "news_content.php";?>
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
</div>

</font>
</body>