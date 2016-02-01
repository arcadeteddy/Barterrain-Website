<?php
ob_start();
include_once "../config.php";
$id=$_POST['id'];
$ids=$_POST['ids'];

if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];}
if(isset($_POST['cacheBuster']))
	{$cacheBuster=$_POST['cacheBuster'];}

if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();

$mysql1 = mysql_query("SELECT planets_array FROM planets WHERE id='$id'");
while($row = mysql_fetch_array($mysql1))
	{$planets_array = $row['planets_array'];}
	
// Planets List
$planets_list = "";
if ($planets_array != "")
	{$planetsArray = explode(",",$planets_array);
	$planetsArray = array_reverse($planetsArray);
	$planets_count = count($planetsArray);
	// Pagination
	$list_planets="";
	$items_per_planet=4;
	$planets_planets=ceil($planets_count/$items_per_planet);
	$planet_planets=(isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$start=($planet_planets-1) * $items_per_planet;
	$planetsArray8 = array_slice($planetsArray,$start,$items_per_planet);
	
	if($planets_planets>1)
		{for($x=1;$x<=$planets_planets;$x++)
			{if(($x==$planet_planets)AND($x==$planets_planets)){$list_planets.="<b>$x</b>";}
			else if($x==$planet_planets){$list_planets.="<b>$x</b><span class='dot_pagination'> &bull; </span>";}
			else if($x==$planets_planets){$list_planets.="<a href='#' onclick='return false' onmousedown='javascript:linked_planets_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a>";}
			else {$list_planets.="<a href='#' onclick='return false' onmousedown='javascript:linked_planets_list(".$x.",".$id.",".$ids.");' class='bold'>".$x."</a><span class='dot_pagination'> &bull; </span>";}
			}
		}
	// End Pagination
	$planets_list .= "<div class='middle_bars'>
					<div class='float_left'><span class='heading_list'><img src='blank.gif' width='1px' height='1px' class='planets_linked_lists'>Linked Planets (".$planets_count.")</span></div>
					<div class='float_right'>".$list_planets."</div>
					</div>";
	$i = 0;
	$planets_list .="<div class='under_side_bars'>";
	foreach ($planetsArray8 as $key => $value)
		{$i++;
		$mysql_planet1=mysql_query("SELECT * FROM planets WHERE id='$value' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row = mysql_fetch_array($mysql_planet1))
			{$planet_id = $row['id'];
			$user_id = $row['user_id'];
			$planet_name = $row['planet_name'];	
			$categories = $row['categories'];
			if ((strlen($categories))>25)
				{$categories = substr($categories,0,25);
				$categories=$categories."...";}	
			if(strlen($planet_name)>18){$planet_name=substr($planet_name, 0, 18)."...";}		
			$like_array_planet = $row['like_array'];
			$love_array_planet = $row['love_array'];
			$likeArray_planet = explode(",",$like_array_planet);
			$loveArray_planet = explode(",",$love_array_planet);
			$like_array_count_planet = count($likeArray_planet);
			$love_array_count_planet = count($loveArray_planet);		

			$comment_type="planets";
			$comment_type=json_encode($comment_type);

	if (in_array($ids,$likeArray_planet))
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unlikeLike_circle(".$ids.",".$planet_id.",".$comment_type.");'>Unlike</a>";}
	else if (in_array($ids,$loveArray_planet))
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:unloveLove_circle(".$ids.",".$planet_id.",".$comment_type.");'>Unlove</a>";}
	else 
		{$like_love_planet = "<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Like_circle(".$ids.",".$planet_id.",".$comment_type.");'>Like</a><span class='dot_divider'> &middot; </span>
						<a href='#' class='post_link' onclick='return false' onmousedown='javascript:Love_circle(".$ids.",".$planet_id.",".$comment_type.");'>Love</a>";}
	if (($like_array_planet !="")AND($love_array_planet !=""))
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>".$like_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/><span class='dot_divider'> &middot; </span>
						<a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>".$love_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else if ($like_array_planet !="")
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a title='Like Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_like_array(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>".$like_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='like_count'/>";}
	else if ($love_array_planet !="")
		{$like_love2_planet = "<span class='dot_divider'> &middot; </span><a title='Love Array' href='#' class='post_link display_button' onclick='return false' onmousedown='javascript:display_love_array(".$id.",".$ids.", ".$planet_id.",".$comment_type.");'>".$love_array_count_planet."</a> <img src='blank.gif' width='1px' height='1px' class='love_count'/>";}
	else
		{$like_love2_planet = "";}
		
			$check_pic_planet_bar="../planet_files/planet$value/planet_thumb.jpg";
			$default_pic_planet_bar="../planet_files/planet0/planet_thumb.png";
			if (file_exists($check_pic_planet_bar))
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$value'><img src='$check_pic_planet_bar#$cacheBuster' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			else
				{$user_pic_planet_bar="<a href='../planet/planet.php?id=$value'><img src='$default_pic_planet_bar' height='55px' width='55px' height='55px' class='thumb_background'/></a>";}
			if($user_id!==$id){$planet_type="Planet Member";}
			else{$planet_type="Planet Creator";}

		$planets_list .="<div class='list_wrap2'>
						<div class='list_wrap_1'><a href='../planet/planet.php?id=".$planet_id."'>".$user_pic_planet_bar."</a></div>
						<div class='list_wrap_3'><div class='profile_link'><a class='profile_link' href='../planet/planet.php?id=".$planet_id."'><b>".$planet_name."</b></a></div>
							<span class='places'>".$categories."</span>
							<div class='planet_ll' id='information_circle_planets".$planet_id."'>
								".$like_love_planet."".$like_love2_planet."
							</div>
						</div>
						</div>";
			}
		}
	$planets_list .="</div>";
	}
if ($planets_array!=="")
{echo $planets_list;}
?>
<script type="text/javascript">
// friends Pagination
function linked_planets_list(a,b,c)
	{$.post("planet_linked_planets_list.php?page="+a,{x:a,id:b,ids:c,cacheBuster:cacheBuster},function(data) 
		{$("#linked_planets_list").html(data).show()});	
	}
</script>