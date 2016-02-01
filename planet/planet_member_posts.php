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
		$.post(url,{id:id,ids:ids,type:type,post2:post_field.val(),post_type:post_type.val(),thisWipit:thisRandNum},function(data)
			{$('#bottom_member_post').html(data).show();
			document.post_form.post_field.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
</script>

<body>
<font>
<div class="wall_body" id="wall_body">
    
<?php
if (in_array($ids,$creatorArray))
	{echo '';}
else if ((in_array($ids,$adminArray))OR(in_array($ids,$memberArray)))
	{echo '<div class="top_wall"><div id="top_half_box" class="top_half_box"><a href="#" class="top_box1 top_boxes" onclick="return false" onmousedown="javascript:post();"></a></div>
		<div id="bottom_half_box"><div class="bottom_half_box">
			<a href="#" onclick="return false" onmousedown="javascript:post();"><input class="top_box_input" placeholder="Post Something..."/></a>
		</div></div></div>
		
		<div id="bottom_half_box_post" class="bottom_half_box_hide" style="display:none;">
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
     	</div><br/>
		
		<div id="interactive_error" style="text-align:center;width:100%;"></div>';
		}
else {echo "";}
?>

<div class="just_line"></div>

<div id="entire_bottom_wall">
<div class="bottom_wall" id="bottom_member_post">
	<?php include "planet_member_posts_content.php";?>
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