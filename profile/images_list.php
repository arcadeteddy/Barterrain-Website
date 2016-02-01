<?php
ob_start();
include_once "../config.php";

if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];}
if(isset($_POST['cacheBuster']))
	{$cacheBuster=$_POST['cacheBuster'];}
if(isset($_POST['album_id']))
	{$album_id=$_POST['album_id'];
	$item_id=$_POST['album_id'];}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();

$mysql = mysql_query("SELECT friend_array,family_array FROM members WHERE id='$id' LIMIT 1");
while($row = mysql_fetch_array($mysql))
	{$friend_array=$row['friend_array'];
	$friend_array = explode(",",$friend_array);
	$family_array=$row['family_array'];
	$family_array = explode(",",$family_array);}
	
if (in_array($ids,$friend_array))
	{$view_type="AND image_type!='c'";}
else if (in_array($ids,$family_array))
	{$view_type="AND image_type!='b'";}
else {$view_type="";}

$mysql = mysql_query("SELECT id FROM images WHERE album_id='$album_id' ".$view_type." AND delete_item='1' ORDER BY id DESC, upload_date DESC");
$numRows=mysql_num_rows($mysql);

$imagesDisplayList="";
if ($numRows>0)
	{// Pagination
	while ($row = mysql_fetch_array($mysql))
	{$image_id = $row['id'];
	if (!isset($images_array)){$images_array=$image_id;}
	else{$images_array=$images_array.",".$image_id;}}
	$imagesArray=explode(",",$images_array);echo $images_array;
	$list_images="";
	$items_per_page=32;
	$pages_images=ceil($numRows/$items_per_page);
	$page_images=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($page_images-1) * $items_per_page;
	$imagesArray2 = array_slice($imagesArray,$start,$items_per_page);
	
	if($pages_images>1)
		{for($x=1;$x<=$pages_images;$x++)
			{if(($x==$page_images)AND($x==$pages_images)){$list_images.="<b>$x</b>";}
			else if($x==$page_images){$list_images.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$pages_images){$list_images.="<a href='#' onclick='return false' onmousedown='javascript:images_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_images.="<a href='#' onclick='return false' onmousedown='javascript:images_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	
	$imagesDisplayList .= "<div class='album_bars'>
						<div class='float_left'><img src='blank.gif' class='albums_lists'/><span class='heading_list'>Images (".$numRows.")</span></div>
					<div class='float_right'>".$list_images."</div></div><div>";
	
	$i = 0;
	foreach ($imagesArray2 as $key => $value)
		{$i++;	
		$mysql_images = mysql_query("SELECT * FROM images WHERE id=$value ORDER BY upload_date DESC");
		while($row = mysql_fetch_array($mysql_images))
			{$image_id = $row['id'];
			$item_id = $row['id'];
			$user_id = $row['user_id'];
			$album_id = $row['album_id'];
			$ext = $row['ext'];
			$image_type = $row['image_type'];
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

		$comment_type="images";
		$comment_type=json_encode($comment_type);
	
		if (in_array($ids,$likeArray_image))
			{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_image(".$id.",".$ids.", ".$image_id.",".$comment_type.");'>Unlike</a>";}
		else if (in_array($ids,$loveArray_image))
			{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_image(".$id.",".$ids.", ".$image_id.",".$comment_type.");'>Unlove</a>";}
		else{$like_love_image = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_image(".$id.",".$ids.", ".$image_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
								<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_image(".$id.",".$ids.", ".$image_id.",".$comment_type.");'>Love</a>";}
		if (($like_array_image !="")AND($love_array_image !=""))
			{$like_love2_image = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
								<a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else if ($like_array_image !="")
			{$like_love2_image = "<span class='dot_divider'> &middot; </span><a href='#' title='Like Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$like_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
		else if ($love_array_image !="")
			{$like_love2_image = "<span class='dot_divider'> &middot; </span><a href='#' title='Love Array' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'>".$love_array_count_image."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
		else{$like_love2_image = "";}
		
		// Little Things
		if($ids==$user_id)
			{if($image_type=="a"){$type="<div class='option_box' id='type_change_images".$image_id."'><a href='#' title='Display To All' class='bff_type1' onclick='return false' onmousedown='javascript:type_change(".$image_id.",".$comment_type.");'></a></div>";}
			else if($image_type=="b"){$type="<div class='option_box' id='type_change_images".$image_id."'><a href='#' title='Display To Friends' class='bff_type2' onclick='return false' onmousedown='javascript:type_change(".$image_id.",".$comment_type.");'></a></div>";}
			else if($image_type=="c"){$type="<div class='option_box' id='type_change_images".$image_id."'><a href='#' title='Display To Family' class='bff_type3' onclick='return false' onmousedown='javascript:type_change(".$image_id.",".$comment_type.");'></a></div>";}}
		else{$type="";}
		if($ids==$user_id)
			{$delete_button_image="<div class='option_box'  id='delete_image_".$image_id."'><a href='#' title='Delete' class='top_options_delete1' onclick='return false' onmousedown='javascript:delete_image1(".$image_id.",".$comment_type.");'></a></div>";}
		else{$delete_button_image="";}
		if($ids!==$user_id){$point="<div class='option_box2' id='point_images".$image_id."'><a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$image_id.",".$comment_type.");'></a><b class='point'>".$point_array_count_image."</b></div>";}
		else if($point_array_count_image=="0"){$point="";}
		else{$point="<div title='Point Array' class='option_box2 display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><a href='#' class='point0' onclick='return false'></a><a href='#' title='Point Array' class='body display_button' onclick='return false' onmousedown='javascript:display_point_array(".$id.",".$ids.",".$item_id.",".$comment_type.");'><b class='point3'>".$point_array_count_image."</b></a></div>";}
		
		$black_gif="";
		if ($ext=="gif") {$black_gif="<img class='black_gif' style='margin:0px;' src='barterrain_profile_images/black.png' height='168px' width='168px'/><table class='black_gif' style='margin:0px;' height='168px' width='168px'><tr><td><span class='black_gif'>GIF</span></td></tr></table>";}
		$image_pic="../user_files/user$user_id/album_thumbs_$album_id/album_".$album_id."_thumb_".$image_id.".jpg";
		$image_default_pic="../user_files/user0/default_image_cover.png";
		$cacheBuster = rand(9999999,99999999999);
		if(file_exists($image_pic))
			{$image_thumb="<a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img src='$image_pic' height='168px' width='168px' class='thumb_background'/></a>";}
		else{$image_thumb="<a href='#' onclick='return false' class='display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$value.");'>".$black_gif."<img src='$image_default_pic' height='168px' width='168px' class='thumb_background'/></a>";}
		
		
		$imagesDisplayList .= '<div class="image_box" id="image_box'.$image_id.'">
							<div class="image_box1">
								<div class="top_options">
									'.$point.''.$type.''.$delete_button_image.'
								</div>
								<div class="image_pic"><div style="float:left;">'.$image_thumb.'</div></div>
							</div>
							<div class="image_ll_wrap"><div class="image_ll" id="image_ll'.$image_id.'">
								<div class="like_love">'.$like_love_image.'&nbsp;</div>'.$like_love2_image.'
							</div></div>
							</div>';
			}
		$imagesDisplayList .= '</div>';
	}
echo $imagesDisplayList;
?>
<head>
<script type="text/javascript">
var album_id = "<?php echo $album_id; ?>";
// Images Pagination
function images_list(a,b,c)
	{$.post("images_list.php?page="+a,{x:a,id:b,ids:c,album_id:album_id,cacheBuster:cacheBuster},function(data) 
		{$("#image_box_wrap").html(data).show()});	
	}
</script>