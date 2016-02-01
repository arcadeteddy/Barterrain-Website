<?php
ob_start();
include_once "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
if(!isset($number)){$number="0";}
$DisplayList ="";
$numRows ="";
$comment ="";
$comments ="";
$like_love="";
$like_love2="";

if(isset($_GET['number']))
	{$number=$_GET['number'];
	$cacheBuster=$_GET['cacheBuster'];
	$id=$_GET['id'];
	$ids=$_GET['ids'];}
if(isset($_GET['search']))
	{$search=$_GET['search'];
	$search = strip_tags($_GET['search']);
	$search = mysql_real_escape_string($search);}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql = mysql_query("SELECT friend_array, family_array FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$friend_array = $row['friend_array'];
	$family_array = $row['family_array'];
	$friendArray = explode(",",$friend_array);
	$familyArray = explode(",",$family_array);
	if(($friend_array!=="")AND($family_array!==""))
		{$FF_array=$friend_array.",".$family_array;}
	else if($family_array!==""){$FF_array=$family_array;}
	else if($friend_array!==""){$FF_array=$friend_array;}
	else {$FF_array="";}
	$FFArray = explode(",",$FF_array);
	$FRIENDS = join(',',$FFArray);}
	
////////// SEARCH!!! //////////
if ($FF_array=="") {$mysql_union = mysql_query("(SELECT id, last_login_date AS datetime, union_type FROM members WHERE (delete_member='1')
								AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%'))
							ORDER BY datetime DESC LIMIT ".$number.",20");}
else {$mysql_union = mysql_query("(SELECT id, last_login_date AS datetime, union_type FROM members WHERE (delete_member='1')
								AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%'))
							ORDER BY FIND_IN_SET(id,'$FRIENDS') DESC, datetime DESC LIMIT ".$number.",20");}
$numRows=mysql_num_rows($mysql_union);
if($numRows>0)
{while ($row = mysql_fetch_array ($mysql_union))
	{$item_id = $row['id'];
	$datetime = $row['datetime'];
	$union_type = $row['union_type'];
	
if ($union_type=="profiles")
{$mysql_name = mysql_query("SELECT * FROM members WHERE id='$item_id' LIMIT 1") or die ("Sorry, we have a system error!");
while ($row=mysql_fetch_array($mysql_name))
	{$member_id=$row['id'];
	$member_firstname=$row['firstname'];
	$member_lastname=$row['lastname'];
	$member_location=$row['location'];
	$member_secondary_school=$row['secondary_school'];
	$member_post_secondary=$row['post_secondary'];
	$member_friend_array=$row['friend_array'];
	$member_family_array=$row['family_array'];
	$check_pic="../user_files/user$member_id/profile_thumb.jpg";
	$default_pic="../user_files/user0/default_profile_pic_thumb.png";
	$cacheBuster = rand(9999999,99999999999);
	if (file_exists($check_pic))
		{$user_pic="<a href='../profile/profile.php?id=$member_id'><img src='$check_pic#$cacheBuster' width='55px' height='55px' class='thumb_background'/></a>";}
	else{$user_pic="<a href='../profile/profile.php?id=$member_id'><img src='$default_pic' width='55px' height='55px' class='thumb_background'/></a>";}
	
	if($member_post_secondary!=""){$place=$member_post_secondary."<br/>";}
	else if($member_secondary_school!=""){$place=$member_secondary_school."<br/>";}
	else if($member_location!=""){$place=$member_location."<br/>";}
	else {$place="";}
	if(($member_friend_array!=="")AND($member_family_array!==""))
		{$FF_member_array=$member_friend_array.",".$member_friend_array;}
	else if($member_friend_array!==""){$FF_member_array=$member_friend_array;}
	else if($member_family_array!==""){$FF_member_array=$member_family_array;}
	else {$FF_member_array="";}
	$FFmemberArray = explode(",",$FF_member_array);
	$FFmemberArray = array_intersect($FFmemberArray, $FFArray);
	$FFpersonArray_json_encode = json_encode($FFmemberArray);
	$FFArray_count=count($FFmemberArray);
	if ($FFArray_count!==1) {$mf_s="Friends";}
	else if ($FF_member_array=="") {$mf_s="Friends";}
	else {$mf_s="Friend";}
			
	if (empty($FFmemberArray)) {$FFArray_count="0";}
	else if ($FF_member_array=="") {$FFArray_count="0";}
	else 
		{if ($ids==$member_id)
			{$FFArray_count="<a title='Display Friends' href='http://www.barterrain.com/friends/friends.php?friends=all' class='bold display_button'>".$FFArray_count."</a>";}
		else 
			{$FFArray_count="<a title='Display Mutual Friends' href='#' onclick='return false' onmousedown='javascript:display_mutual_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.");' class='bold display_button'>".$FFArray_count."</a>";}
		}
	
	if ((in_array($member_id,$FFArray))OR($ids==$member_id))
		{$add_friend = "";}
	else {$add_friend = "<span id='request".$member_id."'><a href='#' class='post_link' onclick='return false' onmousedown='javascript:addAsFriend2(".$ids.",".$member_id.");'>Add Friend</a></span><span class='dot_divider'> &middot; </span>";}
	
	if ($ids==$member_id)
		{$mutual_text=$place."You Have ".$FFArray_count." ".$mf_s;}
	else 
		{$mutual_text=$place."You Both Have ".$FFArray_count." Mutual ".$mf_s;}
	
	$DisplayList .= "<div>
						<div class='search_box'>
							<div class='search_box1'>".$user_pic."</div>
						<div class='search_box3'>
							<div class='search_box2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$member_id."'><b>".$member_firstname." ".$member_lastname."</b></a></div>
							<div class='search_box2'><span class='mutual'>".$mutual_text."</span><br/></div>
							<div class='search_box2'>
								".$add_friend."
								<a href='../messages/messages.php?message_id=".$member_id."' class='bar_link'>Message</a>
							</div>
						</div>
						</div>
					</div>";
	}
}
}}

echo $DisplayList;
if($numRows>0){$number=$number+20;}
?>
<script type="text/javascript">
// Add more Content at end of page
var number = "<?php echo $number; ?>";
var search_box = "<?php echo $search; ?>";
var numRows = "<?php echo $numRows; ?>";
var cacheBuster = "<?php echo $cacheBuster; ?>";
$(window).data('ajaxready11', true).scroll(function()
	{if ($(window).data('ajaxready11') == false) return;
	if($(window).scrollTop()>=$("#bottom_search_profiles_profiles").height()-$(document).height())
		{$("div#expand_bottom_box").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready11', false);
		$.ajax({cache: false,url:"search_profiles_profiles_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_profiles_profiles").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				 $(window).data('ajaxready11', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_box").click(function(){
	{if ($(window).data('ajaxready11') == false) return;
	$("div#expand_bottom_box").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready11', false);
	$.ajax({cache: false,url:"search_profiles_profiles_content.php?number="+number+"&cacheBuster="+cacheBuster+"&search="+search_box+"&id="+id+"&ids="+ids,
			success:function(html)
				{if(html){$("#bottom_search_profiles_profiles").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_box").show();}
				$(window).data('ajaxready11', true);}
			});
		}
	});
});
</script>