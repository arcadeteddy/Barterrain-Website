<font>
<?php
ob_start();
include_once "../config.php";

$id = $_POST['id'];
$ids = $_POST['ids'];
$color = $_POST['color'];

// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = rand(9999999,99999999999);
$_SESSION['cacheBuster'] = $cacheBuster;
$DisplayImage="";

include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

$mysql = mysql_query("SELECT user_id,creator_array,admin_array,member_array FROM planets WHERE id='$id'");
while($row = mysql_fetch_array($mysql))
	{$user_id = $row['user_id'];
	$creator_array = $row['creator_array'];
	$admin_array = $row['admin_array'];
	$member_array = $row['member_array'];
	
	$memberArray=explode(",",$member_array);
	$adminArray=explode(",",$admin_array);
	$creatorArray=explode(",",$creator_array);
	$CREATORS=join(',',$creatorArray);
	}
	
if (!in_array($ids,$memberArray))
	{$hide_llc_front="<div style='display:none;'>";
	$hide_llc_back="</div>";}
else
	{$hide_llc_front="";
	$hide_llc_back="";}	

if ($_POST['display']=="display_image")
	{$planet_id=$_POST['id'];
	$ids=$_POST['ids'];
	$image_id=$_POST['image_id'];
	$typex=$_POST['type'];
	$user_type="user_id";
	$item_type="images";
	
	$mysql=mysql_query("SELECT id, user_page_id,user_post_id, album_id, upload_date, image_type, ext, like_array, love_array, point_array FROM ".$typex."_".$item_type." WHERE id='$image_id' LIMIT 1");
	$row=mysql_fetch_assoc($mysql);
		{$item_id=$row['id'];
		$user_page_id=$row['user_page_id'];
		$user_post_id=$row['user_post_id'];
		$album_id=$row['album_id'];
		$upload_date=$row['upload_date'];
		$upload_date = ($myObject -> convert_datetime($upload_date));
		$upload_date = ($myObject -> make_ago($upload_date));
		$image_type=$row['image_type'];
		$ext=$row['ext'];
		$like_array_image = $row['like_array'];
		$love_array_image = $row['love_array'];
		$likeArray_image = explode(",",$like_array_image);
		$loveArray_image = explode(",",$love_array_image);
		$like_array_count_image = count($likeArray_image);
		$love_array_count_image = count($loveArray_image);
		$point_array_image = $row['point_array'];
		$pointArray_image = explode(",",$point_array_image);
		$point_array_count_image = count($pointArray_image);
		$point_array_count_image = $point_array_count_image*10;
		if($point_array_image==""){$point_array_count_image="0";}
		}
		
	$mysql=mysql_query("SELECT user_page_id,album_name,image_array FROM ".$typex."_albums WHERE id='$album_id' LIMIT 1");
	$row=mysql_fetch_assoc($mysql);
		{$album_owner_id=$row['user_page_id'];
		$album_name=$row['album_name'];
		$image_array=$row['image_array'];}
		
	$imageArray=explode(",",$image_array);
	$imageArray=array_reverse($imageArray);
	
	$index = array_search($image_id, $imageArray);
	if($index !== FALSE)
		{$next = $index + 1;
  		$previous = $index - 1;}
	if ($next < count($imageArray))
		{$next_id = $imageArray[$next];
		$next_button="<a href='#' onclick='return false' class='display_image_button post_link' onmousedown='javascript:display_image_next_previous(".$id.",".$ids.",".$next_id.");'>Next</a>";}
	else {$next_button="";}
	if ($previous >= 0)
		{$previous_id = $imageArray[$previous];
		$previous_button="<a href='#' onclick='return false' class='display_image_button post_link' onmousedown='javascript:display_image_next_previous(".$id.",".$ids.",".$previous_id.");'>Previous</a>";}
	else {$previous_button="";}
	if (($next_button!=="")AND($previous_button!==""))
		{$next_previous_dot_divider="<span class='dot_divider'> &middot; </span>";}
	else {$next_previous_dot_divider="";}
		
	$comment_type="images";
	$comment_type=json_encode($comment_type);
	
		if (in_array($ids,$likeArray_image))
			{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_image(".$id.",".$ids.", ".$image_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_image))
			{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_image(".$planet_id.",".$ids.", ".$image_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_image(".$planet_id.",".$ids.", ".$image_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_image(".$planet_id.",".$ids.", ".$image_id.",".$comment_type.");'>Love</a>";}
		if (in_array($ids,$likeArray_image))
			{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_image(".$planet_id.",".$ids.", ".$image_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_image))
			{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_image(".$planet_id.",".$ids.", ".$image_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_image(".$planet_id.",".$ids.", ".$image_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_image(".$planet_id.",".$ids.", ".$image_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_image !="")AND($love_array_image !=""))
			{$like_love2_image = "<a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";$dot_divider='<span class="dot_divider"> &middot; </span>';}
		else if ($like_array_image !="")
			{$like_love2_image = "<a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";$dot_divider='<span class="dot_divider"> &middot; </span>';}
		else if ($love_array_image !="")
			{$like_love2_image = "<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$planet_id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";$dot_divider='<span class="dot_divider"> &middot; </span>';}
		else{$like_love2_image = "";$dot_divider='';}	
	
	
	// Little Things
	if(($ids==$user_id)OR($ids==$user_post_id)OR(in_array($ids,$creatorArray))OR((in_array($ids,$adminArray))AND(!in_array($user_post_id,$creatorArray))AND($user_id!==$user_post_id)))
			{if($image_type=="a"){$type="<div class='option_box' id='type_change_images".$image_id."'><a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$image_id.",".$comment_type.");'></a></div>";}
			else if($image_type=="b"){$type="<div class='option_box' id='type_change_images".$image_id."'><a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$image_id.",".$comment_type.");'></a></div>";}
			else if($image_type=="c"){$type="<div class='option_box' id='type_change_images".$image_id."'><a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$image_id.",".$comment_type.");'></a></div>";}}
		else{$type="";}
		if($ids!==$user_post_id){$point="<div class='option_box2' id='point_images".$image_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$image_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_image."</b></div>";}
		else if($point_array_count_image=="0"){$point="";}
		else{$point="<div title='Point Array' class='option_box2 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><a href='#' class='point0' onclick='return false'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_image."</b></a></div>";}
		
	$check_pic="../planet_files/planet".$user_page_id."/planet_album_".$album_id."/planet_album_".$album_id."_pic_".$image_id.".".$ext."";
	list($width, $height) = getimagesize($check_pic);
	if ($width-50>$height) {$display_length="width='590px'";$div_display_length="style='overflow-x:hidden;overflow-y:hidden;'";}
	else if ($width-50<=$height) {$display_length="height='495px'";$div_display_length="style='overflow-y:hidden;overflow-x:hidden;'";}
	}

ob_flush();
?>
<script type="text/javascript">
// CHANGER //
var planet_id = "<?php echo $planet_id; ?>";
var ids = "<?php echo $ids; ?>";
var color = "<?php echo $color; ?>";
var type = "<?php echo "planets"; ?>";
var image_id = "<?php echo $image_id; ?>";
var url = "../scripts/create_interactive_box.php";
var like_loveURL = "../scripts/like_love.php";

function image_post()
	{$("#interactive_error").html('').show();
		$(".top_boxes").removeClass("selected_box");
		$(".image_top_box1").toggleClass("selected_box");
		$(".images_bottom_posts").removeClass("error_box");
		$(".images_bottom_posts").addClass("selected_box");
		$("#image_half_box").hide();
		$(".bottom_half_box_hide").hide();
		$("#image_half_box_post").show();
	}
	
// Display Image	
function display_image_next_previous(a,b,c)
	{$("#full_page_display_image").removeClass("full_page_loader_hidden");
	$.post(DisplayImage,{display:"display_image",id:a,ids:b,image_id:c,type:type,color:color},function(data) 
		{$("#full_page_display_image").addClass("full_page_loader_hidden");
		$("#display_image_div").html(data).show();});
	}
	
////////////// IMAGE POSTING //////////////
$('#image_post_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function image_post_form()
	{var image_post_field = $('#image_post_field');
	var image_post_type = $('#image_post_type:checked');
	if (image_post_field.val() == '')
		{$(".images_bottom_posts").addClass("error_box");
		$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Post field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("#full_page_display_image").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:planet_id,planet_id:planet_id,ids:ids,image_id:image_id,image_post:image_post_field.val(),image_type:image_post_type.val(),typex:type,thisWipit:thisRandNum},function(data)
			{$('#bottom_image_display').html(data).show();
			document.image_post_form.image_post_field.value='';
			$("#full_page_display_image").addClass("full_page_loader_hidden");});
		}
	}
		
// Like/Love Images
function Like_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Like_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
function Love_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Love_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
function unlikeLike_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unlikeLike_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
function unloveLove_image(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unloveLove_image",id:a,ids:b,image_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#image_ll"+c).html(data).show()});	
	}
</script>

<div class="full_page_loader_hidden" id="full_page_display_image"><div class="full_page_display_image"></div><img class="full_page_loader" src="../barterrain_main_images/loader_full_<?php echo $color;?>.gif" width="128px" height="128px"/></div>

<div class="display_image_div">
					<div class='display_image_top'>
                        <div style='float:left;'><b>Album: </b><?php echo "<a href='http://www.barterrain.com/planet/planet.php?id=".$album_owner_id."&force_album=".$album_id."' class='body'>".$album_name."</a>";?></div><div class='option_box_wrap3'><?php echo $point."".$type; ?></div>
                    </div>
                    <div class='display_image_bottom'>
                    	<div class='float_left'>
						<?php echo '<div class="image_ll_wrap" style="padding:0px;margin:0px;"><div class="image_ll"  style="padding:0px;margin:0px;" id="image_ll'.$image_id.'">
								<div class="like_love">'.$like_love_image.'&nbsp;'.$dot_divider.''.$like_love2_image.'</div>
							</div></div>'; ?>
                        </div>
                        <div class='float_right'>
                        	<?php echo $previous_button."".$next_previous_dot_divider."".$next_button; ?>
                        </div>
                    </div>
					<div class='display_image_left'>
                    <table style="width:100%;height:100%;border-spacing:none;border:none;padding:0px;margin:0px;display:fixed;" cellspacing="0" cellpadding="0">
                    <tr><td height='8px'></td></tr>
                    <tr style="vertical-align:middle;text-align:center;border-spacing:none;border:none;"><td>
						<?php echo "<img src='../planet_files/planet".$user_page_id."/planet_album_".$album_id."/planet_album_".$album_id."_pic_".$image_id.".".$ext."' ".$display_length." />"; ?>
					</td></tr>
                    </table>
                    </div>
					<div class='display_image_right'>
                    
   					<div class="top_content">
							<div id="top_half_box" class="top_half_box">
								<a href="#" class="image_top_box1 top_boxes" onclick="return false" onmousedown="javascript:image_post();"></a>
							</div>
							<div id="image_half_box">
								<div class="bottom_half_box">
									<a href="#" onclick="return false" onmousedown="javascript:image_post();"><input class="top_box_input" placeholder="Post Something..."/></a>
								</div>
							</div>
                            <div id="image_half_box_post" class="bottom_half_box_hide" style="display:none;">
    		    				<div class="bottom_half_box2"><form class="post_form" action="javascript:image_post_form()" method="post" type="multipart/form-data" name="image_post_form">
			    					<textarea class="post_field" name="image_post_field" id="image_post_field" placeholder="Post Something..."></textarea>
			    					<div class="bottom_box_input">	
			    						<div class="bottom_box_input1">
				    						<input class="radio" type="radio" name="image_post_type" id="image_post_type" value="a" checked="checked"/> Both
				    						<input type="radio" name="image_post_type" id="image_post_type" value="b" /> Members
				    						<input type="radio" name="image_post_type" id="image_post_type" value="c" /> Admin
				    					</div>
				    				<div class="bottom_box_input2"><input src="blank.gif" width="1px" height="1px" type="image" name="post" class="post_button"/></div>
			    				</div></form></div>
   	    				  	</div>
						</div>
						<br/>
				
                        <div id='interactive_error' style='text-align:center;width:100%;'></div>
                        <div class='just_line'></div>
                        <div class='images_bottom_posts'>
                        	<div style='width:500px;overflow-x:hidden;'>
							<div class='bottom_wall' id='bottom_image_display'>
									<?php include "../scripts/create_images_posts_content.php" ;?>   
                            </div>
                            </div>
							<div class='bottom_box2' id='bottom_box'>
								<div class='expand_bottom_wall' id='image_expand_bottom_box'>
									<center><span class='expand_bottom_box'>&#9660;</span></center>
								</div>
								<div class='expand_bottom_wall' id='image_load_content_scroll' style='display:none;'>
									<?php echo "<center><img class='loader' src='../inside/barterrain_inside_images/loader_light_".$color.".gif' width='220px' height='19px'></center>"; ?>
							</div>
                        </div> 
						</div>
					</div>
</div>
</font>