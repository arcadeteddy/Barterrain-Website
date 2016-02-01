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

$ids = $_SESSION['ids'];

include_once "../scripts/check_login.php";

$mysql = mysql_query("SELECT id,family_array, friend_array,planets_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$ids = $row['id'];
	$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$planets_array = $row['planets_array'];
	$FF_array2=$ids.",".$family_array.",".$friend_array;
	$FF_array2 = explode(",",$FF_array2);
	$FF_planet = join(',',$FF_array2);}

// Post Box
$top_box = '';
if (isset($_SESSION['ids']) && $_SESSION['ids'] === $id)
	{$top_box = '<div id="top_half_box" class="top_half_box">
		<a href="#" class="top_box5 top_boxes" onclick="return false" onmousedown="javascript:planet();"></a><br/>
	</div>
	<div id="bottom_half_box">
		<div class="bottom_half_box">
			<a href="#" onclick="return false" onmousedown="javascript:planet();"><input class="top_box_input" placeholder="Planet Name..."/></a>
		</div>
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
				<a href="javascript:planet_form();"><img src="blank.gif" width="1px" height="1px" name="create" class="create_button"/></a>
				<input name="parse_var" type="hidden" value="create_planet" id="create_planet"/></div>
		</div></form></div>
     </div><br/>';}

if($planets_array!=="")
	{$content="<br/><div class='middle_bars'><div class='float_left'><img src='blank.gif' width='1px' height='1px' class='planets_lists'/><span class='heading_list'>Their Activity</span></div><div class='float_right'></div></div>";}
else{$content="";}

ob_flush();
?>

<?php $type="planets";?>
<script type="text/javascript">
var type = "<?php echo $type; ?>";
</script>
<script src="../planet/planet.js" type="text/javascript" async></script>

<body>
<font>

<div class="wall_body" id="wall_body">
<div class="top_wall">
	<?php echo $top_box;?>
</div>
<div id='interactive_error' style='text-align:center;width:100%;'></div>

<div id="entire_bottom_wall">

<div id="colonized_planets_list">
<?php // Family
include_once "colonized_planets_list.php";
?>
</div>
<div id="created_planets_list">
<?php // Friends
include_once "created_planets_list.php";
?>
</div>

<div class="bottom_wall" id="bottom_planets">
	<?php echo $content; $type="planets";
	include "planets_content.php";?>
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
</div>

</font>
</body>